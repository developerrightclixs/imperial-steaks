<?php
/**
 * Template Name: Imperial Steaks - Contact
 *
 * Generated from the static prototype (contact.html) by
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
       Elementor section: Contact Page Banner
       Container (background Matte Black) > Heading widget
       Client revision: title is just "Contact Us" and smaller, with the
       subtitle "Sales & Inquiries".
       ===================================================================== -->
  <section class="imperial-banner imperial-banner--sm">
    <div class="container">
      <h1 class="imperial-banner__title" data-reveal="down">Contact Us</h1>
      <p class="imperial-banner__subtitle">Sales &amp; Inquiries</p>
    </div>
  </section>

  <!-- ========================================================================
       Elementor section: Contact Details
       Container (background Matte Black) > Container (grid, 2 columns)
         > Icon Box widget per detail
       ----------------------------------------------------------------------
       Client revision: the old dark boxes with thin red lines are gone. The
       section is matte black and every card is solid red with white text - one
       uniform treatment. The "IS" monogram image on the right has been removed.
       ===================================================================== -->
  <section class="section" aria-labelledby="contact-details-heading">
    <div class="container">

      <div class="section__head" data-reveal="up">
        <h2 class="section__title" id="contact-details-heading">Contact us now</h2>
        <hr class="imperial-rule imperial-rule--center">
      </div>

      <div class="grid grid--2">

        <div class="imperial-contact-card" data-reveal="up" data-reveal-delay="1">
          <p class="imperial-contact-card__label">Phone</p>
          <!-- PENDING CLIENT: new Imperial Steaks phone number. Shown in the
               XXX-XXX-XXXX format so it reads as a slot waiting for a number
               rather than as finished copy. Make it a tel: link once the real
               number arrives. -->
          <p class="imperial-contact-card__value">XXX-XXX-XXXX</p>
        </div>

        <div class="imperial-contact-card" data-reveal="up" data-reveal-delay="2">
          <p class="imperial-contact-card__label">Email</p>
          <p class="imperial-contact-card__value"><a href="mailto:kougiek@gmail.com">kougiek@gmail.com</a></p>
        </div>

        <div class="imperial-contact-card" data-reveal="up" data-reveal-delay="3">
          <p class="imperial-contact-card__label">Website</p>
          <p class="imperial-contact-card__value"><a href="https://www.imperialsteaks.com/">www.imperialsteaks.com</a></p>
        </div>

        <div class="imperial-contact-card" data-reveal="up" data-reveal-delay="1">
          <p class="imperial-contact-card__label">Warehouse</p>
          <p class="imperial-contact-card__value">Boucherville, QC J4B&nbsp;8N4</p>
        </div>

        <div class="imperial-contact-card" data-reveal="up" data-reveal-delay="2">
          <p class="imperial-contact-card__label">Inquiries</p>
          <p class="imperial-contact-card__value">Foodservice &amp; Retail</p>
        </div>

        <div class="imperial-contact-card" data-reveal="up" data-reveal-delay="3">
          <p class="imperial-contact-card__label">Other offices</p>
          <p class="imperial-contact-card__value">USA and Middle East</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ========================================================================
       Elementor section: Send Us a Message
       Container (background Brand Red) > Heading + Text Editor + Button widgets
       ----------------------------------------------------------------------
       AUDIT NOTE: the old site shows a "send us a message" heading with no
       working form behind it. No fake form has been built here. At migration,
       drop an Elementor Form widget (Pro) or a WPForms/Contact Form 7 shortcode
       into this Container and route submissions to kougiek@gmail.com.
       ===================================================================== -->
  <section class="section section--red" aria-labelledby="message-heading">
    <div class="container container--narrow text-center">

      <h2 class="imperial-cta__title" id="message-heading">Send us a message</h2>
      <p class="imperial-cta__text">Email us and a member of the Imperial Steaks team will come back to you with
        pricing, availability and samples for your operation.</p>

      <div class="btn-row" data-reveal="up">
        <a class="btn btn--primary" href="mailto:kougiek@gmail.com">Email sales</a>
      </div>

    </div>
  </section>

</main>

<?php
get_footer();
