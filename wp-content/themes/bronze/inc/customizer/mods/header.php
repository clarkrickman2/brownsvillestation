<?php
/**
 * Bronze header_settings
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

function bronze_set_header_settings_mods( $mods ) {

	$mods['header_settings'] = array(

		'id'      => 'header_settings',
		'title'   => esc_html__( 'Header Layout', 'bronze' ),
		'icon'    => 'editor-table',
		'options' => array(

			'hero_layout'            => array(
				'label'     => esc_html__( 'Page Header Layout', 'bronze' ),
				'id'        => 'hero_layout',
				'type'      => 'select',
				'choices'   => array(
					'standard'   => esc_html__( 'Standard', 'bronze' ),
					'big'        => esc_html__( 'Big', 'bronze' ),
					'small'      => esc_html__( 'Small', 'bronze' ),
					'fullheight' => esc_html__( 'Full Height', 'bronze' ),
					'none'       => esc_html__( 'No header', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			'hero_background_effect' => array(
				'id'      => 'hero_background_effect',
				'label'   => esc_html__( 'Header Image Effect', 'bronze' ),
				'type'    => 'select',
				'choices' => array(
					'parallax' => esc_html__( 'Parallax', 'bronze' ),
					'zoomin'   => esc_html__( 'Zoom', 'bronze' ),
					'none'     => esc_html__( 'None', 'bronze' ),
				),
			),

			'hero_scrolldown_arrow'  => array(
				'id'      => 'hero_scrolldown_arrow',
				'label'   => esc_html__( 'Scroll Down arrow', 'bronze' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'bronze' ),
					''    => esc_html__( 'No', 'bronze' ),
				),
			),

			array(
				'label'   => esc_html__( 'Header Overlay', 'bronze' ),
				'id'      => 'hero_overlay',
				'type'    => 'select',
				'choices' => array(
					''       => esc_html__( 'Default', 'bronze' ),
					'custom' => esc_html__( 'Custom', 'bronze' ),
					'none'   => esc_html__( 'None', 'bronze' ),
				),
			),

			array(
				'label' => esc_html__( 'Overlay Color', 'bronze' ),
				'id'    => 'hero_overlay_color',
				'type'  => 'color',
				'value' => '#000000',
			),

			array(
				'label' => esc_html__( 'Overlay Opacity (in percent)', 'bronze' ),
				'id'    => 'hero_overlay_opacity',
				'desc'  => esc_html__( 'Adapt the header overlay opacity if needed', 'bronze' ),
				'type'  => 'text',
				'value' => 40,
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['header_settings']['options']['hero_layout']['description'] = sprintf(
			bronze_kses(
				__( 'The header can be overwritten by a <a href="%s" target="_blank">content block</a> on all pages or on specific pages. See the customizer "Layout" tab or the page options below your text editor.', 'bronze' )
			),
			'http://wlfthm.es/content-blocks'
		);
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_header_settings_mods' );
