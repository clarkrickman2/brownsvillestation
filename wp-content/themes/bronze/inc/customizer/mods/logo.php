<?php
/**
 * Bronze customizer logo mods
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Logo mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_logo_mods( $mods ) {

	$mods['logo'] = array(
		'id'          => 'logo',
		'title'       => esc_html__( 'Logo', 'bronze' ),
		'icon'        => 'visibility',
		'description' => sprintf(
			wp_kses(
				__( 'Your theme recommends a logo size of <strong>%1$d &times; %2$d</strong> pixels and set the maximum width to <strong>%3$d</strong> below.', 'bronze' ),
				array(
					'strong' => array(),
				)
			),
			360,
			160,
			180
		),
		'options'     => array(

			'logo_dark'       => array(
				'id'    => 'logo_dark',
				'label' => esc_html__( 'Logo - Dark Version', 'bronze' ),
				'type'  => 'image',
			),

			'logo_light'      => array(
				'id'    => 'logo_light',
				'label' => esc_html__( 'Logo - Light Version', 'bronze' ),
				'type'  => 'image',
			),

			'logo_max_width'  => array(
				'id'    => 'logo_max_width',
				'label' => esc_html__( 'Logo Max Width (don\'t ommit px )', 'bronze' ),
				'type'  => 'text',
			),

			'logo_visibility' => array(
				'id'        => 'logo_visibility',
				'label'     => esc_html__( 'Visibility', 'bronze' ),
				'type'      => 'select',
				'choices'   => array(
					'always'      => esc_html__( 'Always', 'bronze' ),
					'sticky_menu' => esc_html__( 'When menu is sticky only', 'bronze' ),
				),
				'transport' => 'postMessage',
			),
		),
	);

	return $mods;

}
add_filter( 'bronze_customizer_mods', 'bronze_set_logo_mods' );
