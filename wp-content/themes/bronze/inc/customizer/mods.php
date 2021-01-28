<?php
/**
 * Bronze customizer mods
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set default mods from config file
 */
function bronze_set_default_mods() {

	if ( ! is_user_logged_in() || ! current_user_can( 'switch_themes' ) ) {
		return;
	}

	$theme_slug = bronze_get_theme_slug();

	/* Stop if mods have already been set */
	if ( get_option( $theme_slug . '_customizer_init' ) ) {
		return;
	}

	$file = get_theme_file_path( 'config/customizer.dat' );

	if ( is_file( get_parent_theme_file_path( '/THEMES/' . $theme_slug . '/config/customizer.dat' ) ) ) {
		$file = get_parent_theme_file_path( '/THEMES/' . $theme_slug . '/config/customizer.dat' );
	}

	$file_content = bronze_file_get_contents( $file );

	$theme_slug        = ( is_child_theme() ) ? bronze_get_theme_slug() . '_child' : bronze_get_theme_slug();
	$theme_parent_slug = bronze_get_theme_slug();

	$mods = array();

	/* If all good proceed */
	if ( $file_content && false !== ( $data = @unserialize( $file_content ) ) ) { // phpcs:ignore

		$mods = $data['mods'];

	} elseif ( array() !== apply_filters( 'bronze_default_mods_fallback_array', array() ) ) {

		/* Default mods in case the file import doesn't work */
		$mods = apply_filters( 'bronze_default_mods_fallback_array', array() );
	}

	$unset_mods = array(
		'0',
		'nav_menu_locations',
		'logo_dark',
		'logo_light',
		'logo_svg',
		'custom_css',
		'options',
		'wp_css',
		'header_image_data',

	);

	foreach ( $unset_mods as $m ) {
		if ( isset( $mods[ $m ] ) ) {
			unset( $mods[ $m ] );
		}
	}

	$mods = apply_filters( 'bronze_default_mods', $mods ); // filter default mods if needed.

	foreach ( $mods as $key => $value ) {

		/* remove external URL to avoid hot linking */
		if ( bronze_is_external_url( $value ) ) {
			$mods[ $key ] = '';
		}

		set_theme_mod( $key, $value );
	}

	/* Add option to flag that the default mods have been set */
	add_option( $theme_slug . '_customizer_init', true );
}
add_action( 'init', 'bronze_set_default_mods' );

/**
 * Initialize customizer mods
 */
function bronze_customizer_get_mods() {
	return apply_filters( 'bronze_customizer_mods', array() );
}

/**
 * Initialize customizer mods
 */
function bronze_customizer_get_mod_files() {
	$mod_files = array(
		'logo',
		'colors',
		'navigation',
		'socials',
		'fonts',
		'header',
		'header-image',
		'blog',
		'shop',
		'background-image',
		'footer',
		'footer-bg',
	);
	return apply_filters( 'bronze_customizer_mod_files', $mod_files );
}

/**
 * Include customizer mods files
 */
function bronze_include_mod_files() {

	$mod_files = bronze_customizer_get_mod_files();

	foreach ( $mod_files as $filename ) {
		bronze_include( 'inc/customizer/mods/' . sanitize_file_name( $filename ) . '.php' );
	}

	new Bronze_Customizer_Library( bronze_customizer_get_mods() );
}
bronze_include_mod_files();

/**
 * Add selective refresh functionality to certain settings
 *
 * @param object $wp_customize the wp customize object.
 * @return void
 */
function bronze_register_settings_partials( $wp_customize ) {

	/* Abort if selective refresh is not available. */
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->get_setting( 'logo_svg' )->transport     = 'postMessage';
	$wp_customize->get_setting( 'logo_dark' )->transport    = 'postMessage';
	$wp_customize->get_setting( 'logo_light' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'logo_svg',
		array(
			'selector'        => '.logo-container',
			'settings'        => array( 'logo_svg', 'logo_dark', 'logo_light' ),
			'render_callback' => 'bronze_logo',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'header_image',
		array(
			'selector'        => '.post-header-container',
			'settings'        => array( 'header_image' ),
			'render_callback' => 'bronze_output_hero_background',
		)
	);
}

/**
 * Removes the core 'Menus' panel from the Customizer.
 *
 * As we have added a lot of menu item options with a Walker class we don't want the menu to be save and reset all the options
 *
 * @link https://core.trac.wordpress.org/ticket/33411
 *
 * @param object $wp_customize the wp customize object.
 * @return void
 */
function bronze_remove_nav_menus_panel( $wp_customize ) {

	$wp_customize->get_panel( 'nav_menus' )->active_callback = '__return_false';
}
add_action( 'customize_register', 'bronze_remove_nav_menus_panel', 1000 );
