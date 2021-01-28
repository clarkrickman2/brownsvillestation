<?php
/**
 * Bronze plugin extend functions
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'bronze_set_albums_template_url' ) ) {
	/**
	 * Set albums template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function bronze_set_albums_template_url( $template_url ) {

		return bronze_get_template_url() . '/albums/';

	}
	add_filter( 'wolf_albums_url', 'bronze_set_albums_template_url' );
}

if ( ! function_exists( 'bronze_set_artists_template_url' ) ) {
	/**
	 * Set artists template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function bronze_set_artists_template_url( $template_url ) {

		return bronze_get_template_dirname() . '/artists/';
	}
	add_filter( 'wolf_artists_template_folder', 'bronze_set_artists_template_url' );
}

if ( ! function_exists( 'bronze_set_discography_template_url' ) ) {
	/**
	 * Set discography template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function bronze_set_discography_template_url( $template_url ) {

		return bronze_get_template_url() . '/discography/';
	}
	add_filter( 'wolf_discography_template_url', 'bronze_set_discography_template_url' );
	add_filter( 'wolf_discography_url', 'bronze_set_discography_template_url' );
}

if ( ! function_exists( 'bronze_set_events_template_url' ) ) {
	/**
	 * Set events template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function bronze_set_events_template_url( $template_url ) {

		return bronze_get_template_url() . '/events/';
	}
	add_filter( 'wolf_events_template_url', 'bronze_set_events_template_url' );
}

if ( ! function_exists( 'bronze_set_portfolio_template_url' ) ) {
	/**
	 * Set portfolio template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function bronze_set_portfolio_template_url( $template_url ) {

		return bronze_get_template_url() . '/portfolio/';
	}
	add_filter( 'wolf_portfolio_template_url', 'bronze_set_portfolio_template_url' );
}

if ( ! function_exists( 'bronze_set_videos_template_url' ) ) {
	/**
	 * Set videos template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function bronze_set_videos_template_url( $template_url ) {

		return bronze_get_template_url() . '/videos/';
	}
	add_filter( 'wolf_videos_template_url', 'bronze_set_videos_template_url' );
}

/**
 * Get single work layout
 *
 * @return string $layout
 */
function bronze_get_single_work_layout() {

	$single_work_layout = ( get_post_meta( get_the_ID(), '_single_work_layout', true ) ) ? get_post_meta( get_the_ID(), '_single_work_layout', true ) : 'small-width';

	if ( is_singular( 'work' ) ) {
		return apply_filters( 'bronze_single_work_layout', $single_work_layout );
	}
}

/**
 * Filter add to wishlist button class
 *
 * @return string $layout
 */
function bronze_filter_addo_to_wishlist_button_class( $class ) {

	$class = str_replace( 'button', '', $class );

	return $class;
}
add_filter( 'wolf_add_to_wishlist_class', 'bronze_filter_addo_to_wishlist_button_class' );

/**
 * Set Wolf Gram widget lightbox
 *
 * @return string $lightbox
 */
function bronze_set_wolf_gram_lightbox( $lightbox ) {

	return 'fancybox';
}
add_filter( 'wolf_gram_lightbox', 'bronze_set_wolf_gram_lightbox' );

/**
 * Filter ticket link CSS class
 *
 * @param string $class
 * @param string $class
 */
function bronze_filter_ticket_link_css_class( $class ) {
	return 'button ticket-button';
}
add_filter( 'we_ticket_link_class', 'bronze_filter_ticket_link_css_class' );
