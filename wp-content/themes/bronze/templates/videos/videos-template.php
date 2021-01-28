<?php
/**
 * The videos template file.
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
get_header();
?>
	<div id="primary" class="content-area">
		<main id="content" class="clearfix">
			<?php
				/**
				 * Output post loop through hook so we can do the magic however we want
				 */
				do_action( 'bronze_posts', array(
					'el_id' => 'videos-index',
					'post_type' => 'video',
					'videos_per_page' => bronze_get_theme_mod( 'videos_per_page', '' ),
					'pagination' => bronze_get_theme_mod( 'video_pagination', '' ),
					'grid_padding' => bronze_get_theme_mod( 'video_grid_padding', 'yes' ),
					'item_animation' => bronze_get_theme_mod( 'video_item_animation' ),
				) );
			?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar( 'videos' );
get_footer();
?>