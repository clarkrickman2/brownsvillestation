<?php
/**
 * Template part for displaying single post content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
?>
<article <?php bronze_post_attr( 'content-section' ); ?>>
		<?php
			/**
			 * bronze_post_content_before hook
			 *
			 * @see inc/fontend/hooks.php
			 */
			do_action( 'bronze_post_content_before' );
		?>
		<div class="single-post-content-container">
			<?php
				/**
				 * bronze_post_content_start hook
				 *
				 * @see inc/fontend/hooks.php
				 */
				do_action( 'bronze_post_content_start' );
			?>
				<div class="entry-content clearfix">
					<?php
						/**
						 * The post content
						 */
						the_content();

						wp_link_pages( array(
							'before' => '<div class="clear"></div><div class="page-links clearfix">' . esc_html__( 'Pages:', 'bronze' ),
							'after' => '</div>',
							'link_before' => '<span class="page-number">',
							'link_after' => '</span>',
						) );
					?>
				</div><!-- .entry-content -->
			<?php
				/**
				 * bronze_post_content_end hook
				 *
				 * @see inc/fontend/hooks.php
				 */
				do_action( 'bronze_post_content_end' );
			?>
		</div><!-- .single-post-content-container -->
		<?php
			/**
			 * bronze_post_content_after hook
			 *
			 * @see inc/fontend/hooks.php
			 */
			do_action( 'bronze_post_content_after' );
		?>
</article>