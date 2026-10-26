<?php
/**
 * Site header.
 *
 * If an Elementor Theme Builder Header template exists it is rendered and the
 * fallback below never runs. The fallback reproduces the static prototype's
 * header using WordPress functions, so the site looks right from first install
 * - before anyone has opened Theme Builder.
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to main content', 'imperial-steaks' ); ?></a>

<?php
// Elementor Theme Builder header, if one has been published.
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) :
	?>

	<!-- Fallback header - replace by publishing an Elementor Header template. -->
	<header class="imperial-header">
		<div class="imperial-header__inner container">

			<?php if ( has_custom_logo() ) : ?>
				<div class="imperial-header__brand"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<a class="imperial-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"
				   aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' - home' ); ?>">
					<img class="imperial-header__logo"
					     src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-concept-2.svg' ); ?>"
					     alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="462" height="178">
				</a>
			<?php endif; ?>

			<button class="imperial-nav-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
				<span class="imperial-nav-toggle__bar"></span>
				<span class="imperial-nav-toggle__bar"></span>
				<span class="imperial-nav-toggle__bar"></span>
				<span class="sr-only"><?php esc_html_e( 'Main menu', 'imperial-steaks' ); ?></span>
			</button>

			<nav class="imperial-nav" aria-label="<?php esc_attr_e( 'Primary', 'imperial-steaks' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'imperial-nav__list',
							'container'      => false,
							'depth'          => 2,
							'fallback_cb'    => false,
						)
					);
				} else {
					/*
					 * No menu assigned yet (fresh install). List published pages so the
					 * header is navigable immediately instead of showing an empty bar.
					 * Assign a menu to the "Primary" location and this disappears.
					 */
					echo '<ul class="imperial-nav__list" id="primary-menu">';
					wp_list_pages(
						array(
							'title_li' => '',
							'depth'    => 1,
							'sort_column' => 'menu_order, post_title',
						)
					);
					echo '</ul>';
				}
				?>
			</nav>

		</div>
	</header>

<?php endif; ?>
