<?php
/**
 * Site footer.
 *
 * As with the header: an Elementor Theme Builder Footer template wins if one
 * exists; otherwise the prototype's footer is reproduced with WordPress menus
 * so the site is usable immediately.
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) :
	?>

	<!-- Fallback footer - replace by publishing an Elementor Footer template. -->
	<footer class="imperial-footer">

		<div class="imperial-footer__top container">
			<div class="imperial-footer__grid">

				<div class="imperial-footer__col">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<img class="imperial-footer__logo"
						     src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>"
						     alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="970" height="343">
					<?php endif; ?>
					<?php
					/*
					 * Its own Customizer field, not the WordPress tagline. The tagline
					 * is empty on a fresh install and also feeds the <title>, so using
					 * it here printed an empty paragraph on every page and tied the
					 * footer copy to an SEO field that wants different wording.
					 */
					$blurb = get_theme_mod( 'imperial_steaks_footer_blurb', imperial_steaks_default_blurb() );
					if ( $blurb ) :
						?>
						<p class="imperial-footer__blurb"><?php echo esc_html( $blurb ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( has_nav_menu( 'footer-company' ) ) : ?>
					<div class="imperial-footer__col">
						<h2 class="imperial-footer__title"><?php esc_html_e( 'Company', 'imperial-steaks' ); ?></h2>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-company',
								'menu_class'     => 'imperial-footer__list',
								'container'      => false,
								'depth'          => 1,
								'fallback_cb'    => false,
							)
						);
						?>
					</div>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'footer-products' ) ) : ?>
					<div class="imperial-footer__col">
						<h2 class="imperial-footer__title"><?php esc_html_e( 'Products', 'imperial-steaks' ); ?></h2>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-products',
								'menu_class'     => 'imperial-footer__list',
								'container'      => false,
								'depth'          => 1,
								'fallback_cb'    => false,
							)
						);
						?>
					</div>
				<?php endif; ?>

				<div class="imperial-footer__col">
					<h2 class="imperial-footer__title"><?php esc_html_e( 'Contact us now', 'imperial-steaks' ); ?></h2>
					<?php
					/*
					 * Contact details are theme-mod driven so the client can edit them in
					 * Customizer without touching code. Defaults match the brief.
					 */
					$tel       = get_theme_mod( 'imperial_steaks_phone', '514.944.8628' );
					$email     = get_theme_mod( 'imperial_steaks_email', 'info@imperialsteaks.com' );
					$email_alt = get_theme_mod( 'imperial_steaks_email_alt', 'kougiek@gmail.com' );
					$web   = get_theme_mod( 'imperial_steaks_website', 'https://www.imperialsteaks.com/' );
					// One address line per row. The non-breaking space (U+00A0) before 8W4
					// keeps the postal code whole when the narrow footer column wraps.
					$place    = get_theme_mod( 'imperial_steaks_location', "120 Rue T-A-Bombardier\nBoucherville, QC J4B\xc2\xa08W4\nCanada" );
					$approved = get_theme_mod( 'imperial_steaks_approved', "CFIA Approved \xe2\x80\x93 HACCP" );
					$also     = get_theme_mod( 'imperial_steaks_other_offices', "Canada \xe2\x80\x93 USA \xe2\x80\x93 Middle East" );
					?>
					<ul class="imperial-footer__contact">
						<li class="imperial-footer__contact-item">
							<span class="imperial-footer__contact-label"><?php esc_html_e( 'Tel', 'imperial-steaks' ); ?></span>
							<?php
							// Only link it when it is a number; a tel: link with no digits in it
							// is worse than plain text.
							$tel_digits = preg_replace( '/[^0-9+]/', '', $tel );
							if ( strlen( preg_replace( '/[^0-9]/', '', $tel_digits ) ) >= 7 ) :
								?>
								<a href="tel:<?php echo esc_attr( $tel_digits ); ?>"><?php echo esc_html( $tel ); ?></a>
							<?php else : ?>
								<span><?php echo esc_html( $tel ); ?></span>
							<?php endif; ?>
						</li>
						<li class="imperial-footer__contact-item">
							<span class="imperial-footer__contact-label"><?php esc_html_e( 'Email', 'imperial-steaks' ); ?></span>
							<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
						</li>
						<?php if ( $email_alt ) : ?>
						<li class="imperial-footer__contact-item">
							<span class="imperial-footer__contact-label"><?php esc_html_e( 'Email', 'imperial-steaks' ); ?></span>
							<a href="mailto:<?php echo esc_attr( $email_alt ); ?>"><?php echo esc_html( $email_alt ); ?></a>
						</li>
						<?php endif; ?>
						<li class="imperial-footer__contact-item">
							<span class="imperial-footer__contact-label"><?php esc_html_e( 'Web', 'imperial-steaks' ); ?></span>
							<a href="<?php echo esc_url( $web ); ?>"><?php echo esc_html( preg_replace( '#^https?://|/$#', '', $web ) ); ?></a>
						</li>
						<li class="imperial-footer__contact-item">
							<span class="imperial-footer__contact-label"><?php esc_html_e( 'Facility', 'imperial-steaks' ); ?></span>
							<span><?php echo nl2br( esc_html( $place ), false ); ?></span>
						</li>
						<li class="imperial-footer__contact-item">
							<span class="imperial-footer__contact-label"><?php esc_html_e( 'Approved', 'imperial-steaks' ); ?></span>
							<span><?php echo esc_html( $approved ); ?></span>
						</li>
						<li class="imperial-footer__contact-item">
							<span class="imperial-footer__contact-label"><?php esc_html_e( 'Locations', 'imperial-steaks' ); ?></span>
							<span><?php echo esc_html( $also ); ?></span>
						</li>
					</ul>

					<?php
					/*
					 * Social row. Matches the static prototype, which the theme
					 * footer was missing. Rendered as non-interactive placeholders
					 * until the client supplies profile URLs - at which point
					 * replace this with an Elementor Social Icons widget, or wire
					 * each item to a real link.
					 */
					?>
					<div class="imperial-social" role="list"
					     aria-label="<?php esc_attr_e( 'Social profiles (coming soon)', 'imperial-steaks' ); ?>">
						<span class="imperial-social__item" role="listitem">IG</span>
						<span class="imperial-social__item" role="listitem">FB</span>
						<span class="imperial-social__item" role="listitem">X</span>
					</div>
				</div>

			</div>
		</div>

		<div class="imperial-footer__bottom">
			<div class="container">
				<p class="imperial-footer__copyright">
					<?php
					printf(
						/* translators: 1: year, 2: site name */
						esc_html__( 'Copyright © %1$s %2$s. All rights reserved.', 'imperial-steaks' ),
						esc_html( gmdate( 'Y' ) ),
						esc_html( get_bloginfo( 'name' ) )
					);
					?>
				</p>
			</div>
		</div>

	</footer>

<?php endif; ?>

<!-- Back to top. Replace with Elementor's "Back to Top" widget if preferred. -->
<button class="imperial-to-top" type="button" aria-label="<?php esc_attr_e( 'Back to top', 'imperial-steaks' ); ?>">
	<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" focusable="false">
		<path d="M12 19 V6 M5.5 12.5 L12 6 L18.5 12.5" fill="none" stroke="currentColor"
		      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
	</svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
