"""Generate the three Imperial Steaks logo concepts as SVG.

Every concept keeps the same hierarchy the client asked for: IMPERIAL is the
dominant word, STEAKS is the quiet secondary one. Type is converted to outlines
so the mark renders identically everywhere, with no webfont dependency.
"""
import os
import sys

HERE = os.path.dirname(os.path.abspath(__file__))
sys.path.insert(0, HERE)
from textpath import text_path, text_width  # noqa: E402

FONTS = os.path.join(HERE, "fonts")
BODONI = os.path.join(FONTS, "bodoni900.ttf")
OSWALD_BOLD = os.path.join(FONTS, "oswald700.ttf")
OSWALD_LIGHT = os.path.join(FONTS, "oswald200.ttf")
POPPINS = os.path.join(FONTS, "poppins600.ttf")

RED = "#FF0000"
OUT = os.path.abspath(os.path.join(HERE, "..", "..", "..", "..", "..", "..",
                                   "..", "imperialsteaks", "assets", "images"))


def svg(width, height, body, title):
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {width:.0f} {height:.0f}"\n'
        f'     width="{width:.0f}" height="{height:.0f}" role="img" aria-label="{title}">\n'
        f'  <title>{title}</title>\n{body}</svg>\n'
    )


# ---------------------------------------------------------------------------
# Concept 1 - "Imperial Serif". Bodoni Black IMPERIAL over a hairline rule,
# with STEAKS set small and widely tracked underneath. Closest in spirit to the
# Tasty Steaks reference, with the dominance of the two words reversed.
# ---------------------------------------------------------------------------
def concept_one(word_fill, accent, bar_text):
    big, small, track_big, track_small = 96.0, 20.0, 4.0, 15.5
    pad = 24.0
    w_big = text_width(BODONI, "IMPERIAL", big, track_big)
    w_small = text_width(OSWALD_LIGHT, "STEAKS", small, track_small)
    width = w_big + pad * 2
    cap, rule_gap = big * 0.72, 20.0
    base_big = pad + cap
    rule_y = base_big + rule_gap
    base_small = rule_y + 16.0 + small * 0.72
    height = base_small + pad

    d_big, _ = text_path(BODONI, "IMPERIAL", big, track_big)
    d_small, _ = text_path(OSWALD_LIGHT, "STEAKS", small, track_small)
    x_small = (width - w_small) / 2

    body = (
        f'  <g transform="translate({pad:.1f} {base_big:.1f})">'
        f'<path fill="{word_fill}" d="{d_big}"/></g>\n'
        f'  <rect x="{pad:.1f}" y="{rule_y:.1f}" width="{w_big:.1f}" height="3" fill="{accent}"/>\n'
        f'  <g transform="translate({x_small:.1f} {base_small:.1f})">'
        f'<path fill="{word_fill}" d="{d_small}"/></g>\n'
    )
    return svg(width, height, body, "Imperial Steaks")


# ---------------------------------------------------------------------------
# Concept 2 - "Block". Oswald Bold IMPERIAL at full width, STEAKS reversed out
# of a solid red bar sitting directly beneath it. The most industrial of the
# three and the one that survives being stamped on a carton.
# ---------------------------------------------------------------------------
def concept_two(word_fill, accent, bar_text):
    big, small, track_big, track_small = 104.0, 21.0, 1.0, 13.0
    pad = 24.0
    w_big = text_width(OSWALD_BOLD, "IMPERIAL", big, track_big)
    w_small = text_width(OSWALD_LIGHT, "STEAKS", small, track_small)
    width = w_big + pad * 2
    base_big = pad + big * 0.73
    bar_y = base_big + 14.0
    bar_h = 40.0
    base_small = bar_y + bar_h / 2 + small * 0.36
    height = bar_y + bar_h + pad

    d_big, _ = text_path(OSWALD_BOLD, "IMPERIAL", big, track_big)
    d_small, _ = text_path(OSWALD_LIGHT, "STEAKS", small, track_small)

    body = (
        f'  <g transform="translate({pad:.1f} {base_big:.1f})">'
        f'<path fill="{word_fill}" d="{d_big}"/></g>\n'
        f'  <rect x="{pad:.1f}" y="{bar_y:.1f}" width="{w_big:.1f}" height="{bar_h:.1f}" fill="{accent}"/>\n'
        f'  <g transform="translate({(width - w_small) / 2:.1f} {base_small:.1f})">'
        f'<path fill="{bar_text}" d="{d_small}"/></g>\n'
    )
    return svg(width, height, body, "Imperial Steaks")


# ---------------------------------------------------------------------------
# Concept 3 - "Crest". A red crown device above a Bodoni IMPERIAL, with STEAKS
# in small tracked Poppins below. The most premium-looking, and the one that
# gives the brand a standalone icon for the favicon and social avatars.
# ---------------------------------------------------------------------------
def concept_three(word_fill, accent, bar_text):
    big, small, track_big, track_small = 86.0, 16.0, 6.0, 12.0
    pad = 24.0
    w_big = text_width(BODONI, "IMPERIAL", big, track_big)
    w_small = text_width(POPPINS, "STEAKS", small, track_small)
    width = w_big + pad * 2
    crown_h = 40.0
    base_big = pad + crown_h + 14.0 + 9.0 + 22.0 + big * 0.72
    base_small = base_big + 26.0 + small * 0.72
    height = base_small + pad

    d_big, _ = text_path(BODONI, "IMPERIAL", big, track_big)
    d_small, _ = text_path(POPPINS, "STEAKS", small, track_small)

    # Five-point crown, drawn rather than borrowed, so the mark is ours.
    cw = 104.0
    cx, cy = width / 2, pad
    band = 9.0           # solid base band under the points
    valley = cy + crown_h * 0.52
    crown = (
        f"M{cx - cw / 2:.1f} {cy + crown_h:.1f} "
        f"L{cx - cw / 2:.1f} {cy + crown_h * 0.30:.1f} "
        f"L{cx - cw / 4:.1f} {valley:.1f} "
        f"L{cx:.1f} {cy:.1f} "
        f"L{cx + cw / 4:.1f} {valley:.1f} "
        f"L{cx + cw / 2:.1f} {cy + crown_h * 0.30:.1f} "
        f"L{cx + cw / 2:.1f} {cy + crown_h:.1f} Z"
    )
    crown += (
        f" M{cx - cw / 2:.1f} {cy + crown_h + 5:.1f} "
        f"H{cx + cw / 2:.1f} V{cy + crown_h + 5 + band:.1f} "
        f"H{cx - cw / 2:.1f} Z"
    )

    body = (
        f'  <path fill="{accent}" d="{crown}"/>\n'
        f'  <g transform="translate({pad:.1f} {base_big:.1f})">'
        f'<path fill="{word_fill}" d="{d_big}"/></g>\n'
        f'  <g transform="translate({(width - w_small) / 2:.1f} {base_small:.1f})">'
        f'<path fill="{accent}" d="{d_small}"/></g>\n'
    )
    return svg(width, height, body, "Imperial Steaks")


CONCEPTS = {1: concept_one, 2: concept_two, 3: concept_three}

VARIANTS = {
    "":         ("#FFFFFF", RED, "#FFFFFF"),   # on matte black
    "-onlight": ("#1A1A1A", RED, "#FFFFFF"),   # on white / light stock
    "-onred":   ("#FFFFFF", "#FFFFFF", RED),   # reversed, on the brand red
}

if __name__ == "__main__":
    out = sys.argv[1]
    for n, fn in CONCEPTS.items():
        for suffix, args in VARIANTS.items():
            path = os.path.join(out, f"logo-concept-{n}{suffix}.svg")
            with open(path, "w", encoding="utf-8") as fh:
                fh.write(fn(*args))
            print(path)
