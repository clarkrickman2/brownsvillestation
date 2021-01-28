<?php
/**
 * The main navigation for desktop
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( bronze_do_onepage_menu() ) {

	echo bronze_one_page_menu();

} else {
	wp_nav_menu( bronze_get_menu_args() );
}
