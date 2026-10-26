# Imperial Steaks — brand colours

**For the printer.** These are the values to use for the cartons and the brochure.
They are the same values the website uses — but note that the brand red is now
`#FF0000`, which is outside the CMYK gamut, so print and web will **not** match
exactly on the red. See the printer's note in §2 before quoting.

Last updated: 20 October 2026 (second revision that day). **The brand red
changed twice on this date — see §2. Use only this copy.**

---

## 1. Matte black — the only black

The client asked for matte black only. The previous build mixed three blacks
(onyx `#0F0F10`, matte `#171717`, charcoal `#242424`) across different sections,
which is what produced the "mixed dark and light grey sections" he did not want.
There is now one black, used for every section background.

| | Value |
|---|---|
| **HEX** | `#1A1A1A` |
| **RGB** | 26 / 26 / 26 |
| **CMYK — flat** | 0 / 0 / 0 / 100 |
| **CMYK — rich black (recommended for the box)** | 60 / 40 / 40 / 100 |
| **Pantone (closest)** | Neutral Black C |

**Note for the printer:** on a large matte surface, flat 100% K prints washed-out
and patchy. Use the rich black build above, or a 100% K plus a matte laminate.
Ask for a soft-touch / matte varnish rather than gloss — the whole brand is built
on the matte finish.

---

## 2. Brand red

**⚠ CHANGED TWICE ON 20 OCTOBER 2026. Discard every earlier copy of this
sheet, including one dated earlier the same day.** Anything already sent to
plate against `#F21B26` or `#ED1C24` needs re-checking.

The brand red is **pure red: `#FF0000`**.

This is the client's own specification, given as a flat value, and it replaces
`#ED1C24` (set earlier on 20 October from the Hormel / JBS reference marks) and
the `#F21B26` / `#EC3237` pair before that. It is no longer derived from any
reference mark — it is simply pure red.

| | Value |
|---|---|
| **HEX** | `#FF0000` |
| **RGB** | 255 / 0 / 0 |
| **CMYK (nominal)** | 0 / 100 / 100 / 0 |
| **Pantone** | **No exact match — see the note below.** |

**Note for the printer — read this before quoting.** `#FF0000` is an RGB
display primary. It sits **outside the CMYK gamut**, so it cannot be reproduced
exactly in process printing. The 0/100/100/0 build above is the nominal
conversion and is what a press will actually give you: a red that reads
noticeably darker and duller than the on-screen colour. There is no Pantone
book colour that matches `#FF0000` either; the nearest bright spot reds are in
the **Red 032 C / Warm Red C** family, and a draw-down is required before
anyone commits to a plate.

Practically this means:

* **On screen (website, email, social) the colour is exact** — `#FF0000` is
  what the brief asks for and what the site now renders.
* **In print it is an approximation.** If the carton can carry a spot plate,
  pick the spot red from a physical book against the artwork and accept that it
  will not be identical to the screen colour. If it is process only, expect
  batch-to-batch shift — saturated reds are the worst case for this.
* **Flag back to the client** that print and web will not match exactly on this
  value, which is the trade-off that comes with specifying a display primary.
  `#ED1C24` had a real book colour behind it (1788 C); `#FF0000` does not.

### Web-only variants

These exist so buttons and links have states. They are **not** for print.

| Use | HEX |
|---|---|
| Hover / pressed | `#D40000` |
| Focus ring and link hover | `#FF0000` |

---

## 3. Chicken yellow

The brief splits the range by colour: **chicken = yellow**, **beef = red + black**.
This is the yellow. It always carries black text, never white — white on yellow
fails contrast badly.

| | Value |
|---|---|
| **HEX** | `#F2A900` |
| **RGB** | 242 / 169 / 0 |
| **CMYK** | 0 / 32 / 100 / 0 |
| **Pantone** | **130 C** (coated) / 130 U (uncoated) |

---

## 4. Supporting neutrals (web only)

| Use | HEX |
|---|---|
| White — headings, reversed type | `#FFFFFF` |
| Body copy on matte black | `#C9C9C9` |
| Labels, eyebrows, muted type | `#8C8C8C` |
| Hairlines on black | `rgba(255,255,255,0.14)` |
| Card surface on black | `rgba(255,255,255,0.045)` |

The card surface is a translucent white rather than a second grey, deliberately.
A solid second grey is what made the old build look like it had light and dark
sections.

---

## 5. How they combine

| Surface | Background | Type |
|---|---|---|
| Default section | Matte black `#1A1A1A` | White / `#C9C9C9` |
| Accent band | Brand red `#FF0000` | White |
| Chicken product | Yellow `#F2A900` | Matte black `#1A1A1A` |
| Beef product | Red + matte black | White |
| Product code chip, black band | Brand red `#FF0000` | Matte black `#1A1A1A` |
| Product code chip, red band | Matte black `#1A1A1A` | Brand red `#FF0000` |

Pages alternate matte black and red down the page. The chicken yellow appears
only on chicken product surfaces, so it stays a signal rather than a third
background colour.

### Contrast

Measured against the WCAG 2.1 formula, not estimated.

| Combination | Ratio | WCAG |
|---|---|---|
| White on `#1A1A1A` | 17.4:1 | AAA |
| `#C9C9C9` on `#1A1A1A` | 10.5:1 | AAA |
| `#1A1A1A` on `#F2A900` | 8.7:1 | AAA |
| White on `#FF0000` | **4.00:1** | **AA large text only** |
| `#1A1A1A` on `#FF0000` | **4.35:1** | **AA large text only** |
| `#FF0000` on `#1A1A1A` | **4.35:1** | **AA large text only** |

**⚠ Every combination involving the red is now a shortfall.** None of the three
reaches the 4.5:1 AA floor for text under 18.66px. All three clear the 3:1
large-text floor.

**Correction to the earlier sheet.** The 20 October morning version listed
`#1A1A1A` on `#ED1C24` as 4.79:1 and `#ED1C24` on `#1A1A1A` as 3.97:1. Those
are the same pair of colours, and contrast ratio is symmetric — both were in
fact 3.97:1, and the 4.79 figure was an error. The claim in `components.css`
that the black-on-red chip "passes AA outright" was therefore wrong, and has
been corrected there as well.

**What changed with the move to `#FF0000`.** It is a trade, not a loss:

| | `#ED1C24` (old) | `#FF0000` (now) |
|---|---|---|
| White on red | 4.38:1 | **4.00:1** — worse |
| Black on red | 3.97:1 | **4.35:1** — better |

So the red bands' white body copy got slightly harder to read, and the product
code chips got slightly easier. Neither crosses the AA line in either
direction.

Where it bites, in practice:

* **Fine as they are** — every heading on a red band, the buttons, the card
  labels, the brand-values line. All are large or bold enough to qualify under
  the 3:1 large-text rule.
* **Below AA** — the 16px paragraphs on the red bands: the homepage
  introduction, the About page "Quality & Pricing" column, and the Contact page
  "Send us a message" line. They are set at weight 400 instead of 300 so they
  read as solidly as the colour allows, but weight does not change the ratio.
* **Below AA** — the 13px product code chip (`XLS`, `XL`, `NS` …) in both its
  forms. It is decorative rather than load-bearing: the same code is repeated
  in the heading immediately below it, so nothing is lost to a reader who
  cannot resolve the chip.

The Contact page's six detail cards used to be on this list. They came off the
red on 20 October at the client's request and now measure 17.4:1.

**This is the client's call and has been applied as given.** `#FF0000` is the
hardest red there is to pass contrast with — it is already at maximum
luminance for a pure hue, so there is no version of it that scores better.
If the shortfalls need closing later, in order of least disruption:

1. Set the red-band paragraphs at 18px bold — they then qualify as large text
   and clear AA at 3:1 with no colour change at all. **Recommended.**
2. Move those paragraphs onto the black bands, where they measure 17.4:1.
3. Keep `#FF0000` everywhere it is seen as brand — logo, chips, buttons,
   accents — but use a darkened red for **large text backgrounds only**
   (around `#D81124` reaches 4.5:1 against white). This breaks the "one red"
   rule and needs the client's agreement.

---

## 6. Where these are set in the code

`assets/css/global.css`, in the `:root` block at the top:

```css
--is-black:       #1A1A1A;
--is-red:         #FF0000;   /* pure red      - the one brand red */
--is-red-dark:    #D40000;   /* darkened step - hover/pressed     */
--is-red-bright:  #FF0000;   /* link hover and focus rings        */
--is-yellow:      #F2A900;
```

The red is **also baked into the logo artwork** — `assets/images/*.svg`, the
favicon and the box mockup all carry it as a literal hex, and so do the two
generators in `tools/brand-assets/`. All of them were updated on 20 October, in both this revision and the one before it.
Changing the red again means changing those files too, not just the token.

In WordPress, re-enter the same three under **Elementor → Site Settings →
Global Colors** so every widget inherits them. See `docs/ELEMENTOR_MIGRATION.md`.
