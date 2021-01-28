<?php
/**
 * Bronze background_image
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Backgorund image mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_background_image_mods( $mods ) {

	/* Move background image setting here and rename the seciton title */
	$mods['background_image'] = array(
		'icon'    => 'format-image',
		'id'      => 'background_image',
		'title'   => esc_html__( 'Background Image', 'bronze' ),
		'options' => array(),
	);

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_background_image_mods' );
