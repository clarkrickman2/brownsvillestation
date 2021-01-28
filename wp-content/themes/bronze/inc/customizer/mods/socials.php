<?php
/**
 * Bronze Socials
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Social services mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_socials_mods( $mods ) {

	if ( function_exists( 'wvc_get_socials' ) ) {

		$socials = wvc_get_socials();

		$mods['socials'] = array(
			'id'      => 'socials',
			'title'   => esc_html__( 'Social Networks', 'bronze' ),
			'icon'    => 'share',
			'options' => array(),
		);

		foreach ( $socials as $social ) {
			$mods['socials']['options'][ $social ] = array(
				'id'    => $social,
				'label' => ucfirst( $social ),
				'type'  => 'text',
			);
		}
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_socials_mods' );
