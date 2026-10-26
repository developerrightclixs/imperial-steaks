# Imperial Steaks — static prototype

Rebuild of the **Imperial Steaks** website (reference: https://tastysteaks.ca/) as a
plain HTML5 / CSS3 prototype with one small vanilla-JS file, structured for a
later WordPress + Elementor rebuild.

> **Revision round 2 — 16 October 2026.** The client's second set of notes has
> been applied: new brand red, a restructured homepage where every section
> declares its own background colour, a Retail page that is nothing but COMING
> SOON, Warehouse-and-postcode in the footer and on Contact, and redrawn product
> placeholders. See **"What changed in this round"** below, and
> `docs/PAGE_SECTION_MAP.md` for the section-by-section detail. The first
> revision round (13 October: the Tasty Steaks → Imperial Steaks rebrand) is
> summarised under it.
>
> **Three things to confirm before launch:**
> 1. The old reference site is **tastysteaks.ca**, but the new brand was given as
>    `imperialsteaks.com`. Verify the business actually owns that domain.
> 2. `sales@imperialsteaks.com` must be a mailbox that exists before launch.
> 3. **White body copy on the new red measures 4.2:1 — just under WCAG AA.**
>    It was 5.9:1 on the previous red. Headings and buttons are fine; the 16px
>    paragraphs on the red bands are not. Detail and the three ways out:
>    `docs/BRAND_COLOURS.md` §5.

Internal office project. **Not deployed** — no production deployment has been
made or is implied.

---

## Preview it locally (no build step)

Nothing to compile, install, or bundle. There is no `package.json`, no
dependencies, and no toolchain.

**Option A — open the file directly**

Double-click `index.html`. Every page, style and link works from `file://`.

**Option B — a local static server** (recommended; matches production path
resolution)

```bash
# from the project root
python -m http.server 8077
# then open http://127.0.0.1:8077/index.html
```

Any equivalent works: `npx serve .`, `php -S localhost:8077`, VS Code Live
Server. The only external request the pages make is to Google Fonts; with no
network the pages still render correctly on the declared fallback fonts.

---

## Project structure

```text
imperialsteaks/
├── index.html                      # Home
├── about.html                      # About Us
├── products.html                   # Products (6 products, anchored)
├── retail.html                     # Retail  (see "Decisions taken" below)
├── contact.html                    # Contact Us
├── assets/
│   ├── css/
│   │   ├── global.css              # :root design tokens, reset, typography, layout primitives
│   │   ├── components.css          # 15 reusable component blocks
│   │   └── animations.css          # scroll reveals, sticky-header state, back-to-top
│   ├── js/
│   │   └── main.js                 # mobile nav toggle + carousel arrows — not migrated
│   ├── images/                     # logos, badges, box, product + hero photography
│   └── images/_withdrawn/          # superseded placeholders and old-site photos
├── docs/
│   ├── SITE_AUDIT.md               # Phase A audit of the reference site (read this first)
│   ├── ELEMENTOR_MIGRATION.md      # Section → Elementor widget map + global style values
│   ├── PAGE_SECTION_MAP.md         # Page order, sections, classes, what changed per section
│   ├── IMAGE_REPLACEMENT_LIST.md   # Image inventory and replacement instructions
│   └── BRAND_COLOURS.md            # HEX / CMYK / Pantone spec — hand this to the printer
├── tools/
│   ├── fetch-original-images.py    # recovers the original imagery from the Wayback Machine
│   ├── place-product-images.py     # crops the client's `Product image/` drop to the 3:2 slots
│   ├── build-theme-templates.py    # regenerates the theme's page templates from these pages
│   └── brand-assets/               # generators for the logos, box mockup and placeholders
├── wp-theme/
│   ├── imperial-steaks/               # WordPress theme source (see its own README)
│   └── imperial-steaks.zip            # ready to upload: Appearance > Themes > Add New
├── logo-concepts.html              # internal review sheet: the 3 logo concepts
└── IMPERIAL_STEAKS_CLAUDE_CODE_SPEC.md
```

Page filenames follow the audited site's four real pages plus `retail.html` (see
below). `foodservice.html` was **not** created — Foodservice is a section, as the
brief specifies.

---

## ⚠️ Audit finding that needs escalating

**tastysteaks.ca is serving injected online-casino / gambling SEO spam.** Every
page carries 5–6 blocks of injected casino copy, and the homepage links to 100+
URLs under `/ca/online-casinos/`. None of it has been copied into this build;
all extraction filtered it out explicitly.

The client should be told the reference site appears compromised, and the host
should audit the install. It is also an additional reason not to restore a
backup. Full detail: `docs/SITE_AUDIT.md` §3.

---

## What changed in this round (20 Oct 2026 — client website changes)

Six items off the client's Trello card. Five are done; one needs files from him.

* **The brand red is now pure red, `#FF0000`, and there is only one of it.**
  The red moved twice on 20 Oct: first to `#ED1C24` (both the Hormel and JBS
  marks he named publish that value, so the `#F21B26` / `#EC3237` pair was
  dropped), then to `#FF0000` when he specified pure red outright. `#FF0000`
  is what is live. Hover is `#D40000`, a darkened step off it. This touched
  more than the token: the logo SVGs, the favicon, the box mockup and the two
  generators in `tools/brand-assets/` all carried the red as a literal and
  were updated with it, as did the WordPress theme's copy of the stylesheets.
  **`docs/BRAND_COLOURS.md` §2 is reissued — discard any earlier copy,
  including one dated earlier on 20 Oct, before anything goes to plate.**
  Two things flagged there and worth repeating: `#FF0000` is outside the CMYK
  gamut so print will not match the screen, and every red/white and red/black
  pairing now sits below the 4.5:1 AA contrast floor (all still clear 3:1 for
  large text). Both are consequences of the value itself, not of how it was
  applied.
* **The hero is sentence case and the two lines now match.** "Quality you can
  trust" over "Service you can rely on", both at 54px in white. Line 2 was
  26px uppercase in red. The uppercase came from CSS, not the markup.
* **The product code chips swapped grounds.** Black type throughout: red
  ground with black type on the black bands, black ground with red type on the
  red bands. The yellow chicken band already worked this way and is unchanged.
* **The Contact cards came off the red.** Six solid red boxes was "too much
  red". They now use the surface treatment every other card on the site
  already uses — translucent white on matte black, hairline, 3px red left rule
  — which drops the red to an accent without adding a colour. The "Send us a
  message" band below them is still red; it is the page's one red band.
* **The website URL reads `www.imperialsteaks.com`** in all five footers, the
  Contact card, and the WordPress Customizer default.
* **The Categories cards went round twice, and both are now placed.** He asked
  for the cattle and poultry shots to be changed, supplied **raw-product**
  shots for both, then supplied **live-animal** shots and asked for those
  instead. Live animals is the direction that stands.
  * **Beef** — a Holstein cow in pasture, cropped to 3:2, `alt` rewritten.
    **[NOTE]** Holstein is a *dairy* breed and the shot it replaces was a beef
    breed; raised with him and he kept it.
  * **Chicken** — **replaced 23 Oct, and this one is no longer a photograph.**
    The client supplied a chicken *cuts diagram* (neck, back, wing, breast,
    thigh, drumstick), which now carries the card as
    `category-chicken.png`. It is artwork on a transparent ground, so it takes
    the `--mark` treatment the Halal seal uses — white plate, contained, not
    cropped — because the bird is near-black and would vanish on the media
    slot's black. **This clears the watermark problem**: the rooster shot is
    out of the build and parked in `_withdrawn/` as
    `category-chicken-rooster-watermarked.jpg`.
    * **[FLAG] provenance, not watermark.** The diagram carries no visible
      mark, but it was supplied as a bare PNG with no licence attached and it
      has the look of stock clipart. Client-supplied is not the same as
      client-owned. Worth one question before launch — a much smaller one
      than the TRVST position it replaces.
    * **[DECISION OPEN] the row is now mixed** — Beef is a photograph, Chicken
      is a diagram. It reads fine (see the Categories row), but it is a visible
      inconsistency. Either Beef wants a matching beef-cuts diagram or Chicken
      wants to go back to photography. The client has not been asked yet.
  * The raw-product pair from earlier in the day is kept in `_withdrawn/` in
    case that direction comes back — `docs/IMAGE_REPLACEMENT_LIST.md` §2c.

**The licence question is still the main thing outstanding on imagery, but as
of 23 Oct it is back to theoretical.** Nothing on this build is work Imperial
Steaks commissioned — the product photographs, the Beef card and the hero
frames all came from elsewhere. The one *active* rights-holder claim, the
watermarked rooster, is now out of the build, replaced by the client's own
cuts diagram. What remains is unconfirmed provenance across the rest, which is
the ordinary version of this problem rather than the urgent one.
`docs/IMAGE_REPLACEMENT_LIST.md` §1 items 0 and 1 have the full position. This
still wants a direct conversation with the client before launch.

Two accessibility notes, both recorded in `docs/BRAND_COLOURS.md` §5. The
Contact change *fixed* the page's worst ratio (white on red 4.38:1 → white on
black 17.4:1). The chip change introduced one: red on black measures 3.97:1,
under the AA floor for 13px type. It was applied as instructed; the code is
repeated in the heading beside it, so nothing is carried by the chip alone.

---

## What changed in this round (16 Oct 2026, evening — the photography drop)

The client supplied a `Product image/` folder. **Every file in it has been
placed**, and the two things the morning round left open are now closed.

* **All six product slots carry a real photograph.** `product-xls`, `-xl`,
  `-ns`, `-re`, `-epic` and `-chx` are now `.jpg`, cropped to the 3:2 slot and
  exported inside the 250 KB budget. The dashed placeholder tiles moved to
  `assets/images/_withdrawn/product-*.svg`.
* **But only four products were actually named in the drop** — NS, XL, rib eye
  and chicken. **House Blend XLS** and **Signature Blend EPIC** had no file of
  their own, so the folder's two unlabelled generic beef shots were **assigned**
  to them. Those two slots look finished but are not yet photographs of the
  products they name. Needs the client's word —
  `docs/IMAGE_REPLACEMENT_LIST.md` §4.
* **The hero chicken frame is replaced** — the chicken cheesesteak from the same
  folder, written over the same filename at the same 880 × 520, so no markup
  changed. The Ritter crop is kept at
  `_withdrawn/hero-chicken-philly-ritter-crop.jpg`.
* **The Rib Eye slot is the client's own photograph** (`IMG_3096` of the eight
  he sent), a lined case of whole-muscle rib eye rolls. It is the strongest file
  in the set. Alternates are listed in `docs/IMAGE_REPLACEMENT_LIST.md` §4.
* **Two files were deliberately not used.** `philly steak raw frozen.avif` is a
  **Walmart Great Value retail carton** and cannot go on the site.
  `philly chicken steak raw frozen.jpg` is a beef cheesesteak (misnamed) that
  would replace the hero beef frame — left alone because the client said to keep
  the beef image.
* **Two flags were raised, not cleared.** Most of the supplied files look like
  supplier or retailer product shots rather than an Imperial Steaks shoot — one
  is named for **Diamond State Meats** — so the right to publish needs
  confirming. And **XL**, **NS** and **CHX** came from phone screengrabs and a
  490 px web asset, so they are at their usable limit at the sizes the layout
  asks for. Both are detailed in `docs/IMAGE_REPLACEMENT_LIST.md` §4.
* Theme assets, page templates and `imperial-steaks.zip` were all rebuilt to match.

---

## What changed earlier that day (16 Oct 2026 revision)

Full section-by-section detail is in `docs/PAGE_SECTION_MAP.md`. The headlines:

### Site-wide
* **New brand red, set by the client from two reference marks:** base
  **`#F21B26`** (the Hormel red), hover **`#EC3237`** (the JBS one). They replace
  Pantone 186 C `#C8102E`. Changed in one place — `:root` in
  `assets/css/global.css` — plus the hex baked into the logo, favicon and box
  artwork, so nothing is left on the old value.
  ⚠️ **This costs contrast:** white on the new red is **4.2:1**, under the 4.5:1
  AA threshold for text below 18.66px. Large type and buttons still pass.
  `docs/BRAND_COLOURS.md` §5 records what falls short and the three ways to fix
  it if the client wants it fixed.
* **Print spec re-issued.** `docs/BRAND_COLOURS.md` carries the new CMYK build.
  **No Pantone book value lands on `#F21B26`** — the printer needs a draw-down
  before the carton goes to plate. That is the one thing to tell them.
* **Footer and Contact: "Office" → "Warehouse", with the postal code** —
  **Boucherville, QC J4B 8N4**, on all five pages, on the Contact page card, and
  as the WordPress Customizer default.

### Home — six sections, each one declaring its own background
The client asked to be able to see where a section starts and ends. Every
section now sets its own background and the page alternates
**black · red · black · red · black · red**.

1. **Hero + the two sandwich photographs are now one black section.** Copy is
   top left and all caps: **"QUALITY YOU CAN TRUST"** over **"SERVICE YOU CAN
   RELY ON"** (line 2 is the heading that used to sit above the brand values).
   The "Philly steak importer & distributor." line is gone, the red hero band is
   gone, and the **CHICKEN / BEEF pill labels under the photos are gone**.
2. **Introduction + carton → red.** The carton photograph was retouched so the
   **box reads fully black**: the white bottom panel and the white cut edges are
   out. The band went red so a black box is not sitting on a black page.
3. **Categories → black, with live animal photography back** — the cattle and
   poultry shots from the old site — and **the four brand values now close the
   section** under the cards.
4. **Foodservice → red, untouched otherwise**, as instructed.
5. **Products → black.** All of this round's changes are inside the placeholder
   artwork: brighter, heavier dashed frame; the product code **red, not white**,
   and a quarter larger; a **white** rule under it, thick enough to read; and the
   two small lines under the code removed. Those two are worth naming for the
   team: the **descriptor line** ("HOUSE BLEND") and the **status line**
   ("PRODUCT PHOTOGRAPHY TO FOLLOW").
6. **Standards → red.**

### Retail
* Replaced with **COMING SOON and nothing else** — no banner, no eyebrow pill, no
  paragraph, no button. The heading fills the viewport and scales with it.

### Not done at the time — needs the client
* ~~**The chicken sandwich photograph.**~~ **Closed the same evening** by the
  `Product image/` drop — see the round above. The note it answered: he asked
  for the chicken frame to be changed and the beef one kept.

---

## What changed in the first round (13 Oct 2026 revision)

### Site-wide
* **Rebrand:** Tasty Steaks → Imperial Steaks everywhere — logo, header, footer,
  copyright, body copy, product box, `imperialsteaks.com`,
  `sales@imperialsteaks.com`.
* **Three logo concepts** delivered for selection at **`logo-concepts.html`**,
  each on matte black, brand red and white. IMPERIAL dominates, STEAKS is the
  quiet word. Concept 2 is in place on the review build.
* **Matte black only.** The onyx / matte / charcoal trio is gone; one matte
  black (`#1A1A1A`) now backs every section. Raised surfaces use a translucent
  white overlay rather than a second grey.
* **Chicken is yellow** `#F2A900` (Pantone 130 C); beef is red + black.
* **Removed:** all four "IS" monogram placeholders, every product image
  recovered from the old site, and **the Puck product entirely** (page section,
  carousel slide and footer link).
* **Phone number** removed rather than carried over; every page shows
  `XXX-XXX-XXXX` until the client supplies the new one.

### Home
* Brand values corrected to **Value. Quality. Service. Integrity.**
* Heading "Tasty Philly Steaks" → "Imperial Steaks"; the client's photograph of
  the printed case replaced the drawn box mockup.
* Products band → matte black, Puck removed, Download Guide kept.
* SQF badge label → **Level 3**.

### About Us
* Rebuilt on the old `tastysteaks.ca/about-us-2` structure: intro paragraph with
  no "Who We Are" heading, then a two-column split (quality/pricing + SQF badge
  ‖ "Ideal for your establishment" checklist + closing paragraph), then the
  values band with a button.
* **Urgent fix applied:** the Supplier Standards paragraph no longer ends
  *"according to the information provided by our client"* — that internal note
  was visible on the page.
* Values corrected; SQF Level 2 → Level 3.

### Products
* Backgrounds alternate matte black / red, with the **chicken row on yellow**.
* **Bullets only** — the intro sentences above each list are gone, because they
  repeated the bullets underneath.
* "100% sirloin tip" is now the first bullet wherever it applies.
* Puck section removed.
* **Fixed:** the "Talk to us about your menu" CTA buttons, which were clipped.

### Contact
* Title is just "Contact Us" and smaller; subtitle "Sales & Inquiries".
* The dark boxes with thin red lines are gone: matte black section, **uniform
  solid red cards with white text**. "IS" placeholder removed.

---

## Still blocked on the client

| | Needed for |
|---|---|
| **New phone number** | Footer and Contact page — currently `XXX-XXX-XXXX` |
| ~~**Product photography** (6 slots)~~ | ✅ **Supplied and placed 16 Oct.** All six slots carry a photograph. Rights and resolution still to be confirmed — `docs/IMAGE_REPLACEMENT_LIST.md` §4 |
| ~~**Chicken sandwich photograph**~~ | ✅ **Supplied and placed 16 Oct**, same filename and slot size. Low-resolution original; a larger copy is still worth asking for — `docs/IMAGE_REPLACEMENT_LIST.md` §3 |
| **Rights for the supplied photography** | ⚠️ Most of the new files look like supplier or retailer product shots, one named for **Diamond State Meats**. Confirm the right to publish each — `docs/IMAGE_REPLACEMENT_LIST.md` §4 |
| **Beef / chicken category shots** | The cattle and poultry images are the old site's own and their licence is unconfirmed — `docs/IMAGE_REPLACEMENT_LIST.md` §2a |
| **About Us copy correction** | The client's note: "by the time you wake up" |
| **Logo choice** | Three concepts at `logo-concepts.html` |
| **Corrected About copy** | About page intro |
| **Retail box photography** | Retail page, after Coming Soon |

---

## Decisions taken (and why)

1. **`retail.html` was created.** "Retail" is in the reference site's primary
   menu but is a `menu-item-type-custom` with **no `href` and no page behind it**
   — `/retail/` 404s. Keeping the menu item without a page would mean shipping a
   dead nav item. The page therefore exists, but contains only client-supported
   facts plus a visible review placeholder.
2. **No `foodservice.html`.** The brief calls for a Foodservice *section*; it
   appears on Home, About and Retail in the site's existing card style.
3. **Template choice: the reference site's own stack.** tastysteaks.ca is
   Astra + **Elementor**. Rather than bolt on a third-party HTML theme, this
   prototype mirrors Elementor's own box model — 1140px boxed containers,
   flex/grid containers, 1024px/767px breakpoints, 25px/20px radii, pill buttons
   — all measured from the reference site's generated CSS. The rebuild is then a
   transcription, not a reinterpretation. Rationale and measurements:
   `docs/SITE_AUDIT.md` §1 and §4.
4. **Typography matches the original exactly** — Poppins (body/headings), Oswald
   (hero line 1), Aleo (hero line 2), Bodoni Moda (brand values), at the measured
   sizes, weights and letter-spacing.
5. **Red is used in four restrained roles only** — accent band backgrounds,
   short rules under headings, card/callout accent borders, and the CTA band. Not
   every white area was turned red. The Categories band is the single
   white-to-red substitution, flagged for approval.
6. **Three typos on the reference site were corrected** and are listed here for
   transparency: "TRADITIONAL PHILL" → "Traditional Philly", "IN-HOUSE CREAFTED"
   → removed with the EPIC rewrite, "We all products" → "View all products". The
   original's `www.taskysteaks.ca` typo is moot — the contact details are all new.
7. **Client photography over reference-site photography.** The reference site's
   stock is on the previous owner's licence, so every slot held a neutral
   on-brand SVG at the exact slot aspect ratio until real photos arrived. They
   arrived on 16 Oct and all six product slots plus the hero chicken frame now
   carry the client's own files; the layout did not move, which is what the
   fixed aspect ratios were for. The SVGs are kept at
   `assets/images/_withdrawn/product-*.svg` as the fallback.
8. **The internal `CLIENT REVIEW` banners have been removed** at the client's
   request, along with the "pending verification" captions under the
   certification badges. The underlying approvals are **still outstanding** —
   they now live only in HTML comments and in this file's
   "Outstanding client approvals" section below. Nothing on the rendered pages
   flags them any more, so they must be tracked here.

---

## Brand colours

One matte black, one red, one yellow. Set once in `assets/css/global.css`
`:root`; nothing hard-codes a colour, so changing a value re-skins the whole
site. The same values map to Elementor Global Colors
(`docs/ELEMENTOR_MIGRATION.md` §2.1).

| Token | Hex | Pantone | Role |
|---|---|---|---|
| `--is-black` | `#1A1A1A` | Neutral Black C | Every section background, header, footer |
| `--is-red` | `#F21B26` | to confirm | Accent bands, rules, contact cards, CTA, beef (Hormel red) |
| `--is-red-dark` | `#EC3237` | to confirm | Hover / pressed (JBS red) |
| `--is-yellow` | `#F2A900` | **130 C** | Chicken product surfaces only |

**Full print spec — CMYK, the rich-black build for the carton, and the contrast
measurements — is in `docs/BRAND_COLOURS.md`. That is the document to hand the
printer** for the boxes and the brochure. **Tell them the red has no exact
Pantone:** it needs a draw-down against the CMYK build before plating.

The previous three-black system (onyx / matte / charcoal) was removed at the
client's request: he asked for matte black with no mixed dark/light grey
sections. Cards now sit on a translucent white overlay instead of a second grey.

---

## Outstanding client approvals and missing materials

### Blocking — must not go live as-is
1. **The beef sandwich photograph on the homepage hero** is cropped from
   **Ritter Foods' own trade advert**. The branding and type are cropped out,
   but the photography is theirs. The client approved the frame on 16 Oct, but
   approval is not provenance — it must be licensed or commissioned before the
   Oct 19 launch. The chicken half of the pair **was** replaced that evening
   with the client's own file, clearing that half of the flag. A ready
   replacement for the beef half came in the same drop and was deliberately not
   used, because the client said to keep this one.
   See `docs/IMAGE_REPLACEMENT_LIST.md` §3.
1b. **The cattle and poultry category shots** came back into the live set on
   16 Oct at the client's request, but they are the old site's own images and
   the licence is unconfirmed. `docs/IMAGE_REPLACEMENT_LIST.md` §2a.
2. **USDA-inspected facilities** and **SQF Level 3** — confirm current status,
   exact approved wording, and evidence.
3. **Halal certification wording** — the category is retained; the Imperial
   Steaks claim needs confirming.
4. **Certification badge artwork** — licensed/approved files only.

### Needed to finish the build
5. **Logo selection** — three concepts at `logo-concepts.html`. Concept 2 is in
   place on the review build; swapping is a one-line change per page.
6. **New phone number** — the old Tasty Steaks number has been removed rather
   than carried over. Footer and Contact page show `XXX-XXX-XXXX`.
7. ~~**Product photography** — 6 slots~~ — **done 16 Oct**, all six placed from
   the client's `Product image/` folder. What is left is confirmation of the
   **right to publish** each file, and higher-resolution originals for **XL**,
   **NS** and **CHX**, which came in at or just past their usable limit.
   `docs/IMAGE_REPLACEMENT_LIST.md` §4.
8. **Corrected About copy** — the client is sending it; the current text is the
   previous copy with the rebrand applied.
9. **Retail box photography** — the client has it; the page is a Coming Soon
   holder until it arrives.
10. **Product guide PDF** for the "Download Guide" button.
11. **Social profile URLs** — still non-interactive placeholders.
12. **Contact form** — confirm required fields and the destination inbox.
13. **A higher-resolution carton photograph**, if one exists. The one in use has
    been retouched to take the white panels off; the untouched original is at
    `assets/images/_withdrawn/product-box-open-white-panels.png`.
14. **Confirmation on the red's contrast shortfall** — white body copy on
    `#F21B26` is 4.2:1, under AA. Either accept it, or pick one of the three
    options in `docs/BRAND_COLOURS.md` §5.

### Open questions
15. Copyright year is set to **2026** across the footer — confirm.
16. Does the client want the **Halal** category and badge retained at all, given
    certification is unconfirmed?
17. `logo-concepts.html` is an internal review sheet carrying `noindex, nofollow`.
    Delete it before launch, or leave it unlinked.

---

## Build quality notes

* **Responsive** at 1024px and 767px (Elementor's breakpoints) — grids collapse
  3→2→1, split columns stack, buttons go full-width, the nav becomes a toggle.
* **Accessibility** — one `<h1>` per page, ordered headings, skip link, visible
  focus rings, `aria-expanded` on the nav toggle, Escape closes the mobile menu,
  descriptive `alt` on every image, `aria-current` on the active nav item,
  `prefers-reduced-motion` respected.
* **Contrast** — body grey `#C9C9C9` on matte black 10.5:1; white on matte black
  17.4:1; matte black on Chicken Yellow 8.7:1 — all AA or better. **White on the
  new Brand Red is 4.2:1**, which passes AA for large text but not for the 16px
  paragraphs on the red bands; those are set at weight 400 to read as solidly as
  the colour allows. Measured, not estimated — `docs/BRAND_COLOURS.md` §5 has the
  full table and the options for closing the gap.
* **No frameworks or dependencies** — no React, Next.js, Tailwind, Bootstrap,
  jQuery, bundler or npm package. One small vanilla-JS file doing four jobs: the
  mobile menu, the carousel arrows, the scroll reveals, and the sticky-header /
  back-to-top controls. All four degrade gracefully with JavaScript off — and
  critically, **no content is ever hidden without JavaScript**: the reveal styles
  are scoped behind a `reveal-on` class that only the script adds.
* **Motion** — entrance reveals on scroll, carried over from the reference site,
  which used Elementor `fadeInDown` animations with a 200ms stagger on its hero.
  Only `opacity` and `transform` animate, so nothing triggers layout. No
  parallax, no glassmorphism, no bounce. Fully suppressed under
  `prefers-reduced-motion`.
* **Verified** — all internal links, in-page anchors and asset paths resolve
  (0 broken); HTML tag balance and duplicate-ID checks clean on all 5 pages; CSS
  braces balanced and every `var()` token defined; all pages and assets serve
  200 over a local static server; no `!important` chains (one reduced-motion
  override), no inline styles, no lorem ipsum.
* **Visually verified this round** — all five pages rendered in headless Chrome
  over a local server at desktop (1280px) and mobile (420px) and checked by eye.
  No horizontal overflow at either width. Re-verified after the 16 Oct round:
  link, anchor, asset-path, tag-balance, duplicate-id, CSS-brace and `var()`
  coverage checks all clean.

---

## Next step

Read `docs/SITE_AUDIT.md`, then `docs/ELEMENTOR_MIGRATION.md`. The migration
guide is a transcription plan: **a static HTML file cannot be imported into
Elementor as a fully editable page**, and no plugin does it properly. Each
section is recreated with the listed stock widgets — no custom widget, no
plugin, and only four small pieces of custom CSS (all listed, with
widget-control alternatives for three of them).
