# Phase A — Reference site audit

**Reference site:** https://tastysteaks.ca/
**Audited:** 2026-10-12 (live HTML + Elementor CSS inspection, no backup used)
**Method:** fetched the live HTML of every reachable page plus the site's generated
Elementor CSS files (`post-523.css` = kit/global, `post-1413.css` = homepage,
`post-1416.css` = About, `post-1938.css` = Products, `post-1918.css` = Contact,
`post-1977.css` = header/footer templates). No backup was downloaded, extracted
or restored.

---

## 1. Platform the reference site runs on

| Item | Finding |
|---|---|
| CMS | WordPress |
| Theme | Astra |
| Page builder | **Elementor** (Containers + `data-widget_type` widgets) |
| Header/footer | Built with Elementor + "Header Footer Elementor" (`hfe-`) widgets |
| Fonts loaded | Poppins, Oswald, Aleo, Bodoni Moda, Roboto / Roboto Slab, Abril Fatface |

**Why this matters:** the original is already an Elementor site, so the section
structure we rebuild here maps back onto Elementor Containers almost one-to-one.
That is the template choice for this project — not a third-party HTML theme. The
static prototype deliberately mirrors Elementor's own box model (boxed container
at 1140px, flex/grid containers, 1024px and 767px breakpoints) so the WordPress
rebuild is a transcription rather than a redesign.

---

## 2. Navigation and page inventory (as audited)

Primary menu, in order, exactly as the reference site renders it:

| Label | Target on reference site | Status |
|---|---|---|
| Home | `/` | Live page |
| About Us | `/about-us-2/` | Live page |
| Products | `/product/` | Live page |
| Retail | *(no `href` at all — `menu-item-type-custom` with no link)* | **Dead menu item, no page** |
| Contact Us | `/contact-us/` | Live page |

`/products/` and `/retail/` both return 404. The only content pages are the four
above.

**Decision taken:** the prototype keeps all five menu items so the audited
navigation is preserved, and adds a minimal `retail.html` so the menu has no dead
item. That page carries only client-supplied facts plus a clearly marked
`TODO: CLIENT REVIEW` placeholder — no retail copy has been invented. See
`PAGE_SECTION_MAP.md`.

---

## 3. Suspicious / unrelated content — FLAGGED, NOT MIGRATED

The reference site is **heavily injected with online-casino and gambling SEO
spam**. This is the single most important audit finding.

* Every audited page carries 5–6 injected `<h2>` blocks of Canadian online-casino
  copy ("Casino Bonuses and Low-Deposit Offers for Canadian Players", "Online
  Casinos in Canada", etc.), appended after the real page content.
* The homepage alone links to **100+ URLs** under `https://tastysteaks.ca/ca/online-casinos/…`
  (e.g. `1-deposit-casino-canada.html`, `100-free-spins-no-deposit-canada.html`,
  `bitcoin-casino.html`, dozens of casino "review" pages).
* These paths are not WordPress pages; they are a separate injected directory tree.

**Action taken:** none of this content, markup or any of its links has been copied
into the Imperial Steaks build. All extraction scripts filtered it out explicitly.

**Recommended escalation (for the client, not this build):** the reference site
appears compromised or to have been monetised with injected SEO spam. Before any
DNS/domain or content reuse decisions are made, the client should be told that
tastysteaks.ca is serving gambling content, and the host should audit the install
for a backdoor. **This is also an additional reason not to restore a backup.**

---

## 4. Original design system (measured, not guessed)

Values read directly from the reference site's generated Elementor CSS.

### Colours used by the original

| Original value | Where |
|---|---|
| `#FFFFFF` | Categories section background; hero gradient top half; all heading/body text on dark |
| `#4D4D4D` | Header bar, Products section, footer, hero gradient bottom half, "save big!" text |
| `#8C8C8C` | Homepage intro section background, About section background, "Think thin." text |
| `#000000` | Button label on the white "DOWNLOAD GUIDE" pill |

The original palette is **white / mid-grey / dark-grey with no accent colour**.
There is no red anywhere on the reference site — the red accent is new to
Imperial Steaks.

### Typography used by the original

| Role | Font | Size / weight | Notes |
|---|---|---|---|
| Hero line 1 ("Think thin.") | Oswald | 50px / 300, 6.2px tracking, uppercase | 25px on mobile |
| Hero line 2 ("save big!") | Aleo | 90px / 800, 6.5px tracking, uppercase | 43px on mobile |
| Brand values (value./Quality./service.) | Bodoni Moda | 40px / 800, 10px tracking, uppercase, white, right-aligned | 20px on mobile |
| Section headings | Poppins | 30px / 600, uppercase | 18–20px on mobile |
| Body copy | Poppins | 300 weight, justified | 14px on mobile |
| Card / carousel captions | Poppins | 30px / 600 (cards), 20px / 600 (captions) | |
| Footer column headings | Poppins | 20px / 600, 3.9px tracking, uppercase | |
| Copyright | Poppins | 15px / 400 | |

### Geometry used by the original

| Property | Value |
|---|---|
| Content width | 1140px boxed |
| Breakpoints | 1024px (tablet), 767px (mobile) |
| Hero min-height | 60vh desktop / 600px tablet / 472px mobile |
| Section padding | 80px desktop, 20–30px tablet, 5–15px mobile |
| Category card image radius | 25px |
| Product carousel image radius | 20px |
| Button radius | 20px (pill) |
| Divider | 2px white rule, 10% width, centred |
| Category / badge grids | CSS grid, `repeat(3, 1fr)` → `repeat(1, 1fr)` on mobile |

---

## 5. Homepage section order (original)

1. Header bar (`#4D4D4D`) — logo left, menu right, hamburger under 1024px
2. **Hero** — gradient `#FFFFFF`→`#4D4D4D`; "Think thin." / "save big!" + cut-out
   cheesesteak image + "value. Quality. service." right-aligned in white
3. **Intro** (`#8C8C8C`) — `h2` "Premium Philly steaks" + two paragraphs, square
   product image on the right
4. **Categories** (`#FFFFFF`) — `h2` "Categories" + 3 Image Boxes: BEEF, CHICKEN, HALAL
5. **Products** (`#4D4D4D`) — `h2` "Products" + Image Carousel (3 visible slides,
   white captions) listing 7 products
6. **CTA** (`#4D4D4D`) — white pill button "DOWNLOAD GUIDE" (**`href="#"` — no target**)
7. Divider + **badge strip** — 3 images (Halal, USDA, Halal)
8. Footer (`#4D4D4D`) — logo, "Company" menu, "Products" menu, "Contact us now"
   icon list, 3 social icons (**none of which have an `href`**), copyright bar

## 6. About Us section order (original)

1. Banner/intro (`#4D4D4D`) — `h2` "ABOUT US" + 2 paragraphs
2. Image + `h2` "SQF CERTIFIED - LEVEL 2"
3. (`#8C8C8C`, with a repeating food-pattern background image) "We are confident
   that our product is ideal and suited for your establishments because:" + 4
   Icon Boxes
4. Closing paragraph
5. "value. / Quality. / service." (Bodoni Moda, white) + outlined button
   **"We all products"** (typo on the original) → `/product/`

## 7. Products page (original)

One alternating row per product: `h2` heading + an all-caps spec bullet list +
a 3:2 photo, with the image side alternating. Section backgrounds alternate
`#FFFFFF` / `#8C8C8C`. Exact spec lists captured verbatim:

| Product (original name) | Spec bullets (verbatim) |
|---|---|
| VALUE BLEND - MTL | ECONOMICALLY PRICED · BLEND OF WHOLE MUSCLE · UNIQUE BLEND AND TASTE · MARBLED FOR A TENDER BITE |
| TRADITIONAL PHILL - XL | MARINATED WHOLE MUSCLE · TOP SIRLOIN · LEAN PERCENTAGE |
| PREMIUM PHILLY - NS | NO SOYA · TOP SIRLOIN · BETTER YIELD PERCENTAGE |
| RIB EYE -RE | LIGHTLY MARINATED · 100% RIB EYE · MODERATELY MARBLED · CUSTOMIZED SEASONING |
| SIGNATURE BLEND - EPIC | BLADE MEAT · EXCELLENT BEEF FLAVOR AND TENDER TEXTURE · SIGNATURE MARINATION · IN-HOUSE CREAFTED *(sic)* |
| PUCK | MARBLED · NO CHOPPING NECESSARY · PREVENTS YIELD LOSS |
| PREMIUM CHICKEN -CHX | 95% LEAN · 100% BONELESS BREAST MEAT · LIGHTLY MARINATED |

There are **no prose product descriptions** on the original — only these bullet
lists. No nutrition, pricing, pack-size or availability data appears anywhere.

## 8. Contact page (original)

`h2` "send us message" followed by four Icon Lists (phone, email, website,
location). **There is no form on the page** despite the heading. Original details:
`+1.514.662.0044`, `jziannis@tastysteaks.ca`, `www.taskysteaks.ca` *(sic — typo
in the original)*, `Montreal ,QC ,H3M 2A8`.

---

## 9. What can be reproduced accurately vs. what is missing

### Reproduced faithfully
* Page hierarchy and navigation (all five menu items)
* Homepage section order and the hero's three-part tagline/values composition
* Typography system (Oswald / Aleo / Bodoni Moda / Poppins at the measured sizes)
* Geometry: 1140px boxed width, 1024/767 breakpoints, 25px/20px radii, pill buttons
* Products page alternating rows with all-caps spec lists
* Footer structure: logo + Company menu + Products menu + contact list + socials
* About Us structure including the four "ideal for your establishment" points

### Missing / unavailable, and how it was handled
| Gap | Handling |
|---|---|
| All photography (not licensed for reuse; replacements pending client) | Neutral on-brand SVG placeholders at the exact slot aspect ratios — see `IMAGE_REPLACEMENT_LIST.md` |
| Imperial Steaks logo | Temporary SVG wordmark; replace with the approved logo file |
| USDA / Halal / SQF badge artwork | Neutral placeholder badges; licensed artwork required, claims flagged |
| Product guide PDF ("DOWNLOAD GUIDE") | Button retained, pointed at the Products page until a PDF is supplied |
| Contact form | Not faked. To be added with the Elementor Form widget at migration |
| Social profile URLs | Rendered as non-interactive placeholders (as on the original, which has no URLs either) |
| Retail page content | Page created with client facts only + a visible review placeholder |
| Welcome paragraph | **Verified and retained verbatim** from the reference homepage |

---

## 10. Items the client must resolve

Tracked in full in `../README.md` § "Outstanding client approvals".

1. USDA-inspected / SQF Level 3 certification wording and evidence.
2. Halal certification wording (category retained from the original).
3. NS exact composition.
4. All photography and the final logo.
5. Red shade approval (`#B71C1C` proposed) and which of the three blacks leads.
6. Retail page content.
7. Social profile URLs, product guide PDF, contact-form fields and destination inbox.
8. Awareness of the casino-spam injection on tastysteaks.ca (§3).
