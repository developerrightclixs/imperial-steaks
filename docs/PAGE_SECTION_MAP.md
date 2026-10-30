# Page and section map — Imperial Steaks

Section order per page, with the unique class on each `<section>` and what
changed. **Updated 2026-10-16 for the second client revision round.** The
"change" column describes the move from the previous Tasty Steaks build to this
one; entries marked **[CLIENT 16 Oct]** are from the latest round.

Change legend:
**[SAME]** unchanged in this round · **[REBRAND]** Tasty Steaks → Imperial Steaks
naming/styling only · **[CLIENT]** new or rewritten per the revision brief ·
**[REMOVED]** section or element deleted · **[FLAG]** needs client approval or a
pending asset before publishing

---

## Shared across all five pages

| Block | Class | Elementor target | Change |
|---|---|---|---|
| Skip link | `.skip-link` | n/a (accessibility) | **[SAME]** |
| Site header | `.imperial-header` | Theme Builder › Header | **[CLIENT]** matte black (was onyx); logo is now `logo-concept-2.svg` at 190px |
| Primary nav | `.imperial-nav`, `__list`, `__link` | Nav Menu widget | **[SAME]** Home / About Us / Products / Retail / Contact Us — structure unchanged, as briefed |
| Mobile toggle | `.imperial-nav-toggle` | Nav Menu mobile dropdown | **[SAME]** |
| Site footer | `.imperial-footer` + `__grid`, `__title`, `__list`, `__contact`, `__bottom` | Theme Builder › Footer | **[CLIENT]** matte black throughout · Imperial Steaks logo · Puck **[REMOVED]** from the product list · email/web updated · phone replaced with `XXX-XXX-XXXX` · copyright now © 2026 Imperial Steaks · **[CLIENT 16 Oct]** the **Office** label is now **Warehouse** and the address carries the postal code: **Boucherville, QC J4B&nbsp;8N4** (same change on the Contact page card, and in the theme Customizer default) |
| Social row | `.imperial-social` | Social Icons widget | **[FLAG]** still non-interactive; URLs pending |
| Back to top | `.imperial-to-top` | Back to Top widget | **[SAME]** |

---

## 1. `index.html` — Home

**Six sections, and each one declares its own background colour** so the eye can
see where one ends and the next begins — the client's instruction on 16 Oct.
The rhythm down the page is **black · red · black · red · black · red**.

| # | Section | Background | Class(es) | Change |
|---|---|---|---|---|
| 1 | Hero **+** beef / chicken photography | **Matte black** | `.imperial-hero` + `__inner`, `__text`, `__title`, `__line`; `.imperial-duo` + `__panel`, `__media`, `__image` | **[CLIENT 16 Oct]** hero and photographs are now **one section**, not two. Copy sits **top left**. **[CLIENT 20 Oct]** it is now **sentence case**, not all caps — "Quality you can trust" over "Service you can rely on" — and the two lines are **matched**: same face, same 54px, same weight, both **white**. Line 2 was 26px uppercase in brand red. (The second line is the heading that used to sit over the brand values.) The descriptor line "Philly steak importer & distributor." is **[REMOVED]**, the red hero background is gone, and the **CHICKEN / BEEF pill labels under the photos are [REMOVED]** — `.imperial-duo__label` has been deleted from the CSS. The red → black seam gradient is gone with it. **[FLAG]** the beef frame is the one the client approved; the **chicken frame is still the Ritter crop and is the image he asked to change** |
| 2 | Introduction + the carton | **Brand red** | `.imperial-intro` + `__title`, `__text`, `__image` | **[CLIENT 16 Oct]** the carton photograph has been retouched so the **box reads fully black** — the white bottom panel and the white cut edges are gone (the untouched original is kept at `assets/images/_withdrawn/product-box-open-white-panels.png`). The band moved **black → red** so a now-black box does not sit on a black background. Heading rule switched to `--white`. **[CLIENT 30 Oct]** the retouch was rebuilt — the front panel is one quad again rather than a patch that did not line up, and the wordmark on it is now `logo.png`. Regenerate with `tools/fix-box-image.py` |
| 3 | Categories **+** brand values | **Matte black** | `.imperial-categories`, `.imperial-card--beef/--chicken/--halal`, `.imperial-values` + `__item` | **[CLIENT 16 Oct]** beef and chicken cards carry **live animal photography** again — `category-beef.jpg` (cattle) and `category-chicken.jpg` (poultry), the old site's shots restored from `_withdrawn/`. The **four brand values close the section** under the cards: **Value. Quality. Service. Integrity.** The separate "Service you can rely on" values band (`.imperial-promise`) is **[REMOVED]** — its heading became hero line 2. **[FLAG]** Halal wording; **[CLIENT 20 Oct]** the client asked for **both animal shots to be replaced** with "something similar but different". This went round twice: he first supplied **raw-product** shots for both, then supplied **live-animal** shots and asked for those instead. **Live animals is the direction that stands, and both cards are placed** — a Holstein in pasture and a free-range rooster, both `alt` rewritten. The withdrawn raw-product pair is kept in `_withdrawn/`. **[FLAG] the rooster source is watermarked** ("trvst" / "#TRVST TRVST.WORLD"); the published 3:2 crop excludes the mark by 195 px and nothing was retouched, but the rights are unsettled — raised twice, confirmed by the client twice, placed as instructed. **[NOTE]** the new cow is a **Holstein, a dairy breed**, where the shot it replaces was a beef breed — also raised, also kept. `docs/IMAGE_REPLACEMENT_LIST.md` §1 item 0, §2b, §2c and §2d. **[CLIENT 27 Oct]** **Partners.** leads the line, making five values. **[CLIENT 30 Oct]** **Partners trails off in dots** — `PARTNERS…. VALUE. QUALITY. SERVICE. INTEGRITY.` Four dots after Partners alone, in a `.imperial-values__dots` span at 0.8em with no tracking; the other four keep their single full stop. The values band on About Us has no Partners and is unchanged |
| 4 | Sandwich Steaks | **Brand red** | `.imperial-foodservice.section--red`, `.imperial-feature` | **[CLIENT 27 Oct]** renamed from Foodservice; institutions added to the customer list; Serving Suggestions added; the "All products" card removed. **[CLIENT 30 Oct]** serving suggestions take his wording in full: **"Subs, salads, tacos, sandwiches, pizza toppings, and / or hoagies."** |
| 5 | Products | **Matte black** | `.imperial-products` + `__carousel`, `__scroller`, `__slide` | **[CLIENT 16 Oct, evening]** the six dashed placeholder tiles are **[REPLACED]** by the client's own photography — `assets/images/product-{xls,xl,ns,re,epic,chx}.jpg`. The slot is 3:2 and the CSS crops with `object-fit: cover`, so the files differ in pixel size and each `<img>` carries its own intrinsic `width`/`height`. The product name still shows on the caption under each tile, which is page markup, not artwork. The withdrawn SVGs are at `assets/images/_withdrawn/product-*.svg` |
| 6 | Standards | **Brand red** | `.imperial-badges`, `.imperial-badge` | **[CLIENT 16 Oct]** band moved **black → red**, closing the alternation. Heading rule switched to `--white`; the certification marks keep their white plates. **[FLAG]** all three claims and marks still unverified |

---

## 2. `about.html` — About Us

Rebuilt to follow the structure of the old `tastysteaks.ca/about-us-2` page.

| # | Section | Class(es) | Change |
|---|---|---|---|
| 1 | Banner | `.imperial-banner` | **[REBRAND]** matte black |
| 2 | Intro paragraph | `.imperial-intro`, `.container--narrow` | **[CLIENT]** the separate "Who We Are" heading is **[REMOVED]** — the page opens on the paragraph, as the old About page did. **[CLIENT 27 Oct]** replaced with the client's own wording. **[CLIENT 30 Oct]** split into his three paragraphs — Imperial / Our vision / Our commitment — with the Halal sentence moved up behind the first sentence, the one ending "in Canada". **[CLIENT 31 Oct]** **centred**; the justification and the first-line indent both came out with it |
| 3 | Two-column split | `.section--red`, `.split` | **[CLIENT]** **[NEW]** left: quality/pricing paragraph + the SQF badge. Right: the "Ideal for your establishment" checklist + the closing paragraph. Replaces the old numbered icon-box list |
| 3b | Checklist | `.imperial-checklist` + `__item`, `__tick` | **[CLIENT]** **[NEW]** bullets instead of sentences, per the brief |
| 4 | Supplier standards | `.imperial-badge` grid | **[CLIENT]** ⚠️ **urgent fix applied:** the sentence ending *"according to the information provided by our client"* — an internal note visible on the page — has been removed. SQF now reads Level 3 |
| 5 | Values + CTA | `.section--red`, `.imperial-values`, `.btn-row` | **[CLIENT]** values corrected to **Value. Quality. Service. Integrity.** One button, "View all products" |
| — | Foodservice block | — | **[REMOVED]** it duplicated the homepage section; the brief asks to avoid repetition |

---

## 3. `products.html` — Products

| # | Section | Class(es) | Change |
|---|---|---|---|
| 1 | Banner | `.imperial-banner` | **[REBRAND]** |
| 2 | Shared statement | `.imperial-callout` | **[SAME]** 3–8 oz / double paper, shown once above the range |
| 3 | House Blend — XLS | `.imperial-product-row#xls` | **[CLIENT]** matte black band · bullets only · anchor renamed `house-blend-xls` → `xls` |
| 4 | Traditional Philly — XL | `#xl`, `.section--red` | **[CLIENT]** red band · intro sentence **[REMOVED]** · bullets re-ordered so **100% sirloin tip is first** |
| 5 | Premium Philly — NS | `#ns` | **[CLIENT]** matte black · intro sentence **[REMOVED]** · sirloin tip first, then lightly marinated, firmer bite, no soya, better yield |
| 6 | Rib Eye — RE | `#re`, `.section--red` | **[CLIENT]** red band · intro sentence **[REMOVED]** |
| 7 | Signature Blend — EPIC | `#epic` | **[CLIENT]** matte black · intro sentence **[REMOVED]** |
| 8 | Premium Chicken — CHX | `#chx`, `.section--yellow` | **[CLIENT]** **the yellow band** · order per the brief: lightly marinated, 95% lean, 100% boneless breast meat |
| — | Puck | — | **[REMOVED]** entirely — page section, footer list and carousel |
| 9 | CTA | "Talk to us about your menu" | **[CLIENT]** ⚠️ **fix applied:** the buttons were clipped in the previous build. Phone button removed until the new number arrives |
| — | Product code chips | `.imperial-product-row__code` | **[CLIENT 20 Oct]** the chip now carries **black** type throughout, and the two variants hold the same two colours and swap the ground. On a **matte black band**: red ground, **black** type (was white). On a **red band**: **black** ground, **red** type (was white ground, red type). The yellow chicken band already followed this rule — black ground, yellow type — and is unchanged. **[CLIENT 27 Oct]** the chip moved off the heading and into the photograph, one corner per product. **[CLIENT 30 Oct]** it was too small to read — **14px → 22px**, padding and tracking stepped up with it. **[FLAG]** red on black measures 3.97:1; at 22px that now clears the 3:1 large-text floor comfortably, and the code is repeated in the adjacent heading so nothing is carried by the chip alone |
| — | All product images | `.imperial-product-row__image` | **[CLIENT 16 Oct, evening]** all six now carry the client's supplied photography. **[FLAG]** the right to publish is unconfirmed on most of the files, and XL / NS / CHX are at their resolution limit — `docs/IMAGE_REPLACEMENT_LIST.md` §4 |

---

## 4. `retail.html` — Retail

| # | Section | Class(es) | Change |
|---|---|---|---|
| 1 | Coming Soon | `.imperial-soon-section`, `.imperial-soon__title` | **[CLIENT 16 Oct]** the page is the words **COMING SOON, set large, and nothing else**. The page banner, the eyebrow pill, the supporting paragraph and the Contact button are all **[REMOVED]**. The heading is the page's `h1`, sized `clamp(48px, 13vw, 150px)` in a section that fills 60vh, so it centres between header and footer at any width. Nav item stays; page keeps `noindex, follow` |
| — | Banner / eyebrow / body copy / CTA | `.imperial-banner`, `.imperial-soon__eyebrow`, `__text` | **[REMOVED]** — the eyebrow and text rules have been deleted from the CSS, not just unused |

---

## 5. `contact.html` — Contact Us

| # | Section | Class(es) | Change |
|---|---|---|---|
| 1 | Banner | `.imperial-banner.imperial-banner--sm` | **[CLIENT]** title is just "Contact Us" and **smaller**; subtitle "Sales & Inquiries" |
| 2 | Contact details | `.imperial-contact-card` ×6 | **[CLIENT 20 Oct]** six solid red cards was **"too much red"**. The cards are now the **standard site surface** — translucent white on matte black with a hairline border and a **3px brand-red left rule**, matching `.imperial-feature`. Red drops from about half the section's area to six thin rules, and white-on-red at 4.38:1 becomes white-on-black at 17.4:1. All six still share one treatment. **[CLIENT 30 Oct]** the phone reads **`514.944.8628`** — dots, not hyphens, everywhere it is displayed, with the `tel:` href keeping the dialable `+1` form — and the Email card carries **two** addresses, `info@imperialsteaks.com` above `kougiek@gmail.com`. The **"Send us a message" band below is still red** — it is the page's one red band and keeps the black/red rhythm; say the word if the client wants that gone too |
| | | | Values: phone **[FLAG]** pending · `info@imperialsteaks.com` · `imperialsteaks.com` · **[CLIENT 16 Oct]** the "Location" card is now **Warehouse — Boucherville, QC J4B&nbsp;8N4** · Foodservice & Retail · USA and Middle East |
| 3 | Send us a message | `.section--red` | **[CLIENT]** moved onto the red band, centred, one button. The "IS" monogram image on the right is **[REMOVED]**. Still no fake form — add an Elementor Form widget at migration |

---

## 6. `logo-concepts.html` — internal review sheet

Not part of the site. Three logo concepts, each on matte black, brand red and
white, plus at header size. `noindex, nofollow`. Delete it before launch, or
leave it unlinked.
