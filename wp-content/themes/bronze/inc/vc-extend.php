<?php
/**
 * WPBakery Page Builder Extension theme related functions
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

/**
 * Set WPBPB as theme
 */
function bronze_set_as_theme() {
	vc_set_as_theme();
}
add_action( 'vc_before_init', 'bronze_set_as_theme' );

/**
 * Add theme accent color to shared colors
 */
function bronze_wvc_add_accent_color_option( $colors ) {

	$colors = array( esc_html__( 'Theme Accent Color', 'bronze' ) => 'accent' ) + $colors;

	return $colors;
}
add_filter( 'wvc_shared_colors', 'bronze_wvc_add_accent_color_option', 14 );

/**
 * Add row css class
 */
function bronze_wvc_add_row_css_class( $classes ) {

	$classes[] = 'section';

	return $classes;
}
add_filter( 'wvc_row_css_class', 'bronze_wvc_add_row_css_class' );

/**
 * Set VC default post types
 */
function bronze_vc_default_post_types() {

	vc_set_default_editor_post_types( bronze_get_default_post_types() );
}
add_action( 'vc_after_init', 'bronze_vc_default_post_types' );

/**
 * Set WVC default post types
 *
 * @param array $post_types The post types array.
 * @return string
 */
function bronze_wvc_default_post_types( $post_types ) {
	$default_post_types = bronze_get_default_post_types();

	return wp_parse_args( $post_types, $default_post_types );
}
add_filter( 'wvc_default_post_types', 'bronze_wvc_default_post_types' );

/**
 * Filter WVC theme accent color
 *
 * @param string $color The color to filter.
 * @return string
 */
function bronze_set_wvc_theme_accent_color( $color ) {
	return bronze_get_inherit_mod( 'accent_color' );
}
add_filter( 'wvc_theme_accent_color', 'bronze_set_wvc_theme_accent_color' );

/**
 * Add post types to post module
 *
 * @param array $post_types The post types array.
 * @return array
 */
function bronze_set_wvc_post_types( $post_types ) {

	if ( class_exists( 'Wolf_Portfolio' ) ) {
		$post_types[ esc_html__( 'Work', 'bronze' ) ] = 'work';
	}

	if ( class_exists( 'Wolf_Albums' ) ) {
		$post_types[ esc_html__( 'Gallery', 'bronze' ) ] = 'gallery';
	}

	if ( class_exists( 'Wolf_Discography' ) ) {
		$post_types[ esc_html__( 'Release', 'bronze' ) ] = 'release';
	}

	if ( class_exists( 'Wolf_Videos' ) ) {
		$post_types[ esc_html__( 'Videos', 'bronze' ) ] = 'videos';
	}

	if ( class_exists( 'Wolf_Events' ) ) {
		$post_types[ esc_html__( 'Events', 'bronze' ) ] = 'events';
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$post_types[ esc_html__( 'Product', 'bronze' ) ] = 'product';
	}

	return $post_types;
}
add_filter( 'bronze_available_post_types', 'bronze_set_wvc_post_types' );

/**
 * Add theme templates to WPBPB from XML feed
 *
 * @param array $default_templates The default templates.
 * @return array $default_templates
 */
function bronze_add_vc_templates( $default_templates ) {

	$templates = array();

	$cache_duration = 60 * 60 * 1; // 1 hour
	$cache_duration = 1;

	$trans_key = '_vc_templates_' . bronze_get_theme_slug();

	$xml = null;

	$theme_slug = bronze_get_theme_slug();

	$template_xml_root = 'https://updates.wolfthemes.com/' . $theme_slug;
	$template_xml_url  = $template_xml_root . '/vc-templates/vc-templates.xml';

	/* Get XML feed */
	if ( false === ( $cached_xml = get_transient( $trans_key ) ) ) {

		$response = wp_remote_get( $template_xml_url, array( 'timeout' => 10 ) );

		if ( ! is_wp_error( $response ) && is_array( $response ) ) {
			$xml = wp_remote_retrieve_body( $response ); // use the content.
		}

		if ( $xml ) {
			set_transient( $trans_key, $xml, $cache_duration );
		}
	} else {
		$xml = $cached_xml;
	}

	if ( $xml ) {

		/* Parse XML */
		$xml_templates = new SimpleXMLElement( $xml );
		$type_slug     = 'default_templates';

		/* Loop */
		foreach ( $xml_templates as $xml_template ) {

			$slug         = ( $xml_template && isset( $xml_template->slug ) ) ? (string) $xml_template->slug : '';
			$name         = ( $xml_template && isset( $xml_template->name ) ) ? (string) $xml_template->name : '';
			$custom_class = ( $xml_template && isset( $xml_template->custom_class ) ) ? (string) $xml_template->custom_class : '';
			$content      = ( $xml_template && isset( $xml_template->content ) ) ? (string) $xml_template->content : '';

			$template         = array();
			$template['name'] = $name;
			$template['custom_class'] = $custom_class;
			$template['content']      = $content;

			array_unshift( $default_templates, $template );
		}
	}

	return $default_templates;
}
