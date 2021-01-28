<?php
/**
 * Displays top right navigation type
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
?>
<div id="nav-bar" class="nav-bar" data-menu-layout="top-right">
	<div class="flex-wrap">
		<?php
			if ( 'left' === bronze_get_inherit_mod( 'side_panel_position' ) && bronze_can_display_sidepanel() ) {
				/**
				 * Output sidepanel hamburger
				 */
				do_action( 'bronze_sidepanel_hamburger' );
			}
		?>
		<div class="logo-container">
			<?php
				/**
				 * Logo
				 */
				bronze_logo();
			?>
		</div><!-- .logo-container -->
		<nav class="menu-container" itemscope="itemscope"  itemtype="https://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				bronze_primary_desktop_navigation();
			?>
		</nav><!-- .menu-container -->
		<div class="cta-container">
			<?php
				/**
				 * Secondary menu hook
				 */
				do_action( 'bronze_secondary_menu', 'desktop' );
			?>
		</div><!-- .cta-container -->
		<?php
			if ( 'right' === bronze_get_inherit_mod( 'side_panel_position' ) && bronze_can_display_sidepanel() ) {
				/**
				 * Output sidepanel hamburger
				 */
				do_action( 'bronze_sidepanel_hamburger' );
			}
		?>
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->