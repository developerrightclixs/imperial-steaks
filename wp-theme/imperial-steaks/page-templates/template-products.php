<?php
/**
 * Template Name: Imperial Steaks - Products
 *
 * Generated from the static prototype (products.html) by
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
       Elementor section: Products Page Banner
       Container (background Matte Black) > Heading widget
       ===================================================================== -->
  <section class="imperial-banner">
    <div class="container">
      <h1 class="imperial-banner__title" data-reveal="down">Products</h1>
      <p class="imperial-banner__subtitle">Thin-sliced beef &amp; chicken steak</p>
    </div>
  </section>

  <!-- ========================================================================
       Elementor section: Shared Product Statement
       Container (background Matte Black) > Text Editor inside a bordered
       Container. Displayed once, above the range.
       ===================================================================== -->
  <section class="section">
    <div class="container">
      <div class="imperial-callout imperial-callout--center" data-reveal="up">
        <p class="imperial-callout__text">All products come in 3&ndash;8 oz portions, individually layered in double paper.</p>
      </div>
    </div>
  </section>

  <!-- ========================================================================
       PRODUCT ROWS
       One Container per product, flex row, alternating image side and
       alternating background: matte black / brand red, with the chicken row
       on yellow.

       Content rule from the client: bullets only. The intro sentences that
       used to sit above each list have been removed, because they repeated the
       bullets underneath. Where a product is made from sirloin tip, that is
       always the first bullet.

       CLIENT PHOTOGRAPHY, supplied Oct 16. All six slots now hold a real
       photograph; the dashed placeholders moved to assets/images/_withdrawn/.
       The slot is 3:2 and the CSS crops with object-fit: cover, so the files
       differ in pixel size - the width/height attributes carry each file's own
       intrinsic size. XL and NS came off phone screengrabs of the client's dev
       site and are the two lowest-resolution files in the set; ask for the
       originals. XLS and EPIC had no file of their own in the drop - the two
       unlabelled beef shots were assigned to them and still need the client's
       word. See docs/IMAGE_REPLACEMENT_LIST.md section 4.
       ===================================================================== -->

  <!-- Product - HOUSE BLEND - XLS ------------------------------------------ -->
  <section class="imperial-product-row" id="xls" aria-labelledby="xls-heading">
    <div class="container">
      <div class="split">

        <div class="split__col" data-reveal="up">
          <p class="imperial-product-row__code">XLS</p>
          <h2 class="imperial-product-row__title" id="xls-heading">House Blend &ndash; XLS</h2>
          <hr class="imperial-rule">
          <ul class="imperial-speclist">
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Blend of whole muscle</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Marbled for a tender bite</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Unique blend and taste</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Economically priced</li>
          </ul>
        </div>

        <div class="split__col" data-reveal="up">
          <img class="imperial-product-row__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/product-xls.jpg" alt="House Blend XLS - a frozen portion of thinly sliced blended Philly steak" width="1000" height="667">
        </div>

      </div>
    </div>
  </section>

  <!-- Product - TRADITIONAL PHILLY - XL ------------------------------------ -->
  <section class="imperial-product-row section--red" id="xl" aria-labelledby="xl-heading">
    <div class="container">
      <div class="split split--reverse">

        <div class="split__col" data-reveal="up">
          <p class="imperial-product-row__code">XL</p>
          <h2 class="imperial-product-row__title" id="xl-heading">Traditional Philly &ndash; XL</h2>
          <hr class="imperial-rule imperial-rule--white">
          <ul class="imperial-speclist">
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>100% sirloin tip (peeled knuckles)</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Marinated whole muscle</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Lean steak with a firmer bite</li>
          </ul>
        </div>

        <div class="split__col" data-reveal="up">
          <img class="imperial-product-row__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/product-xl.jpg" alt="Traditional Philly XL - a frozen sheet of marinated sirloin tip Philly steak on parchment" width="1200" height="800">
        </div>

      </div>
    </div>
  </section>

  <!-- Product - PREMIUM PHILLY - NS ---------------------------------------- -->
  <section class="imperial-product-row" id="ns" aria-labelledby="ns-heading">
    <div class="container">
      <div class="split">

        <div class="split__col" data-reveal="up">
          <p class="imperial-product-row__code">NS</p>
          <h2 class="imperial-product-row__title" id="ns-heading">Premium Philly &ndash; NS</h2>
          <hr class="imperial-rule">
          <ul class="imperial-speclist">
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>100% sirloin tip (peeled knuckles)</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Lightly marinated and seasoned</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Lean steak with a firmer bite</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>No soya</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Better yield percentages</li>
          </ul>
        </div>

        <div class="split__col" data-reveal="up">
          <img class="imperial-product-row__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/product-ns.jpg" alt="Premium Philly NS - frozen sheets of sliced sirloin tip Philly steak, interleaved with parchment" width="1200" height="800">
        </div>

      </div>
    </div>
  </section>

  <!-- Product - RIB EYE - RE ----------------------------------------------- -->
  <section class="imperial-product-row section--red" id="re" aria-labelledby="re-heading">
    <div class="container">
      <div class="split split--reverse">

        <div class="split__col" data-reveal="up">
          <p class="imperial-product-row__code">RE</p>
          <h2 class="imperial-product-row__title" id="re-heading">Rib Eye &ndash; RE</h2>
          <hr class="imperial-rule imperial-rule--white">
          <ul class="imperial-speclist">
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Whole-muscle ribeye rolls</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Sliced very thin</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Stacked in small batches</li>
          </ul>
        </div>

        <div class="split__col" data-reveal="up">
          <img class="imperial-product-row__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/product-re.jpg" alt="Rib Eye RE - a case of whole-muscle rib eye rolls" width="1400" height="933">
        </div>

      </div>
    </div>
  </section>

  <!-- Product - SIGNATURE BLEND - EPIC ------------------------------------- -->
  <section class="imperial-product-row" id="epic" aria-labelledby="epic-heading">
    <div class="container">
      <div class="split">

        <div class="split__col" data-reveal="up">
          <p class="imperial-product-row__code">EPIC</p>
          <h2 class="imperial-product-row__title" id="epic-heading">Signature Blend &ndash; EPIC</h2>
          <hr class="imperial-rule">
          <ul class="imperial-speclist">
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Highest-quality beef cuts</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Signature house blend</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Light marination</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Distinct texture and bite</li>
          </ul>
        </div>

        <div class="split__col" data-reveal="up">
          <img class="imperial-product-row__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/product-epic.jpg" alt="Signature Blend EPIC - a stack of frozen sliced Signature Blend Philly steak, interleaved with parchment" width="1800" height="1200">
        </div>

      </div>
    </div>
  </section>

  <!-- Product - PREMIUM CHICKEN - CHX ---------------------------------------
       The chicken range carries the yellow scheme, as beef carries red+black.
       ===================================================================== -->
  <section class="imperial-product-row section--yellow" id="chx" aria-labelledby="chx-heading">
    <div class="container">
      <div class="split split--reverse">

        <div class="split__col" data-reveal="up">
          <p class="imperial-product-row__code">CHX</p>
          <h2 class="imperial-product-row__title" id="chx-heading">Premium Chicken &ndash; CHX</h2>
          <hr class="imperial-rule imperial-rule--black">
          <ul class="imperial-speclist">
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>Lightly marinated</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>95% lean</li>
            <li class="imperial-speclist__item"><span class="imperial-speclist__marker" aria-hidden="true"></span>100% boneless breast meat</li>
          </ul>
        </div>

        <div class="split__col" data-reveal="up">
          <img class="imperial-product-row__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/product-chx.jpg" alt="Premium Chicken CHX - a stack of frozen sliced chicken breast Philly steak, interleaved with parchment" width="900" height="600">
        </div>

      </div>
    </div>
  </section>

  <!-- ========================================================================
       Elementor section: Products CTA
       Container (background Matte Black) > Heading + Text Editor + Buttons
       ----------------------------------------------------------------------
       FIXED: the buttons were being clipped in the previous build. The pills
       now cap at 100% width and wrap their labels (see .btn in components.css).
       The phone button is gone until the client supplies the new number.
       ===================================================================== -->
  <section class="section" aria-labelledby="products-cta-heading">
    <div class="container container--narrow text-center">
      <h2 class="imperial-cta__title" id="products-cta-heading">Talk to us about your menu</h2>
      <p class="imperial-cta__text">Ideal for restaurants, pizza shops and sandwich shops.</p>
      <div class="btn-row" data-reveal="up">
        <a class="btn btn--accent" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact us</a>
        <a class="btn btn--outline" href="mailto:sales@imperialsteaks.com">Email sales</a>
      </div>
    </div>
  </section>

</main>

<?php
get_footer();
