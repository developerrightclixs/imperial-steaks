#!/usr/bin/env python3
"""
Remove the small print from the black lid flap of the homepage carton photo.

The client asked for the flap to be plain black ("Get rid of all that writing
on the top. Black clean.", 6 Nov). product-box-open.* is the client's own
red-background file, not an output of tools/fix-box-image.py, so this works on
it in place: only the pixels of the print change. The PNG keeps its palette and
is repainted by palette index; the WebP is re-encoded.

Run from the project root:  python tools/clean-box-lid.py
Safe to rerun. Needs Pillow and NumPy.
"""

import os
import shutil

import numpy as np
from PIL import Image, ImageFilter

ROOT   = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
IMAGES = os.path.join(ROOT, 'assets', 'images')
THEME  = os.path.join(ROOT, 'wp-theme', 'imperial-steaks', 'assets', 'images')
PNG    = os.path.join(IMAGES, 'product-box-open.png')
WEBP   = os.path.join(IMAGES, 'product-box-open.webp')

BOX   = (510, 33, 955, 79)        # the print, in image pixels: left, top, right, bottom
BLACK = np.array([13, 13, 13])    # the flap's own black
LIGHT = 26                        # any channel above this inside BOX is print


def print_mask(rgb):
    """Boolean mask of the print and its compression halo."""
    left, top, right, bottom = BOX
    hit = np.zeros(rgb.shape[:2], bool)
    area = rgb[top:bottom, left:right].astype(int)
    # The print, plus its faint neutral ghost. The flap's knob is tinted red, so
    # the spread test leaves it alone.
    hit[top:bottom, left:right] = (area.min(axis=2) > LIGHT) | (area.max(axis=2) - area.min(axis=2) < 12)
    grown = Image.fromarray((hit * 255).astype('uint8'), 'L').filter(ImageFilter.MaxFilter(7))
    mask = np.array(grown) > 0
    outside = np.ones_like(mask)
    outside[top:bottom, left:right] = False
    mask[outside] = False
    return mask


# WebP: paint the flap black, then re-encode.
webp = np.array(Image.open(WEBP).convert('RGB'))
mask = print_mask(webp)
webp[mask] = BLACK
Image.fromarray(webp).save(WEBP, 'WEBP', quality=92, method=6)
print('webp pixels painted:', int(mask.sum()))

# PNG: repaint by palette index, so nothing outside the print is touched.
png = Image.open(PNG)
assert png.mode == 'P', 'expected the palette PNG'
palette = np.array(png.getpalette()[:768]).reshape(-1, 3)
index = int(np.abs(palette - BLACK).sum(axis=1).argmin())
pixels = np.array(png)
mask = print_mask(palette[pixels])
pixels[mask] = index
out = Image.fromarray(pixels, 'P')
out.putpalette(png.getpalette())
out.save(PNG, optimize=False, **({'transparency': png.info['transparency']} if 'transparency' in png.info else {}))
print('png pixels painted:', int(mask.sum()))

for path in (PNG, WEBP):
    shutil.copy2(path, THEME)
print('mirrored both into wp-theme/imperial-steaks/assets/images/')
