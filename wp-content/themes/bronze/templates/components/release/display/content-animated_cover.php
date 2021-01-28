<?php // phpcs:ignore
/**
 * Template part for displaying release posts animated cover layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

$current_post_id             = get_the_ID();
$featured_image_id           = get_post_thumbnail_id();
$secondary_featured_image_id = get_post_meta( $current_post_id, '_release_secondary_featured_image', true );
$release_type                = ( get_post_meta( $current_post_id, '_release_cover_type', true ) ) ? get_post_meta( $current_post_id, '_release_cover_type', true ) : 'CD';

extract(
	wp_parse_args(
		$template_args,
		array(
			'custom_thumbnail_size' => '375x375',
		)
	)
);
?>
<article <?php bronze_post_attr(); ?>>
<a href="<?php the_permalink(); ?>">
<?php
	echo do_shortcode( '[wvc_album_disc img_size="' . esc_attr( $custom_thumbnail_size ) . '" type="' . esc_attr( $release_type ) . '" cover_image="' . esc_attr( $featured_image_id ) . '" disc_image="' . esc_attr( $secondary_featured_image_id ) . '"]' );
?>
</a>
</article>
<?php
