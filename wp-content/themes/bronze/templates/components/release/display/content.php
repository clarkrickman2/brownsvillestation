<?php
/**
 * Template part for displaying release posts common layout
 *
 * As all release posts share the same markup, we use this common template.
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
			'overlay_color'             => 'auto',
			'overlay_custom_color'      => '',
			'overlay_opacity'           => 88,
			'overlay_text_color'        => '',
			'overlay_text_custom_color' => '',
			'release_add_buy_links'     => false,
			'custom_thumbnail_size'     => '',
		)
	)
);

$text_style         = '';
$overlay_text_color = apply_filters( 'wvc_release_overlay_text_color', $overlay_text_color );
if ( function_exists( 'wvc_convert_color_class_to_hex_value' ) && $overlay_text_color && 'overlay' === $layout ) {
	$text_color = wvc_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$text_style .= 'color:' . bronze_sanitize_color( $text_color ) . '!important;';
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
?>
<article <?php bronze_post_attr( array( $overlay_tone_class ) ); ?>>
	<div class="entry-box">
		<div class="entry-container">
			<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
			
			<?php

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

					bronze_resized_thumbnail( $custom_thumbnail_size ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound

				} else {

					?>
						<div class="entry-cover">
						<?php

						echo bronze_background_img(
							array(
								'background_img_size' => 'large',
							)
						);

						?>
						</div><!-- entry-cover -->
						<?php
				}
				?>

			</div>
			<div class="entry-inner">
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
					<h3 class="entry-title"><a href="<?php the_permalink(); ?>" style="<?php echo bronze_esc_style_attr( $text_style ); ?>"><?php the_title(); ?></a></h3>
					<div style="<?php echo bronze_esc_style_attr( $text_style ); ?>" class="entry-taxonomy">
						<?php echo get_the_term_list( get_the_ID(), 'band', apply_filters( 'bronze_release_tax_before', '' ), ' / ', '' ); ?>
					</div><!-- .entry-taxonomy -->
					<?php do_action( 'bronze_loop_release_caption_end' ); ?>
				</div><!--  .entry-summary  -->
			</div><!--  .entry-summary-container  -->
		</div>
	</div><!-- .entry-box -->

	<?php do_action( 'bronze_loop_release_end', $release_add_buy_links ); ?>
</article><!-- #post-## -->
