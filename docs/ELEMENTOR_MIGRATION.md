# Elementor migration guide — Imperial Steaks

**What this document is:** a transcription plan. It maps every section of the
static prototype onto the Elementor Containers, widgets and Site Settings needed
to rebuild it in WordPress with genuine visual editability.

> **Important, please read before quoting timelines.**
> A static HTML file **cannot** be imported into Elementor as a fully editable
> page. There is no one-click HTML-to-Elementor conversion. Third-party
> "HTML to Elementor" plugins produce either a single HTML widget (not editable)
> or unusable markup. Each section below must be **recreated** in Elementor using
> the listed widgets. The prototype is built to make that transcription fast and
> unambiguous — it is not an importable artifact.
>
> The good news: the reference site (tastysteaks.ca) is itself an Astra +
> Elementor site, and this prototype deliberately mirrors Elementor's own box
> model (1140px boxed containers, flex/grid containers, 1024px/767px
> breakpoints). Nothing here needs a custom widget or a plugin.

---

## 1. Recommended WordPress stack

| Layer | Recommendation | Why |
|---|---|---|
| Theme | **`wp-theme/imperial-steaks`** (included in this project) | Purpose-built, Elementor-first: Theme Builder locations, the 3 menus, the brand CSS and a working fallback header/footer. See its own README. Hello Elementor or Astra remain fine alternatives if you prefer a stock theme |
| Builder | **Elementor Pro** | Needed for Theme Builder (header/footer templates) and the Form widget |
| Containers | Elementor **Flexbox Containers** (not legacy Sections/Columns) | The prototype's layout primitives are flex/grid, so they map 1:1 |
| Forms | Elementor Form widget (Pro), or WPForms / Contact Form 7 | The contact page intentionally ships without a fake form |
| Not needed | No custom theme, no custom widget, no page-builder add-ons, no JS libraries | |

---

## 2. Step 1 — Site Settings (do this first)

Everything in the prototype is driven by CSS custom properties in
`assets/css/global.css` under `:root`. Enter each one **once** in Elementor, then
pick the global value in every widget instead of typing hex codes. That is what
makes the rebuild editable later.

### 2.1 Global Colors → *Site Settings › Global Colors*

| Elementor global colour name | Value | Prototype token | Used for |
|---|---|---|---|
| Matte Black | `#1A1A1A` | `--is-black` | Every section background, header, footer |
| Brand Red | `#FF0000` | `--is-red` | Accent band backgrounds, rules, borders, contact-card left rules, CTA band |
| Red Dark | `#D40000` | `--is-red-dark` | Button hover |
| Red Bright | `#FF0000` | `--is-red-bright` | Link hover, focus ring, eyebrow text |
| Chicken Yellow | `#F2A900` | `--is-yellow` | Chicken product surfaces only |
| Yellow Dark | `#C98A00` | `--is-yellow-dark` | Yellow hover states |
| White | `#FFFFFF` | `--is-white` | Headings and copy on dark |
| Body Grey | `#C9C9C9` | `--is-grey-text` | Body copy on dark |
| Muted Grey | `#8C8C8C` | `--is-grey-muted` | Eyebrow labels |

> **Matte black only.** The three-black system (onyx / matte / charcoal) was
> removed at the client's request: he wanted matte black and no mixed dark/light
> grey sections. Raised surfaces — cards, callouts — now use a translucent white
> (`rgba(255,255,255,0.045)`) over the matte black rather than a second grey.
> In Elementor set that as a Background Overlay, not as a fourth global colour.
>
> **Red is the client's own specification, and it is pure red.** There is
> **one** brand red, `#FF0000`, given by the client as a flat value on 20 Oct.
> It supersedes `#ED1C24` (set earlier the same day from the Hormel / JBS
> marks) and the `#F21B26` / `#EC3237` pair before that. `Red Dark` is a
> darkened step off it for hover states only.
>
> Two things to carry into Elementor with it. First, **`#FF0000` is outside
> the CMYK gamut** — it is exact on screen but cannot be matched in print, so
> anything heading for the carton or the brochure needs the printer's note in
> `docs/BRAND_COLOURS.md` §2. Second, **every red/white and red/black pairing
> is now below the 4.5:1 AA floor** (white on red 4.00:1, black on red
> 4.35:1); all clear the 3:1 large-text floor. Before setting any new body
> copy on a red band, read §5 of that document — the cheapest fix is to set it
> at 18px bold so it qualifies as large text.

### 2.2 Global Fonts → *Site Settings › Global Fonts*

Load Poppins, Oswald and Bodoni Moda (Elementor pulls Google Fonts
automatically; or use a local-fonts plugin for GDPR/performance).

| Elementor global font | Family / weight | Prototype token | Used for |
|---|---|---|---|
| Primary | Poppins 600 | `--is-font-body` | All headings |
| Text | Poppins 300 | `--is-font-body` | Body copy |
| Accent | Poppins 500 | `--is-font-body` | Buttons, nav, spec lists, labels |
| Secondary | Bodoni Moda 800 | `--is-font-display` | Brand values (Value. / Quality. / Service. / Integrity.) |
| *(per-widget)* | Oswald 500 | `--is-font-condensed` | Hero headline and the Retail "Coming Soon" title |

Aleo is no longer used — it set the old 90px hero line, which the client asked to
drop. Oswald appears in two places, so set it directly on those Heading widgets
rather than burning a global slot.

### 2.3 Type scale (enter on the matching global font / widget)

| Role | Desktop | Tablet (≤1024) | Mobile (≤767) |
|---|---|---|---|
| Hero line 1 + line 2 (Oswald 500, 2px tracking, **sentence case**, one line each) | 54px | 40px | 30px |
| Brand values (Bodoni Moda 800, 5px tracking, uppercase) | 28px | 22px | 18px |
| H1 / page banner | 40px | 32px | 26px |
| H2 / section title | 30px | 24px | 20px |
| H3 / card title | 20px | 20px | 20px |
| Body | 16px | 16px | 15px |
| Small (nav, buttons, spec list) | 14px | 14px | 14px |
| Eyebrow / label | 13px | 13px | 13px |

### 2.4 Layout → *Site Settings › Layout*

| Setting | Value |
|---|---|
| Content width (boxed) | **1140px** |
| Widgets space | 20px |
| Breakpoints | Tablet **1024px**, Mobile **767px** (Elementor defaults — matches the prototype) |
| Default page layout | Elementor Full Width / Canvas (no theme sidebar) |

### 2.5 Spacing scale (use in Container padding/margin controls)

| Token | Value | Typical use |
|---|---|---|
| `--is-space-xs` | 8px | Icon/text gaps |
| `--is-space-sm` | 16px | Paragraph rhythm |
| `--is-space-md` | 24px | Container inner padding, container gutters |
| `--is-space-lg` | 40px | Section head → content |
| `--is-space-xl` | 56px | Split-column gap, banner padding |
| `--is-section-y` | **80px** desktop / 56px tablet / 44px mobile | Section vertical padding |
| `--is-gap-grid` | 30px desktop / 20px mobile | Grid gap |

### 2.6 Radii and borders

| Token | Value | Applies to |
|---|---|---|
| `--is-radius-card` | 25px | Category cards (matches the reference site) |
| `--is-radius-media` | 20px | Product and feature imagery (matches the reference site) |
| `--is-radius-pill` | 20px | All buttons (matches the reference site) |
| `--is-radius-sm` | 6px | Feature cards, callouts, contact cards |
| Hairline border | `rgba(255,255,255,.14)`, 1px | Card and section edges |

---

## 3. Step 2 — Theme Builder templates (build once, use everywhere)

### 3.1 Header — *Templates › Theme Builder › Header*

Prototype source: the `<header class="imperial-header">` block, identical in all
five pages.

| Prototype element | Elementor equivalent | Settings |
|---|---|---|
| `header.imperial-header` | **Container** (outer) | Background: Matte Black · Border-bottom: 2px solid Brand Red · Sticky: Top (Motion Effects) · Z-index 50 |
| `.imperial-header__inner` | **Container** (inner, boxed 1140px) | Direction: Row · Justify: Space Between · Align: Center · Padding block 16px |
| `.imperial-header__brand` + logo `<img>` | **Site Logo** widget | Width 190px · Link: Home · Upload the chosen `logo-concept-*.svg` as the WP Site Logo |
| `.imperial-nav` / `.imperial-nav__list` | **Nav Menu** widget | WP menu "Primary" · Layout: Horizontal · Pointer: None · Typography: Accent 14px/500, 1.2px tracking, uppercase · Normal white, Hover Red Bright, Active white |
| `.imperial-nav__link.is-current` | Nav Menu *Active* state | Bottom border 2px Brand Red |
| `.imperial-nav-toggle` | Nav Menu *Mobile Dropdown* | Breakpoint: Tablet (1024px) · Toggle colour white · Dropdown background Matte Black, item dividers hairline |

**`assets/js/main.js` and `assets/css/animations.css` are not migrated — delete
both at migration.** They do four things, and Elementor replaces all of them
natively: the Nav Menu widget supplies its own mobile dropdown, the Image
Carousel widget supplies its own prev/next arrows (§4.1, row 5b), Motion Effects
supplies the entrance animations, and the Back to Top widget supplies the scroll
control (§4.6). Nothing else on the site depends on JavaScript.

**Display condition:** Entire Site.

### 3.2 Footer — *Templates › Theme Builder › Footer*

Prototype source: the `<footer class="imperial-footer">` block, identical in all
five pages.

| Prototype element | Elementor equivalent | Settings |
|---|---|---|
| `footer.imperial-footer` | **Container** (outer) | Background: Matte Black · Border-top: 2px Brand Red |
| `.imperial-footer__grid` | **Container** | Display: **Grid** · Columns `1.3fr 1fr 1fr 1.2fr` · Gap 30px · Tablet: 2 columns · Mobile: 1 column · Padding block 56px |
| Column 1: logo + `.imperial-footer__blurb` | **Site Logo** + **Text Editor** | Logo 200px · Text: Body Grey 14px |
| Column 2 heading + list | **Heading** + **Nav Menu** | Heading: Poppins 20/600, 2px tracking, uppercase, white · Menu: WP menu **"Footer — Company"** (Home, About Us, Products, Retail, Contact Us), vertical |
| Column 3 heading + list | **Heading** + **Nav Menu** | WP menu **"Footer — Products"** — **6** custom links to `/products/#xls`, `#xl`, `#ns`, `#re`, `#epic`, `#chx`. Puck is removed from the range |
| Column 4 heading + contact list | **Heading** + **Icon List** | 5 items: Tel (**plain text `XXX-XXX-XXXX` until the client supplies the new number — do not link it**), Email (`mailto:sales@imperialsteaks.com`), Web (`https://imperialsteaks.com/`), **Warehouse** (Boucherville, QC J4B 8N4), Also (USA and Middle East) · Icons white · Text white 14px |
| `.imperial-social` | **Social Icons** widget | Instagram / Facebook / X · Shape: Circle · Background transparent · Border 2px **dashed** white · **URLs pending from client** |
| `.imperial-footer__bottom` | **Container** | Background: Matte Black · Border-top hairline · Padding block 16px · Centered **Heading/Text**: Poppins 14/400 white |

**Display condition:** Entire Site.

### 3.3 WordPress menus to create (*Appearance › Menus*)

1. **Primary** — Home, About Us, Products, Retail, Contact Us
2. **Footer — Company** — same five items
3. **Footer — Products** — 6 custom links to the product anchors on the Products page

---

## 4. Step 3 — Page-by-page section map

Every `<section>` in the prototype carries an HTML comment naming its Elementor
target, e.g. `<!-- Elementor section: Homepage Hero -->`. Build one Elementor
Container per `<section>`, in the same order.

### 4.1 `index.html` → **Home**

| # | Prototype section / class | Elementor build | Notes |
|---|---|---|---|
| | | | **Revision 16 Oct: every section declares its own background colour** so each one visibly starts and ends. Down the page: **black · red · black · red · black · red**. Set the background on the Container, never on a child. |
| 1 | `.imperial-hero` | Container: **background Matte Black**, Direction Column, Align **Stretch**, padding block 80px, gap 56px | Client revision: the hero and the two sandwich photographs are now **one section**. The red hero background is gone |
| 1a | `.imperial-hero__title` | **Heading** (H1) | "Quality you can trust" — **one line, top left**, Oswald 500, 54px, 4px tracking, uppercase, white. `white-space: nowrap` on desktop/tablet; wraps on mobile |
| 1b | `.imperial-hero__line` | **Heading** (H2 or Text) | "Service you can rely on" — the second line of the lockup. **Revised 20 Oct:** matched to line 1 exactly — Oswald 500, 54px, 2px tracking, **sentence case**, **White**. It was 26px uppercase in Brand Red. The descriptor line "Philly steak importer & distributor." has been **removed** |
| 2 | `.imperial-duo` | Inner Container, Direction Row, max-width 940px, centred | Still inside section 1. **No gradient any more** — the red → black seam went with the red hero |
| 2a | `.imperial-duo__panel--chicken` | Container → **Image** | Image 16:9, radius 20px, `transform: rotate(-3.5deg)`. **The CHICKEN label pill has been removed** |
| 2b | `.imperial-duo__panel--beef` | Container → **Image** | Image 16:9, radius 20px, `transform: rotate(3.5deg)`. **The BEEF label pill has been removed** |
| | | | The rotation is the one place Elementor needs custom CSS — put it in the Container's Advanced › Custom CSS, or accept un-tilted panels |
| 3 | `.imperial-intro` | Container: **background Brand Red**, padding 80px, Direction Row | Moved black → red so the now fully-black carton does not sit on black |
| 3a | | **Heading** "Imperial Steaks" + **Divider** + **Text Editor** ×2 | The "Service you can rely on" eyebrow is gone — it is hero line 2 now. Divider 72px, 3px, **white**, left. Paragraphs Poppins **400** (not 300) white — see the contrast note in §2.1 |
| 3b | | **Image** widget | The carton photograph, retouched so the box reads **fully black**: no white bottom panel, no white cut edges |
| 4 | `.imperial-categories` | Container: **Matte Black** | |
| 4a | | **Heading** "Categories" + red **Divider** (centred) | |
| 4b | `.grid--3` | Container: Display **Grid**, 3 cols → 2 (tablet) → 1 (mobile) | |
| 4c | `.imperial-card` ×3 | **Image Box** widget ×3 | Radius 25px · Card background = translucent white overlay on Matte Black, hairline border · **Beef:** 4px top border Brand Red, **live cattle photograph** · **Chicken:** 4px top border + title in Chicken Yellow, **live poultry photograph** · **Halal:** 4px top border white, mark on a white plate |
| 4d | `.imperial-values` | **4 Heading widgets** in a wrapping row Container, centred, 56px above | **Moved here from the hero, 16 Oct.** Bodoni Moda 800, 28px, 5px tracking, uppercase, white. **Value. Quality. Service. Integrity.** They close the Categories section |
| 5 | `.imperial-foodservice.section--red` | Container: **background Brand Red** | Left untouched this round at the client's instruction |
| 5a | | **Heading** "Foodservice" + white **Divider** | |
| 5b | `.imperial-feature` ×2 | **Icon Box** ×2 in a 2-column grid | On red: card background solid Matte Black, **left border 3px white** · Copy: "Restaurants, pizza shops and sandwich shops." and the 3–8 oz statement |
| 6 | `.imperial-products` | Container: Matte Black | |
| 6a | | **Heading** "Products" + red **Divider** | |
| 6b | `.imperial-products__carousel` | **Image Carousel** widget | **6 slides — Puck removed.** Slides to show 3 (1 on mobile) · Caption: Title · Image radius 20px · Caption Poppins 20/600 white · Navigation: Arrows (the widget draws its own) · **Alternative:** a Loop Grid over a "Products" CPT if the client will add products later |
| | | | **The 16 Oct evening change is in the files, not the widget** — the six placeholders were replaced by the client's photography at `assets/images/product-*.jpg`. Nothing to configure in Elementor; upload the six JPGs to the Media Library and point the carousel at them. The slot is 3:2 and crops with `object-fit: cover`, so the files need not share a pixel size |
| 6c | `.imperial-callout` | Container + **Text Editor** | Translucent surface, hairline border, **left border 4px Brand Red** |
| 6d | `.btn--primary` | **Button** widget | Label "Download Guide" · White background, matte black text, radius 20px · Hover: Brand Red, white text · **Link pending** — points at the Products page until the client supplies the PDF |
| 7 | `.imperial-badges` | Container: **background Brand Red** → grid, 3 columns | Moved black → red on 16 Oct, closing the alternation. Heading divider **white**; the marks keep their white plates. SQF label reads **"SQF Certified — Level 3"** |
| 7a | `.imperial-badge` ×3 | **Image** + **Heading** per column | ⚠️ Third-party marks, claims unverified — see §6 |

### 4.2 `about.html` → **About Us**

Rebuilt to follow the old `tastysteaks.ca/about-us-2` structure, as briefed.

| # | Prototype section | Elementor build | Notes |
|---|---|---|---|
| 1 | `.imperial-banner` | Container: Matte Black, border-bottom 2px Brand Red, padding block 56px → **Heading** (H1) + **Text Editor** | H1 "About Us", 4px tracking, uppercase |
| 2 | `.imperial-intro` | Container (narrow, 900px) → **Text Editor** only | **Intro paragraph with no "Who We Are" heading above it** — that heading was dropped at the client's request. ⚠️ Corrected About copy is still coming from the client |
| 3 | `.section--red` (two-column split) | Container: **background Brand Red**, Direction Row | |
| 3a | Left column | **Heading** + white **Divider** + **Text Editor** + **Image** | Quality / pricing paragraph, then the SQF mark on a white plate |
| 3b | Right column | **Heading** + white **Divider** + **Icon List** + **Text Editor** | "Ideal for your establishment" as a **tick checklist** — bullets, not sentences — then the closing paragraph. Tick icon: white circle, red check |
| 4 | Supplier standards | Container: Matte Black, narrow (900px), centred → **Heading** + **Divider** + **Text Editor** + 3-column badge grid | ⚠️ The internal note *"according to the information provided by our client"* has been removed from this paragraph — do not reinstate it |
| 5 | `.section--red` (values + CTA) | Container: Brand Red → **4 Heading widgets** + 1 **Button** | **Value. Quality. Service. Integrity.** Button: "View all products" |

### 4.3 `products.html` → **Products**

| # | Prototype section | Elementor build | Notes |
|---|---|---|---|
| 1 | `.imperial-banner` | Container + **Heading** (H1 "Products") | |
| 2 | `.imperial-callout` | Container + **Text Editor** | Shared 3–8 oz statement, shown once above the range |
| 3–8 | `.imperial-product-row` ×**6** | One Container per product, Direction Row, alternating `row` / `row-reverse`, **alternating background Matte Black / Brand Red** | **Puck is gone.** Order: XLS, XL, NS, RE, EPIC, CHX |
| 8 | `.imperial-product-row.section--yellow` (CHX) | Container: **background Chicken Yellow** | The chicken row is the one yellow surface on the page. All type inside flips to matte black |
| | Product code badge | **Heading** widget | Brand Red bg / white text on the black bands · **white bg / red text** on the red bands · **black bg / yellow text** on the yellow band |
| | Spec bullets (`.imperial-speclist`) | **Icon List** widget | Icon: small square — Brand Red on black, white on red, black on yellow · Text 14px/500, 1px tracking, uppercase · **Bullets only: the intro sentences above each list were removed because they repeated the bullets** · Where a product is sirloin tip, "100% sirloin tip (peeled knuckles)" is always the first bullet · Set the anchors (`xls`, `xl`, `ns`, `re`, `epic`, `chx`) as each Container's **CSS ID** |
| 9 | Products CTA | Container: Matte Black → **Heading** + **Text Editor** + 2 **Button** widgets | "Talk to us about your menu". The phone button is removed until the new number arrives. **Give the buttons `max-width: 100%` — the previous build clipped these labels** |

### 4.4 `retail.html` → **Retail**

Client revision, 16 Oct: the page is **COMING SOON, set large, and nothing
else**. The nav item stays. Do not mix foodservice content in here — it is one
or the other.

| # | Prototype section | Elementor build | Notes |
|---|---|---|---|
| 1 | `.imperial-soon-section` | **One** Container: Matte Black, min-height 60vh, content centred vertically and horizontally → a single **Heading** (H1) | "Coming Soon" in Oswald 500, uppercase, fluid `clamp(48px, 13vw, 150px)` — in Elementor set the H1 size per breakpoint (150 / 96 / 48px) and leave it at that. Page carries `noindex, follow` |
| — | Banner, eyebrow pill, body copy, Button | — | **All removed.** There is no page banner on Retail any more |
| | | | The client has retail box photography and will send it for this page |

### 4.5 `contact.html` → **Contact Us**

| # | Prototype section | Elementor build | Notes |
|---|---|---|---|
| 1 | `.imperial-banner.imperial-banner--sm` | Container + **Heading** (H1 "Contact Us") + **Text Editor** | **Smaller than the other banners**, per the client. Title is just "Contact Us"; subtitle "Sales & Inquiries" |
| 2 | Contact details | Container: Matte Black → **Heading** + **Divider** + 2-column grid of 6 cards | **Client revision: the dark boxes with thin red lines are gone.** Every card is now solid Brand Red with white text — one uniform treatment. The "IS" monogram image on the right has been removed. **16 Oct:** the "Location" card is now labelled **Warehouse** and reads **Boucherville, QC J4B 8N4** |
| | Phone card | **Icon Box** | Same solid red card as the other five — the client asked for one uniform treatment. Reads `XXX-XXX-XXXX` **pending the client's new number**; add the `tel:` link once it arrives |
| | Email / Website | Must stay real links | `mailto:sales@imperialsteaks.com` · `https://imperialsteaks.com/` |
| 3 | `.section--red` (Send us a message) | Container: Brand Red, narrow, centred → **Heading** + **Text Editor** + **Button** | **Add the Elementor Form widget here.** The prototype ships no fake form; the old site's "send us message" heading has no form behind it either. Confirm fields + destination inbox with the client |

---

## 4.6 Motion: reveals, sticky header, back to top

`assets/css/animations.css` and sections 3–4 of `main.js` are **not migrated** —
Elementor reproduces all of it natively. The reference site already used
entrance animations (`fadeInDown`, 200ms stagger on the hero headings), so this
is carrying existing behaviour over rather than adding something new.

| Prototype | Elementor equivalent | Settings |
|---|---|---|
| `[data-reveal="up"]` | Widget/Container › **Advanced › Motion Effects › Entrance Animation** | `Fade In Up` · Duration **Slow** (~0.7s) |
| `[data-reveal="down"]` (hero headings, page banners) | Entrance Animation | `Fade In Down` — matches the reference site exactly |
| `[data-reveal="zoom"]` (hero image) | Entrance Animation | `Zoom In` · Duration Slow |
| `[data-reveal-delay="1..6"]` | Entrance Animation › **Animation Delay** | 90ms × n (70ms on mobile). Applied to grid siblings so cards arrive in sequence |
| `.imperial-header.is-scrolled` | Header template › **Motion Effects › Sticky: Top** + *Effects Offset* 40 | Add the shrunk padding / shadow on the sticky state |
| `.imperial-to-top` | **Back to Top** widget | Circle, Brand Red, shows after ~1 screen |

**Keep the reduced-motion behaviour.** In Elementor, entrance animations are
suppressed for users with `prefers-reduced-motion` only if the theme/plugin
honours it — verify after the rebuild, or add this to Site Settings › Custom CSS:

```css
@media (prefers-reduced-motion: reduce) {
  .elementor-invisible { visibility: visible !important; animation: none !important; }
}
```

That snippet matters: Elementor hides pending-animation elements with
`.elementor-invisible`, so if its animations are ever blocked the content can be
left invisible. The static prototype avoids the same trap by scoping its hidden
state behind a class that only JavaScript adds.

---

## 5. Where custom CSS is still needed

Everything above is achievable with stock widget controls. Only these four
details need a small amount of CSS — put each one in the widget's *Advanced ›
Custom CSS* (Elementor Pro) or in *Site Settings › Custom CSS*:

| # | Detail | Why stock controls fall short | Suggested CSS |
|---|---|---|---|
| 1 | Tilting the beef and chicken panels toward each other | Elementor has no rotate control on a Container or Image | `selector .imperial-duo__media{transform:rotate(-3.5deg)}` on the chicken panel and `rotate(3.5deg)` on the beef one. Dropping this leaves two flat panels — acceptable, but it loses the "two ends meeting" effect the client asked for |
| 2 | Hard-stop red → black gradient behind that band | Elementor's gradient control does support colour stops, so this is usually achievable in the UI | Background › Gradient, Type Linear, Angle 180°, first colour Brand Red at **42%**, second Matte Black at **42%**. Equal stops are what give a hard seam rather than a blend |
| 3 | `aspect-ratio` on card and product images | Elementor has no aspect-ratio control on the Image widget | `selector img{aspect-ratio:3/2;object-fit:cover}` — **or** set WordPress image sizes / use the Image Box "Image Size: custom 900×600" crop, which avoids CSS |
| 4 | Dashed social-icon border | Social Icons widget border style offers solid only in some versions | `selector .elementor-social-icon{border-style:dashed}` |
| 5 | Certification marks on a white plate | The marks are dark artwork on transparent backgrounds and vanish on the dark sections | Set the Image widget's **Background colour: White** + **Padding** + **Border radius 6px** in the style tab — no CSS needed. Only the `object-fit: contain` needs CSS if the widget crops: `selector img{object-fit:contain}` |

Nothing in this build requires a custom Elementor widget, a plugin, or
JavaScript. If a proposed change ever does, raise it before implementing.

---

## 6. Content that must NOT be published without client approval

Carry these forward as draft/hidden until signed off. Each one is marked in the
prototype with a `TODO: CLIENT REVIEW` or `PENDING CLIENT` HTML comment.

| Item | Where | Required action |
|---|---|---|
| **USDA-inspected facilities** claim | Home badge strip, About "Supplier standards" | Confirm status + exact approved wording + evidence |
| **SQF Level 3** claim | Home badge strip, About "Supplier standards" | Confirm status + exact approved wording + evidence. *(The reference site claimed "SQF Certified — Level 2" for a different supplier — do not reuse that wording)* |
| **Halal** claim | Home categories + badge strip, About | Confirm certification wording for Imperial Steaks |
| **Retail page copy** | Retail page | Coming Soon holder only; nothing has been invented. The client has retail box photography to supply |
| Badge artwork (USDA / SQF / Halal) | Home, About | Licensed/approved artwork only — never reuse a third-party logo file |
| **Beef and chicken photography** | Home split, category cards | ⚠️ **Blocking.** Both shots are cropped from Ritter Foods' advert and must be replaced with licensed or commissioned images before launch — see `IMAGE_REPLACEMENT_LIST.md` §3 |
| **Logo choice** | Site-wide | Three concepts are at `logo-concepts.html`. Concept 2 is in place on the review build; swap the file once the client picks |
| **New phone number** | Footer, Contact page | Currently `XXX-XXX-XXXX`. The old Tasty Steaks number has been removed rather than carried over |

---

## 7. Migration checklist

- [ ] Install WordPress + Hello Elementor (or Astra) + Elementor Pro
- [ ] Enter all 9 Global Colors (§2.1) — values also in `docs/BRAND_COLOURS.md`
- [ ] Enter Global Fonts + the type scale with tablet/mobile values (§2.2–2.3)
- [ ] Set content width 1140px and confirm breakpoints 1024 / 767 (§2.4)
- [ ] Create the 3 WordPress menus (§3.3)
- [ ] Build the Header template, condition = Entire Site (§3.1)
- [ ] Build the Footer template, condition = Entire Site (§3.2)
- [ ] Build Home, About Us, Products, Retail, Contact Us — one Container per prototype `<section>` (§4)
- [ ] Set Container **CSS IDs** for the 6 product anchors and `#foodservice`
- [ ] Upload final imagery per `IMAGE_REPLACEMENT_LIST.md`; keep the listed aspect ratios
- [ ] Add the Elementor Form widget to the Contact page and route it to `sales@imperialsteaks.com`
- [ ] Replace the two Ritter-sourced photographs (`IMAGE_REPLACEMENT_LIST.md` §3)
- [ ] Swap in the client's chosen logo concept
- [ ] Add the new phone number and restore the `tel:` links
- [ ] Add the product guide PDF and repoint the "Download Guide" button
- [ ] Add social profile URLs to the Social Icons widget
- [ ] Set unique page titles + meta descriptions (copy them from each prototype `<head>`)
- [ ] Re-test: keyboard navigation, mobile menu, `tel:`/`mailto:` links, all anchors, contrast
- [ ] Confirm every item in §6 is approved before going live
