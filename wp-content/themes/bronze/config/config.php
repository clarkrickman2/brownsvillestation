<?php
/**
 * Theme configuration file
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Default Google fonts option
 */
function bronze_set_default_google_font() {
	return 'Roboto:400,700,900|Lato:400,700,900|Open+Sans:400,700,900|Raleway:400,500,600,700,900|Oswald|Roboto+Mono:400,700|Playfair+Display:400,700';
}
add_filter( 'bronze_default_google_fonts', 'bronze_set_default_google_font' );

/**
 * Set color scheme
 *
 * Add csutom color scheme
 *
 * @param array $color_scheme
 * @param array $color_scheme
 */
function bronze_set_color_schemes( $color_scheme ) {

	//unset( $color_scheme['default'] );

	$color_scheme['light'] = array(
		'label'  => esc_html__( 'Light', 'bronze' ),
		'colors' => array(
			'#000000', // body_bg
			'#fff', // page_bg
			'#f7f7f7', // submenu_background_color
			'#0d0d0d', // submenu_font_color
			'#c74735', // '#c3ac6d', // accent
			'#444444', // main_text_color
			'#4c4c4c', // secondary_text_color
			'#0d0d0d', // strong_text_color
			'#999289', // secondary accent
		)
	);

	$color_scheme['dark'] = array(
		'label'  => esc_html__( 'Dark', 'bronze' ),
		'colors' => array(
			'#000000', // body_bg
			'#000000', // page_bg
			'#000000', // submenu_background_color
			'#ffffff', // submenu_font_color
			'#c74735', // accent
			'#f4f4f4', // main_text_color
			'#ffffff', // secondary_text_color
			'#ffffff', // strong_text_color
			'#999289', // secondary accent
		)
	);

	return $color_scheme;
}
add_filter( 'bronze_color_schemes', 'bronze_set_color_schemes' );

/**
 * Add additional theme support
 */
function bronze_additional_theme_support() {

	/**
	 * Enable WooCommerce support
	 */
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'bronze_additional_theme_support' );

/**
 * Set default WordPress option
 */
function bronze_set_default_wp_options() {

	update_option( 'thumbnail_size_w', 260 );
	update_option( 'thumbnail_size_h', 260 );
	update_option( 'thumbnail_crop', 1 );

	update_option( 'medium_size_w', 600 );
	update_option( 'medium_size_h', 600 );

	update_option( 'large_size_w', 1200 );
	update_option( 'large_size_h', 1024 );

	update_option( 'thread_comments_depth', 2 );
}
add_action( 'bronze_default_wp_options_init', 'bronze_set_default_wp_options' );

/**
 * Set mod files to include
 */
function bronze_customizer_set_mod_files( $mod_files ) {
	$mod_files = array(
		'loading',
		'logo',
		'layout',
		'colors',
		'navigation',
		'socials',
		'fonts',
		'header',
		'header-image',
		'blog',
		'events',
		'discography',
		'videos',
		'shop',
		'background-image',
		'footer',
		'footer-bg',
		'wvc',
		'extra',
	);

	return $mod_files;
}
add_filter( 'bronze_customizer_mod_files', 'bronze_customizer_set_mod_files' );

add_filter( 'bronze_default_mods_fallback_array', function( $mods ) {
	return array(
		'color_scheme' => 'light',
            'body_background_color' => '#000000',
            'page_background_color' => '#ffffff',
            'submenu_background_color' => '#ffffff',
            'submenu_font_color' => '#0d0d0d',
            'accent_color' => '#93816b',
            'main_text_color' => '#444444',
            'strong_text_color' => '#0d0d0d',
            'secondary_accent_color' => '#a766e8',
            'body_font_name' => 'Open Sans',
            'menu_font_name' => 'Lato',
            'menu_font_weight' => '700',
            'menu_font_transform' => 'uppercase',
            'submenu_font_transform' => 'uppercase',
            'submenu_font_weight' => '700',
            'menu_font_letter_spacing' => '4',
            'submenu_font_letter_spacing' => '0',
            'heading_font_name' => 'Roboto Mono',
            'heading_font_weight' => '700',
            'heading_font_transform' => 'none',
            'heading_font_letter_spacing' => '0',
            'hero_layout' => 'standard',
            'hero_background_effect' => 'parallax',
            'hero_overlay_color' => '#000000',
            'hero_overlay_opacity' => '30',
            'header_image' => 'remove-header',
            'menu_width' => 'wide',
            'menu_style' => 'solid',
            'mega_menu_width' => 'fullwidth',
            'menu_breakpoint' => '1350',
            'menu_sticky_type' => 'soft',
            'menu_cta_content_type' => 'none',
            'menu_socials' => 'facebook,twitter,instagram',
            'post_pagination' => 'load_more',
            'post_excerpt_type' => 'auto',
            'side_panel_position' => 'right',
            'hero_font_tone' => 'light',
            'product_layout' => 'sidebar-right',
            'product_single_layout' => 'standard',
            'product_columns' => '2',
            'product_item_animation' => 'none',
            'related_products_carousel' => '1',
            'cart_menu_item' => '1',
            'products_per_page' => '9',
            'wishlist_menu_item' => '1',
            'product_skin' => 'light',
            'loading_animation_type' => 'overlay',
            'logo_max_width' => '250px',
            'logo_visibility' => 'always',
	);
} );