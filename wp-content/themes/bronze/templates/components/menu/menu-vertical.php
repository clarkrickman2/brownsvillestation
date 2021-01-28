<?php
/**
 * The main navigation for vertical menus
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( bronze_do_onepage_menu() ) {

	echo bronze_one_page_menu();

} else {

	if ( has_nav_menu( 'vertical' ) ) {

		wp_nav_menu( bronze_get_menu_args( 'vertical', 'vertical' ) );

	} else {
		wp_nav_menu( bronze_get_menu_args( 'primary', 'vertical' ) );
	}
}