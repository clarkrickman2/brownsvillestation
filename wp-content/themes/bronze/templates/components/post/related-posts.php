<?php
/**
 * Template part for displaying related posts on single post page
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
$related_posts_query = bronze_related_post_query();

if ( ! $related_posts_query ) {
	return;
}
?>
<section class="related-post-container entry-section">
	<div class="related-posts clearfix"><?php if( $related_posts_query->have_posts() ) : ?>
			<h3 class="related-post-title"><?php echo apply_filters( 'bronze_related_posts_text', esc_html__( 'More Posts', 'bronze' ) ); ?></h3>
			<?php while ( $related_posts_query->have_posts() ) : $related_posts_query->the_post();
				/*
				* Include the template part for the entry content.
				*/
				get_template_part( bronze_get_template_dirname() . '/components/post/content', 'related' );
			endwhile;
	endif; ?></div><!-- .related-posts -->
</section><!-- .related-post-container -->
<?php wp_reset_postdata(); ?>
