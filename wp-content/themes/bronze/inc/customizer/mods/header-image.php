<?php
/**
 * Bronze header_image
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Header image mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_header_image_mods( $mods ) {

	/* Move header image setting here and rename the section title */
	$mods['header_image'] = array(
		'id'      => 'header_image',
		'title'   => esc_html__( 'Header Image', 'bronze' ),
		'icon'    => 'format-image',
		'options' => array(),
	);

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_header_image_mods' );
