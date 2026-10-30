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
			// Client, Oct 30: the number is written with dots, not hyphens.
			'default' => '514.944.8628',
			'sanitize' => 'sanitize_text_field',
		),
		'imperial_steaks_email'          => array(
			'label'   => esc_html__( 'Email', 'imperial-steaks' ),
			'default' => 'info@imperialsteaks.com',
			'sanitize' => 'sanitize_email',
		),
		'imperial_steaks_website'        => array(
			'label'   => esc_html__( 'Website', 'imperial-steaks' ),
			'default' => 'https://www.imperialsteaks.com/',
			'sanitize' => 'esc_url_raw',
		),
		'imperial_steaks_location'       => array(
			'label'   => esc_html__( 'Facility (one line per row)', 'imperial-steaks' ),
			// Non-breaking space (U+00A0) before 2T2 - see the note in footer.php.
			'default' => "191-9150 Boul. de L\xe2\x80\x99Acadie\nMontreal, QC, H4N\xc2\xa02T2\nCanada",
			'sanitize' => 'sanitize_textarea_field',
			'type'     => 'textarea',
		),
		'imperial_steaks_approved'       => array(
			'label'   => esc_html__( 'Approvals', 'imperial-steaks' ),
			'default' => "CFIA Approved \xe2\x80\x93 HACCP",
			'sanitize' => 'sanitize_text_field',
		),
		'imperial_steaks_other_offices'  => array(
			'label'   => esc_html__( 'Locations', 'imperial-steaks' ),
			'default' => "Canada \xe2\x80\x93 USA \xe2\x80\x93 Middle East",
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
				'type'    => isset( $field['type'] ) ? $field['type'] : 'text',
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
		'phone'    => array( 'imperial_steaks_phone', '514.944.8628' ),
		'email'    => array( 'imperial_steaks_email', 'info@imperialsteaks.com' ),
		'website'  => array( 'imperial_steaks_website', 'https://www.imperialsteaks.com/' ),
		'location' => array( 'imperial_steaks_location', "191-9150 Boul. de L\xe2\x80\x99Acadie\nMontreal, QC, H4N\xc2\xa02T2\nCanada" ),
		'approved' => array( 'imperial_steaks_approved', "CFIA Approved \xe2\x80\x93 HACCP" ),
		'offices'  => array( 'imperial_steaks_other_offices', "Canada \xe2\x80\x93 USA \xe2\x80\x93 Middle East" ),
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

	if ( 'location' === $key ) {
		return nl2br( esc_html( $value ), false );
	}

	return esc_html( $value );
}
add_shortcode( 'imperial_contact', 'imperial_steaks_contact_shortcode' );
