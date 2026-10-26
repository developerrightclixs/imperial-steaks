"""Convert a run of text into a single SVG path, using a real font file.

Returns path data in a coordinate system where y grows downward and the text
baseline sits at y=0, scaled so that 1 unit == 1 px at the requested size.
"""
from fontTools.ttLib import TTFont
from fontTools.pens.svgPathPen import SVGPathPen
from fontTools.pens.transformPen import TransformPen
from fontTools.misc.transform import Transform

_cache = {}


def _font(path):
    if path not in _cache:
        f = TTFont(path)
        _cache[path] = (f, f.getGlyphSet(), f["head"].unitsPerEm,
                        f.getBestCmap(), f["hmtx"])
    return _cache[path]


def text_path(path, string, size, tracking=0.0):
    """tracking is extra advance per character, in px."""
    font, gs, upem, cmap, hmtx = _font(path)
    scale = size / upem
    pen = SVGPathPen(gs)
    x = 0.0
    for ch in string:
        name = cmap.get(ord(ch))
        if name is None:
            x += size * 0.3 + tracking
            continue
        # flip y so the path is in screen coordinates with baseline at y=0
        tp = TransformPen(pen, Transform(scale, 0, 0, -scale, x, 0))
        gs[name].draw(tp)
        x += hmtx[name][0] * scale + tracking
    return pen.getCommands(), x - tracking


def text_width(path, string, size, tracking=0.0):
    font, gs, upem, cmap, hmtx = _font(path)
    scale = size / upem
    x = 0.0
    for ch in string:
        name = cmap.get(ord(ch))
        x += (hmtx[name][0] * scale if name else size * 0.3) + tracking
    return x - tracking
