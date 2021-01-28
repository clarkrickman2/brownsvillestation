<?php
/**
 * The sidebar containing the footer widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( is_active_sidebar( 'sidebar-footer' ) ) :
	$bronze_tertiary_widget_area_class  = 'sidebar-footer';
	$bronze_tertiary_widget_area_class .= ' ' . apply_filters( 'bronze_sidebar_footer_class', '' );
	?>
	<div id="tertiary" class="<?php echo bronze_sanitize_html_classes( $bronze_tertiary_widget_area_class ); ?>">
		<div class="sidebar-footer-inner wrap">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-footer-inner -->
	</div><!-- #tertiary .sidebar-footer -->
<?php endif; ?>
