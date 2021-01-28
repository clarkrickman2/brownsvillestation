<?php
/**
 * The main navigation for mobile
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( bronze_do_onepage_menu() ) {

	echo bronze_one_page_menu( 'mobile' );

} else {

	if ( has_nav_menu( 'mobile' ) ) {

		wp_nav_menu( bronze_get_menu_args( 'mobile', 'mobile' ) );

	} else {
		wp_nav_menu( bronze_get_menu_args( 'primary', 'mobile' ) );
	}
}