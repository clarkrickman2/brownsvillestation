<?php
/**
 * Bronze customizer color mods
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Color scheme mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_colors_mods( $mods ) {

	$color_scheme = bronze_get_color_scheme();

	$mods['colors'] = array(
		'id'      => 'colors',
		'icon'    => 'admin-customizer',
		'title'   => esc_html__( 'Colors', 'bronze' ),
		'options' => array(
			array(
				'label'     => esc_html__( 'Color scheme', 'bronze' ),
				'id'        => 'color_scheme',
				'type'      => 'select',
				'choices'   => bronze_get_color_scheme_choices(),
				'transport' => 'postMessage',
			),

			'body_background_color'    => array(
				'id'        => 'body_background_color',
				'label'     => esc_html__( 'Body Background Color', 'bronze' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[0],
			),

			'page_background_color'    => array(
				'id'        => 'page_background_color',
				'label'     => esc_html__( 'Page Background Color', 'bronze' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[1],
			),

			'submenu_background_color' => array(
				'id'        => 'submenu_background_color',
				'label'     => esc_html__( 'Submenu Background Color', 'bronze' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[2],
			),

			array(
				'id'        => 'submenu_font_color',
				'label'     => esc_html__( 'Submenu Font Color', 'bronze' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[3],
			),

			'accent_color'             => array(
				'id'        => 'accent_color',
				'label'     => esc_html__( 'Accent Color', 'bronze' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[4],
			),

			array(
				'id'        => 'main_text_color',
				'label'     => esc_html__( 'Main Text Color', 'bronze' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[5],
			),

			array(
				'id'          => 'strong_text_color',
				'label'       => esc_html__( 'Strong Text Color', 'bronze' ),
				'type'        => 'color',
				'transport'   => 'postMessage',
				'default'     => $color_scheme[7],
				'description' => esc_html__( 'Heading, "strong" tags etc...', 'bronze' ),
			),
		),
	);

	return $mods;

}
add_filter( 'bronze_customizer_mods', 'bronze_set_colors_mods' );
