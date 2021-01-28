<?php
/**
 * Displays hero content
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */
?>
<div id="hero">
	<?php
		/**
		 * bronze_hero_background hook
		 * @see bronze_output_hero_background function
		 */
		do_action( 'bronze_hero_background' );
	?>
	<div id="hero-inner">
		<div id="hero-content">
			<div class="post-title-container hero-section"><?php
				/**
				 * bronze_hero_title hook
				 * @see bronze_output_post_title function
				 */
				do_action( 'bronze_hero_title' );
			?></div><!-- .post-title-container -->
			<div class="post-meta-container hero-section"><?php
				/**
				 * bronze_hero_meta hook
				 * @see inc/frontend/hooks.php
				 */
				do_action( 'bronze_hero_meta' );
			?></div><!-- .post-meta-container -->
			<div class="post-secondary-meta-container hero-section"><?php
				/**
				 * bronze_hero_secondary_meta hook
				 * @see inc/frontend/hooks.php
				 */
				do_action( 'bronze_hero_secondary_meta' );
			?></div><!-- .post-meta-container -->
		</div><!-- #hero-content -->
	</div><!-- #hero-inner -->
</div><!-- #hero-container -->
