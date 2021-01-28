<?php
/**
 * Bronze extra
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Extra mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_extra_mods( $mods ) {

	$mods['extra'] = array(

		'id'      => 'extra',
		'title'   => esc_html__( 'Extra', 'bronze' ),
		'icon'    => 'plus-alt',
		'options' => array(
			array(
				'label' => esc_html__( 'Enable Scroll Animations on Mobile (not recommended)', 'bronze' ),
				'id'    => 'enable_mobile_animations',
				'type'  => 'checkbox',
			),
			array(
				'label' => esc_html__( 'Enable Parallax on Mobile (not recommended)', 'bronze' ),
				'id'    => 'enable_mobile_parallax',
				'type'  => 'checkbox',
			),
		),
	);
	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_extra_mods' );
