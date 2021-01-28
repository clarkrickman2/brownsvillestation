<?php
/**
 * Bronze about page
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Bronze_Admin_About_Page' ) ) {
	/**
	 * About Page Class
	 */
	class Bronze_Admin_About_Page {

		var $theme_name;
		var $theme_version;
		var $theme_slug;
		var $user_capability;

		/**
		 * __construct function.
		 */
		public function __construct() {

			$this->theme_name      = bronze_get_theme_name();
			$this->theme_version   = bronze_get_theme_version();
			$this->theme_slug      = bronze_get_theme_slug();
			$this->user_capability = 'activate_plugins';

			$this->dismiss_cookie();

			add_action( 'admin_menu', array( $this, 'admin_menus' ) );
			add_action( 'admin_init', array( $this, 'welcome' ) );
		}

		/**
		 * Add admin menus/screens
		 */
		public function admin_menus() {

			add_theme_page( esc_html__( 'About the Theme', 'bronze' ), esc_html__( 'About the Theme', 'bronze' ), 'switch_themes', $this->theme_slug . '-about', array( $this, 'about_screen' ) );
		}

		/**
		 * Admin notice dismiss
		 *
		 * Set cookie from "hide permanently" admin notice links if JS was not available
		 *
		 * @access private
		 */
		private function dismiss_cookie() {
			if ( isset( $_GET['page'] ) && bronze_get_theme_slug() . '-about' === esc_attr( $_GET['page'] ) && isset( $_GET['dismiss'] ) ) {
				$cookie_id = esc_attr( $_GET['dismiss'] );

				setcookie( $cookie_id, 'hide', time() + 2 * YEAR_IN_SECONDS, '/' );
			}
		}

		/**
		 * Into text/links shown on all about pages.
		 *
		 * @access private
		 */
		private function intro() {
			if ( isset( $_GET['bronze-activated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				update_user_meta( get_current_user_id(), 'show_welcome_panel', true );
			}

			?>
			<h1><?php printf( esc_html__( 'Welcome to %1$s %2$s', 'bronze' ), esc_attr( $this->theme_name ), esc_attr( $this->theme_version ) ); ?></h1>

			<div class="wp-badge bronze-about-page-logo">
				<?php printf( esc_html__( 'Version %s', 'bronze' ), esc_attr( $this->theme_version ) ); ?>
			</div>
			<?php
		}

		/**
		 * Output the about screen.
		 */
		public function about_screen() {
			?>
			<div class="wrap bronze-about-page-wrap">
				<?php $this->intro(); ?>
				<?php $this->actions(); ?>
				<?php $this->tabs(); ?>
			</div>
			<?php
		}

		/**
		 * Check if TGM plugin activation is completed
		 *
		 * As there isn't any filter or hook to know if TGMPA plugin installation has been completed
		 * We check if its menu exists as it is disabled when plugin is completed
		 */
		private function is_tgmpa_in_da_place() {
			global $submenu;

			$tgmpa_menu_slug = 'tgmpa-install-plugins'; // must be the same as in the plugin config/plugins.php file.

			if ( ! get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_tgmpa' ) ) { // if user didn't dismissed the notice.
				if ( isset( $submenu['themes.php'] ) ) {
					$theme_menu_items = $submenu['themes.php'];

					foreach ( $theme_menu_items as $item ) {

						if ( isset( $item[2] ) && $tgmpa_menu_slug == $item[2] ) {
							return true;
							break;
						}
					}
				}
			}
		}

		/**
		 * Output action buttons
		 */
		public function actions() {
			?>
			<p class="bronze-about-actions">
				<?php if ( $this->is_tgmpa_in_da_place() ) : ?>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-primary">
						<span class="dashicons dashicons-admin-plugins"></span>
						<?php esc_html_e( 'Install Recommended Plugins', 'bronze' ); ?>
					</a>
				<?php endif; ?>
				<?php if ( bronze_get_theme_changelog() ) : ?>
					<a target="_blank" href="<?php echo esc_url( 'https://docs.wolfthemes.com/documentation/theme/' . bronze_get_theme_slug() ); ?>" class="button">
						<span class="dashicons dashicons-sos"></span>
						<?php esc_html_e( 'Documentation', 'bronze' ); ?>
					</a>
				<?php endif; ?>
			</p>
			<?php
		}

		/**
		 * Tabs
		 */
		private function tabs() {
			?>
			<div id="bronze-welcome-tabs">
				<h2 class="nav-tab-wrapper">
					<?php if ( bronze_get_theme_changelog() || current_user_can( $this->user_capability ) ) : ?>
						<div class="tabs" id="tabs1">

							<?php
								/**
								 * More tabs
								 */
								do_action( 'bronze_before_about_tabs' );
							?>

							<a href="#faq" class="nav-tab"><?php esc_html_e( 'FAQ', 'bronze' ); ?></a>
							<?php if ( current_user_can( $this->user_capability ) ) : ?>
								<a href="#system-status" class="nav-tab"><?php esc_html_e( 'System Status', 'bronze' ); ?></a>

								<?php if ( bronze_get_theme_changelog() ) : ?>
								<a href="#changelog" class="nav-tab"><?php esc_html_e( 'Changelog', 'bronze' ); ?></a>
								<?php endif; ?>
							<?php endif; ?>

							<?php
								/**
								 * More tabs
								 */
								do_action( 'bronze_after_about_tabs' );
							?>

							<?php
								/**
								 * WVC License tab
								 */
								do_action( 'wvc_license_tab' );

								/**
								 * Extension License tab
								 */
								do_action( 'wolf_core_license_tab' );
							?>
						</div>
					<?php endif; ?>
				</h2>

				<div class="content">

					<?php
						/**
						 * More tabs
						 */
						do_action( 'bronze_before_about_tabs_content' );
					?>

					<div id="faq" class="bronze-options-panel">
						<?php $this->faq(); ?>
					</div><!-- #system-status -->

					<?php if ( current_user_can( $this->user_capability ) ) : ?>
						<div id="system-status" class="bronze-options-panel">
							<?php $this->system_status(); ?>
						</div><!-- #system-status -->
					<?php endif; ?>

					<?php if ( bronze_get_theme_changelog() ) : ?>
						<div id="changelog" class="bronze-options-panel">
							<?php $this->changelog(); ?>
						</div><!-- #changelog -->
					<?php endif; ?>

					<?php
						/**
						 * More tabs
						 */
						do_action( 'bronze_after_about_tabs_content' );
					?>

					<?php
						/**
						 * WVC License tab content
						 */
						do_action( 'wvc_license_tab_content' );

						/**
						 * Extension License tab
						 */
						do_action( 'wolf_core_license_tab_content' );
					?>
				</div>
			</div><!-- #bronze-about-tabs -->
			<?php
		}

		/**
		 * FAQ
		 */
		public function faq() {
			?>
			<div class="faq-text bronze-faq-text">
				<div class="row bronze-about-columns">
					<div class="col col-4">
						<h4><?php esc_html_e( 'Getting Started', 'bronze' ); ?></h4>
						<ul>
							<li><a href="https://wolfthemes.ticksy.com/article/11652/" target="_blank"><?php esc_html_e( 'Before Getting Started', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11655/" target="_blank"><?php esc_html_e( 'Install Recommended Plugins', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11656/" target="_blank"><?php esc_html_e( 'Import Demo Data', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/13268/" target="_blank"><?php esc_html_e( 'Activate the Page Builder Extension', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.com/wordpress-theme-installation-customization-services/?o=faq" target="_blank"><?php esc_html_e( 'Installation & Customization Services', 'bronze' ); ?></a></li>
						</ul>
					</div>
					<div class="col col-4">
						<h4><?php esc_html_e( 'Troubleshooting', 'bronze' ); ?></h4>
						<ul>
							<li><a href="https://wolfthemes.ticksy.com/article/11682/" target="_blank"><?php esc_html_e( '"Wrong theme" error message', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11682/" target="_blank"><?php esc_html_e( 'Stylesheet is missing', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11680/" target="_blank"><?php esc_html_e( 'Issue Importing the Demo', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11681/" target="_blank"><?php esc_html_e( '404 error page', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11678/" target="_blank"><?php esc_html_e( 'Other FAQ\'s', 'bronze' ); ?></a></li>
						</ul>
					</div>
					<div class="col col-4">
						<h4><?php esc_html_e( 'Help', 'bronze' ); ?></h4>
						<ul>
							<li><a href="https://docs.wolfthemes.com/documentation/theme/<?php echo esc_attr( $this->theme_slug ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11671/" target="_blank"><?php esc_html_e( 'Update WPBakery Page Builder', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/12629/" target="_blank"><?php esc_html_e( 'Bundled Plugin Activation', 'bronze' ); ?></a></li>
						</ul>
					</div>
				</div>
				<div class="row bronze-about-columns">
					<div class="col col-4">
						<h4><?php esc_html_e( 'How To\'s', 'bronze' ); ?></h4>
						<ul>
							<li><a href="https://wolfthemes.ticksy.com/article/12792" target="_blank"><?php esc_html_e( 'Use Content Blocks', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/13469/" target="_blank"><?php esc_html_e( 'Increase Your Loading Speed', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11669/" target="_blank"><?php esc_html_e( 'Translate your Theme', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11664/" target="_blank"><?php esc_html_e( '"Coming Soon" or "Maintenance" Mode', 'bronze' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11975/" target="_blank"><?php esc_html_e( 'Create a custom 404 Error Page', 'bronze' ); ?></a></li>
						</ul>
					</div>
					<div class="col col-4">
						<h4>
						<?php
						printf(
							/* translators: %s: theme name */
							bronze_kses( __( 'Need more help using %s?', 'bronze' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
							esc_attr( $this->theme_name )
						);
						?>
						</h4>
						<p>
							<?php
								printf(
									/* translators: 1: forum KB link, 2: forum link */
									bronze_kses( __( 'We will find our complete knowledge base here: <a href="%1$s" target="_blank">%2$s</a>.', 'bronze' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
									'https://wolfthemes.ticksy.com/articles/',
									'https://wolfthemes.com/help/'
								);
							?>
						</p>
					</div>
					<div class="col col-4"></div>
				</div>

			</div>
			<?php
		}

		/**
		 * System status
		 *
		 * Display system status
		 */
		private function system_status() {

			$vars = bronze_get_minimum_required_server_vars();
			?>
			<div id="bronze-system-status">
				<?php if ( ! bronze_get_theme_changelog() ) : ?>
					<h3><?php esc_html_e( 'System Status', 'bronze' ); ?></h3>
				<?php endif; ?>
				<p>
					<?php esc_html_e( 'Check that all the requirements below are fulfiled and labeled in green.', 'bronze' ); ?>
				</p>

				<h4><?php esc_html_e( 'WordPress Environment', 'bronze' ); ?></h4>

				<table>
			<?php
			$xml_latest   = '5.5';
			$xml_requires = $vars['REQUIRED_WP_VERSION'];

			$xml = bronze_get_theme_changelog();

			if ( $xml ) {
				$xml_latest   = (string) $xml->latest;
				$xml_requires = (string) $xml->requires;
			}
			$theme_version = bronze_get_parent_theme_version();

			$required_theme_version      = $xml_latest;
			$theme_version_condition     = ( version_compare( $theme_version, $required_theme_version, '>=' ) );
			$theme_update_url            = ( class_exists( 'Envato_Market' ) ) ? admin_url( 'admin.php?page=envato-market' ) : 'https://wolfthemes.ticksy.com/article/11658/';
			$target                      = ( class_exists( 'Envato_Market' ) ) ? '_parent' : '_blank';
			$theme_version_error_message = ( ! $theme_version_condition ) ? ' - ' . esc_html__( 'It is recommended to update the theme to the latest version', 'bronze' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Theme Version', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="
						<?php
						/* translators: %s: theme version */
						esc_attr_e( sprintf( __( 'The version of %s installed on your site.', 'bronze' ), bronze_get_theme_name() ) );
						?>
						" target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $theme_update_url ); ?>"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $theme_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $theme_version . $theme_version_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $theme_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $theme_version_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$wp_version               = get_bloginfo( 'version' );
			$required_wp_version      = $xml_requires;
			$wp_version_condition     = ( version_compare( $wp_version, $required_wp_version, '>=' ) );
			$wp_version_error_message = ( ! $wp_version_condition ) ? ' - ' . esc_html__( 'It is recommended to update WordPress to the latest version', 'bronze' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Version', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The version of WordPress installed on your site.', 'bronze' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11677/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $wp_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $wp_version . $wp_version_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $wp_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $wp_version_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$wp_memory_limit = WP_MEMORY_LIMIT;

			$required_wp_memory_limit      = $vars['REQUIRED_WP_MEMORY_LIMIT'];
			$wp_memory_limit_condition     = ( wp_convert_hr_to_bytes( $wp_memory_limit ) >= wp_convert_hr_to_bytes( $required_wp_memory_limit ) );
			$wp_memory_limit_error_message = ( ! $wp_memory_limit_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your WP memory limit to %s at least', 'bronze' ), $vars['REQUIRED_WP_MEMORY_LIMIT'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Memory Limit', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of memory (RAM) that your site can use at one time.', 'bronze' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11676/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $wp_memory_limit_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $wp_memory_limit . $wp_memory_limit_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $wp_memory_limit_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $wp_memory_limit_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$wp_debug               = ( false === WP_DEBUG ) ? 'false' : 'true';
			$required_wp_debug      = false;
			$wp_debug_condition     = ( WP_DEBUG === $required_wp_debug );
			$wp_debug_error_message = ( ! $wp_debug_condition ) ? ' - ' . sprintf( __( 'It is recommended to set WP_DEBUG to %s on a production website.', 'bronze' ), 'false' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Debug', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'A PHP constant used to trigger the “debug” mode throughout WordPress.', 'bronze' ) ); ?>" href="https://wordpress.org/support/article/debugging-in-wordpress/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $wp_debug_condition ) ) ? 'green' : 'red'; ?>">
						<?php echo esc_attr( $wp_debug . $wp_debug_error_message ); ?>
						</td>
						<td class="status <?php echo ( esc_attr( $wp_debug_condition ) ) ? 'green' : 'red'; ?>">
						<?php echo ( esc_attr( $wp_debug_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

			<?php
			$max_upload_size = size_format( wp_max_upload_size() );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Max Upload Size', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The largest filesize that can be uploaded to your WordPress installation.', 'bronze' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?>"
						href="https://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data"><?php echo esc_attr( $max_upload_size ); ?></td>
						<td class="status">&nbsp;</td>
					</tr>

				</table>

				<h4><?php esc_html_e( 'Server Environment', 'bronze' ); ?></h4>

				<table>
			<?php
			$php_version = phpversion();

			$required_php_version      = $vars['REQUIRED_PHP_VERSION'];
			$php_version_condition     = ( version_compare( $php_version, $required_php_version, '>=' ) );
			$php_version_error_message = ( ! $php_version_condition ) ? ' - ' . sprintf( __( 'The theme needs at least PHP %s installed on your server', 'bronze' ), $vars['REQUIRED_PHP_VERSION'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Version', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The version of PHP installed on your hosting server.', 'bronze' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11673/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $php_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $php_version . $php_version_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $php_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $php_version_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$max_input_vars = @ini_get( 'max_input_vars' );

			$required_max_input_vars                = $vars['REQUIRED_MAX_INPUT_VARS'];
			$max_input_vars_condition               = ( $max_input_vars >= $required_max_input_vars );
			$max_input_vars_condition_error_message = ( ! $max_input_vars_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your server max_input_var value to %s at least', 'bronze' ), $vars['REQUIRED_MAX_INPUT_VARS'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Max Input Vars', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of variable your server can use for a single function.', 'bronze' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11675/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $max_input_vars_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $max_input_vars . $max_input_vars_condition_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $max_input_vars_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $max_input_vars_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

			<?php
			$php_memory_limit = @ini_get( 'memory_limit' );

			$required_php_memory_limit      = $vars['REQUIRED_SERVER_MEMORY_LIMIT'];
			$php_memory_limit_condition     = ( wp_convert_hr_to_bytes( $php_memory_limit ) >= wp_convert_hr_to_bytes( $required_php_memory_limit ) );
			$php_memory_limit_error_message = ( ! $php_memory_limit_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your server memory limit to %s at least', 'bronze' ), $vars['REQUIRED_SERVER_MEMORY_LIMIT'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Server Memory Limit', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of memory (RAM) that your server can use at one time.', 'bronze' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11674/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $php_memory_limit_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $php_memory_limit . $php_memory_limit_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $php_memory_limit_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $php_memory_limit_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

			<?php
			$gd_library = extension_loaded( 'gd' );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'GD Library', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'A common PHP extension to process image.', 'bronze' ) ); ?>" href="https://wolfthemes.ticksy.com/article/14455" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $gd_library ) ) ? 'green' : ''; ?>"><?php echo ( esc_attr( $gd_library ) ) ? esc_html__( 'YES', 'bronze' ) : esc_html__( 'NO', 'bronze' ); ?></td>
						<td class="status <?php echo ( esc_attr( $gd_library ) ) ? 'green' : ''; ?>"><?php echo ( esc_attr( $gd_library ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

			<?php
			$php_post_max_size = size_format( wp_convert_hr_to_bytes( @ini_get( 'post_max_size' ) ) );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Post Max Size', 'bronze' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The largest filesize that can be contained in one post.', 'bronze' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11672/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data"><?php echo esc_attr( $php_post_max_size ); ?></td>
						<td class="status">&nbsp;</td>
					</tr>
				</table>

				<p>
				<?php
					printf(
						__( 'Please check the <a target="_blank" href="%1$s">server requirements</a> recommended by WordPress. You can find more informations <a href="%2$s" target="_blank">here</a>.', 'bronze' ),
						'https://wordpress.org/about/requirements/',
						'https://wolfthemes.ticksy.com/article/11651/'
					)
				?>
				</p>
			</div><!-- .bronze-system-status -->

			<?php
		}

		/**
		 * Output the last new feature if set in the changelog XML
		 */
		private function changelog() {

			$xml = bronze_get_theme_changelog();

			if ( $xml ) {
				?>
				<div id="bronze-notifications">

					<?php
					if ( '' !== (string) $xml->warning ) {
						$warning = (string) $xml->warning;
						?>
						<div class="bronze-changelog-notice bronze-notice-warning" id="bronze-changelog-warning"><?php echo bronze_kses( $warning ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?></div>
					<?php } ?>
					<?php
					if ( '' !== (string) $xml->info ) {
						$info = (string) $xml->info;
						?>
						<div class="bronze-changelog-notice bronze-notice-info" id="bronze-changelog-info"><?php echo bronze_kses( $info ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?></div>
					<?php } ?>
					<?php
					if ( '' !== (string) $xml->new ) {
						$new = (string) $xml->new;
						?>
						<div class="bronze-changelog-notice bronze-notice-news" id="bronze-changelog-news"><?php echo bronze_kses( $new ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?></div>
					<?php } ?>
				</div><!-- #bronze-notifications -->

				<div id="bronze-changelog">
					<?php echo bronze_kses( $xml->changelog ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?>
				</div><!-- #bronze-changelog -->
				<hr>
				<?php
			}
		}

		/**
		 * Sends user to the welcome page on first activation
		 */
		public function welcome() {
			if ( isset( $_GET['activated'] ) && 'true' === $_GET['activated'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				flush_rewrite_rules();
				wp_redirect( admin_url( 'admin.php?page=' . $this->theme_slug . '-about&bronze-activated' ) );
				exit;
			}
		}
	}

	new Bronze_Admin_About_Page();
} // end class exists check
