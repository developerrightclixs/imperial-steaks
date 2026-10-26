#!/usr/bin/env python3
"""
Place the client's `Product image/` drop (16 Oct 2026) into assets/images/.

Every slot on the site is 3:2 and the CSS crops with `object-fit: cover`, so a
file that is not 3:2 would be cropped twice - once here and once by the browser.
This script therefore produces a true 3:2 file for each slot, either by cropping
a 3:2 window out of a larger source or by growing the canvas:

  * white-ground catalogue shots      -> pad with white, invisible
  * the XL screengrab (grey studio)   -> reflect-tile the clean background bands
                                         above and below the subject, blurred

Nothing is upscaled more than ~1.6x, so each output is exported at the size its
source can actually carry rather than at a uniform 1800x1200. The <img>
width/height attributes in index.html and products.html carry those same sizes.

Run from the project root:  python tools/place-product-images.py
Then copy the results into wp-theme/imperial-steaks/assets/images/ and re-run
tools/build-theme-templates.py.

Provenance and the open flags on these files: docs/IMAGE_REPLACEMENT_LIST.md §4.
"""

import os
from PIL import Image, ImageFilter

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SRC = os.path.join(ROOT, 'Product image')
OUT = os.path.join(ROOT, 'assets', 'images')
R = 3 / 2


def pad_to_ratio(im, fill):
    """Grow the canvas to 3:2 with a flat fill, image centred."""
    w, h = im.size
    nw, nh = (w, round(w / R)) if w / h > R else (round(h * R), h)
    bg = Image.new('RGB', (nw, nh), fill)
    bg.paste(im, ((nw - w) // 2, (nh - h) // 2))
    return bg


def reflect_pad_to_ratio(im, top_clean, bot_clean):
    """Grow to 3:2 by reflect-tiling the clean background bands above/below.

    top_clean / bot_clean are the number of rows at each edge that hold only
    background - no subject - and so are safe to repeat.
    """
    w, h = im.size
    nh = round(w / R)
    need = nh - h
    top = round(need * top_clean / (top_clean + bot_clean))
    bot = need - top
    out = Image.new('RGB', (w, nh))
    out.paste(im, (0, top))

    def band(box, height):
        strip = im.crop(box)
        sh = strip.size[1]
        tile = Image.new('RGB', (w, height))
        y, flip = height, True
        while y > 0:
            y -= sh
            tile.paste(strip.transpose(Image.FLIP_TOP_BOTTOM) if flip else strip, (0, y))
            flip = not flip
        return tile.filter(ImageFilter.GaussianBlur(6))

    if top:
        out.paste(band((0, 0, w, top_clean), top), (0, 0))
    if bot:
        out.paste(band((0, h - bot_clean, w, h), bot), (0, top + h))
    return out


def save(im, name, size, q=84):
    path = os.path.join(OUT, name)
    im.convert('RGB').resize(size, Image.LANCZOS).save(
        path, 'JPEG', quality=q, optimize=True, progressive=True)
    print(f'  {name:26} {size[0]}x{size[1]:<6} {os.path.getsize(path) // 1024:4} KB')


def src(name):
    return Image.open(os.path.join(SRC, name)).convert('RGB')


print('assets/images/')

# XLS - House Blend. Single frozen portion on white; crop a 3:2 window.
save(src('philly steak raw frozen.jpg').crop((0, 141, 1000, 808)),
     'product-xls.jpg', (1000, 667))

# XL - Traditional Philly. Phone screengrab of the client's dev site: lift the
# page's own photo card (x 60-1224, y 1209-1749) then extend the grey ground.
# 34 clean rows at the top of the card, 26 at the bottom.
save(reflect_pad_to_ratio(src('Traditional Philly \u2013 XL.PNG').crop((60, 1209, 1224, 1749)), 34, 26),
     'product-xl.jpg', (1200, 800))

# NS - Premium Philly. Same screengrab treatment; the card is white, so plain
# white padding is invisible.
save(pad_to_ratio(src('Premium Philly \u2013 NS.PNG').crop((60, 715, 1224, 1255)), (255, 255, 255)),
     'product-ns.jpg', (1200, 800))

# RE - Rib Eye. The client's own photograph, one of eight picks. Dropped to
# 1400 wide to stay inside the 250 KB budget - it is a detailed, noisy frame.
save(src('Picks for rib eye/IMG_3096.jpeg').crop((0, 126, 2016, 1470)),
     'product-re.jpg', (1400, 933), q=76)

# EPIC - Signature Blend. Stacked sliced portions on white.
save(src('philly steak raw frozen 1.jpg').crop((0, 349, 2000, 1682)),
     'product-epic.jpg', (1800, 1200))

# CHX - Premium Chicken. Transparent PNG; flatten onto white first.
chx = Image.open(os.path.join(SRC, 'Philly Chicken Cheese Steak Meat (1 lb.) \u2013 Diamond State Meats.webp')).convert('RGBA')
flat = Image.new('RGB', chx.size, (255, 255, 255))
flat.paste(chx, mask=chx.getchannel('A'))
save(pad_to_ratio(flat.crop((0, 10, 490, 292)), (255, 255, 255)),
     'product-chx.jpg', (900, 600))

# Home hero, chicken half. 880x520 is the slot, not 3:2 - keep the existing
# filename and size so no markup changes. Source is only 560x420; see §3.
save(src('philly chicken flat steak raw.webp').crop((0, 48, 560, 379)),
     'hero-chicken-philly.jpg', (880, 520), q=86)
