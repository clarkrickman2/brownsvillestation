<?php
/**
 * Bronze footer_bg
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer background mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_footer_bg_mods( $mods ) {

	$mods['footer_bg'] = array(
		'id'         => 'footer_bg',
		'label'      => esc_html__( 'Footer Background', 'bronze' ),
		'background' => true,
		'font_color' => true,
		'icon'       => 'format-image',
	);

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_footer_bg_mods' );
