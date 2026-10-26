#!/usr/bin/env python3
"""
Fetch the original Tasty Steaks imagery from the Wayback Machine and wire it
into the Imperial Steaks prototype.

WHY THIS SCRIPT EXISTS
----------------------
Two things were discovered during the image hand-off (2026-10-12):

  1. The live site's entire uploads directory is GONE. Every
     https://tastysteaks.ca/wp-content/uploads/... URL returns HTTP 404 served
     by WordPress/PHP - including the logo and every product photo. The pages
     still reference them, so the live site currently renders with broken
     images. The origin is therefore not a usable source.

  2. The Wayback Machine is the only remaining source - and at the time of
     writing the whole Internet Archive was returning its "Temporarily Offline"
     page on every endpoint (web.archive.org, the CDX API, and the availability
     API). archive.today and the Memento aggregator were also unreachable.

So the images could not be retrieved in that session. This script does the whole
job in one command as soon as the Internet Archive is back up.

USAGE
-----
    python tools/fetch-original-images.py            # fetch + rewrite the HTML
    python tools/fetch-original-images.py --dry-run  # show what it would do
    python tools/fetch-original-images.py --check    # just test if the archive is up

WHAT IT DOES
------------
  * asks the Wayback CDX API for the newest good snapshot of each original file
  * downloads the raw bytes using the `id_` modifier (no archive toolbar or
    URL rewriting injected into the file)
  * saves each one into assets/images/ under this project's own filename
  * rewrites the matching src="..." references across the five HTML pages so the
    new .png/.jpg replaces the .svg placeholder
  * leaves the SVG placeholder in place for anything it cannot fetch, and says so

It is safe to re-run: already-downloaded files are skipped unless --force.

AFTER RUNNING
-------------
  * Look at the three badge images on a dark background. The originals are
    transparent cut-outs and may have dark artwork that disappears on Onyx -
    they may need a white pill/backing or a light variant.
  * EPIC has no usable original: the reference site mistakenly used a pink-rose
    stock photo in that slot. It stays a placeholder.
  * Confirm stock-photo licensing with the client before publishing (see the
    note at the bottom of docs/IMAGE_REPLACEMENT_LIST.md).
"""

import argparse
import json
import os
import re
import sys
import time
import urllib.error
import urllib.parse
import urllib.request

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
IMG_DIR = os.path.join(ROOT, "assets", "images")
PAGES = ["index.html", "about.html", "products.html", "retail.html", "contact.html"]

UPLOADS = "https://tastysteaks.ca/wp-content/uploads/2024/06/"
UA = ("Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 "
      "(KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36")

# original upload filename  ->  (project filename, what it fills)
MAP = [
    ("sizzling-satisfaction-authentic-philly-cheesesteak-white-background-delicious-food__1_-removebg-preview.png",
     "hero-philly-steak.png", "Homepage hero cut-out"),
    ("WhatsApp_Image_2024-06-19_at_9.52.36_PM-removebg-preview.png",
     "home-intro-steak.png", "Homepage intro square"),
    ("Qualityphillysteaks.png",
     "about-quality.png", "About Us feature image"),
    ("pexels-photo-248337-248337.jpg",
     "category-beef.jpg", "Category - Beef"),
    ("gb5c5435b3e142cb14bbe4e9ef6fbd12fca51e1bc03f3e9be6cf77757b1cffbf6dd38df49e03ed7f6ad55f77f14d4253acfcdacdecdb0137dfea9122515fded71_1280-5645894.jpg",
     "category-chicken.jpg", "Category - Chicken"),
    ("1690277014599-removebg-preview.png",
     "category-halal.png", "Category - Halal (also the Halal badge)"),
    ("png-transparent-usda-hd-logo-removebg-preview-e1718724039941.png",
     "badge-usda-inspected.png", "Badge - USDA"),
    ("images__2_-removebg-preview.png",
     "badge-third.png", "Badge - third mark on the reference strip (identify on arrival)"),
    ("7991391.jpg",
     "product-house-blend-xls.jpg", "Product - House Blend XLS (was VALUE BLEND-MTL)"),
    ("roasted-meat-cutting-board-1.jpg",
     "product-xl.jpg", "Product - Traditional Philly XL"),
    ("raw-meat-with-ingredients-cooking-meal-1.jpg",
     "product-ns.jpg", "Product - Premium Philly NS"),
    ("overhead-view-red-meat-wooden-cutting-board-garlic-green-lemon-onion-fork-knife-dark-background.jpg",
     "product-re.jpg", "Product - Rib Eye RE"),
    ("raw-meat-with-spices-herbs-table.jpg",
     "product-puck.jpg", "Product - Puck"),
    ("assortment-frozen-chicken-table.jpg",
     "product-chx.jpg", "Product - Premium Chicken CHX"),
]

# Slots with no original to recover - these keep their SVG placeholders.
NO_ORIGINAL = {
    "product-epic.svg": "Reference site used an unrelated pink-rose stock photo in the EPIC slot.",
    "retail-packaging.svg": "The reference site has no Retail page, so no original exists.",
    "contact-distribution.svg": "The reference contact page had no image.",
    "imperial-steaks-logo.svg": "Tasty Steaks logo is old branding - Imperial Steaks needs its own.",
    "favicon.svg": "Old-brand favicon - not reused.",
}


def get(url, timeout=60, retries=3, polite=True):
    """GET with a browser UA and backoff.

    The Wayback replay endpoints rate-limit hard (HTTP 429) if you hammer them,
    and they are slow while the archive is under load. 429 and 5xx therefore get
    a long, escalating wait rather than a quick retry.
    """
    last = None
    for attempt in range(retries):
        try:
            req = urllib.request.Request(url, headers={"User-Agent": UA})
            with urllib.request.urlopen(req, timeout=timeout) as resp:
                return resp.read()
        except urllib.error.HTTPError as exc:
            last = exc
            if exc.code in (429, 503, 502, 504) and attempt < retries - 1 and polite:
                wait = 45 * (attempt + 1)
                print(f"         HTTP {exc.code} - backing off {wait}s", flush=True)
                time.sleep(wait)
            elif attempt < retries - 1:
                time.sleep(5)
            else:
                break
        except Exception as exc:                      # noqa: BLE001
            last = exc
            if attempt < retries - 1:
                time.sleep(8 * (attempt + 1))
    raise last


def archive_is_up():
    """The archive serves a 'Temporarily Offline' HTML page when it is down."""
    try:
        body = get("https://archive.org/wayback/available?url=example.com",
                   timeout=30, retries=1)
    except Exception as exc:                          # noqa: BLE001
        return False, f"unreachable: {exc}"
    if b"Temporarily Offline" in body:
        return False, "Internet Archive reports: Temporarily Offline"
    try:
        json.loads(body)
    except ValueError:
        return False, "unexpected response from the availability API"
    return True, "up"


# Snapshot URL forms tried in order. The CDX API is deliberately NOT used: it
# was returning 502/503 for every lookup while the archive was recovering, even
# though the snapshot replay endpoints below were serving files correctly.
# `id_` and `im_` both ask for the raw stored file with no toolbar injected;
# a bare year resolves to the nearest snapshot without needing a CDX query.
SNAPSHOT_FORMS = [
    "20250801105051im_",   # the snapshot the project owner pointed at
    "2025id_",             # nearest snapshot in 2025
    "2024id_",             # nearest snapshot in 2024 (uploads are dated 2024/06)
    "20250801105051id_",
]


def looks_like_image(data):
    """Cheap magic-number check so an error page is never saved as an image."""
    if not data or len(data) < 512:
        return False
    return (data.startswith(b"\x89PNG")              # png
            or data.startswith(b"\xff\xd8\xff")      # jpeg
            or data[:4] == b"GIF8"                   # gif
            or data[8:12] == b"WEBP")                # webp


def fetch_original(original_url):
    """Try each snapshot form until one yields real image bytes.

    Forms are tried one at a time with real backoff, because trying four forms
    in quick succession per file is exactly what triggers the 429s.

    Returns (data, form_used) or (None, reason).
    """
    problems = []
    for form in SNAPSHOT_FORMS:
        url = f"https://web.archive.org/web/{form}/{original_url}"
        try:
            data = get(url, timeout=120, retries=3)
        except Exception as exc:                      # noqa: BLE001
            problems.append(f"{form}: {exc}")
            continue
        if looks_like_image(data):
            return data, form
        problems.append(f"{form}: not an image ({len(data)} bytes)")
    return None, "; ".join(problems)


def rewrite_pages(old_name, new_name, dry_run=False):
    """Swap assets/images/<old_name> -> <new_name> across every page."""
    touched = []
    for page in PAGES:
        path = os.path.join(ROOT, page)
        if not os.path.exists(path):
            continue
        with open(path, encoding="utf-8") as fh:
            src = fh.read()
        needle = "assets/images/" + old_name
        if needle not in src:
            continue
        if not dry_run:
            with open(path, "w", encoding="utf-8") as fh:
                fh.write(src.replace(needle, "assets/images/" + new_name))
        touched.append(page)
    return touched


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true", help="show the plan, change nothing")
    ap.add_argument("--check", action="store_true", help="only test archive availability")
    ap.add_argument("--force", action="store_true", help="re-download files already present")
    ap.add_argument("--delay", type=float, default=10.0,
                    help="seconds to wait between files (default 10; raise if you see 429s)")
    args = ap.parse_args()

    up, why = archive_is_up()
    print(f"Internet Archive: {why}")
    if args.check:
        return 0 if up else 1
    if not up:
        print("\nCannot fetch the images while the archive is offline.")
        print("The live origin is not an option either: every "
              "tastysteaks.ca/wp-content/uploads/ URL returns HTTP 404.")
        print("Re-run this script when https://web.archive.org/ responds normally.")
        return 1

    os.makedirs(IMG_DIR, exist_ok=True)
    ok, missing = [], []

    first = True
    for original, target, label in MAP:
        dest = os.path.join(IMG_DIR, target)
        if os.path.exists(dest) and not args.force:
            print(f"  skip (already present)  {target}", flush=True)
            ok.append((original, target, label))
            continue

        # Throttle: the replay endpoints 429 quickly if hit back-to-back.
        if not first and not args.dry_run:
            time.sleep(args.delay)
        first = False

        url = UPLOADS + original
        data, note = fetch_original(url)

        if data is None:
            print(f"  FAIL  {target}: {note}", flush=True)
            missing.append((target, label, note))
            continue

        if args.dry_run:
            print(f"  would save  {target}  ({len(data)/1024:.0f} KB, via {note})", flush=True)
        else:
            with open(dest, "wb") as fh:
                fh.write(data)
            print(f"  saved  {target}  ({len(data)/1024:.0f} KB, via {note})", flush=True)

        # Point the HTML at the new file and drop the placeholder.
        placeholder = os.path.splitext(target)[0] + ".svg"
        pages = rewrite_pages(placeholder, target, dry_run=args.dry_run)
        if pages:
            print(f"         rewrote src in: {', '.join(pages)}")
            stale = os.path.join(IMG_DIR, placeholder)
            if os.path.exists(stale) and not args.dry_run:
                os.remove(stale)
                print(f"         removed placeholder {placeholder}")
        ok.append((original, target, label))

    print("\n" + "=" * 70)
    print(f"Fetched/present: {len(ok)}   Failed: {len(missing)}")
    if missing:
        print("\nStill on placeholders (archive had nothing usable):")
        for target, label, why_not in missing:
            print(f"  - {target:34s} {label}\n      reason: {why_not}")
    print("\nSlots with no original by design:")
    for name, reason in NO_ORIGINAL.items():
        print(f"  - {name:34s} {reason}")
    print("\nNext: check the badge cut-outs against the dark background, then")
    print("update the Status column in docs/IMAGE_REPLACEMENT_LIST.md.")
    return 0


if __name__ == "__main__":
    sys.exit(main())
