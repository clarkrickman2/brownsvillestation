<?php
/**
 * Bronze customizer font mods
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( bronze_is_elementor_fonts_enabled() ) {
	return;
}

/**
 * Font mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_font_mods( $mods ) {

	/**
	 * Get Google Fonts from Font loader
	 */
	$_fonts = apply_filters( 'bronze_mods_fonts', bronze_get_google_fonts_options() );

	$font_choices = array( 'default' => esc_html__( 'Default', 'bronze' ) );

	foreach ( $_fonts as $key => $value ) {
		$font_choices[ $key ] = $key;
	}

	$mods['fonts'] = array(
		'id'      => 'fonts',
		'title'   => esc_html__( 'Fonts', 'bronze' ),
		'icon'    => 'editor-textcolor',
		'options' => array(),
	);

	$mods['fonts']['options']['body_font_name'] = array(
		'label'     => esc_html__( 'Body Font Name', 'bronze' ),
		'id'        => 'body_font_name',
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['body_font_size'] = array(
		'label'       => esc_html__( 'Body Font Size', 'bronze' ),
		'id'          => 'body_font_size',
		'type'        => 'text',
		'transport'   => 'postMessage',
		'description' => esc_html__( 'Don\'t ommit px. Leave empty to use the default font size.', 'bronze' ),
	);

	/*************************Menu*/

	$mods['fonts']['options']['menu_font_name'] = array(
		'id'        => 'menu_font_name',
		'label'     => esc_html__( 'Menu Font', 'bronze' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_weight'] = array(
		'label'     => esc_html__( 'Menu Font Weight', 'bronze' ),
		'id'        => 'menu_font_weight',
		'type'      => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_transform'] = array(
		'id'        => 'menu_font_transform',
		'label'     => esc_html__( 'Menu Font Transform', 'bronze' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'bronze' ),
			'uppercase' => esc_html__( 'Uppercase', 'bronze' ),
			'lowercase' => esc_html__( 'Lowercase', 'bronze' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Menu Letter Spacing (omit px)', 'bronze' ),
		'id'        => 'menu_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_style'] = array(
		'id'        => 'menu_font_style',
		'label'     => esc_html__( 'Menu Font Style', 'bronze' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'bronze' ),
			'italic'  => esc_html__( 'Italic', 'bronze' ),
			'oblique' => esc_html__( 'Oblique', 'bronze' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_name'] = array(
		'id'        => 'submenu_font_name',
		'label'     => esc_html__( 'Submenu Font', 'bronze' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_weight'] = array(
		'label'     => esc_html__( 'Submenu Font Weight', 'bronze' ),
		'id'        => 'submenu_font_weight',
		'type'      => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_transform'] = array(
		'id'        => 'submenu_font_transform',
		'label'     => esc_html__( 'Submenu Font Transform', 'bronze' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'bronze' ),
			'uppercase' => esc_html__( 'Uppercase', 'bronze' ),
			'lowercase' => esc_html__( 'Lowercase', 'bronze' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_style'] = array(
		'id'        => 'submenu_font_style',
		'label'     => esc_html__( 'Submenu Font Style', 'bronze' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'bronze' ),
			'italic'  => esc_html__( 'Italic', 'bronze' ),
			'oblique' => esc_html__( 'Oblique', 'bronze' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Submenu Letter Spacing (omit px)', 'bronze' ),
		'id'        => 'submenu_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	/*************************Heading*/

	$mods['fonts']['options']['heading_font_name'] = array(
		'id'        => 'heading_font_name',
		'label'     => esc_html__( 'Heading Font', 'bronze' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_weight'] = array(
		'label'       => esc_html__( 'Heading Font weight', 'bronze' ),
		'id'          => 'heading_font_weight',
		'type'        => 'text',
		'description' => esc_html__( 'For example: "400" is normal, "700" is bold.The available font weights depend on the font.', 'bronze' ),
		'transport'   => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_transform'] = array(
		'id'        => 'heading_font_transform',
		'label'     => esc_html__( 'Heading Font Transform', 'bronze' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'bronze' ),
			'uppercase' => esc_html__( 'Uppercase', 'bronze' ),
			'lowercase' => esc_html__( 'Lowercase', 'bronze' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_style'] = array(
		'id'        => 'heading_font_style',
		'label'     => esc_html__( 'Heading Font Style', 'bronze' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'bronze' ),
			'italic'  => esc_html__( 'Italic', 'bronze' ),
			'oblique' => esc_html__( 'Oblique', 'bronze' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Heading Letter Spacing (omit px)', 'bronze' ),
		'id'        => 'heading_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	return $mods;

}
add_filter( 'bronze_customizer_mods', 'bronze_set_font_mods', 10 );
