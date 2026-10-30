#!/usr/bin/env python3
"""
Rebuild assets/images/product-box-open.png from the untouched original.

The client asked for a carton that reads fully black. The earlier retouch
pasted a black rectangle over the unprinted left half of the front panel; it
did not line up with the printed label beside it, so the panel showed a step
and a vertical seam ("fix the clean as it shows broken", 30 Oct).

This redraws the front as one shape instead of patching it. The unprinted half
and the printed label are both found as connected regions of flat colour; the
convex hull of the two is the carton's real front quad, and filling that quad
with the label's own black leaves nothing to misalign. The lid strip keeps its
rounded corner, so it is recoloured in place rather than squared off. Finally
the brand logo replaces the condensed wordmark that was printed on the panel.

Run from the project root:  python tools/fix-box-image.py

Needs Pillow and NumPy. Rerun this rather than hand-editing the PNG, so the
retouch stays reproducible from the file the client supplied.
"""

import os
from collections import deque

import numpy as np
from PIL import Image, ImageDraw, ImageFilter

ROOT     = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
IMAGES   = os.path.join(ROOT, 'assets', 'images')
SRC      = os.path.join(IMAGES, '_withdrawn', 'product-box-open-white-panels.png')
LOGO     = os.path.join(IMAGES, 'logo.png')
OUT      = os.path.join(IMAGES, 'product-box-open.png')
OUT_WEBP = os.path.join(IMAGES, 'product-box-open.webp')

# Seeds into the four flat regions of the supplied file. They are coordinates
# in that file, so they only change if the source photograph is re-supplied.
SEED_FRONT_UNPRINTED = (200, 1100)
SEED_FRONT_LABEL     = (380, 1150)
SEED_LID_UNPRINTED   = (200, 70)

PANEL     = np.array([23, 23, 22], float)   # the printed label's own black
LOGO_W    = 470                             # logo width on the panel, in px
LOGO_AT   = (560, 1056)                     # its centre on the panel

im = Image.open(SRC).convert('RGBA')
a = np.array(im).astype(float)
rgb, al = a[:, :, :3], a[:, :, 3]
H, W = al.shape


def flood(mask, seed):
    """The 4-connected component of `mask` containing `seed`, given as (x, y)."""
    out = np.zeros_like(mask)
    sx, sy = seed
    assert mask[sy, sx], 'seed not in mask: %s' % (seed,)
    q = deque([(sy, sx)])
    out[sy, sx] = True
    while q:
        y, x = q.popleft()
        for ny, nx in ((y + 1, x), (y - 1, x), (y, x + 1), (y, x - 1)):
            if 0 <= ny < H and 0 <= nx < W and mask[ny, nx] and not out[ny, nx]:
                out[ny, nx] = True
                q.append((ny, nx))
    return out


def hull(mask):
    """Convex hull of a boolean mask, as a list of (x, y) in order."""
    ys, xs = np.nonzero(mask)
    pts = sorted(set(zip(xs.tolist(), ys.tolist())))

    def half(seq):
        h = []
        for p in seq:
            while len(h) > 1 and ((h[-1][0] - h[-2][0]) * (p[1] - h[-2][1])
                                  - (h[-1][1] - h[-2][1]) * (p[0] - h[-2][0])) <= 0:
                h.pop()
            h.append(p)
        return h

    return half(pts)[:-1] + half(pts[::-1])[:-1]


def simplify(poly, tol=2.0):
    """Drop hull vertices within `tol` of the chord beside them, so a quad that
    is a few pixels ragged comes back as four corners."""
    p = list(poly)
    changed = True
    while changed and len(p) > 4:
        changed = False
        for i in range(len(p)):
            a_, b_, c_ = p[i - 1], p[i], p[(i + 1) % len(p)]
            dx, dy = c_[0] - a_[0], c_[1] - a_[1]
            length = (dx * dx + dy * dy) ** .5 or 1
            if abs(dx * (a_[1] - b_[1]) - (a_[0] - b_[0]) * dy) / length < tol:
                p.pop(i)
                changed = True
                break
    return p


def grow(poly, px):
    """Push a convex polygon outward by `px` pixels, so it covers the
    anti-aliased fringe the original edge left behind."""
    xs = [q[0] for q in poly]
    ys = [q[1] for q in poly]
    cx, cy = (min(xs) + max(xs)) / 2, (min(ys) + max(ys)) / 2
    w, h = max(xs) - min(xs), max(ys) - min(ys)
    fx, fy = (w + 2 * px) / w, (h + 2 * px) / h
    return [(cx + (x - cx) * fx, cy + (y - cy) * fy) for x, y in poly]


SS = 4   # supersample, for an anti-aliased edge on the filled quad


def polymask(poly):
    big = Image.new('L', (W * SS, H * SS), 0)
    ImageDraw.Draw(big).polygon([(x * SS, y * SS) for x, y in poly], fill=255)
    return np.array(big.resize((W, H), Image.LANCZOS)).astype(float) / 255.0


white = ((abs(rgb[:, :, 0] - 244) < 14) & (abs(rgb[:, :, 1] - 245) < 14)
         & (abs(rgb[:, :, 2] - 246) < 14) & (al > 150))
dark = (rgb.sum(2) < 110) & (al > 150)

front_unprinted = flood(white, SEED_FRONT_UNPRINTED)
front_label     = flood(dark,  SEED_FRONT_LABEL)
lid_unprinted   = flood(white, SEED_LID_UNPRINTED)

front_poly = simplify(hull(front_unprinted | front_label))
print('front panel quad:', [(round(x), round(y)) for x, y in front_poly])

front = polymask(grow(front_poly, 2.5))
# The unprinted half carried a light fringe of its own; cover that too.
fringe = Image.fromarray((front_unprinted * 255).astype('uint8'), 'L')
fringe = fringe.filter(ImageFilter.MaxFilter(7)).filter(ImageFilter.GaussianBlur(0.8))
front = np.clip(front + np.array(fringe).astype(float) / 255.0, 0, 1)

# The lid strip keeps its rounded corner, so recolour it in place and feather
# the edge rather than squaring it off with a hull.
lid = Image.fromarray((lid_unprinted * 255).astype('uint8'), 'L')
lid = lid.filter(ImageFilter.MaxFilter(5)).filter(ImageFilter.GaussianBlur(0.8))
lid = np.array(lid).astype(float) / 255.0

m = np.clip(front + lid, 0, 1)[:, :, None]
out_rgb = rgb * (1 - m) + PANEL * m
out_al = np.maximum(al, m[:, :, 0] * 252)
res = Image.fromarray(np.dstack([out_rgb, out_al]).round().clip(0, 255).astype('uint8'), 'RGBA')

# Brand logo in place of the condensed wordmark, centred on the now-uniform
# panel. NOTE: the cartons as printed still carry the old mark - see README.
logo = Image.open(LOGO).convert('RGBA')
logo = logo.crop(logo.getbbox())
logo = logo.resize((LOGO_W, round(LOGO_W * logo.height / logo.width)), Image.LANCZOS)
res.alpha_composite(logo, (LOGO_AT[0] - logo.width // 2, LOGO_AT[1] - logo.height // 2))

res.save(OUT_WEBP, 'WEBP', quality=88, method=6)

# The source is a 256-colour PNG; antialiasing the new panel edge and the logo
# pushes that to ~1900 and the file to 2.4x its weight for no visible gain, so
# the PNG fallback goes back to a palette. Max channel delta against the
# full-colour render is ~58 on a handful of logo edge pixels, mean 0.45.
res.quantize(colors=256, method=Image.FASTOCTREE, dither=Image.NONE).save(OUT, optimize=True)
print('wrote', OUT, res.size)
print('wrote', OUT_WEBP)
print('now mirror both into wp-theme/imperial-steaks/assets/images/')
