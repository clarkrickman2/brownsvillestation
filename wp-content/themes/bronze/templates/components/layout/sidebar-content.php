<?php
/**
 * Displays sidebar content
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( bronze_is_woocommerce_page() ) {

	dynamic_sidebar( 'sidebar-shop' );

} else {

	if ( function_exists( 'wolf_sidebar' ) ) {

		wolf_sidebar();

	} else {

		dynamic_sidebar( 'sidebar-page' );
	}
}