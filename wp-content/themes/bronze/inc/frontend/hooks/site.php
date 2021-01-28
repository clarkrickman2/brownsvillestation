<?php
/**
 * Bronze site hook functions
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function bronze_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'bronze_pingback_header' );

/**
 * Output anchor at the very top of the page
 */
function bronze_output_top_anchor() {
	?>
	<div id="top"></div>
	<?php
}
add_action( 'bronze_body_start', 'bronze_output_top_anchor' );

/**
 * Output loader overlay
 */
function bronze_page_loading_overlay() {

	$show_overlay = apply_filters( 'bronze_display_loading_overlay', 'none' != bronze_get_inherit_mod( 'loading_animation_type', 'none' ) );

	if ( ! $show_overlay ) {
		return;
	}
	?>
	<div id="loading-overlay" class="loading-overlay">
		<?php bronze_spinner(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'bronze_body_start', 'bronze_page_loading_overlay' );

/**
 * Output ajax loader overlay
 */
function bronze_ajax_loading_overlay() {

	if ( 'none' === bronze_get_theme_mod( 'ajax_animation_type', 'none' ) ) {
		return;
	}
	?>
	<div id="ajax-loading-overlay" class="loading-overlay">
		<?php bronze_spinner(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'wolf_site_content_start', 'bronze_ajax_loading_overlay' );

/**
 * Add panel closer overlay
 */
function bronze_add_panel_closer_overlay() {
	$toggle_class = 'toggle-side-panel';

	if ( 'offcanvas' === bronze_get_inherit_mod( 'menu_layout' ) ) {
		$toggle_class = 'toggle-offcanvas-menu';
	}

	$toggle_class = apply_filters( 'bronze_panel_closer_overlay_class', $toggle_class );
	?>
	<div id="panel-closer-overlay" class="panel-closer-overlay <?php echo bronze_sanitize_html_classes( $toggle_class ); ?>"></div>
	<?php
}
add_action( 'bronze_main_content_start', 'bronze_add_panel_closer_overlay' );

/**
 * Scroll to top arrow
 */
function bronze_scroll_top_link() {
	?>
	<a href="#top" id="back-to-top"><?php echo esc_attr( apply_filters( 'bronze_backtop_text', esc_html__( 'Back to the top', 'bronze' ) ) ); ?></a>
	<?php
}
add_action( 'bronze_body_start', 'bronze_scroll_top_link' );

/**
 * Output frame
 */
function bronze_frame_border() {

	if ( 'frame' === bronze_get_inherit_mod( 'site_layout' ) || bronze_is_customizer() ) {
		?>
		<span class="frame-border frame-border-top"></span>
		<span class="frame-border frame-border-bottom"></span>
		<span class="frame-border frame-border-left"></span>
		<span class="frame-border frame-border-right"></span>
		<?php
	}
}
add_action( 'bronze_body_start', 'bronze_frame_border' );

/**
 * Hero
 */
function bronze_output_hero_content() {

	$show_hero = true;

	$no_hero_post_types = apply_filters( 'bronze_no_header_post_types', array( 'product', 'release', 'event', 'proof_gallery', 'attachment' ) );

	if ( is_single() && in_array( get_post_type(), $no_hero_post_types, true ) ) {
		$show_hero = false;
	}

	if ( is_single() && 'none' === get_post_meta( get_the_ID(), '_post_hero_layout', true ) ) {
		$show_hero = false;
	}

	if ( apply_filters( 'bronze_show_hero', $show_hero ) ) {
		get_template_part( bronze_get_template_dirname() . '/components/layout/hero', 'content' );
	}
}
add_action( 'bronze_hero', 'bronze_output_hero_content' );

/**
 * Output Hero background
 *
 * Diplsay the hero background through the hero_background hook
 */
function bronze_output_hero_background() {

	echo bronze_get_hero_background();

	if ( bronze_get_inherit_mod( 'hero_scrolldown_arrow' ) ) {
		echo '<a class="scroll-down" id="hero-scroll-down-arrow" href="#"><i class="fa scroll-down-icon"></i></a>';
	}
}
add_action( 'bronze_hero_background', 'bronze_output_hero_background' );

/**
 * Output bottom bar with menu copyright text and social icons
 */
function bronze_bottom_bar() {

	$class           = 'site-infos wrap';
	$hide_bottom_bar = get_post_meta( get_the_ID(), '_post_bottom_bar_hidden', true );
	$services        = sanitize_text_field( bronze_get_theme_mod( 'footer_socials' ) );
	$display_menu    = has_nav_menu( 'tertiary' );
	$display_menu    = false;
	$credits         = bronze_get_theme_mod( 'copyright' );

	if ( 'yes' === $hide_bottom_bar ) {
		return;
	}

	if ( $services || $display_menu || $credits ) :
		?>
	<div class="site-infos clearfix">
		<div class="wrap">
			<div class="bottom-social-links">
				<?php
					/**
					 * Social icons
					 */
				if ( function_exists( 'wvc_socials' ) && $services ) {
					echo wvc_socials(
						array(
							'services' => $services,
							'size'     => 'fa-1x',
						)
					);
				}
				?>
			</div><!-- .bottom-social-links -->
			<?php
				/**
				 * Fires in the Bronze bottom menu
				 */
				do_action( 'bronze_bottom_menu' );
			?>
			<?php if ( has_nav_menu( 'tertiary' ) ) : ?>
			<div class="clear"></div>
			<?php endif; ?>
			<div class="credits">
				<?php
					/**
					 * Fires in the Bronze footer text for customization.
					 *
					 * @since Bronze 1.0
					 */
					do_action( 'bronze_credits' );
				?>
			</div><!-- .credits -->
		</div>
	</div><!-- .site-infos -->
		<?php
	endif;

}
add_action( 'bronze_bottom_bar', 'bronze_bottom_bar' );

/**
 * Copyright/site info text
 *
 * @since Bronze 1.0.0
 */
function bronze_site_infos() {

	$footer_text = bronze_get_theme_mod( 'copyright' );

	if ( $footer_text ) {
		$footer_text = '<span class="copyright-text">' . $footer_text . '</span>';
		echo bronze_kses( apply_filters( 'bronze_copyright_text', $footer_text ) );
	}
}
add_action( 'bronze_credits', 'bronze_site_infos' );

/**
 * Output top block beafore header using WVC Content Block plugin function
 */
function bronze_output_top_bar_block() {

	if ( ! class_exists( 'Wolf_Vc_Content_Block' ) || ! defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = bronze_get_the_id();

	$block_mod  = bronze_get_theme_mod( 'top_bar_block_id' );
	$block_meta = get_post_meta( $post_id, '_post_top_bar_block_id', true );

	if ( ! is_single() && ! is_page() ) {
		$block_meta = null;
	}

	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( bronze_get_woocommerce_shop_page_id(), '_post_top_bar_block_id', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == bronze_get_woocommerce_shop_page_id();

	$is_wc = bronze_is_woocommerce_page() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta && apply_filters( 'bronze_force_display_shop_top_bar_block_id', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta    = get_post_meta( $blog_page_id, '_post_top_bar_block_id', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;

	$is_blog = bronze_is_blog() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta && apply_filters( 'bronze_force_display_blog_top_bar_block_id', $is_blog ) ) {
		$block = $blog_meta;
	}

	/* Video page inheritance */
	$video_page_id = bronze_get_videos_page_id();
	$video_meta    = get_post_meta( $video_page_id, '_post_top_bar_block_id', true );
	$is_video_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $video_page_id;

	$is_video = bronze_is_videos() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $video_meta && apply_filters( 'bronze_force_display_video_top_bar_block_id', $is_video ) ) {
		$block = $video_meta;
	}

	/* Portfolio page inheritance */
	$portfolio_page_id = bronze_get_portfolio_page_id();
	$portfolio_meta    = get_post_meta( $portfolio_page_id, '_post_top_bar_block_id', true );
	$is_portfolio_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $portfolio_page_id;

	$is_portfolio = bronze_is_portfolio() || is_singular( 'work' );

	if ( ! $block_meta && 'none' !== $block_meta && $portfolio_meta && apply_filters( 'bronze_force_display_portfolio_top_bar_block_id', $is_portfolio ) ) {
		$block = $portfolio_meta;
	}

	/* Artists page inheritance */
	$artists_page_id = bronze_get_artists_page_id();
	$artists_meta    = get_post_meta( $artists_page_id, '_post_top_bar_block_id', true );
	$is_artists_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $artists_page_id;

	$is_artists = bronze_is_artists() || is_singular( 'artist' );

	if ( ! $block_meta && 'none' !== $block_meta && $artists_meta && apply_filters( 'bronze_force_display_artists_top_bar_block_id', $is_artists ) ) {
		$block = $artists_meta;
	}

	/* Releases page inheritance */
	$releases_page_id = bronze_get_discography_page_id();
	$releases_meta    = get_post_meta( $releases_page_id, '_post_top_bar_block_id', true );
	$is_releases_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $releases_page_id;

	$is_releases = bronze_is_discography() || is_singular( 'release' );

	if ( ! $block_meta && 'none' !== $block_meta && $releases_meta && apply_filters( 'bronze_force_display_releases_top_bar_block_id', $is_releases ) ) {
		$block = $releases_meta;
	}

	/* Events page inheritance */
	$events_page_id = bronze_get_events_page_id();
	$events_meta    = get_post_meta( $events_page_id, '_post_top_bar_block_id', true );
	$is_events_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $events_page_id;

	$is_events = bronze_is_events() || is_singular( 'event' );

	if ( ! $block_meta && 'none' !== $block_meta && $events_meta && apply_filters( 'bronze_force_display_events_top_bar_block_id', $is_events ) ) {
		$block = $events_meta;
	}

	if ( is_search() ) {
		$block = get_post_meta( get_option( 'page_for_posts' ), '_post_top_bar_block_id', true );

		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) {

			$block = get_post_meta( bronze_get_woocommerce_shop_page_id(), '_post_top_bar_block_id', true );

		} else {
			$block = get_post_meta( get_option( 'page_for_posts' ), '_post_top_bar_block_id', true );
		}
	}

	if ( $block && 'none' !== $block && function_exists( 'wccb_block' ) ) {

		wp_enqueue_script( 'js-cookie' );

		echo '<div id="top-bar-block">';
		echo wccb_block( $block );

		if ( 'yes' === bronze_get_inherit_mod( 'top_bar_closable' ) ) {
			echo '<a href="#" id="top-bar-close">' . esc_html__( 'Close', 'bronze' ) . '</a>';
		}

		echo '</div>';
	}
}
add_action( 'bronze_top_bar_block', 'bronze_output_top_bar_block' );

/**
 * Output top block after header using WVC Content Block plugin function
 */
function bronze_output_after_header_block() {

	if ( ! class_exists( 'Wolf_Vc_Content_Block' ) && ! class_exists( 'Wolf_Core' )  ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = bronze_get_the_id();

	$block_mod  = bronze_get_theme_mod( 'after_header_block' );
	$block_meta = get_post_meta( $post_id, '_post_after_header_block', true );

	if ( ! is_single() && ! is_page() ) {
		$block_meta = null;
	}

	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( bronze_get_woocommerce_shop_page_id(), '_post_after_header_block', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == bronze_get_woocommerce_shop_page_id();

	$is_wc = bronze_is_woocommerce_page() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta && apply_filters( 'bronze_force_display_shop_after_header_block', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta    = get_post_meta( $blog_page_id, '_post_after_header_block', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;

	$is_blog = bronze_is_blog() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta && apply_filters( 'bronze_force_display_blog_after_header_block', $is_blog ) ) {
		$block = $blog_meta;
	}

	/* Video page inheritance */
	$video_page_id = bronze_get_videos_page_id();
	$video_meta    = get_post_meta( $video_page_id, '_post_after_header_block', true );
	$is_video_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $video_page_id;

	$is_video = bronze_is_videos() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $video_meta && apply_filters( 'bronze_force_display_video_after_header_block', $is_video ) ) {
		$block = $video_meta;
	}

	/* Portfolio page inheritance */
	$portfolio_page_id = bronze_get_portfolio_page_id();
	$portfolio_meta    = get_post_meta( $portfolio_page_id, '_post_after_header_block', true );
	$is_portfolio_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $portfolio_page_id;

	$is_portfolio = bronze_is_portfolio() || is_singular( 'work' );

	if ( ! $block_meta && 'none' !== $block_meta && $portfolio_meta && apply_filters( 'bronze_force_display_portfolio_after_header_block', $is_portfolio ) ) {
		$block = $portfolio_meta;
	}

	/* Artists page inheritance */
	$artists_page_id = bronze_get_artists_page_id();
	$artists_meta    = get_post_meta( $artists_page_id, '_post_after_header_block', true );
	$is_artists_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $artists_page_id;

	$is_artists = bronze_is_artists() || is_singular( 'artist' );

	if ( ! $block_meta && 'none' !== $block_meta && $artists_meta && apply_filters( 'bronze_force_display_artists_after_header_block', $is_artists ) ) {
		$block = $artists_meta;
	}

	/* Releases page inheritance */
	$releases_page_id = bronze_get_discography_page_id();
	$releases_meta    = get_post_meta( $releases_page_id, '_post_after_header_block', true );
	$is_releases_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $releases_page_id;

	$is_releases = bronze_is_discography() || is_singular( 'release' );

	if ( ! $block_meta && 'none' !== $block_meta && $releases_meta && apply_filters( 'bronze_force_display_releases_after_header_block', $is_releases ) ) {
		$block = $releases_meta;
	}

	/* Events page inheritance */
	$events_page_id = bronze_get_events_page_id();
	$events_meta    = get_post_meta( $events_page_id, '_post_after_header_block', true );
	$is_events_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $events_page_id;

	$is_events = bronze_is_events() || is_singular( 'event' );

	if ( ! $block_meta && 'none' !== $block_meta && $events_meta && apply_filters( 'bronze_force_display_events_after_header_block', $is_events ) ) {
		$block = $events_meta;
	}

	if ( is_search() ) {
		$block = get_post_meta( get_option( 'page_for_posts' ), '_post_after_header_block', true );

		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) {

			$block = get_post_meta( bronze_get_woocommerce_shop_page_id(), '_post_after_header_block', true );

		} else {
			$block = get_post_meta( get_option( 'page_for_posts' ), '_post_after_header_block', true );
		}
	}

	$block = apply_filters( 'bronze_after_header_block_id', $block );

	if ( $block && 'none' !== $block ) {
		if ( function_exists( 'wccb_block' ) ) {

			echo wccb_block( $block );

		}

		if ( function_exists( 'wolf_core_content_block' ) ) {

			echo wolf_core_content_block( $block );
		}
	}
}
add_action( 'bronze_after_header_block', 'bronze_output_after_header_block' );

/**
 * Output bottom block before footer using WVC Content Block plugin function
 */
function bronze_output_before_footer_block() {

	if ( ! class_exists( 'Wolf_Vc_Content_Block' ) && ! class_exists( 'Wolf_Core' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = bronze_get_the_id();

	$block_mod  = bronze_get_theme_mod( 'before_footer_block' );
	$block_meta = get_post_meta( $post_id, '_post_before_footer_block', true );
	$block      = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta          = get_post_meta( bronze_get_woocommerce_shop_page_id(), '_post_before_footer_block', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == bronze_get_woocommerce_shop_page_id();
	$is_wc            = ( bronze_is_woocommerce_page() || $is_wc_page_child || is_singular( 'product' ) );

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta && apply_filters( 'bronze_force_display_shop_pre_footer_block', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id       = get_option( 'page_for_posts' );
	$blog_meta          = get_post_meta( $blog_page_id, '_post_before_footer_block', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;
	$is_blog            = ( bronze_is_blog() || $is_blog_page_child ) && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta && apply_filters( 'bronze_force_display_blog_pre_footer_block', $is_blog ) ) {
		$block = $blog_meta;
	}

	$block = apply_filters( 'bronze_before_footer_block_id', $block );

	if ( $block && 'none' !== $block ) {

		if ( function_exists( 'wccb_block' ) ) {

			echo wccb_block( $block );

		}

		if ( function_exists( 'wolf_core_content_block' ) ) {

			echo wolf_core_content_block( $block );
		}
	}
}
add_action( 'bronze_before_footer_block', 'bronze_output_before_footer_block', 28 );


/**
 * Output music network icons
 *
 * @see Wolf Music Network http://wolfthemes.com/plugin/wolf-music-network/
 */
function bronze_output_music_network() {

	if ( function_exists( 'wolf_music_network' ) ) {
		echo '<div class="music-social-icons-container clearfix">';
			wolf_music_network();
		echo '</div><!--.music-social-icons-container-->';
	}

}
add_action( 'bronze_before_footer_block', 'bronze_output_music_network' );
