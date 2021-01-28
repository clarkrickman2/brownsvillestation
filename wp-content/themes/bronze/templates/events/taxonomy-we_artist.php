<?php
/**
 * The "artist" taxonomy template file.
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
					'event_index' => true,
					'el_id' => 'events-index',
					'post_type' => 'event',
					'grid_padding' => bronze_get_theme_mod( 'event_grid_padding', 'yes' ),
					'item_animation' => bronze_get_theme_mod( 'event_item_animation' ),
				) );
			?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar( 'events' );
get_footer();