<?php
/**
 * Bronze Page Builder
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * WPBAkery Page Builder Extension plugin mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_wvc_mods( $mods ) {

	if ( class_exists( 'Wolf_Visual_Composer' ) ) {
		$mods['blog']['options']['newsletter'] = array(
			'id'          => 'newsletter_form_single_blog_post',
			'label'       => esc_html__( 'Add newsletter form below single post', 'bronze' ),
			'type'        => 'checkbox',
			'description' => esc_html__( 'Display a newsletter sign up form at the bottom of each blog post.', 'bronze' ),
		);

	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_wvc_mods' );
