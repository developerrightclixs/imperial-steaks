<?php
/**
 * Customizer: contact details.
 *
 * The footer prints phone, email, website, location and other offices. Putting
 * them here means the client can change them in Appearance > Customize without
 * editing a template - and the same values can be pulled into Elementor with a
 * shortcode if the footer is later rebuilt in Theme Builder.
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the panel, section and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function imperial_steaks_customize_register( $wp_customize ) {

	$wp_customize->add_section(
		'imperial_steaks_contact',
		array(
			'title'       => esc_html__( 'Contact details', 'imperial-steaks' ),
			'priority'    => 40,
			'description' => esc_html__( 'Shown in the site footer and available via the [imperial_contact] shortcode.', 'imperial-steaks' ),
		)
	);

	$fields = array(
		'imperial_steaks_phone'          => array(
			'label'   => esc_html__( 'Phone', 'imperial-steaks' ),
			'default' => 'XXX-XXX-XXXX',
			'sanitize' => 'sanitize_text_field',
		),
		'imperial_steaks_email'          => array(
			'label'   => esc_html__( 'Email', 'imperial-steaks' ),
			'default' => 'sales@imperialsteaks.com',
			'sanitize' => 'sanitize_email',
		),
		'imperial_steaks_website'        => array(
			'label'   => esc_html__( 'Website', 'imperial-steaks' ),
			'default' => 'https://www.imperialsteaks.com/',
			'sanitize' => 'esc_url_raw',
		),
		'imperial_steaks_location'       => array(
			'label'   => esc_html__( 'Warehouse', 'imperial-steaks' ),
			// Non-breaking space (U+00A0) before 8N4 - see the note in footer.php.
			'default' => "Boucherville, QC J4B\xc2\xa08N4",
			'sanitize' => 'sanitize_text_field',
		),
		'imperial_steaks_other_offices'  => array(
			'label'   => esc_html__( 'Other offices', 'imperial-steaks' ),
			'default' => 'USA and Middle East',
			'sanitize' => 'sanitize_text_field',
		),
		'imperial_steaks_footer_blurb'   => array(
			'label'   => esc_html__( 'Footer blurb (under the logo)', 'imperial-steaks' ),
			'default' => imperial_steaks_default_blurb(),
			'sanitize' => 'sanitize_text_field',
		),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => $field['sanitize'],
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'imperial_steaks_contact',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'imperial_steaks_customize_register' );

/**
 * [imperial_contact field="email"] - drop a contact detail into any Elementor
 * Text Editor or Shortcode widget so the footer and page content never drift
 * apart.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function imperial_steaks_contact_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'field' => 'email' ), $atts, 'imperial_contact' );

	$map = array(
		'phone'    => array( 'imperial_steaks_phone', 'XXX-XXX-XXXX' ),
		'email'    => array( 'imperial_steaks_email', 'sales@imperialsteaks.com' ),
		'website'  => array( 'imperial_steaks_website', 'https://www.imperialsteaks.com/' ),
		'location' => array( 'imperial_steaks_location', "Boucherville, QC J4B\xc2\xa08N4" ),
		'offices'  => array( 'imperial_steaks_other_offices', 'USA and Middle East' ),
	);

	$key = strtolower( $atts['field'] );

	if ( ! isset( $map[ $key ] ) ) {
		return '';
	}

	$value = get_theme_mod( $map[ $key ][0], $map[ $key ][1] );

	if ( 'email' === $key ) {
		return '<a href="mailto:' . esc_attr( $value ) . '">' . esc_html( $value ) . '</a>';
	}

	if ( 'phone' === $key ) {
		return '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $value ) ) . '">' . esc_html( $value ) . '</a>';
	}

	if ( 'website' === $key ) {
		return '<a href="' . esc_url( $value ) . '">' . esc_html( preg_replace( '#^https?://|/$#', '', $value ) ) . '</a>';
	}

	return esc_html( $value );
}
add_shortcode( 'imperial_contact', 'imperial_steaks_contact_shortcode' );
