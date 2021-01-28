<?php
/**
 * Template part for displaying single release content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php bronze_post_attr(); ?>>
	<div class="release-content clearfix">
		<?php
			/**
			 * The post content
			 */
			the_content();

			if ( function_exists( 'wd_release_buttons' ) ) {

				/**
				 * Buy Buttons
				 */
				wd_release_buttons();
			}
		?>
	</div><!-- .release-content -->
	<div class="release-info-container clearfix">
		<div class="release-thumbnail">
			<a class="lightbox" href="<?php echo get_the_post_thumbnail_url( '', '%SLUG-XL%' ); ?>">
				<?php

					if ( function_exists( 'wpb_getImageBySize' ) && function_exists( 'wvc_placeholder_img' ) ) {

						$img_id = get_post_thumbnail_id();
						$cd_size = apply_filters( 'bronze_release_img_size', '400x400' );
						$cd_big_size = apply_filters( 'bronze_release_img_big_size', '1000x1000' );

						$img_size = ( 'wide' == get_post_meta( get_the_ID(), '_post_width', true ) ) ? $cd_big_size : $cd_size;

						if ( wp_attachment_is_image( $img_id ) ) {
				
							$img = wpb_getImageBySize( array(
								'attach_id' => $img_id,
								'thumb_size' => $img_size,
							) );

							echo bronze_kses( $img['thumbnail'] );
						
						} else {
							echo wvc_placeholder_img( $img_size );
						}


					} elseif ( function_exists( 'wd_release_thumbnail' ) ) {
						
						$size = ( 'wide' == get_post_meta( get_the_ID(), '_post_width', true ) ) ? 'large' : 'CD';
						wd_release_thumbnail( $size );
					
					} else {
						the_post_thumbnail();
					}
				?>
			</a>
		</div>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="release-meta-container"><?php
				/**
				 * Release Meta Hook
				 */
				do_action( 'bronze_release_meta' );
			?></div><!-- .release-meta-container -->
		<?php if ( has_excerpt() ) : ?>
			<div class="release-excerpt-container">
				<?php
					/**
					 * The excerpt
					 */
					the_excerpt();
				?>
			</div><!-- .release-excerpt-container -->
		<?php endif; ?>
		<?php

			/**
			 * Share buttons
			 */
			do_action( 'bronze_share' );
		?>
	<div><!-- .release-info -->
</article><!-- #post-## -->