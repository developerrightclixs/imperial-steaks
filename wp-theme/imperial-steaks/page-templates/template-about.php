<?php
/**
 * Template Name: Imperial Steaks - About
 *
 * Generated from the static prototype (about.html) by
 * tools/build-theme-templates.py - do not hand-edit. Change the prototype and
 * re-run the generator, or rebuild this page in Elementor and switch the page's
 * template to "Default".
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main">

  <!-- ========================================================================
       Elementor section: About Page Banner
       Container (background Matte Black, red bottom border) > Heading widget
       ===================================================================== -->
  <section class="imperial-banner">
    <div class="container text-center">
      <h1 class="imperial-banner__title" data-reveal="down">About Us</h1>
    </div>
  </section>

  <!-- ========================================================================
       Elementor section: About Introduction
       Container (background Matte Black) > Text Editor widget
       ----------------------------------------------------------------------
       Follows the structure of the old tastysteaks.ca/about-us-2 page: an
       intro paragraph with no separate "Who We Are" heading above it.

       Client revision (Oct 26): intro rewritten around the client's confirmed
       points - 25 years of restaurant-industry experience, raw thinly sliced
       beef and chicken, and partnerships with distributors, restaurants,
       retailers and foodservice operators across Canada. The supplier sentence
       is carried over from the previous copy. Confirm the final wording with
       the client.

       Client revision (Oct 27): replaced with the client's own About Us text,
       word for word except two typo fixes ("adverse" -> "diverse",
       "who's" -> "whose"). One paragraph, justified, as the client sent it.
       ===================================================================== -->
  <section class="section imperial-intro" aria-labelledby="about-intro-heading">
    <div class="container container--narrow">
      <h2 class="sr-only" id="about-intro-heading">About Imperial Steaks</h2>

      <p class="imperial-intro__text text-justify" data-reveal="up">Imperial Steaks is an independent importer /
        distributor whose aim is to be the leading provider of top quality raw thin-sliced beef and chicken Philly
        steaks. Built on 25 years of restaurant-industry experience, Imperial Steaks and its team are dedicated to
        transferring their knowledge and expertise. Our vision is to work closely and partner with a diverse range of
        customers, including distributors, restaurants, retail, institutions and food service operators across Canada.
        Our commitment is to provide them with premium steak products that will help their business grow. We also
        offer Halal certified Philly steaks for the ever-changing demographics of our country, which in turn reaches a
        wider target market.</p>
    </div>
  </section>

  <!-- ========================================================================
       Elementor section: Quality / Ideal For Your Establishment
       Container (background Brand Red, flex row)
         > Container : Text Editor + Image widget (SQF mark)
         > Container : Heading + Icon List + Text Editor
       The two-column split from the old About page, rebuilt on the red band.
       ----------------------------------------------------------------------
       Client revision (Oct 27): Quality & pricing rewritten with the client's
       text. The "Collaborating" statement was briefly bold and uppercase; the
       client then asked for it to match the paragraph above, with new wording.
       Black rules and black check marks on this band (client, Oct 27).
       TODO: CLIENT COPY - the client's draft reads "dedicated to offer...";
       the "competitive pricing and premium quality" fill-in is ours. Confirm.
       ===================================================================== -->
  <section class="section section--red" aria-labelledby="about-split-heading">
    <div class="container">
      <h2 class="sr-only" id="about-split-heading">Quality, pricing and fit</h2>
      <div class="split">

        <div class="split__col" data-reveal="up">
          <h3 class="imperial-intro__title text-white">Quality &amp; pricing</h3>
          <hr class="imperial-rule imperial-rule--black">

          <p class="text-white text-justify">Imperial Steaks is dedicated to offering competitive pricing and premium
            quality that will help us establish long-term relationships with our customers. Our aim is to work
            side-by-side with our customers, treat them as partners, and address all their needs and
            specifications.</p>

          <p class="text-white text-justify u-mt-md">Collaborating and being the exclusive importer / distributor in
            Canada and abroad with a trusted and dominant USA-based protein supplier that has served the industry for
            more than 100 years will enable us to build and differentiate ourselves from other brands.</p>
        </div>

        <div class="split__col" data-reveal="up" data-reveal-delay="1">
          <h3 class="imperial-intro__title text-white">Ideal for your establishment</h3>
          <hr class="imperial-rule imperial-rule--black">

          <!-- Bullets rather than sentences, per the client's direction. -->
          <ul class="imperial-checklist">
            <li class="imperial-checklist__item">
              <span class="imperial-checklist__tick" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="12" height="12" focusable="false">
                  <path d="M5 12.5 L10 17.5 L19 7" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span><strong>PORTION CONTROLLED</strong> for ease of use and allowing you to track and account for the exact cost per serving.</span>
            </li>
            <li class="imperial-checklist__item">
              <span class="imperial-checklist__tick" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="12" height="12" focusable="false">
                  <path d="M5 12.5 L10 17.5 L19 7" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span><strong>COST-EFFECTIVE</strong> given our pricing competitiveness, which will reduce overall food costs.</span>
            </li>
            <li class="imperial-checklist__item">
              <span class="imperial-checklist__tick" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="12" height="12" focusable="false">
                  <path d="M5 12.5 L10 17.5 L19 7" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span><strong>PERFECT ALTERNATIVE</strong> to sliced rib eye, which is more expensive, less tasty and less tender than our product.</span>
            </li>
            <li class="imperial-checklist__item">
              <span class="imperial-checklist__tick" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="12" height="12" focusable="false">
                  <path d="M5 12.5 L10 17.5 L19 7" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span><strong>MENU-FRIENDLY</strong> allowing easy and quick meals, without compromising taste.</span>
            </li>
          </ul>

          <p class="text-white text-justify u-mt-md">Whether you already serve thin-sliced beef or chicken or are
            thinking of adding it, we can work with you to enhance your menu and show you the profit-building
            potential of our products.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ========================================================================
       Elementor section: Supplier Standards
       Container (background Matte Black) > Heading + Text Editor + grid
       ----------------------------------------------------------------------
       FIXED: this paragraph previously ended "according to the information
       provided by our client", an internal note that was visible on the page.
       ===================================================================== -->
  <section class="section" aria-labelledby="standards-heading">
    <div class="container container--narrow text-center">

      <h2 class="section__title" id="standards-heading">Supplier standards</h2>
      <hr class="imperial-rule imperial-rule--center">

      <p>Our supplier operates USDA-inspected facilities and holds SQF Level&nbsp;3 certification.</p>

      <div class="grid grid--3 u-mt-lg">
        <div class="imperial-badge" data-reveal="up" data-reveal-delay="1">
          <img class="imperial-badge__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/badge-usda-inspected.png" alt="USDA mark" width="500" height="325">
          <p class="imperial-badge__label">USDA-inspected facilities</p>
        </div>
        <div class="imperial-badge" data-reveal="up" data-reveal-delay="2">
          <img class="imperial-badge__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/badge-sqf-level-3.png" alt="SQF certification mark" width="318" height="158">
          <p class="imperial-badge__label">SQF Certified &ndash; Level 3</p>
        </div>
        <div class="imperial-badge" data-reveal="up" data-reveal-delay="3">
          <img class="imperial-badge__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/badge-halal.png" alt="Halal Food Certified mark" width="400" height="419">
          <p class="imperial-badge__label">Halal</p>
        </div>
      </div>

    </div>
  </section>

  <!-- ========================================================================
       Elementor section: Values Band + CTA
       Container (background Brand Red) > 4 Heading widgets + Button widget
       Values corrected per the client: Quality was missing from the build.
       ===================================================================== -->
  <section class="section section--red" aria-labelledby="values-heading">
    <div class="container container--narrow text-center">

      <h2 class="sr-only" id="values-heading">Our values</h2>

      <div class="imperial-values" data-reveal="down">
        <p class="imperial-values__item">Value.</p>
        <p class="imperial-values__item">Quality.</p>
        <p class="imperial-values__item">Service.</p>
        <p class="imperial-values__item">Integrity.</p>
      </div>
      <hr class="imperial-rule imperial-rule--center imperial-rule--black u-mt-md">

      <div class="btn-row u-mt-lg" data-reveal="up">
        <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/products/' ) ); ?>">View all products</a>
      </div>

    </div>
  </section>

</main>

<?php
get_footer();
