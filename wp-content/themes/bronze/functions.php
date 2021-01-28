<?php
/**s
 * Bronze functions and definitions
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package    WordPress
 * @subpackage Bronze
 * @version    1.1.0
 */

defined( 'ABSPATH' ) || exit;
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
/**
 * Sets up theme defaults and registers support for various WordPress features using the BRONZE function
 *
 * @see inc/framework.php
 */
function bronze_setup_config() {
	/**
	 *  Require the wolf themes framework core file
	 */
	include_once get_template_directory() . '/inc/framework.php';

	/**
	 * Set theme main settings
	 *
	 * We this array to configure the main theme settings
	 */
	$bronze_settings = array(

		/* Menus */
		'menus'       => array(
			'primary'   => esc_html__( 'Primary Menu', 'bronze' ),
			'secondary' => esc_html__( 'Secondary Menu', 'bronze' ),
			'mobile'    => esc_html__( 'Mobile Menu (optional)', 'bronze' ),
		),

		/**
		 *  We define wordpress thumbnail sizes that we will use in our design
		 */
		'image_sizes' => array(

			/**
			 * Create custom image sizes if the Wolf WPBakery Page Builder extension plugin is not installed
			 * We will use the same image size names to avoid duplicated image sizes in the case the plugin is active
			 */
			'bronze-photo'         => array( 500, 500, false ),
			'bronze-metro'         => array( 550, 999, false ),
			'bronze-masonry'       => array( 500, 2000, false ),
			'bronze-masonry-small' => array( 400, 400, false ),
			'bronze-XL'            => array( 1920, 3000, false ),
		),
	);

	BRONZE( $bronze_settings ); // let's go.
}
bronze_setup_config();

