"""Generate the Imperial Steaks box mockup and the product-photo placeholders.

All product photography recovered from the old site has been pulled at the
client's instruction, and the real shots have not arrived yet. These stand in
for them: matte black, on-palette, and obviously placeholders rather than
pretend food photography.
"""
import os
import sys

HERE = os.path.dirname(os.path.abspath(__file__))
sys.path.insert(0, HERE)
from textpath import text_path, text_width  # noqa: E402

FONTS = os.path.join(HERE, "fonts")
OSWALD_BOLD = os.path.join(FONTS, "oswald700.ttf")
OSWALD_LIGHT = os.path.join(FONTS, "oswald200.ttf")
POPPINS = os.path.join(FONTS, "poppins600.ttf")

BLACK = "#1A1A1A"
RED = "#FF0000"
YELLOW = "#F2A900"
WHITE = "#FFFFFF"


def centred(font, string, size, tracking, cx, baseline, fill):
    d, _ = text_path(font, string, size, tracking)
    w = text_width(font, string, size, tracking)
    return (f'<g transform="translate({cx - w / 2:.1f} {baseline:.1f})">'
            f'<path fill="{fill}" d="{d}"/></g>')


# ---------------------------------------------------------------------------
# Matte black carton, three-quarter view, with the wordmark on the front face.
# The client asked for the box to read "Imperial Steaks" on a matte black box.
# ---------------------------------------------------------------------------
def box_mockup():
    W, H = 900, 600
    # Front face.
    fx0, fy0, fx1, fy1 = 150, 225, 700, 540
    dx, dy = 115, 78          # depth offset toward the upper right
    parts = [
        f'<rect width="{W}" height="{H}" fill="{BLACK}"/>',
        # No cast shadow: on a matte black page it reads as a floating smudge.
        # The faces separate on their edge highlights instead.
        # Top face.
        f'<path fill="#2A2A2A" d="M{fx0} {fy0} L{fx0 + dx} {fy0 - dy} '
        f'L{fx1 + dx} {fy0 - dy} L{fx1} {fy0} Z"/>',
        # Right face.
        f'<path fill="#121212" d="M{fx1} {fy0} L{fx1 + dx} {fy0 - dy} '
        f'L{fx1 + dx} {fy1 - dy} L{fx1} {fy1} Z"/>',
        # Front face.
        f'<rect x="{fx0}" y="{fy0}" width="{fx1 - fx0}" height="{fy1 - fy0}" fill="#1E1E1E"/>',
        # Edge highlights, so the faces separate without a second grey section.
        f'<path fill="none" stroke="{WHITE}" stroke-opacity="0.10" stroke-width="2" '
        f'd="M{fx0} {fy0} L{fx0 + dx} {fy0 - dy} L{fx1 + dx} {fy0 - dy} '
        f'L{fx1 + dx} {fy1 - dy} L{fx1} {fy1} L{fx0} {fy1} Z"/>',
        f'<path fill="none" stroke="{WHITE}" stroke-opacity="0.10" stroke-width="2" '
        f'd="M{fx0} {fy0} H{fx1} V{fy1} M{fx1} {fy0} L{fx1 + dx} {fy0 - dy}"/>',
    ]

    cx = (fx0 + fx1) / 2
    # Wordmark, matching logo concept 2: IMPERIAL over a red bar reading STEAKS.
    big, small = 70.0, 15.0
    bar_w = text_width(OSWALD_BOLD, "IMPERIAL", big, 1.0)
    parts.append(centred(OSWALD_BOLD, "IMPERIAL", big, 1.0, cx, 350, WHITE))
    parts.append(f'<rect x="{cx - bar_w / 2:.1f}" y="364" width="{bar_w:.1f}" '
                 f'height="32" fill="{RED}"/>')
    parts.append(centred(OSWALD_LIGHT, "STEAKS", small, 9.0, cx, 388, WHITE))
    # Product descriptor, as it would be printed on a real carton.
    parts.append(centred(POPPINS, "THIN SLICED PHILLY STEAK", 13.0, 3.0, cx, 452,
                         "#9A9A9A"))
    parts.append(f'<rect x="{cx - 70:.1f}" y="476" width="140" height="2" '
                 f'fill="{WHITE}" opacity="0.25"/>')
    parts.append(centred(POPPINS, "KEEP FROZEN", 11.0, 2.5, cx, 508, "#7A7A7A"))

    body = "\n  ".join(parts)
    return (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" '
            f'width="{W}" height="{H}" role="img" '
            f'aria-label="Imperial Steaks matte black carton">\n'
            f'  <title>Imperial Steaks matte black carton</title>\n  {body}\n</svg>\n')


# ---------------------------------------------------------------------------
# Product-photo placeholders. One per product still waiting on photography.
# ---------------------------------------------------------------------------
def placeholder(code, name, accent):
    """One product placeholder.

    Client revision, 16 Oct: the frame is brighter and heavier; the PRODUCT
    CODE is red (never white, never yellow) and set larger; the RULE under it
    is white and thick enough to read. The DESCRIPTOR LINE (the product name,
    e.g. "HOUSE BLEND") and the STATUS LINE ("PRODUCT PHOTOGRAPHY TO FOLLOW")
    were both dropped - those are the two lines to ask for by name if they are
    ever wanted back. The product name still shows on the caption under the
    tile, which is page markup, not artwork.

    `accent` stays per-product (red, yellow for chicken) because it still
    drives the frame; only the code colour is fixed to red.
    """
    W, H = 900, 600
    cx = W / 2
    parts = [
        f'<rect width="{W}" height="{H}" fill="{BLACK}"/>',
        f'<rect x="16" y="16" width="{W - 32}" height="{H - 32}" fill="none" '
        f'stroke="{accent}" stroke-opacity="1" stroke-width="6" '
        f'stroke-dasharray="20 12" rx="18"/>',
        centred(OSWALD_BOLD, code, 187.5, 5.0, cx, 347, RED),
        f'<rect x="{cx - 130:.1f}" y="383" width="260" height="10" fill="{WHITE}"/>',
    ]
    body = "\n  ".join(parts)
    return (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" '
            f'width="{W}" height="{H}" role="img" '
            f'aria-label="{name} - product photography to follow">\n'
            f'  <title>{name} - product photography to follow</title>\n'
            f'  {body}\n</svg>\n')


PLACEHOLDERS = [
    ("product-xls.svg",  "XLS",  "House Blend",       RED),
    ("product-xl.svg",   "XL",   "Traditional Philly", RED),
    ("product-ns.svg",   "NS",   "Premium Philly",    RED),
    ("product-re.svg",   "RE",   "Rib Eye",           RED),
    ("product-epic.svg", "EPIC", "Signature Blend",   RED),
    ("product-chx.svg",  "CHX",  "Premium Chicken",   YELLOW),
]

if __name__ == "__main__":
    out = sys.argv[1]
    with open(os.path.join(out, "product-box-mockup.svg"), "w", encoding="utf-8") as fh:
        fh.write(box_mockup())
    print("product-box-mockup.svg")
    for filename, code, name, accent in PLACEHOLDERS:
        with open(os.path.join(out, filename), "w", encoding="utf-8") as fh:
            fh.write(placeholder(code, name, accent))
        print(filename)
