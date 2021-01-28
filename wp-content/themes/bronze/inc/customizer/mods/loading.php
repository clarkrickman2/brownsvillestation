<?php
/**
 * Bronze loading
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Loading animation mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_loading_mods( $mods ) {

	$mods['loading'] = array(

		'id'      => 'loading',
		'title'   => esc_html__( 'Loading', 'bronze' ),
		'icon'    => 'update',
		'options' => array(

			array(
				'label'   => esc_html__( 'Loading Animation Type', 'bronze' ),
				'id'      => 'loading_animation_type',
				'type'    => 'select',
				'choices' => array(
					'spinner' => esc_html__( 'Spinner', 'bronze' ),
					'none'    => esc_html__( 'None', 'bronze' ),
				),
			),
		),
	);
	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_loading_mods' );
