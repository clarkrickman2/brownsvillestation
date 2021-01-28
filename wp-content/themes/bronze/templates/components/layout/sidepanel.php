<?php
/**
 * Displays side panel
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
$sp_classes = apply_filters( 'bronze_side_panel_class', '' );
?>
<div id="side-panel" class="side-panel <?php echo bronze_sanitize_html_classes( $sp_classes ); ?>">
	<div class="side-panel-inner">
		<?php
			/* Side Panel start hook */
			do_action( 'bronze_sidepanel_start' );

		if ( bronze_get_theme_mod( 'sidepanel_content_block_id' ) ) {

			echo '<div id="side-panel-block" class="sidebar-container sidebar-side-panel">';
			echo '<div class="sidebar-inner">';
			echo ( function_exists( 'wccb_block' ) ) ? wccb_block( bronze_get_theme_mod( 'sidepanel_content_block_id' ) ) : '';
			echo '</div>';
			echo '</div>';

		} else {
			get_sidebar( 'side-panel' );
		}
		?>
	</div><!-- .side-panel-inner -->
</div><!-- .side-panel -->
