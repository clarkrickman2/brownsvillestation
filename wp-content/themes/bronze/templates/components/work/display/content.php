<?php
/**
 * Template part for displaying work posts common layout
 *
 * As all work posts share the same markup, we use this common template.
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
			'layout'                    => '',
			'overlay_color'             => 'auto',
			'overlay_custom_color'      => '',
			'overlay_opacity'           => 88,
			'overlay_text_color'        => '',
			'overlay_text_custom_color' => '',
			'work_is_gallery'           => '',
			'custom_thumbnail_size'     => '',
		)
	)
);
$text_style = '';

if ( function_exists( 'wvc_convert_color_class_to_hex_value' ) && $overlay_text_color && 'overlay' === $layout ) {
	$text_color = wvc_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$text_style .= 'color:' . bronze_sanitize_color( $text_color ) . ';';
	}
}

$dominant_color       = bronze_get_image_dominant_color( get_post_thumbnail_id() );
$actual_overlay_color = '';

if ( 'auto' === $overlay_color ) {

	$actual_overlay_color = $dominant_color;

} elseif ( function_exists( 'wvc_convert_color_class_to_hex_value' ) ) {
	$actual_overlay_color = wvc_convert_color_class_to_hex_value( $overlay_color, $overlay_custom_color );
}

$overlay_tone_class = 'overlay-tone-' . bronze_get_color_tone( $actual_overlay_color );

$the_permalink  = ( $work_is_gallery ) ? '#' : get_the_permalink();
$gallery_params = ( $work_is_gallery && function_exists( 'bronze_get_gallery_params' ) ) ? bronze_get_gallery_params() : '';
$link_class     = ( $work_is_gallery ) ? 'gallery-quickview entry-link entry-link-mask' : 'entry-link entry-link-mask';
?>
<figure <?php bronze_post_attr( array( $overlay_tone_class ) ); ?>>
	<div class="entry-box">
		<div class="entry-container">
			<a data-gallery-params="<?php echo esc_js( wp_json_encode( $gallery_params ) ); ?>" class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $the_permalink ); ?>"></a>
			<?php do_action( 'bronze_work_bg', $template_args ); ?>
			<div class="entry-image">
					<?php

					if ( 'custom' === $thumbnail_size && $custom_thumbnail_size ) {
						$thumbnail_size = $custom_thumbnail_size;
					} else {
						$thumbnail_size = bronze_convert_img_size_name( $thumbnail_size );
					}
					?>
					<div class="entry-cover" style="padding-bottom:<?php echo esc_attr( bronze_convert_img_dimension_percent_ratio( $thumbnail_size ) ); ?>">
						<?php
							if ( bronze_is_gif( get_post_thumbnail_id() ) ) {
								echo bronze_background_img( array( 'background_img_size' => 'full' ) );
							} else {
								bronze_resized_thumbnail( $thumbnail_size, 'img-bg' );
							}
						?>
					</div>
			</div><!-- .entry-image -->
			<div class="entry-inner">
				<a data-gallery-params="<?php echo esc_js( wp_json_encode( $gallery_params ) ); ?>" class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $the_permalink ); ?>"></a>
				<div class="entry-inner-padding">
					<?php
						$dominant_color = bronze_get_image_dominant_color( get_post_thumbnail_id() );

					if ( $dominant_color && 'auto' === $overlay_color ) {
						$overlay_custom_color = $dominant_color;
					}

						echo bronze_background_overlay(
							array(
								'overlay_color'        => $overlay_color,
								'overlay_custom_color' => $overlay_custom_color,
								'overlay_opacity'      => $overlay_opacity,
							)
						);
						?>
					<div style="<?php echo bronze_esc_style_attr( $text_style ); ?>" class="entry-summary">

						<?php do_action( 'bronze_work_grid_summary_start', $template_args ); ?>

						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" style="<?php echo bronze_esc_style_attr( $text_style ); ?>"><?php the_title(); ?></a></h3>
						<div style="<?php echo bronze_esc_style_attr( $text_style ); ?>" class="entry-taxonomy">
							<?php echo get_the_term_list( get_the_ID(), 'work_type', '', ' <span class="work-taxonomy-separator">/</span> ', '' ); ?>
						</div><!-- .entry-taxonomy -->

						<?php do_action( 'bronze_work_grid_summary_end', $template_args ); ?>
					</div><!--  .entry-summary -->
				</div><!-- .entry-inner-padding -->
			</div><!--  .entry-inner -->
		</div>
	</div><!-- .entry-container -->
</figure><!-- #post-## -->
