# Imperial Steaks — Website Recreation & Rebranding Specification

> **Audience:** Claude Code / internal development team  
> **Project type:** Internal office assignment  
> **Existing website / primary reference:** https://tastysteaks.ca/  
> **New brand:** Imperial Steaks  
> **Target domain:** https://imperialsteaks.com/  
> **Objective:** Recreate the existing steak-business website as faithfully as practical on a suitable theme/template and implement the client’s requested changes. **This is not a ground-up redesign.** Build in plain HTML/CSS with minimal vanilla JavaScript, explicitly prepared for later WordPress + Elementor migration.

## 1. Non-negotiable instructions

1. **Do not download, extract, restore, or rely on a website backup.** Build a new implementation using a suitable theme or template.
2. Audit the *actual current* Tasty Steaks website first, including navigation, page hierarchy, sections, typography, layout, buttons, and product presentation. Use screenshots supplied by the team where live inspection is incomplete.
3. Match the original website’s structure and visual feel closely. Change only what is required for Imperial Steaks branding, the specified copy, colors, contact information, and approved images.
4. Do not migrate or copy unrelated, injected, suspicious, gambling, casino, or spam content if any is encountered on the reference site. Flag it for review.
5. Do not claim certifications, locations, suppliers, or product attributes beyond the client-provided wording; mark anything requiring verification for approval before publication.
6. Do not silently invent missing paragraphs, product descriptions, product photos, or other assets. Preserve accessible original copy where explicitly requested, otherwise add a clearly identified `TODO: CLIENT REVIEW` note in source content.
7. Image replacements are **pending client instructions**. Keep suitable original assets only when use is authorized; otherwise use clearly identified temporary placeholders and make replacement straightforward.
8. This is **internal office work**, not a freelance quote or sales proposal.
9. **Technology requirement:** plain HTML5, CSS3, and minimal vanilla JavaScript only. No Next.js, React, Tailwind, Vue, build tooling, or frontend frameworks.
10. **Migration requirement:** this is a static prototype that will later be rebuilt in WordPress with Elementor. Structure every section to be easily recreated with Elementor Containers, widgets, global styles, and WordPress menus. Do not claim a static HTML file can be imported into Elementor as a fully editable page automatically.

## 2. Visual references and hierarchy

**Primary design and structure reference:** https://tastysteaks.ca/ — prioritize this over all other websites.

**Secondary industry inspiration only:**
- https://ritterfoods.com/
- https://bmphillysteaks.com/
- https://tysonfoodservice.com/
- JBS, Hormel, Danish Crown, and Original Philly brand websites (find their official sites if needed).

Do not copy competitor logos, text, photos, or designs wholesale. Use secondary references only to understand professional meat-industry presentation and restrained black/red styling.

### Color directions

- **Primary palette:** black, white text, and red accent.
- Explore **three black variants** in the implementation, preferably as theme tokens or documented swatches:
  - Onyx: `#0F0F10` (proposed)
  - Matte black: `#171717` (proposed)
  - Deep charcoal: `#242424` (proposed)
- **Red:** proposed starting point `#B71C1C`; final shade requires visual approval.
- Use white for major headings and copy on dark sections.
- Where the existing design uses white backgrounds, test red replacements **where appropriate**, but do not turn every white area red automatically. Preserve readability, hierarchy, and resemblance to the original. Flag ambiguous areas for review.
- Avoid gratuitous gradients, glassmorphism, animations, or layout changes.

## 3. Page and content requirements

Preserve the actual existing site's navigation and pages as identified during the audit. The pages below are the expected work areas, **not an excuse to invent a new site map**.

### 3.1 Homepage

**Remove:** `Think Thin Save Big`  
**Replace with:** `Quality You Can Taste`

Prominently display these brand values in white text:

- Value
- Integrity
- Service

**Brand heading:** `Imperial Philly Steaks`

**Introduction copy — lightly proofread for grammar, preserving meaning:**

> As a Philly steak importer and distributor, our commitment is to provide premium steak products to our clients. Imperial Steaks was established to build long-term relationships with clients and provide unmatched products through quality and consistency that exceed our customers’ expectations.

**Welcome paragraph:** Reuse the existing welcome paragraph from the reference site if it can be verified; do not create a replacement from scratch. If unavailable, leave a client-review placeholder.

### 3.2 About Us

Rework the existing About Us paragraphs to convey the following client-supplied facts, without adding unsupported claims:

- Imperial Steaks is an importer/distributor entering the market to serve foodservice and retail customers nationwide.
- The team brings **25 years of restaurant-industry experience**.
- The company was formed to deliver high standards of flavor, consistency, quality, and service.
- Its vision emphasizes long-term relationships and exclusive collaboration with a supplier with **over 100 years of industry experience**.
- The supplier has **USDA-inspected facilities** and is described by the client as **SQF Level 3 certified**. **Confirm current certification wording and evidence before publishing as a verified claim.**
- Pricing is intended to be competitive for future customers.

**Suggested working draft (subject to client approval):**

> Imperial Steaks is a Philly steak importer and distributor proud to serve foodservice and retail customers nationwide. Built on 25 years of restaurant-industry experience, Imperial Steaks and its team are dedicated to delivering exceptional flavor, consistent quality, and dependable service. Our vision is to build lasting customer relationships through a commitment to quality and consistency. Working with a supplier that has served the industry for more than 100 years gives us a strong foundation for product quality and reliability.
>
> Our supplier operates USDA-inspected facilities and, according to the information provided by our client, holds SQF Level 3 certification. **[Verify exact certification status and approved wording before publishing.]**
>
> We aim to offer competitive pricing while delivering dependable quality and service to our customers.

Keep other About Us content not specifically targeted for changes; client will correct or replace additional text later.

### 3.3 Foodservice

Add or update a section labeled **Foodservice** with this message:

> Ideal for restaurants, pizza shops, and sandwich shops.

Use the same card/section style as the existing site. Do not add an entirely new page unless the current architecture or client request warrants it.

### 3.4 Products

Keep the existing product presentation and product-specific images until approved replacements are supplied. Apply these copy changes:

| Product | Required content treatment |
|---|---|
| **HOUSE BLEND-XLS** | Keep the existing wording; add that it is marbled for a tender bite and taste, and offers superior taste and quality at a reduced price. |
| **XL** | Describe as made with 100% sirloin tip (also known as peeled knuckles), a lean steak with a firmer bite. |
| **NS** | Follow the applicable XL description; add lightly marinated and seasoned, with better yield percentages. Confirm exact composition if not clear. |
| **RE** | Replace the existing description: whole-muscle ribeye rolls, sliced very thin and stacked in small batches. |
| **EPIC** | Highlight highest-quality beef cuts, signature house blend, texture and bite, with light marination. |
| **CHX** | Keep existing description unchanged. |

**Shared product statement** (display once in an appropriate product area, or consistently where the existing design requires):

> All products come in 3–8 oz portions, individually layered in double paper.

Do not add unrequested nutrition, ingredients, pricing, availability, or product specifications.

### 3.5 Contact

Replace contact details with:

| Field | Value |
|---|---|
| Phone | +1 514-994-8628 |
| Email | sales@imperialsteaks.com |
| Website | https://imperialsteaks.com/ |
| Location | Boucherville, QC J4B 8N4 |
| Other offices | USA and Middle East |

Use `tel:+15149948628` and `mailto:sales@imperialsteaks.com` for working contact links. Do not invent a street address, maps pin, or specific international office addresses.

## 4. Image and asset handling

1. Audit image placements on the reference website (hero, products, About Us, foodservice, etc.).
2. Record each asset in a simple image inventory with current placement and replacement status.
3. Keep the layout and aspect ratios stable even before new images arrive.
4. **Do not scrape and publish competitors' images.** Use licensed/approved assets only.
5. Mark all image slots awaiting client selection as `PENDING CLIENT IMAGE` in the content configuration or developer notes, not as visible public-facing labels.
6. Provide one easy-to-edit asset mapping/configuration for later replacements.

## 5. Technical implementation — HTML/CSS first, Elementor-ready later

**Required stack:** semantic HTML5, standard CSS3, and **only minimal vanilla JavaScript** when necessary for interactive navigation. Do not use React, Next.js, TypeScript, Tailwind, Bootstrap, jQuery, bundlers, npm dependencies, or any JavaScript framework. Do not build a custom WordPress theme at this stage.

### Deliverable file structure

```text
imperial-steaks/
├── index.html
├── about.html
├── products.html
├── retail.html            # only if present on the reference site
├── foodservice.html       # only if warranted by original navigation
├── contact.html
├── assets/
│   ├── css/
│   │   ├── global.css
│   │   └── components.css
│   ├── js/
│   │   └── main.js       # only if needed
│   └── images/
├── docs/
│   ├── ELEMENTOR_MIGRATION.md
│   ├── PAGE_SECTION_MAP.md
│   └── IMAGE_REPLACEMENT_LIST.md
└── README.md
```

Keep actual page filenames aligned with the audited site; do not create empty or invented pages just to match this example.

### Elementor migration compatibility

1. Use a clear **one-section-per-Elementor-container** hierarchy: `<header>`, `<main>`, `<section>`, `<footer>`; inside each section, use simple nested `<div>` containers, headings, paragraphs, images, links, and buttons.
2. Annotate sections with readable comments, e.g. `<!-- Elementor section: Homepage Hero -->`, and unique classes like `imperial-hero` and `imperial-products`.
3. Prefer flexbox and CSS grid patterns that Elementor Containers can reproduce without custom scripts or absolute positioning.
4. Define global colors, typography, spacing, and breakpoints in `:root` CSS variables so they can be mapped to **Elementor Site Settings**.
5. Use reusable CSS classes for buttons, cards, headings, and spacing; avoid deeply nested selectors, `!important` chains, inline styles, and layout tricks.
6. Keep all editable copy in HTML elements rather than pseudo-elements, background images, or JavaScript-generated markup. Use real `<img>` elements for meaningful content images and descriptive `alt` text.
7. Keep header, footer, navigation, product sections, and calls to action independently identifiable for later conversion to Elementor Theme Builder templates/widgets.
8. Avoid complex custom widgets and interactions that would require writing an Elementor plugin.
9. Create `docs/ELEMENTOR_MIGRATION.md` mapping each static section to recommended Elementor widgets (Container, Heading, Text Editor, Image, Button, Icon List, etc.) and indicating where custom CSS may still be needed.
10. Create `docs/PAGE_SECTION_MAP.md` documenting page order, sections, and section-specific classes, and `docs/IMAGE_REPLACEMENT_LIST.md` with image paths and pending client selections.
11. **Do not promise one-click HTML-to-Elementor conversion.** The eventual WordPress implementation will involve recreating these sections in Elementor for genuine visual editability.

### Build quality

- Fully responsive on desktop, tablet, and mobile using media queries.
- Semantic headings, accessible contrast, keyboard-friendly menus, and descriptive alt text.
- Working internal navigation, CTAs, `tel:` and `mailto:` links.
- Efficient image sizes, no unnecessary animation, and fast-loading static assets.
- Unique page titles and meta descriptions relevant to Imperial Steaks.
- No broken links, console errors, lorem ipsum, or production deployment without approval.
- Pages must open in a browser with a simple local static server; no compilation/build step required.

## 6. Claude Code execution plan

### Phase A — Audit (before coding)

1. Inspect https://tastysteaks.ca/ and all relevant accessible pages.
2. Identify the current navigation, page structure, sections, layout, product cards, images, and content.
3. Check for suspicious/unrelated content and exclude it.
4. Compare available screenshots with the live site where possible.
5. Summarize what can be reproduced accurately and what is missing.
6. Identify a suitable theme/template and explain briefly why it is a close match.

### Phase B — Build

1. Create the plain HTML/CSS project and shared styling files; do not initialize a frontend framework.
2. Recreate the original layout, header, footer, and page structure.
3. Replace Tasty Steaks branding with Imperial Steaks.
4. Implement black/red styling without unnecessary layout changes.
5. Apply all page copy and product revisions.
6. Add updated contact links.
7. Prepare image replacement mapping.

### Phase C — Verify

1. Compare each page against the original site or provided screenshots.
2. Check every requirement in this document.
3. Test desktop, tablet, and mobile layouts.
4. Check navigation, contact links, and product sections.
5. Validate HTML/CSS, check browser console, test links and responsiveness; no build or typecheck should be necessary.
6. List remaining client approvals or missing materials.

## 7. Acceptance checklist

- [ ] No backup downloaded or restored.
- [ ] Original site structure and design closely matched.
- [ ] Imperial Steaks branding used consistently.
- [ ] `Think Thin Save Big` removed.
- [ ] `Quality You Can Taste` added.
- [ ] Value, Integrity, Service displayed in white.
- [ ] Homepage intro updated; original welcome paragraph retained if verified.
- [ ] About Us revised with 25-year experience and supplier history.
- [ ] USDA/SQF claims flagged for verification before publication.
- [ ] Foodservice statement added.
- [ ] HOUSE BLEND-XLS, XL, NS, RE, EPIC updated correctly.
- [ ] CHX description unchanged.
- [ ] 3–8 oz double-paper product statement added.
- [ ] Phone, email, website, location, and office regions updated.
- [ ] Black variants and red accent implemented for review.
- [ ] Images retained/placeholdered pending client selection.
- [ ] No suspicious or unrelated content copied.
- [ ] Mobile responsiveness and links tested.
- [ ] Static HTML/CSS pages render without a build step.
- [ ] No frontend frameworks or build dependencies introduced.
- [ ] Elementor migration map and image replacement documentation delivered.
- [ ] Outstanding approvals documented.

## 8. Final delivery from Claude Code

Provide:

1. The completed local implementation (do not deploy unless instructed).
2. A brief summary of changes by page.
3. A list of image placements awaiting client decisions.
4. Any unresolved content questions or certification verification requirements.
5. Instructions for previewing the static site locally (no build step).
6. Elementor migration guide with a page-by-page section/widget map and global style values.

**Final instruction:** Recreate the Tasty Steaks website as faithfully as possible for Imperial Steaks, using a visually suitable **HTML/CSS template** if helpful and only the requested modifications. Make it straightforward to reconstruct with WordPress + Elementor later. Audit first, implement second, and do not improvise missing client requirements.
