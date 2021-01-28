<?php
/**
 * Template part for displaying related posts
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
		 * Output related post content
		 */
		do_action( 'bronze_related_post_content' );
	?>
</article><!-- #post-## -->