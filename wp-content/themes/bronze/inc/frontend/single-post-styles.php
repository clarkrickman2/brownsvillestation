<?php
/**
 * Bronze Single post styles
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get background CSS
 *
 * @param string $selector
 * @param string $meta_name
 * @return string
 */
function bronze_post_meta_get_background_css( $selector, $meta_name ) {

	$css = '';
	if ( function_exists( 'is_product_category' ) && is_product_category() && get_term_meta( get_queried_object()->term_id, 'thumbnail_id', true ) ) {

		$thumbnail_id = get_term_meta( get_queried_object()->term_id, 'thumbnail_id', true );
		$url = wp_get_attachment_image_src( $thumbnail_id, 'bronze-XL' );
		$css = "$selector {background:url($url) no-repeat center center;}
			$selector {
				-webkit-background-size: 100%;
				-o-background-size: 100%;
				-moz-background-size: 100%;
				background-size: 100%;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
		";
		$css .= ".header-overlay{background-color:#000; opacity:.4}";

	} elseif ( 'image' === get_post_meta( bronze_get_inherit_post_id(), '_post_bg_type', true ) ) {

		$custom_css = get_post_meta( bronze_get_inherit_post_id(), '_post_css', true );

		if ( $custom_css ) {
			$css .= $custom_css;
		}
	}

	if ( ! SCRIPT_DEBUG ) {
		$css = bronze_compact_css( $css );
	}

	return $css;
}

/**
 * Output the post CSS
 */
function bronze_output_post_header_css() {

	if ( is_404() ) {
		return;
	}

	$css =  '/* Single post styles */';

	if ( 'none' != bronze_get_header_type() ) {
		$css .= "\n";
	    	$css .= bronze_post_meta_get_background_css( '#hero', '_post_bg' );
	}
	wp_add_inline_style( 'bronze-single-post-style', $css );
}
add_action( 'wp_enqueue_scripts', 'bronze_output_post_header_css', 14 );
