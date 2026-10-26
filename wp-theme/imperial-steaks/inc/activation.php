<?php
/**
 * One-shot site provisioning.
 *
 * The point of this file: activating the theme should give you the finished
 * site, not an empty shell. On first activation it creates the five pages,
 * assigns their templates, builds and assigns the three menus, sets the static
 * front page, and fills in the site title and contact details.
 *
 * It is deliberately conservative:
 *   - it runs once, guarded by an option;
 *   - it never overwrites a page that already exists at the same slug;
 *   - it never touches an existing menu of the same name;
 *   - it leaves an existing static front page alone.
 *
 * Re-run it by hand from Tools if ever needed (Appearance > "Set up site").
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const IMPERIAL_STEAKS_SETUP_OPTION = 'imperial_steaks_setup_done';

/**
 * Run the setup once, the first time the theme is activated.
 */
function imperial_steaks_after_switch_theme() {
	if ( get_option( IMPERIAL_STEAKS_SETUP_OPTION ) ) {
		return;
	}
	imperial_steaks_run_setup();
	update_option( IMPERIAL_STEAKS_SETUP_OPTION, IMPERIAL_STEAKS_VERSION );
}
add_action( 'after_switch_theme', 'imperial_steaks_after_switch_theme' );

/**
 * Create pages, menus, front page and defaults.
 *
 * @return array Report of what was created, for the admin notice.
 */
function imperial_steaks_run_setup() {
	$report = array(
		'pages' => array(),
		'menus' => array(),
		'notes' => array(),
	);

	$manifest = require get_template_directory() . '/inc/pages.php';
	$ids      = array();
	$front_id = 0;

	/* ---------------------------------------------------------------- pages */
	foreach ( $manifest as $page ) {
		$existing = get_page_by_path( $page['slug'] );

		if ( $existing ) {
			$id = $existing->ID;
			$report['notes'][] = sprintf( 'Page "%s" already existed - left alone.', $page['title'] );
		} else {
			$id = wp_insert_post(
				array(
					'post_title'   => $page['title'],
					'post_name'    => $page['slug'],
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
					'post_excerpt' => $page['description'],
				)
			);

			if ( is_wp_error( $id ) || ! $id ) {
				$report['notes'][] = sprintf( 'Could not create page "%s".', $page['title'] );
				continue;
			}
			$report['pages'][] = $page['title'];
		}

		// Always make sure the template is attached - cheap and idempotent.
		update_post_meta( $id, '_wp_page_template', $page['template'] );

		$ids[ $page['slug'] ] = $id;

		if ( ! empty( $page['front'] ) ) {
			$front_id = $id;
		}
	}

	/* ----------------------------------------------------------- front page */
	if ( $front_id && 'page' !== get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_id );
		$report['notes'][] = 'Static front page set to Home.';
	}

	/* ---------------------------------------------------------------- menus */
	$primary = array( 'home', 'about-us', 'products', 'retail', 'contact-us' );

	$report['menus'] = array_merge(
		$report['menus'],
		imperial_steaks_build_menu( 'Primary', 'primary', $primary, $ids )
	);
	$report['menus'] = array_merge(
		$report['menus'],
		imperial_steaks_build_menu( 'Footer - Company', 'footer-company', $primary, $ids )
	);

	// Footer product links are anchors on the Products page.
	$products_url = isset( $ids['products'] ) ? get_permalink( $ids['products'] ) : home_url( '/products/' );
	// Puck was dropped from the range at the client's instruction, so it is
	// absent here as well as from the Products page and the footer.
	$anchors      = array(
		'xls'  => 'House Blend - XLS',
		'xl'   => 'Traditional Philly - XL',
		'ns'   => 'Premium Philly - NS',
		're'   => 'Rib Eye - RE',
		'epic' => 'Signature Blend - EPIC',
		'chx'  => 'Premium Chicken - CHX',
	);
	$custom = array();
	foreach ( $anchors as $anchor => $label ) {
		$custom[] = array(
			'label' => $label,
			'url'   => $products_url . '#' . $anchor,
		);
	}
	$report['menus'] = array_merge(
		$report['menus'],
		imperial_steaks_build_menu( 'Footer - Products', 'footer-products', array(), $ids, $custom )
	);

	/* ------------------------------------------------------------- identity */
	if ( 'WordPress' === get_option( 'blogname' ) || '' === get_option( 'blogname' ) ) {
		update_option( 'blogname', 'Imperial Steaks' );
	}
	if ( 'Just another WordPress site' === get_option( 'blogdescription' ) ) {
		update_option(
			'blogdescription',
			'Philly steak importer and distributor serving foodservice and retail customers.'
		);
	}

	return $report;
}

/**
 * Create a menu and assign it to a location, unless one is already assigned.
 *
 * @param string $name     Menu name.
 * @param string $location Theme location slug.
 * @param array  $slugs    Page slugs to add, in order.
 * @param array  $ids      slug => page ID map.
 * @param array  $custom   Optional custom links: array( array( label, url ) ).
 * @return array Report lines.
 */
function imperial_steaks_build_menu( $name, $location, $slugs, $ids, $custom = array() ) {
	$locations = get_theme_mod( 'nav_menu_locations', array() );

	// Something is already assigned here - respect it.
	if ( ! empty( $locations[ $location ] ) && is_nav_menu( $locations[ $location ] ) ) {
		return array( sprintf( 'Menu location "%s" already assigned - left alone.', $name ) );
	}

	$menu = wp_get_nav_menu_object( $name );

	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			return array( sprintf( 'Could not create the "%s" menu.', $name ) );
		}
	} else {
		$menu_id = $menu->term_id;
		// Existing menu with this name but no location - just assign it.
		$locations[ $location ] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
		return array( sprintf( 'Existing "%s" menu assigned to its location.', $name ) );
	}

	foreach ( $slugs as $slug ) {
		if ( empty( $ids[ $slug ] ) ) {
			continue;
		}
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => get_the_title( $ids[ $slug ] ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $ids[ $slug ],
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	foreach ( $custom as $item ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => $item['label'],
				'menu-item-url'    => $item['url'],
				'menu-item-type'   => 'custom',
				'menu-item-status' => 'publish',
			)
		);
	}

	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	return array( sprintf( 'Menu "%s" created and assigned.', $name ) );
}

/**
 * Manual re-run, in case setup is ever needed again (e.g. pages deleted).
 * Appearance > Set up site.
 */
function imperial_steaks_setup_admin_page() {
	add_theme_page(
		esc_html__( 'Set up site', 'imperial-steaks' ),
		esc_html__( 'Set up site', 'imperial-steaks' ),
		'edit_theme_options',
		'imperial-steaks-setup',
		'imperial_steaks_setup_admin_page_render'
	);
}
add_action( 'admin_menu', 'imperial_steaks_setup_admin_page' );

/**
 * Render the manual setup screen.
 */
function imperial_steaks_setup_admin_page_render() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$report = null;

	if ( isset( $_POST['imperial_steaks_setup_nonce'] )
		&& wp_verify_nonce( sanitize_key( wp_unslash( $_POST['imperial_steaks_setup_nonce'] ) ), 'imperial_steaks_setup' ) ) {
		$report = imperial_steaks_run_setup();
		update_option( IMPERIAL_STEAKS_SETUP_OPTION, IMPERIAL_STEAKS_VERSION );
	}

	echo '<div class="wrap"><h1>' . esc_html__( 'Imperial Steaks - set up site', 'imperial-steaks' ) . '</h1>';
	echo '<p>' . esc_html__( 'Creates the five pages, assigns their templates, builds the three menus and sets the static front page. Existing pages and menus are never overwritten.', 'imperial-steaks' ) . '</p>';

	if ( $report ) {
		echo '<div class="notice notice-success"><p><strong>' . esc_html__( 'Setup run.', 'imperial-steaks' ) . '</strong></p><ul style="list-style:disc;margin-left:20px">';
		foreach ( array_merge( $report['pages'], $report['menus'], $report['notes'] ) as $line ) {
			echo '<li>' . esc_html( $line ) . '</li>';
		}
		echo '</ul></div>';
	}

	echo '<form method="post">';
	wp_nonce_field( 'imperial_steaks_setup', 'imperial_steaks_setup_nonce' );
	submit_button( esc_html__( 'Run setup now', 'imperial-steaks' ) );
	echo '</form></div>';
}

/**
 * Output a meta description from the page excerpt, so each page keeps the
 * unique description the prototype had. Skipped if an SEO plugin is active.
 */
function imperial_steaks_meta_description() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'SEOPRESS_VERSION' ) ) {
		return;
	}

	$description = '';

	if ( is_front_page() ) {
		$front = (int) get_option( 'page_on_front' );
		if ( $front ) {
			$description = get_post_field( 'post_excerpt', $front );
		}
	} elseif ( is_singular() ) {
		$description = get_post_field( 'post_excerpt', get_the_ID() );
	}

	if ( ! $description ) {
		$description = get_bloginfo( 'description' );
	}

	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $description ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'imperial_steaks_meta_description', 1 );

/* ============================================================================
   UPGRADES
   ----------------------------------------------------------------------------
   imperial_steaks_run_setup() is deliberately one-shot: it must never stomp on
   a site someone has since edited. The cost of that is real, though - a site
   provisioned under an earlier version keeps whatever was written to the
   database at the time, and re-uploading the theme does not touch it. That is
   how the staging site ended up still titled "tastysteaks" after the rebrand.

   So: a version-keyed upgrade pass. It runs once per version bump and only
   corrects values that still carry the retired brand, leaving anything the
   client has deliberately changed alone.
   ========================================================================== */

/**
 * Slugs the Products range currently contains. Anything else in the
 * "Footer - Products" menu is a leftover and gets cleaned up on upgrade.
 */
function imperial_steaks_product_anchors() {
	return array( 'xls', 'xl', 'ns', 're', 'epic', 'chx' );
}

/**
 * Anchors that were renamed, old => new.
 */
function imperial_steaks_renamed_anchors() {
	return array( 'house-blend-xls' => 'xls' );
}

/**
 * Run the upgrade pass when the stored version differs from the theme version.
 */
function imperial_steaks_maybe_upgrade() {
	$stored = get_option( IMPERIAL_STEAKS_SETUP_OPTION );

	// Never provisioned - after_switch_theme handles a first activation.
	if ( ! $stored ) {
		return;
	}
	if ( IMPERIAL_STEAKS_VERSION === $stored ) {
		return;
	}

	imperial_steaks_run_upgrade();
	update_option( IMPERIAL_STEAKS_SETUP_OPTION, IMPERIAL_STEAKS_VERSION );
}
add_action( 'after_setup_theme', 'imperial_steaks_maybe_upgrade' );

/**
 * Correct anything still carrying the retired Tasty Steaks branding.
 *
 * Every step is conditional: it only rewrites a value that still matches the
 * old brand, so a client edit is never overwritten.
 */
function imperial_steaks_run_upgrade() {

	/* --------------------------------------------------------- site identity */
	// The footer copyright and the <title> both come from the Site Title, which
	// is why a stale value here is visible on every page.
	$name = get_option( 'blogname' );
	if ( $name && preg_match( '/tasty\s*steaks?/i', $name ) ) {
		update_option( 'blogname', 'Imperial Steaks' );
	}

	$tagline = get_option( 'blogdescription' );
	if ( $tagline && preg_match( '/tasty\s*steaks?/i', $tagline ) ) {
		update_option(
			'blogdescription',
			'Philly steak importer and distributor serving foodservice and retail customers.'
		);
	}

	/* ------------------------------------------------- page meta descriptions */
	// Stored as post excerpts at provisioning time, so they also went stale.
	$pages = require __DIR__ . '/pages.php';
	foreach ( $pages as $page ) {
		$existing = get_page_by_path( $page['slug'] );
		if ( ! $existing ) {
			continue;
		}
		if ( preg_match( '/tasty\s*steaks?/i', (string) $existing->post_excerpt ) ) {
			wp_update_post(
				array(
					'ID'           => $existing->ID,
					'post_excerpt' => $page['description'],
				)
			);
		}
	}

	/* ------------------------------------------------- Footer - Products menu */
	imperial_steaks_clean_product_menu();
}

/**
 * Drop retired products from the "Footer - Products" menu and repoint renamed
 * anchors. Menu items live in the database, so a code change alone never
 * removes one - Puck is the case this exists for.
 */
function imperial_steaks_clean_product_menu() {
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$menu_id   = isset( $locations['footer-products'] ) ? (int) $locations['footer-products'] : 0;

	if ( ! $menu_id || ! is_nav_menu( $menu_id ) ) {
		$menu = wp_get_nav_menu_object( 'Footer - Products' );
		if ( ! $menu ) {
			return;
		}
		$menu_id = $menu->term_id;
	}

	$items = wp_get_nav_menu_items( $menu_id );
	if ( ! $items ) {
		return;
	}

	$keep    = imperial_steaks_product_anchors();
	$renamed = imperial_steaks_renamed_anchors();

	foreach ( $items as $item ) {
		$url = (string) $item->url;

		if ( false === strpos( $url, '#' ) ) {
			continue;
		}
		list( $base, $anchor ) = array_pad( explode( '#', $url, 2 ), 2, '' );

		if ( isset( $renamed[ $anchor ] ) ) {
			$anchor = $renamed[ $anchor ];
			update_post_meta( $item->ID, '_menu_item_url', $base . '#' . $anchor );
		}

		// Anything no longer in the range - Puck, historically - is removed.
		if ( ! in_array( $anchor, $keep, true ) ) {
			wp_delete_post( $item->ID, true );
		}
	}
}
