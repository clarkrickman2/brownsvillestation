<?php
/**
 * Template part for displaying video posts layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
extract(
	wp_parse_args(
		$template_args,
		array(
			'layout'                => '',
			'video_onclick'         => bronze_get_theme_mod( 'video_onclick', 'lightbox' ),
			'video_preview'         => false,
			'custom_thumbnail_size' => '',
		)
	)
);

// Video link
$permalink = ( 'lightbox' === $video_onclick ) ? bronze_get_first_video_url() : get_the_permalink();

// Link class
$link_class = 'entry-link-mask';

if ( ( 'lightbox' === $video_onclick ) ) {
	$link_class .= ' lightbox-video pause-players';
}
?>
<article <?php bronze_post_attr(); ?>>
	<div class="entry-box">
		<div class="entry-outer">
			<div class="entry-container">
				<a href="<?php echo esc_url( $permalink ); ?>" class="<?php echo bronze_sanitize_html_classes( $link_class ); ?>"></a>
				<?php
				if ( $video_preview ) {
					/**
					 * Video Background
					 */
					echo bronze_background_video( '', true );
				}

				$style              = '';
				$img_dominant_color = bronze_get_image_dominant_color( get_post_thumbnail_id() );

				if ( $img_dominant_color ) {
					$img_dominant_color = bronze_sanitize_color( $img_dominant_color );
					$style              = "background-color:$img_dominant_color;";
				}
				?>

				<div class="entry-image" style="<?php echo bronze_esc_style_attr( $style ); ?>">
					<?php

					if ( $custom_thumbnail_size ) {

						$thumbnail = bronze_get_img_by_size(
							array(
								'attach_id'  => get_post_thumbnail_id(),
								'thumb_size' => $custom_thumbnail_size,
								'class'      => 'resized-thumbnail',
							)
						);

						echo bronze_kses( $thumbnail['thumbnail'] ); // WCS XSS ok.

					} else {
						echo bronze_background_img(
							array(
								'background_img_size'  => 'medium',
								'placeholder_fallback' => true,
							)
						);
					}


						// the_post_thumbnail( 'medium', array( 'class' => 'cover' ) )
					?>
				</div><!-- .entry-image -->

				<div class="video-play-button">
					<span class="fa fa-3x video-play-icon"></span>
				</div><!-- .video-play-button -->
				<div class="video-summary">
					<div class="video-summary-inner">
						<h2 class="entry-title">
							<?php the_title(); ?>
						</h2>

					</div><!-- .video-summary-inner -->
				</div><!-- .video-summary -->
			</div><!-- .entry-container -->
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
	<?php do_action( 'bronze_video_content_after', $layout ); ?>
</article>
