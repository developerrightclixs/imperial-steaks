#!/usr/bin/env python3
"""
Generate the WordPress theme's page templates from the static prototype.

Each prototype page's <main> block becomes a PHP page template, with:
  * asset paths rewritten to get_template_directory_uri()
  * internal .html links rewritten to home_url() permalinks
  * the header/footer supplied by the theme

Run from the project root:  python tools/build-theme-templates.py

Regenerate this whenever the static pages change, so the theme and the
prototype never drift apart.
"""

import os
import re

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
THEME = os.path.join(ROOT, 'wp-theme', 'imperial-steaks')
OUT = os.path.join(THEME, 'page-templates')

# prototype file -> (template file, Template Name, page title, slug, meta description)
PAGES = [
    ('index.html',    'template-home.php',     'Imperial Steaks - Home',
     'Home', 'home',
     'Imperial Steaks is a Philly steak importer and distributor supplying premium '
     'thin-sliced beef and chicken steak products to foodservice and retail '
     'customers. Quality you can trust.'),
    ('about.html',    'template-about.php',    'Imperial Steaks - About',
     'About Us', 'about-us',
     'Imperial Steaks is a Philly steak importer and distributor serving foodservice '
     'and retail customers nationwide, built on 25 years of restaurant-industry '
     'experience.'),
    ('products.html', 'template-products.php', 'Imperial Steaks - Products',
     'Products', 'products',
     'Imperial Steaks thin-sliced Philly steak products: House Blend XLS, Traditional '
     'Philly XL, Premium Philly NS, Rib Eye RE, Signature Blend EPIC and '
     'Premium Chicken CHX.'),
    ('retail.html',   'template-retail.php',   'Imperial Steaks - Retail',
     'Retail', 'retail',
     'Imperial Steaks retail packs are coming soon. Contact us for foodservice '
     'supply in the meantime.'),
    ('contact.html',  'template-contact.php',  'Imperial Steaks - Contact',
     'Contact Us', 'contact-us',
     'Contact Imperial Steaks at info@imperialsteaks.com. Facility in Boucherville, QC, '
     'serving Canada, the USA and the Middle East. Foodservice and retail enquiries.'),
]

# prototype href -> WordPress path
LINKS = {
    'index.html': '/',
    'about.html': '/about-us/',
    'products.html': '/products/',
    'retail.html': '/retail/',
    'contact.html': '/contact-us/',
}

HEADER = '''<?php
/**
 * Template Name: {tpl_name}
 *
 * Generated from the static prototype ({source}) by
 * tools/build-theme-templates.py - do not hand-edit. Change the prototype and
 * re-run the generator, or rebuild this page in Elementor and switch the page's
 * template to "Default".
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {{
	exit;
}}

get_header();
?>
'''

FOOTER = '''
<?php
get_footer();
'''


THEME_URI = '<?php echo esc_url( get_template_directory_uri() ); ?>'


def rewrite(markup):
    """Rewrite asset paths and internal links for WordPress."""
    # assets -> theme directory
    markup = re.sub(
        r'(src|href)="assets/',
        r'\1="' + THEME_URI + '/assets/',
        markup,
    )

    # srcset carries a comma-separated candidate list, so each URL in it has
    # to be rewritten on its own - a plain prefix substitution would miss
    # every candidate after the first. The <picture> sources need this.
    def srcset_sub(m):
        candidates = []
        for candidate in m.group(1).split(','):
            candidate = candidate.strip()
            if candidate.startswith('assets/'):
                candidate = THEME_URI + '/' + candidate
            candidates.append(candidate)
        return 'srcset="' + ', '.join(candidates) + '"'

    markup = re.sub(r'srcset="([^"]*)"', srcset_sub, markup)

    # internal page links (with optional #fragment)
    def link_sub(m):
        attr, page, frag = m.group(1), m.group(2), m.group(3) or ''
        path = LINKS[page]
        return f'{attr}="<?php echo esc_url( home_url( \'{path}\' ) ); ?>{frag}"'

    markup = re.sub(
        r'(href)="(' + '|'.join(re.escape(k) for k in LINKS) + r')(#[\w-]+)?"',
        link_sub,
        markup,
    )
    return markup


def main():
    os.makedirs(OUT, exist_ok=True)
    written = []

    for source, tpl_file, tpl_name, title, slug, desc in PAGES:
        html = open(os.path.join(ROOT, source), encoding='utf-8').read()

        m = re.search(r'(?s)<main id="main">(.*?)</main>', html)
        if not m:
            raise SystemExit(f'no <main> block found in {source}')

        body = rewrite(m.group(1))

        php = HEADER.format(tpl_name=tpl_name, source=source)
        php += '\n<main id="main">' + body + '</main>\n'
        php += FOOTER

        path = os.path.join(OUT, tpl_file)
        with open(path, 'w', encoding='utf-8', newline='\n') as fh:
            fh.write(php)
        written.append((tpl_file, len(php)))
        print(f'  {tpl_file:24s} {len(php)/1024:6.1f} KB   <- {source}')

    # Emit the page manifest the activation routine uses, so the two can never
    # disagree about slugs, titles or templates.
    manifest = os.path.join(THEME, 'inc', 'pages.php')
    os.makedirs(os.path.dirname(manifest), exist_ok=True)
    with open(manifest, 'w', encoding='utf-8', newline='\n') as fh:
        fh.write("<?php\n")
        fh.write("/**\n * Page manifest - generated by tools/build-theme-templates.py.\n")
        fh.write(" * Consumed by inc/activation.php when the theme is activated.\n *\n")
        fh.write(" * @package ImperialSteaks\n */\n\n")
        fh.write("if ( ! defined( 'ABSPATH' ) ) {\n\texit;\n}\n\n")
        fh.write("return array(\n")
        for source, tpl_file, tpl_name, title, slug, desc in PAGES:
            fh.write("\tarray(\n")
            fh.write(f"\t\t'title'       => '{title}',\n")
            fh.write(f"\t\t'slug'        => '{slug}',\n")
            fh.write(f"\t\t'template'    => 'page-templates/{tpl_file}',\n")
            fh.write(f"\t\t'description' => '{desc}',\n")
            fh.write(f"\t\t'front'       => {'true' if slug == 'home' else 'false'},\n")
            fh.write("\t),\n")
        fh.write(");\n")
    print(f'\n  inc/pages.php            manifest for {len(PAGES)} pages')


if __name__ == '__main__':
    main()
