<?php
/**
 * Template part for displaying single video content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
?>
<article <?php bronze_post_attr(); ?>>
	<?php
		/**
		 * The post content
		 */
		the_content();

		/**
		 * Video Meta
		 */
		do_action( 'bronze_video_meta' );

		/**
		 * Share icon meta
		 */
		do_action( 'bronze_share' );
	?>
</article><!-- #post-## -->