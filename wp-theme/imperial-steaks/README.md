# Imperial Steaks — Elementor-first WordPress theme

A deliberately minimal theme. Its entire job is to hand control to Elementor and
carry the brand styling. It is modelled on the Hello Elementor approach: no
opinionated layout, nothing for Elementor to fight.

---

## Upload and go

```
Appearance → Themes → Add New → Upload Theme → imperial-steaks.zip → Activate
```

**That is the whole install.** On first activation the theme provisions the site
for you:

| On activate | Result |
|---|---|
| Creates 5 pages | Home, About Us, Products, Retail, Contact Us |
| Assigns each page its template | Full prototype layout, pixel for pixel |
| Builds 3 menus and assigns them | Primary, Footer - Company, Footer - Products (with the 7 product anchor links) |
| Sets the static front page | Home |
| Sets site title and tagline | If still on the WordPress defaults |
| Sets contact details | Phone, email, website, location, offices |

No page building, no menu wiring, no copy-paste. Elementor is **not required**
for the site to look right — install it only when you want to start editing.

It is deliberately conservative: it runs **once**, never overwrites an existing
page at the same slug, never touches a menu already assigned to a location, and
leaves an existing static front page alone. If you ever need it again:
**Appearance → Set up site → Run setup now**.

Requires WordPress 6.0+ and PHP 7.4+.

---

## When you want to edit a page in Elementor

The five pages render from PHP templates, so they are not Elementor-editable out
of the box — that is the trade-off that makes "upload and go" possible.

To convert one:

1. Edit the page → **Page Attributes → Template → Default template**.
2. Click **Edit with Elementor** — you now have an empty canvas.
3. Rebuild that page's sections using `../../docs/ELEMENTOR_MIGRATION.md` §4.

Do this one page at a time. Every other page keeps working untouched, so the
site is never half-broken. The brand CSS, tokens, header and footer all stay the
same either way.

---

## Files

```
imperial-steaks/
├── style.css          theme header only - no rules live here
├── functions.php      supports, menus, enqueues, Elementor locations
├── header.php         Elementor header location + fallback header
├── footer.php         Elementor footer location + fallback footer + back-to-top
├── index.php          blog index / catch-all
├── page.php           single page - prints nothing of its own for Elementor pages
├── single.php         single post
├── archive.php        archives
├── search.php         search results
├── 404.php            not found
├── page-templates/    the five page layouts, generated from the prototype
│   ├── template-home.php
│   ├── template-about.php
│   ├── template-products.php
│   ├── template-retail.php
│   └── template-contact.php
├── inc/
│   ├── activation.php first-run provisioning + meta descriptions
│   ├── customizer.php contact fields + [imperial_contact] shortcode
│   └── pages.php      generated page manifest (titles, slugs, templates)
├── assets/            byte-identical copies of the prototype's css/js/images
└── screenshot.png
```

### The page templates are generated, not hand-written

`tools/build-theme-templates.py` in the project root builds them from the static
prototype: it lifts each page's `<main>` block, rewrites `assets/...` paths to
`get_template_directory_uri()` and `*.html` links to `home_url()` permalinks.

**Change the prototype, then re-run the generator** — do not hand-edit the files
in `page-templates/`, or the two will drift apart.

```bash
python tools/build-theme-templates.py
```

### How the header and footer decide what to render

Both call `elementor_theme_do_location()` first. If a published Elementor
template exists for that location, it renders and the theme's own markup never
runs. If not — or if Elementor Pro is not installed — the fallback markup runs,
driven by `wp_nav_menu()` and the Customizer values. **The site is therefore
never broken at any stage of the migration.**

### Elementor pages get a clean canvas

`page.php` and `single.php` check `_elementor_edit_mode`. If the entry was built
with Elementor the theme prints no banner and no title — Elementor owns the
whole canvas. Only non-Elementor entries get the fallback banner.

---

## `[imperial_contact]` shortcode

Drop a contact detail into any Elementor Text Editor or Shortcode widget so page
content and the footer never drift apart:

```
[imperial_contact field="phone"]      → linked tel:
[imperial_contact field="email"]      → linked mailto:
[imperial_contact field="website"]    → linked, protocol stripped for display
[imperial_contact field="location"]
[imperial_contact field="offices"]
```

All five live under **Appearance → Customize → Contact details**, alongside
**Footer blurb (under the logo)** — the line of copy beneath the footer logo.

> The Facility field ships with a **non-breaking space** inside the postal
> code (`H4N 2T2`) so the footer column can wrap after "QC" without
> splitting `H4N` from `2T2`. If you retype that field in Customizer with an
> ordinary space, the postcode can break across two lines again.

---

## Dropping the prototype JavaScript

`assets/js/main.js` drives the mobile nav, carousel arrows, scroll reveals and
back-to-top. Once those are rebuilt with Elementor's own widgets (Nav Menu,
Image Carousel, Motion Effects › Entrance Animation, Back to Top), stop loading
it from a child theme or a snippet:

```php
add_filter( 'imperial_steaks_disable_prototype_js', '__return_true' );
```

The CSS can stay either way — it is the brand styling, not the behaviour.

---

## Changelog

**1.4.0** — the brand red is now pure red, `#FF0000`.
- **`--is-red` is `#FF0000`, `--is-red-bright` `#FF0000`, `--is-red-dark`
  `#D40000`** (a darkened step for hover/pressed, set at the same darkness as
  the `#D4141C` it replaces so button states look unchanged). This is the
  client's own specification, given as a flat value, and it supersedes the
  `#ED1C24` of the morning of 20 Oct.
- **Ten image files changed with it.** The red is a literal hex inside the
  eight logo SVGs, the favicon and the box mockup — the token does not reach
  them. The two generators in `tools/brand-assets/` were updated in the
  prototype repo so re-running them reproduces the new red.
- **Version bumped because `assets/` changed** — both the CSS and the images.
  This is the rule set out under 1.3.0, and it was missed on the first pass of
  this change: the CSS was edited without the bump, so `?ver=1.3.1` stayed put
  and the staging site kept serving the old red out of cache while the files
  on disk were correct. Caught by inspecting the computed tokens in DevTools.
- **Two consequences of the value itself**, both recorded in
  `docs/BRAND_COLOURS.md` in the prototype repo: `#FF0000` is outside the CMYK
  gamut, so print cannot match the screen; and every red/white and red/black
  pairing now measures below the 4.5:1 AA floor (white on red 4.00:1, black on
  red 4.35:1), though all still clear 3:1 for large text. Neither is a result
  of how the colour was applied.

**1.3.1** — the client's product photography, dropped the evening of 16 Oct.
- **The six product placeholders are gone.** `assets/images/product-{xls,xl,ns,
  re,epic,chx}.svg` are replaced by `.jpg` photographs supplied by the client
  and cropped to the slot's 3:2. The templates carry each file's own intrinsic
  `width`/`height`, because the files are not all one pixel size — the slot's
  aspect is fixed in CSS and crops with `object-fit: cover`, so they need not be.
- **The hero chicken frame is replaced** with the client's chicken cheesesteak,
  written over the same filename at the same 880 × 520, so no template changed.
- Only four products were named in the drop (XL, NS, rib eye, chicken). **XLS**
  and **EPIC** carry two unlabelled beef shots assigned during the build and
  still awaiting the client's word — see `docs/IMAGE_REPLACEMENT_LIST.md` §4 in
  the prototype repo.
- **Version bumped because `assets/` changed.** Seven image files were replaced;
  without the bump `?ver=` would not change and caches would keep serving the
  old artwork. This is the rule set out under 1.3.0 below, applied.

**1.3.0** — three defects found by diffing the staging render against the
static prototype, pixel by pixel.
- **Headlines rendered too light.** The font enqueue asked Google for
  `Oswald:wght@300;400`, but every Oswald element in the design is **weight
  500** — the homepage hero lockup and the Retail "Coming Soon". The browser
  fell back to 400, so those headlines came out visibly thinner than the
  design everywhere on the site. Now requests `300;400;500`, matching the
  `<link>` in the static prototype exactly.
- **Empty footer blurb.** The line under the footer logo was
  `get_bloginfo( 'description' )` — the WordPress **tagline**, which is empty
  on a fresh install, so every page printed an empty `<p>`. It is now its own
  Customizer field (`imperial_steaks_footer_blurb`) defaulting to the
  prototype copy via `imperial_steaks_default_blurb()`. Tying it to the
  tagline was wrong twice over: the tagline also feeds the `<title>`, which
  wants far shorter wording.
- **Postal code split across lines.** "Warehouse" is a wider label than the
  "Office" it replaced, which squeezed the footer's value column enough to
  wrap the address line. The default carries a non-breaking space inside the
  postcode. (The address became 191-9150 Boul. de L'Acadie, Montreal on 31 Oct;
  the wrapping note still applies.)
- Dropped the `Aleo:wght@800` font request: nothing has used Aleo since the
  two-font hero lockup was removed. The dead `--is-font-slab` token went with
  it.
- **Version bumped to 1.3.0** — which is itself the point. The 16 October
  revision round (new brand red, restructured homepage, Retail rewrite,
  redrawn product placeholders) shipped while the constant still read
  `1.2.0`, so `?ver=` never changed and nothing forced caches to refetch the
  CSS. **Bump `IMPERIAL_STEAKS_VERSION` in `functions.php` and `Version:` in
  `style.css` on every deploy that touches `assets/`.**

**1.0.1**
- Nav and footer links are now styled when rendered by WordPress. `wp_nav_menu()`
  emits plain `<a>` tags with no custom class, so the original CSS (which only
  targeted `.imperial-nav__link` / `.imperial-footer__link`) left them unstyled.
  Added `.imperial-nav__list a` / `.imperial-footer__list a`, plus WordPress's
  own `current-menu-item` and `current_page_item` states for the active
  underline, and `li` dividers for the mobile dropdown.
- Header falls back to `wp_list_pages()` when no menu is assigned to the Primary
  location, so a fresh install has a usable nav instead of an empty bar.
- Footer Company/Products columns are hidden unless their menu exists, instead
  of printing a heading with nothing beneath it.

**1.1.0**
- **Upload and go.** First activation now creates the five pages, assigns their
  templates, builds and assigns the three menus, and sets the static front page.
  Added `inc/activation.php`, `inc/pages.php` and `page-templates/`.
- Page templates generated from the static prototype by
  `tools/build-theme-templates.py`, so the WordPress site matches it exactly.
- Per-page meta descriptions output from the page excerpt (skipped if Yoast,
  Rank Math or SEOPress is active).
- Manual re-run available at **Appearance → Set up site**.

**1.0.0** — initial theme.

---

## Known limitations, stated plainly

- **Activated successfully on a staging install** (2026-10-13): no PHP errors,
  theme styling applied, fallback header and footer both rendering. Still worth
  a pass with `WP_DEBUG` on, and the archive/search/404 templates have not been
  exercised yet.
- **The CSS class prefix is still `imperial-`** (`imperial-header`,
  `imperial-products`, …), left over from when the project was to be branded
  Imperial Steaks. The classes are internal and invisible to visitors, and the
  migration docs reference them throughout, so they were left as-is rather than
  risk a 641-occurrence rename. Worth doing as a tidy-up if you want.
- **No child theme is included.** Add one before customising, so theme updates
  do not overwrite changes.
- `page.php`/`single.php` use the `_elementor_edit_mode` post meta rather than
  Elementor's PHP API, so the check keeps working if Elementor is deactivated.
