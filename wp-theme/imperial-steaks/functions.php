<?php
/**
 * Imperial Steaks theme setup.
 *
 * Deliberately small. The theme's whole job is to hand control to Elementor:
 * register the Theme Builder locations, register the menus, load the brand
 * stylesheets, and otherwise stay out of the way.
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'IMPERIAL_STEAKS_VERSION', '1.4.0' );

/**
 * Theme supports and menus.
 */
function imperial_steaks_setup() {
	load_theme_textdomain( 'imperial-steaks', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	// The supplied logo is 150x79; flex sizing lets the client swap in a larger one.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 79,
			'width'       => 150,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Three menus, matching the static prototype's header and footer.
	 * See docs/ELEMENTOR_MIGRATION.md section 3.3.
	 */
	register_nav_menus(
		array(
			'primary'         => esc_html__( 'Primary', 'imperial-steaks' ),
			'footer-company'  => esc_html__( 'Footer - Company', 'imperial-steaks' ),
			'footer-products' => esc_html__( 'Footer - Products', 'imperial-steaks' ),
		)
	);
}
add_action( 'after_setup_theme', 'imperial_steaks_setup' );

/**
 * Content width - matches the 1140px boxed container used throughout.
 */
function imperial_steaks_content_width() {
	$GLOBALS['content_width'] = 1140;
}
add_action( 'after_setup_theme', 'imperial_steaks_content_width', 0 );

/**
 * The footer blurb shown under the logo when the client has not changed it.
 *
 * Kept in one place so footer.php and the Customizer default cannot drift
 * apart. It is deliberately NOT the WordPress tagline: the tagline is empty on
 * a fresh install and also feeds the <title>, which wants shorter wording.
 *
 * @return string
 */
function imperial_steaks_default_blurb() {
	return __( 'Philly steak importer and distributor serving foodservice and retail customers.', 'imperial-steaks' );
}

/**
 * Front-end styles and scripts.
 *
 * The three brand stylesheets are loaded in dependency order so the cascade
 * matches the static prototype exactly.
 */
function imperial_steaks_assets() {
	$uri = get_template_directory_uri();
	$ver = IMPERIAL_STEAKS_VERSION;

	wp_enqueue_style(
		'imperial-steaks-fonts',
		// Must match the <link> in the static prototype exactly. Oswald 500 is
		// the weight the hero lockup and the Retail "Coming Soon" are set in -
		// without it the browser falls back to 400 and those headlines render
		// visibly lighter than the design. Aleo was dropped when the two-font
		// hero lockup was removed, so it is no longer requested.
		'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Oswald:wght@300;400;500&family=Bodoni+Moda:wght@700;800&display=swap',
		array(),
		null // phpcs:ignore - Google Fonts must not be versioned.
	);

	wp_enqueue_style( 'imperial-steaks-global', $uri . '/assets/css/global.css', array(), $ver );
	wp_enqueue_style( 'imperial-steaks-components', $uri . '/assets/css/components.css', array( 'imperial-steaks-global' ), $ver );
	wp_enqueue_style( 'imperial-steaks-animations', $uri . '/assets/css/animations.css', array( 'imperial-steaks-components' ), $ver );

	// The theme header file itself - keeps WordPress happy, carries no rules.
	wp_enqueue_style( 'imperial-steaks-style', get_stylesheet_uri(), array( 'imperial-steaks-components' ), $ver );

	/*
	 * main.js drives the mobile nav, carousel arrows, scroll reveals and the
	 * back-to-top control. Once those are rebuilt with Elementor widgets
	 * (Nav Menu, Image Carousel, Motion Effects, Back to Top) drop it with:
	 *
	 *   add_filter( 'imperial_steaks_disable_prototype_js', '__return_true' );
	 */
	if ( ! apply_filters( 'imperial_steaks_disable_prototype_js', false ) ) {
		wp_enqueue_script( 'imperial-steaks-main', $uri . '/assets/js/main.js', array(), $ver, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'imperial_steaks_assets' );

// Customizer contact fields + [imperial_contact] shortcode.
require_once get_template_directory() . '/inc/customizer.php';

// First-activation provisioning: pages, menus, front page, meta descriptions.
require_once get_template_directory() . '/inc/activation.php';

/**
 * Register every Elementor Theme Builder location (header, footer, single,
 * archive). Without this, Theme Builder templates have nowhere to render.
 *
 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $manager Locations manager.
 */
function imperial_steaks_register_elementor_locations( $manager ) {
	$manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'imperial_steaks_register_elementor_locations' );

/**
 * Is Elementor active?
 *
 * @return bool
 */
function imperial_steaks_has_elementor() {
	return (bool) did_action( 'elementor/loaded' );
}

/**
 * Was this entry built with Elementor?
 *
 * Used so the theme does not print its own page banner on top of a page the
 * client has laid out in Elementor.
 *
 * @param int|null $post_id Optional post ID.
 * @return bool
 */
function imperial_steaks_built_with_elementor( $post_id = null ) {
	if ( ! imperial_steaks_has_elementor() ) {
		return false;
	}

	$post_id = $post_id ? $post_id : get_the_ID();

	return 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
}

/**
 * Admin notice if Elementor is missing - this theme assumes it.
 */
function imperial_steaks_elementor_notice() {
	if ( imperial_steaks_has_elementor() || ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p><strong>Imperial Steaks theme:</strong> ';
	echo esc_html__( 'this theme is built for Elementor. Install and activate Elementor (and Elementor Pro for Theme Builder header/footer templates) to use it as intended.', 'imperial-steaks' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'imperial_steaks_elementor_notice' );
