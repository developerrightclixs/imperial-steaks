# Brand artwork generators

The Imperial Steaks logos, the carton mockup and the product-photo placeholders
are generated rather than hand-drawn, so they can be re-cut at any size or in
any palette without opening a design tool.

## What each script makes

| Script | Output (into `assets/images/`) |
|---|---|
| `make_logos.py` | `logo-concept-{1,2,3}.svg` plus `-onlight` and `-onred` variants — 9 files |
| `make_assets.py` | `product-box-mockup.svg` and the six `product-*.svg` placeholders |
| `textpath.py` | Shared helper: converts a run of text into an SVG path using a real font file |

Type is converted to outlines, so the artwork renders identically everywhere
with no webfont dependency — which matters for a logo that has to survive being
dropped into a printer's artwork or an email signature.

## Running them

```sh
pip install fonttools

# Fonts are not committed. Fetch the four OFL faces the artwork uses:
mkdir -p tools/brand-assets/fonts
cd tools/brand-assets/fonts
curl -o bodoni900.ttf  "https://fonts.gstatic.com/s/bodonimoda/v28/aFT67PxzY382XsXX63LUYL6GYFcan6NJrKp-VPjfJMShrpsGFUt8oefdwIA.ttf"
curl -o oswald700.ttf  "https://fonts.gstatic.com/s/oswald/v57/TK3_WkUHHAIjg75cFRf3bXL8LICs1xZogUE.ttf"
curl -o oswald200.ttf  "https://fonts.gstatic.com/s/oswald/v57/TK3_WkUHHAIjg75cFRf3bXL8LICs13FvgUE.ttf"
curl -o poppins600.ttf "https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLEj6V1s.ttf"
cd -

python tools/brand-assets/make_logos.py  assets/images
python tools/brand-assets/make_assets.py assets/images
```

The URLs above are whatever `https://fonts.googleapis.com/css2?family=...`
currently serves; if one 404s, re-fetch that CSS and take the new URL from it.

All four faces are SIL Open Font License, which permits use in a logo.

## Changing the colours

The palette is duplicated at the top of each script as plain constants
(`RED`, `YELLOW`, `BLACK`). Keep them in step with `assets/css/global.css` and
`docs/BRAND_COLOURS.md`.

## After regenerating

Copy the output into the theme too, then rebuild:

```sh
cp assets/images/*.svg wp-theme/imperial-steaks/assets/images/
python tools/build-theme-templates.py
```
