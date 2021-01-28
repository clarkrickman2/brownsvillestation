<?php
/**
 * Bronze frontend theme specific functions
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Disable default loading and transition animation
 *
 * @param  bool $bool enable/disable default loading animation.
 * @return bool
 */
function bronze_reset_loading_anim( $bool ) {
	return false;
}
add_filter( 'bronze_display_loading_logo', 'bronze_reset_loading_anim' );
add_filter( 'bronze_display_loading_overlay', 'bronze_reset_loading_anim' );
add_filter( 'bronze_default_page_loading_animation', 'bronze_reset_loading_anim' );
add_filter( 'bronze_default_page_transition_animation', 'bronze_reset_loading_anim' );

/**
 * Loading title markup
 */
function bronze_loading_animation_markup() {

	if ( 'none' !== bronze_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) {
		$logo_url = bronze_get_inherit_mod( 'loading_logo' );
		?>
	<div id="loading-overay">
		<?php if ( $logo_url ) : ?>
		<div class="loader-inner">
			<div id="loader">
				<div class="imgloading-container">
					<span style="background-image: url(<?php echo esc_url( $logo_url ); ?>)"></span>
				</div>
				<div class="imgloading-container-aux">
					<span style="background-image: url(<?php echo esc_url( $logo_url ); ?>)"></span>
				</div>
				<img id="loader-image" alt="loader image" src="<?php echo esc_url( $logo_url ); ?>">
			</div>
		</div>
		<?php endif; ?>
		<div class="loader-bg">
			<?php
			if ( bronze_get_inherit_mod( 'loading_overlay_bg' ) ) {

				$img_url = bronze_get_inherit_mod( 'loading_overlay_bg' );

				if ( is_numeric( bronze_get_inherit_mod( 'loading_overlay_bg' ) ) ) {
					$img_url = wp_get_attachment_url( bronze_get_inherit_mod( 'loading_overlay_bg' ) );
				}

				$style = ' style="background-image:url(' . esc_url( $img_url ) . ')" ';
			} else {
				$style = '';
			}
			?>
			<div class="loader-bg-top"><div <?php echo bronze_kses( $style ); ?>></div></div>
			<div class="loader-bg-bottom"><div <?php echo bronze_kses( $style ); ?>></div></div>
		</div>
	</div>
		<?php
	}
}
add_action( 'bronze_body_start', 'bronze_loading_animation_markup', 0 );

/*
--------------------------------------------------------------------

	FONTS

----------------------------------------------------------------------
*/

/**
 * Add custom fonts
 *
 * @param  array $google_fonts array of Google fonts.
 * @return array
 */
function bronze_add_google_font( $google_fonts ) {

	$default_fonts = array(
		'Open Sans'  => 'Open+Sans:400,700,900',
		'Roboto'     => 'Roboto:400,700,900',
		'Lato'       => 'Lato:400,700,900',
		'Montserrat' => 'Montserrat:400,500,600,700,900',
		'Oswald'     => 'Oswald',
	);

	foreach ( $default_fonts as $key => $value ) {
		if ( ! isset( $google_fonts[ $key ] ) ) {
			$google_fonts[ $key ] = $value;
		}
	}

	return $google_fonts;
}
add_filter( 'bronze_google_fonts', 'bronze_add_google_font' );

/**
 * Set team member social
 */
function bronze_set_team_member_socials( $socials ) {

	return array( 'facebook', 'twitter', 'instagram', 'youtube', 'spotify', 'soundcloud', 'bandsintown', 'vimeo', 'email' );
}
add_filter( 'wvc_team_member_socials', 'bronze_set_team_member_socials' );

/**
 * Add Spotify follow button to socials icons
 */
function bronze_add_socials_spotify_follow_button_param() {
	if ( function_exists( 'vc_add_param' ) ) {
		vc_add_param(
			'wvc_social_icons',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Spotify follow button', 'bronze' ),
				'param_name' => 'add_spotify_follow_button',
			)
		);
	}
}
add_action( 'init', 'bronze_add_socials_spotify_follow_button_param' );

function bronze_output_socials_spotify_follow_button( $string, $atts ) {

	// debug( $atts );

	if ( isset( $atts['add_spotify_follow_button'] ) && 'true' === $atts['add_spotify_follow_button'] ) {

		$spotify_url = wolf_vc_get_option( 'socials', 'spotify' );

		// debug( $spotify_url );

		if ( preg_match( '/https:\/\/open.spotify.com\/artist\/([A-Za-z0-9]+)/', $spotify_url, $match ) ) {
			if ( $match[1] ) {
				ob_start();
				?>
				<div class="wvc-social-icon spotiy-button-container">
					<iframe src="https://open.spotify.com/follow/1/?uri=spotify:artist:<?php echo esc_attr( $match[1] ); ?>&size=basic&theme=light&show-count=0" width="200" height="25" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowtransparency="true"></iframe>
				</div>
				<?php
				return ob_get_clean();
			}
		}
	}
}
add_filter( 'wvc_social_icons_end', 'bronze_output_socials_spotify_follow_button', 10, 2 );

/**
 * Added selector to menu_selectors
 *
 * @param  array $selectors navigation items CSS selectors.
 * @return array $selectors
 */
function bronze_add_menu_selectors( $selectors ) {

	$selectors[] = '.category-filter ul li a';
	$selectors[] = '.cart-panel-buttons a';
	$selectors[] = '.hamburger-icon:after';
	$selectors[] = '.hi-label';

	return $selectors;
}
add_filter( 'bronze_menu_selectors', 'bronze_add_menu_selectors' );
/**
 * Added selector to heading_family_selectors
 *
 * @param  array $selectors headings related CSS selectors.
 * @return array $selectors
 */
function bronze_add_heading_family_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.wvc-button';
	$selectors[] = '.wvc-svc-item-title';
	$selectors[] = '.button';
	$selectors[] = '.onsale, .category-label';
	$selectors[] = '.entry-post-grid_classic .sticky-post';
	$selectors[] = '.entry-post-metro .sticky-post';
	$selectors[] = 'input[type=submit], .wvc-mailchimp-submit';
	$selectors[] = '.nav-next,.nav-previous';
	$selectors[] = '.wvc-embed-video-play-button';
	// $selectors[] = '.category-filter ul li';
	$selectors[] = '.wvc-ati-title';
	$selectors[] = '.wvc-team-member-role';
	$selectors[] = '.wvc-svc-item-tagline';
	$selectors[] = '.entry-metro insta-username';
	$selectors[] = '.wvc-testimonial-cite';
	$selectors[] = '.theme-button-special';
	$selectors[] = '.theme-button-special-accent';
	$selectors[] = '.theme-button-special-accent-secondary';
	$selectors[] = '.theme-button-solid';
	$selectors[] = '.theme-button-outline';
	$selectors[] = '.theme-button-solid-accent';
	$selectors[] = '.theme-button-outline-accent';
	$selectors[] = '.theme-button-solid-accent-secondary';
	$selectors[] = '.theme-button-outline-accent-secondary';
	$selectors[] = '.theme-button-text';
	$selectors[] = '.theme-button-text-accent';
	$selectors[] = '.theme-button-text-accent-secondary';
	$selectors[] = '.wvc-wc-cat-title';
	$selectors[] = '.wvc-pricing-table-button a';
	// $selectors[] = '.load-more-button-line';
	$selectors[] = '.view-post';
	$selectors[] = '.wolf-gram-follow-button';
	// $selectors[] = '#bronze-percent';
	$selectors[] = '.wvc-pie-counter';
	$selectors[] = '.work-meta-label';
	$selectors[] = '.comment-reply-link';
	$selectors[] = '.logo-text, .date-block';
	$selectors[] = '.menu-button-primary a, .menu-button-secondary a';
	$selectors[] = '.single-post-nav-item > a, .post-nav-title, .related-posts .entry-title';

	return $selectors;
}
add_filter( 'bronze_heading_family_selectors', 'bronze_add_heading_family_selectors' );

/**
 * Added selector to heading_family_selectors
 *
 * @param  array $selectors headings related CSS selectors.
 * @return array $selectors
 */
function bronze_add_bronze_heading_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.wvc-svc-item-title';
	$selectors[] = '.wvc-wc-cat-title';
	$selectors[] = '.logo-text, .side-panel-logo-heading';

	$selectors[] = '.filter-link';
	$selectors[] = '.onsale, .category-label';
	$selectors[] = '.single-post-nav-item > a, .post-nav-title, .wvc-ils-item-title';
	// $selectors[] = '.menu-button-primary a, .menu-button-secondary a';

	return $selectors;
}
add_filter( 'bronze_heading_selectors', 'bronze_add_bronze_heading_selectors' );

/*
--------------------------------------------------------------------

	POST TYPES DISPLAY

----------------------------------------------------------------------
*/

/**
 * Get available display options for posts
 *
 * @return array
 */
function bronze_set_post_display_options() {

	return array(
		'grid'     => esc_html__( 'Grid', 'bronze' ),
		// 'grid_modern' => esc_html__( 'Grid Modern', 'bronze' ),
		'masonry'  => esc_html__( 'Masonry', 'bronze' ),
		// 'lateral' => esc_html__( 'Lateral', 'bronze' ),
		'standard' => esc_html__( 'Standard', 'bronze' ),
	);
}
add_filter( 'bronze_post_display_options', 'bronze_set_post_display_options' );

add_filter(
	'bronze_force_fullwidth_wvc_single_post',
	function( $bool ) {
		return false;
	}
);

/**
 * Get available display options for works
 *
 * @return array
 */
function bronze_set_work_display_options() {

	return array(
		'grid'    => esc_html__( 'Grid', 'bronze' ),
		'metro'   => esc_html__( 'Metro', 'bronze' ),
		'masonry' => esc_html__( 'Masonry', 'bronze' ),
		// 'parallax' => esc_html__( 'Parallax', 'bronze' ),
	);
}
add_filter( 'bronze_work_display_options', 'bronze_set_work_display_options' );

/**
 * Get available display options for products
 *
 * @return array
 */
function bronze_set_product_display_options() {

	return array(
		'grid' => esc_html__( 'Grid', 'bronze' ),
		// 'metro' => esc_html__( 'Metro', 'bronze' ),
	);
}
add_filter( 'bronze_product_display_options', 'bronze_set_product_display_options' );

/**
 * Set default shop display
 *
 * @param string $string
 * @return string
 */
function bronze_set_product_display( $string ) {

	return 'grid';
}
add_filter( 'bronze_mod_product_display', 'bronze_set_product_display' );

/**
 * Get available display options for releases
 *
 * @return array
 */
function bronze_set_release_display_options() {

	$layouts = array(
		'grid'       => esc_html__( 'Grid', 'bronze' ),
		'metro'      => esc_html__( 'Metro', 'bronze' ),
		// 'lateral' => esc_html__( 'Lateral', 'bronze' ),
		'offgrid'    => esc_html__( 'Off Grid', 'bronze' ),
		'brokengrid' => esc_html__( 'Broken Grid', 'bronze' ),
	);

	if ( bronze_is_wvc_activated() ) {
		$layouts['animated_cover'] = esc_html__( 'Animated Cover', 'bronze' );
	}

	return $layouts;
}
add_filter( 'bronze_release_display_options', 'bronze_set_release_display_options' );

/**
 * Add release hover effects
 */
function bronze_add_release_hover_effects() {
	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'wvc_release_index',
			array(
				array(
					'heading'    => esc_html__( 'Hover Effect', 'bronze' ),
					'param_name' => 'release_hover_effect',
					'type'       => 'dropdown',
					'value'      => array(
						// esc_html__( 'Zoom', 'bronze' ) => 'default',
						esc_html__( 'Simple', 'bronze' ) => 'simple',
						// esc_html__( 'Slide Up', 'bronze' ) => 'slide-up',
						esc_html__( 'Title Following Cursor', 'bronze' ) => 'cursor',
					),
					'dependency' => array(
						'element'            => 'release_display',
						'value_not_equal_to' => array( 'lateral' ),
					),
				),
			)
		);
	}
}
add_action( 'init', 'bronze_add_release_hover_effects' );

/**
 * Add release date in loop
 */
function wolfheme_add_release_date() {
	if ( 'upcoming' === get_post_meta( get_the_ID(), '_post_release_meta', true ) ) {
		if ( get_post_meta( get_the_ID(), '_wolf_release_date', true ) ) {
			$date                       = get_post_meta( get_the_ID(), '_wolf_release_date', true );
			list( $month, $day, $year ) = explode( '-', $date );
			$sql_date                   = $year . '-' . $month . '-' . $day . ' 00:00:00';
			$display_date               = mysql2date( get_option( 'date_format' ), $sql_date );
			echo '<span class="upcoming-release-date">';
			printf( esc_html__( 'Release %s', 'bronze' ), $display_date );
			echo '</span>';
		}
	}
}
add_action( 'bronze_loop_release_caption_end', 'wolfheme_add_release_date' );

/**
 *  Set default release hover effect
 *
 * @param string $string
 * @return string $string
 */
function bronze_set_release_hover_effect( $string ) {
	return 'simple';
}
add_filter( 'release_default_hover_effect', 'bronze_set_release_hover_effect', 40 );

/**
 * Get available display options for events
 *
 * @return array
 */
function bronze_set_event_display_options() {

	return array(
		'list' => esc_html__( 'List', 'bronze' ),
		'grid' => esc_html__( 'Grid', 'bronze' ),
	);
}
add_filter( 'bronze_event_display_options', 'bronze_set_event_display_options' );

/**
 * Discography "band" text
 */
function wolf_set_discography_band_string( $string ) {
	return esc_html__( 'Artist', 'bronze' );
}
add_filter( 'wolf_discography_band_string', 'wolf_set_discography_band_string', 40 );

/**
 * Set release taxonomy before string
 *
 * @param  string $string String to append before release taxonomy.
 * @return string
 */
function bronze_set_release_tax_before( $string ) {

	return esc_html__( 'by', 'bronze' ) . ' ';

}
add_filter( 'bronze_release_tax_before', 'bronze_set_release_tax_before' );

/*
--------------------------------------------------------------------

	THEME HOOKS

----------------------------------------------------------------------
*/

add_action(
	'init',
	function() {
		remove_action( 'bronze_body_start', 'bronze_side_panel' );
	}
);

add_action(
	'widgets_init',
	function() {
		unregister_sidebar( 'sidebar-side-panel' );
	}
);

/**
 * Overwrite sidepanel
 */

function bronze_overwrite_sidepanel() {

	if ( bronze_show_navigation_panels() ) {

		?>
	<div id="menu-overlay">
		<div id="menu-o-left" class="wvc-font-dark">
			<div class="menu-o-inner">
				<?php
				bronze_logo();

				$left_block_id = bronze_get_inherit_mod( 'nav_overlay_left_block_id' );

				if ( $left_block_id && function_exists( 'wccb_block' ) ) {
					/**
					 * Content Block
					 */
					echo wccb_block( $left_block_id );
				}
				?>
			</div>
		</div>
		<div id="menu-o-right" class="wvc-font-light">
			<div class="close toggle-custom-overlay-menu">
			<span class="name">close</span>
			<span class="x">
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 -151.2 853.2 853.2" enable-background="new 0 -151.2 853.2 853.2" xml:space="preserve">
<path d="M475.4,275.4L843.1-92.4c13.5-13.5,13.5-35.3,0-48.7c-13.5-13.5-35.3-13.5-48.7,0L426.6,226.6L58.8-141.1
	c-13.5-13.5-35.3-13.5-48.7,0c-13.5,13.5-13.5,35.3,0,48.7l367.8,367.8L10.1,643.2c-13.5,13.5-13.5,35.3,0,48.7
	c6.7,6.7,15.6,10.1,24.4,10.1s17.6-3.4,24.4-10.1l367.8-367.8l367.8,367.8c6.7,6.7,15.6,10.1,24.4,10.1s17.6-3.4,24.4-10.1
	c13.5-13.5,13.5-35.3,0-48.7L475.4,275.4z"></path>
</svg>			</span>
		</div>
			<div class="menu-o-inner">
				<?php

				$right_block_id = bronze_get_inherit_mod( 'nav_overlay_right_block_id' );

				if ( $right_block_id && function_exists( 'wccb_block' ) ) {
					/**
					 * Content Block
					 */
					echo wccb_block( $right_block_id );
				}
				?>
			</div>
		</div>
	</div>
		<?php
	} // endif
}
add_action( 'bronze_body_start', 'bronze_overwrite_sidepanel' );

/**
 * Disable single post pagination
 *
 * @param bool $bool
 * @return bool
 */
function bronze_do_disable_single_pagination( $bool ) {

	if ( is_singular( 'product' ) ) {
		return true;
	}

}
add_filter( 'bronze_disable_single_post_pagination', 'bronze_do_disable_single_pagination' );


/**
 * Login popup markup
 */
function bronze_login_form_markup() {
	if ( function_exists( 'wvc_login_form' ) && class_exists( 'WooCommerce' ) ) {

		$skin_class = apply_filters( 'bronze_login_form_container_class', 'wvc-font-dark' );
		?>
		<div id="loginform-overlay">
			<div id="loginform-overlay-inner">
				<div id="loginform-overlay-content" class="<?php echo esc_attr( $skin_class ); ?>">
					<a href="#" id="close-vertical-bar-menu-icon" class="close-panel-button close-loginform-button">X</a>
					<?php
						// phpcs:ignore
						// echo wvc_login_form();
					?>
				</div>
			</div>
		</div>
		<?php
	}
}
add_action( 'bronze_body_start', 'bronze_login_form_markup', 5 );

add_filter(
	'wvc_login_form_submit_button_class',
	function( $class ) {
		$class = 'button theme-button-solid';

		return $class;
	}
);

// add_filter( 'wvc_mailchimp_submit_class', function( $class ) {

// $class .= ' button theme-button-solid';

// return $class;
// } );

add_filter(
	'bronze_proceed_to_checkout_button_class',
	function( $class ) {
		$class = 'checkout-button button theme-button-solid';

		return $class;
	}
);

add_filter(
	'bronze_site_footer_class',
	function( $class ) {
		return 'wvc-font-light wvc-parent-row ' . $class;
	}
);

add_filter(
	'wvc_last_posts_big_slider_caption_container_additional_class',
	function( $class ) {
		return 'wvc-font-light wvc-row-bg-transparent';
	}
);

/**
 * Default separtor height
 */
add_filter(
	'wvc_separator_default_height',
	function( $string ) {
		return '3px';
	}
);

/**
 * Default separtor height
 */
add_filter(
	'wvc_separator_default_width',
	function( $string ) {
		return '50px';
	}
);

/**
 *  Add Mailchimp button class param
 */
function bronze_add_mailchimp_button_param() {

	if ( function_exists( 'vc_add_param' ) ) {
		vc_add_param(
			'wvc_mailchimp',
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Submit Button Style', 'bronze' ),
				'param_name' => 'submit_button_class',
				'value'      => array(
					esc_html__( 'Solid Accent', 'bronze' ) => 'theme-button-solid-accent',
					esc_html__( 'Outline', 'bronze' ) => 'theme-button-outline',
					esc_html__( 'Solid', 'bronze' ) => 'theme-button-solid',
					esc_html__( 'Special', 'bronze' ) => 'theme-button-special',
					esc_html__( 'Outline Accent', 'bronze' ) => 'theme-button-outline-accent',
					esc_html__( 'Special Accent', 'bronze' ) => 'theme-button-special-accent',
				),
			)
		);
	}
}
add_action( 'init', 'bronze_add_mailchimp_button_param' );

/**
 * One Letter Logo filter
 *
 * @param string $html The HTML markup.
 * @return string
 */
function bronze_filter_logo_output( $html ) {

	if ( bronze_get_inherit_mod( 'one_letter_logo' ) ) {
		$html = '<div class="logo logo-is-text one-letter-logo"><a class="logo-text logo-link" href="' . esc_url( home_url( '/' ) ) . '" rel="home">';

		$html .= bronze_get_inherit_mod( 'one_letter_logo' );

		$html .= '</a></div>';
	}

	return $html;

}
add_filter( 'bronze_logo_html', 'bronze_filter_logo_output' );

/**
 * Add currency switcher
 */
function bronze_output_currency_switcher() {

	$cta_content = bronze_get_inherit_mod( 'menu_cta_content_type', 'none' );

	$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == bronze_get_woocommerce_shop_page_id() && bronze_get_woocommerce_shop_page_id(); // phpcs:ignore
	$is_wc            = bronze_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

	if ( apply_filters( 'bronze_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case.
		$cta_content = 'shop_icons';
	}

	if ( 'shop_icons' === $cta_content && bronze_get_inherit_mod( 'currency_switcher' ) ) {

		if ( function_exists( 'wwcs_currency_switcher' ) ) {
			echo '<div class="cta-item currency-switcher">';
			wwcs_currency_switcher();
			echo '</div>';
		} elseif ( defined( 'WOOCS_VERSION' ) ) {
			echo '<div class="cta-item currency-switcher">';
			echo do_shortcode( '[woocs style=1]' );
			echo '</div>';
		}
	}
}
add_action( 'bronze_secondary_menu', 'bronze_output_currency_switcher', 100 );

/**
 * Overwrite standard post entry slider image size
 */
function bronze_overwrite_entry_slider_img_size( $size ) {

	 add_filter(
		'bronze_entry_slider_image_size',
		function() {
			return '847x508';
		}
	);
	add_image_size( 'bronze-masonry', 700, 1500, false );
}
add_action( 'after_setup_theme', 'bronze_overwrite_entry_slider_img_size', 50 );

add_action(
	'init',
	function() {
		add_image_size( 'bronze-related-post-thumbnail', 290, 290, true );
	}
);

/**
 * Single release image size
 */
add_filter(
	'bronze_release_img_size',
	function() {
		return '445x445';
	}
);



/*
--------------------------------------------------------------------

	NAVIGATION

----------------------------------------------------------------------
*/

/**
 * Set sticky menu scrollpoint
 *
 * @param int|string $int
 * @return int
 */
function bronze_set_sticky_menu_scrollpoint( $int ) {

	$int = 200;

	return $int;
}
add_filter( 'bronze_sticky_menu_scrollpoint', 'bronze_set_sticky_menu_scrollpoint' );

/**
 * Add vertical menu location
 */
function bronze_add_lateral_menu( $menus ) {

	$menus['vertical'] = esc_html__( 'Vertical Menu (optional)', 'bronze' );

	return $menus;

}
add_filter( 'bronze_menus', 'bronze_add_lateral_menu' );

/**
 * Set mobile menu template
 *
 * @param string $string Mobile menu template slug.
 * @return string
 */
function bronze_set_mobile_menu_template( $string ) {

	return 'content-mobile-alt';
}
add_filter( 'bronze_mobile_menu_template', 'bronze_set_mobile_menu_template' );

/**
 * Add mobile closer overlay
 */
function bronze_add_mobile_panel_closer_overlay() {
	?>
	<div id="mobile-panel-closer-overlay" class="panel-closer-overlay toggle-mobile-menu"></div>
	<?php
}
add_action( 'bronze_main_content_start', 'bronze_add_mobile_panel_closer_overlay' );

/**
 * Mobile menu
 */
function bronze_mobile_alt_menu() {
	?>
	<div id="mobile-menu-panel">
		<a href="#" id="close-mobile-menu-icon" class="close-panel-button toggle-mobile-menu">X</a>
		<div id="mobile-menu-panel-inner">
		<?php
			/**
			 * Menu
			 */
			bronze_primary_mobile_navigation();
		?>
		</div><!-- .mobile-menu-panel-inner -->
	</div><!-- #mobile-menu-panel -->
	<?php
}
add_action( 'bronze_body_start', 'bronze_mobile_alt_menu' );

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on cuzstimizer option
 */
function bronze_output_mobile_complementary_menu( $context = 'desktop' ) {
	if ( 'mobile' === $context ) {
		$cta_content = bronze_get_inherit_mod( 'menu_cta_content_type', 'none' );

		/**
		 * Force shop icons on woocommerce pages
		 */
		$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == bronze_get_woocommerce_shop_page_id() && bronze_get_woocommerce_shop_page_id(); // phpcs:ignore
		$is_wc            = bronze_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

		if ( apply_filters( 'bronze_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case.
			$cta_content = 'shop_icons';
		}

		if ( 'shop_icons' === $cta_content ) {
			if ( bronze_display_account_menu_item() ) :
				?>
				<div class="account-container cta-item">
					<?php
						/**
						 * account icon
						 */
						bronze_account_menu_item();
					?>
				</div><!-- .cart-container -->
				<?php
			endif;

			if ( bronze_display_cart_menu_item() ) {
				?>
				<div class="cart-container cta-item">
					<?php
						/**
						 * Cart icon
						 */
						bronze_cart_menu_item();
					?>
				</div><!-- .cart-container -->
				<?php
			}
		}
	}
}
add_action( 'bronze_secondary_menu', 'bronze_output_mobile_complementary_menu', 10, 1 );

/**
 * Sidepanel font class
 */
function bronze_set_sidepanel_font_class( $class ) {

	if ( bronze_get_inherit_mod( 'side_panel_bg_img' ) ) {
		$class .= ' wvc-font-light';
	} else {
		if ( 'light' === bronze_get_color_tone( bronze_get_inherit_mod( 'submenu_background_color' ) ) ) {
			$class .= ' wvc-font-dark';
		} else {
			$class .= ' wvc-font-light';
		}
	}

	return $class;
}
add_filter( 'bronze_side_panel_class', 'bronze_set_sidepanel_font_class' );

/**
 *  Enable side panel with overlay menu
 *
 * @param string $layouts
 * @return string $layouts
 */
function bronze_set_excluded_side_panel_menu_layout( $layouts ) {

	$overlay_key = null;
	foreach ( $layouts as $key => $value ) {
		if ( 'overlay' === $value ) {
			$overlay_key = $key;
		}
	}

	if ( $overlay_key && isset( $layouts[ $overlay_key ] ) ) {
		unset( $layouts[ $overlay_key ] );
	}

	return $layouts;
}
add_filter( 'bronze_excluded_side_panel_menu_layout', 'bronze_set_excluded_side_panel_menu_layout', 40 );

/*
--------------------------------------------------------------------

	THEME FILTERS

----------------------------------------------------------------------
*/

/**
 * Add additional JS scripts and functions
 */
function bronze_enqueue_additional_scripts() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : bronze_get_theme_version();

	if ( ! bronze_is_wvc_activated() ) {

		wp_register_style( 'ionicons', get_template_directory_uri() . '/assets/css/lib/fonts/ionicons/ionicons.min.css', array(), bronze_get_theme_version() );
		wp_register_style( 'elegant-icons', get_template_directory_uri() . '/assets/css/lib/fonts/elegant-icons/elegant-icons.min.css', array(), bronze_get_theme_version() );
		wp_register_style( 'dripicons', get_template_directory_uri() . '/assets/css/lib/fonts/dripicons-v2/dripicons.min.css', array(), bronze_get_theme_version() );
		wp_register_style( 'iconmonstr-iconic-font', get_template_directory_uri() . '/assets/css/lib/fonts/iconmonstr-iconic-font/iconmonstr-iconic-font.min.css', array(), bronze_get_theme_version() );

		wp_register_script( 'wvc-accordion', get_template_directory_uri() . '/assets/js/wc-accordion.js', array( 'jquery' ), $version, true );
	}

	wp_register_script( 'visible', get_template_directory_uri() . '/assets/js/lib/jquery.visible.min.js', array( 'jquery' ), '1.3.0', true );

	if ( is_singular( 'product' ) ) {
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'wvc-accordion' );
	}

	if ( is_singular( 'event' ) && bronze_is_wvc_activated() ) {
		wp_enqueue_style( 'wolficons' );
	}

	// wp_enqueue_style( 'ionicons' );
	wp_enqueue_style( 'dripicons' );
	wp_enqueue_style( 'elegant-icons' );
	wp_enqueue_style( 'iconmonstr-iconic-font' );

	// wp_enqueue_script( 'visible' );
	wp_enqueue_script( 'jquery-effects-core' );
	wp_enqueue_script( 'parallax-scroll' );
	wp_enqueue_script( 'bronze-custom', get_template_directory_uri() . '/assets/js/t/bronze.js', array( 'jquery' ), $version, true );

	if ( 'hard' === bronze_get_inherit_mod( 'menu_sticky_type' ) ) {
		wp_localize_script(
			'wolftheme',
			'WolfFrameworkJSParams',
			array(
				'menuOffsetDesktop'    => 66,
				'menuOffsetMobile'     => 66,
				'menuOffsetBreakpoint' => 66,
				'menuOffset'           => 66,
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'bronze_enqueue_additional_scripts', 40 );

/**
 * Add addictional post class
 *
 * @param array
 * @return array
 */
function bronze_additional_post_classes( $classes ) {

	$post_id        = get_the_ID();
	$post_type      = get_post_type();
	$force_is_loop  = apply_filters( 'bronze_post_force_loop_class', false );
	$loop_condition = ( ! is_single() && ! is_search() ) || bronze_is_portfolio() || bronze_is_videos() || bronze_is_blog() || $force_is_loop || ( is_search() && bronze_is_woocommerce_page() );

	// debug(  $loop_condition );

	if ( $loop_condition ) {
		if ( in_array( $post_type, array( 'post', 'work', 'product', 'video', 'release', 'event' ) ) ) {
			$skin = bronze_get_inherit_mod( $post_type . '_skin', '', $post_id );
			if ( $skin ) {
				$classes[] = 'entry-post-skin-' . $skin;
			}
		}

		if ( 'product' === $post_type ) {
			global $product;

			if ( $product->get_gallery_image_ids() ) {
				$classes[] = 'entry-product-has-gallery';
			}
		}
	} elseif ( is_singular( 'product' ) ) {
		$skin = bronze_get_inherit_mod( $post_type . '_skin', '', $post_id );
		if ( $skin ) {
			$classes[] = 'entry-post-skin-' . $skin;
		}
	}

	return $classes;
}
add_filter( 'post_class', 'bronze_additional_post_classes' );

/**
 * Add addictional body class
 *
 * @param array
 * @return array
 */
function bronze_additional_body_classes( $classes ) {

	// $classes[] = 'mobile-menu-alt';

	$sticky_details_meta   = bronze_get_inherit_mod( 'product_sticky' ) && 'no' !== bronze_get_inherit_mod( 'product_sticky' );
	$single_product_layout = bronze_get_inherit_mod( 'product_single_layout' );

	if ( is_singular( 'product' ) && $sticky_details_meta && 'sidebar-right' !== $single_product_layout && 'sidebar-left' !== $single_product_layout ) {
		$classes[] = 'sticky-product-details';
	}

	if ( bronze_get_theme_mod( 'custom_cursor' ) ) {
		$classes[] = 'custom-cursor-enabled';
	}

	if ( get_post_meta( bronze_get_the_id(), '_post_horizontal_scroller', true ) ) {
		$classes[] = 'horizontal-scroller';
	}

	if ( class_exists( 'Wolf_Share' ) ) {
		$classes[] = 'wolf-share';
	}

	if ( bronze_get_inherit_mod( 'sticky_menu_transparent' ) ) {
		$classes[] = 'sticky-menu-transparent';
	}

	if ( bronze_get_inherit_mod( 'hide_single_post_featured_image' ) && is_singular( 'release' ) ) {
		$classes[] = 'hide-release-featured-image';
	}

	if ( bronze_get_inherit_mod( 'accent_color' ) === '#49ffde' ) {
		$classes[] = 'button-color-adjust';
	}

	return $classes;

}
add_filter( 'body_class', 'bronze_additional_body_classes' );

add_action(
	'wp_head',
	function() {
		remove_action( 'bronze_body_start', 'bronze_scroll_top_link' );
	}
);

add_action(
	'wvc_arrow_down_start',
	function() {
		echo '<span class="wvc-arrow-down-inner"></span>';
	},
	99
);

/**
 * Set overlay effects
 *
 * @param array $atts
 * @return string $html
 */
function bronze_set_bg_effects( $atts ) {

	if ( isset( $atts['add_filmgrain'] ) || isset( $atts['add_grunge'] ) || isset( $atts['add_noise'] ) ) {
		$atts['add_effect'] = true;
	}

	return $atts;
}
add_filter( 'wvc_row_atts', 'bronze_set_bg_effects' );
add_filter( 'wvc_row_inner_atts', 'bronze_set_bg_effects' );
add_filter( 'wvc_column_atts', 'bronze_set_bg_effects' );
add_filter( 'wvc_column_inner_atts', 'bronze_set_bg_effects' );
add_filter( 'wvc_advanced_slider_atts', 'bronze_set_bg_effects' );
add_filter( 'wvc_interactive_link_item_bg_atts', 'bronze_set_bg_effects' );

/**
 * Get row overlay effects
 *
 * @param string $html
 * @param array  $atts
 * @return string $html
 */
function bronze_get_overlay_effects( $html, $atts ) {

	if ( isset( $atts['add_filmgrain'] ) && $atts['add_filmgrain'] ) {
		ob_start();
		?>
		<div class="row-bg-filmgrain"></div>
		<?php
		$html .= ob_get_clean();
	}

	if ( isset( $atts['add_grunge'] ) && $atts['add_grunge'] ) {
		ob_start();
		?>
		<div class="row-bg-grunge"></div>
		<?php
		$html .= ob_get_clean();
	}

	if ( isset( $atts['add_noise'] ) && $atts['add_noise'] ) {
		ob_start();
		?>
		<div class="row-bg-noise"></div>
		<?php
		$html .= ob_get_clean();
	}

	return $html;
}
add_filter( 'wvc_background_effect', 'bronze_get_overlay_effects', 10, 2 );

/**
 * Scroll to top arrow
 */
function bronze_overwrite_scroll_top_link() {
	?>
	<a href="#top" id="back-to-top"><span id="back-to-top-inner"></span></a>
	<?php
}
add_action( 'bronze_body_start', 'bronze_overwrite_scroll_top_link' );

function bronze_show_navigation_panels() {
	if ( bronze_get_inherit_mod( 'nav_overlay_left_block_id' )
		&& bronze_get_inherit_mod( 'nav_overlay_right_block_id' )
		&& 'none' !== bronze_get_inherit_mod( 'nav_overlay_left_block_id' )
		&& 'none' !== bronze_get_inherit_mod( 'nav_overlay_right_block_id' )
	) {
		return true;
	}
}

/**
 * Overwrite hamburger icon
 */
function bronze_set_hamburger_icon( $html, $class, $title_attr ) {

	$html = '';

	if ( bronze_show_navigation_panels() ) {

		if ( 'toggle-side-panel' === $class ) {

			$class = 'toggle-custom-overlay-menu';

			$title_attr = esc_html__( 'Side Panel', 'bronze' );

		} else {
			$title_attr = esc_html__( 'Menu', 'bronze' );
		}

		$menu_label = bronze_get_inherit_mod( 'overlay_menu_label', 'Menu' );

		ob_start();
		?>
		<?php if ( $menu_label ) : ?>
			<span class="hi-label <?php echo esc_attr( $class ); ?>"><?php esc_attr( $menu_label ); ?></span>
		<?php endif; ?>
		<a class="hamburger-link <?php echo esc_attr( $class ); ?>" href="#" title="<?php echo esc_attr( $title_attr ); ?>">
			<span class="hamburger-icon">
				<span class="line line-first"></span>
				<span class="line line-second"></span>
				<span class="cross">
					<span></span>
					<span></span>
				</span>
			</span>

		</a>
		<?php
		$html = ob_get_clean();
	} // endif

	return $html;

}
add_filter( 'bronze_hamburger_icon', 'bronze_set_hamburger_icon', 10, 3 );

/**
 * Disable single post pagination
 *
 * @param bool $bool
 * @return bool
 */
add_filter( 'bronze_disable_single_post_pagination', '__return_true' );

/**
 * Filter single work title
 *
 * @param string $string
 * @return string
 */
function bronze_set_single_work_title( $string ) {

	return esc_html__( 'Details & Info', 'bronze' );
}
add_filter( 'bronze_single_work_title', 'bronze_set_single_work_title', 40 );

/**
 * Excerpt more
 *
 * Add span to allow more CSS tricks
 *
 * @return string
 */
function bronze_custom_more_text( $string ) {

	$text = '<small class="wvc-button-background-fill"></small><span>' . esc_html__( 'Continue reading', 'bronze' ) . '</span>';

	return $text;
}
add_filter( 'bronze_more_text', 'bronze_custom_more_text', 40 );

/**
 * Set related posts text
 *
 * @param string $string
 * @return string
 */
function bronze_set_related_posts_text( $text ) {

	return esc_html__( 'You May Also Like', 'bronze' );
}
add_filter( 'bronze_related_posts_text', 'bronze_set_related_posts_text' );

/**
 * Returns large
 */
function bronze_set_large_metro_thumbnail_size() {
	return 'large';
}

/**
 * Filter metro thumnail size depending on row context
 */
function bronze_optimize_metro_thumbnail_size( $atts ) {

	$column_type   = isset( $atts['column_type'] ) ? $atts['column_type'] : null;
	$content_width = isset( $atts['content_width'] ) ? $atts['content_width'] : null;

	if ( 'column' === $column_type ) {
		if ( 'full' === $content_width || 'large' === $content_width ) {
			add_filter( 'bronze_metro_thumbnail_size_name', 'bronze_set_large_metro_thumbnail_size' );
		}
	}
}
add_action( 'wvc_add_row_filters', 'bronze_optimize_metro_thumbnail_size', 10, 1 );

/* Remove metro thumbnail size filter */
add_action(
	'wvc_remove_row_filters',
	function() {
		remove_filter( 'bronze_metro_thumbnail_size_name', 'bronze_set_large_metro_thumbnail_size' );
	}
);

/**
 * Filter post modules
 *
 * @param array $atts
 * @return array $atts
 */
function bronze_filter_post_module_atts( $atts ) {

	$post_type           = $atts['post_type'];
	$affected_post_types = array( 'work' );

	if ( in_array( $post_type, $affected_post_types ) ) {
		if ( isset( $atts[ $post_type . '_display' ] ) && 'offgrid' === $atts[ $post_type . '_display' ] ) {
			$atts['item_animation']         = '';
			$atts[ $post_type . '_layout' ] = 'standard';
		}
	}

	if ( isset( $atts[ $post_type . '_hover_effect' ] ) ) {

		if ( 'simple' === $atts[ $post_type . '_hover_effect' ] ) {
			// $atts[ $post_type . '_layout' ] = 'overlay';
		}

		if ( 'zoom' === $atts[ $post_type . '_hover_effect' ] ) {
			$atts[ $post_type . '_layout' ] = 'overlay';
			// $atts[ 'overlay_color' ] = '';
			// $atts[ $post_type . '_display' ] = 'grid';
		}

		if ( 'slide' === $atts[ $post_type . '_hover_effect' ] ) {
			$atts[ $post_type . '_layout' ] = 'overlay';
		}

		if ( 'glitch' === $atts[ $post_type . '_hover_effect' ] ) {
			// $atts[ $post_type . '_layout' ] = 'overlay';
		}

		if ( 'cursor' === $atts[ $post_type . '_hover_effect' ] ) {

			$atts[ $post_type . '_layout' ] = 'standard';

			if ( 'list' === $post_type . '_display' ) {
				$atts[ $post_type . '_display' ] = 'grid';
			}
		}
	}

	return $atts;
}
add_filter( 'bronze_post_module_atts', 'bronze_filter_post_module_atts' );

/**
 * No header post types
 *
 * @param  array $post_types Post types where the default hero block is disabled.
 * @return array
 */
function bronze_filter_no_hero_post_types( $post_types ) {

	$post_types = array( 'attachment' );

	return $post_types;
}
add_filter( 'bronze_no_header_post_types', 'bronze_filter_no_hero_post_types', 40 );

/**
 *
 */
function bronze_show_shop_header_content_block_single_product( $bool ) {

	if ( is_singular( 'product' ) ) {
		$bool = true;
	}

	return $bool;
}
add_filter( 'bronze_force_display_shop_after_header_block', 'bronze_show_shop_header_content_block_single_product' );

/**
 * Read more text
 */
function bronze_view_post_text( $string ) {
	return esc_html__( 'Read more', 'bronze' );
}
add_filter( 'bronze_view_post_text', 'bronze_view_post_text' );

/**
 * Filter empty p tags in excerpt
 */
function bronze_filter_excerpt_empty_p_tags( $excerpt ) {

	return str_replace( '<p></p>', '', $excerpt );

}
add_filter( 'get_the_excerpt', 'bronze_filter_excerpt_empty_p_tags', 100 );

/**
 *  Set entry slider animation
 *
 * @param string $animation
 * @return string $animation
 */
function bronze_set_entry_slider_animation( $animation ) {
	return 'slide';
}
add_filter( 'bronze_entry_slider_animation', 'bronze_set_entry_slider_animation', 40 );

/**
 * Search form placeholder
 */
function bronze_set_searchform_placeholder( $string ) {
	return esc_attr_x( 'Search&hellip;', 'placeholder', 'bronze' );
}
add_filter( 'bronze_searchform_placeholder', 'bronze_set_searchform_placeholder', 40 );
add_filter( 'bronze_product_searchform_placeholder', 'bronze_set_searchform_placeholder', 40 );

/**
 * Search form placeholder text
 */
function bronze_searchform_placeholder_text( $string ) {
	return esc_html__( 'Type your search and hit enter&hellip;', 'bronze' );
}
add_filter( 'bronze_searchform_placeholder', 'bronze_searchform_placeholder_text' );

/**
 * Add form in no result page
 */
function bronze_add_no_result_form() {
	get_search_form();
}
add_action( 'bronze_no_result_end', 'bronze_add_no_result_form' );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function bronze_set_smooth_scroll_speed( $speed ) {
	return 2500;
}
add_filter( 'bronze_smooth_scroll_speed', 'bronze_set_smooth_scroll_speed' );
add_filter( 'wvc_smooth_scroll_speed', 'bronze_set_smooth_scroll_speed' );

/**
 *  Set smooth scroll easing effect
 *
 * @param string $ease
 * @return string $ease
 */
function bronze_set_smooth_scroll_ease( $ease ) {
	return 'easeInOutQuint';
}
add_filter( 'bronze_smooth_scroll_ease', 'bronze_set_smooth_scroll_ease' );
add_filter( 'wvc_smooth_scroll_ease', 'bronze_set_smooth_scroll_ease' );
add_filter( 'wvc_fp_easing', 'bronze_set_smooth_scroll_ease' );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function bronze_set_fp_anim_time( $speed ) {

	$speed = 1500;

	if ( is_page() || is_single() ) {
		if ( get_post_meta( bronze_get_the_id(), '_post_fullpage_animtime', true ) ) {
			$speed = absint( get_post_meta( bronze_get_the_id(), '_post_fullpage_animtime', true ) );
		}
	}

	return $speed;
}
add_filter( 'wvc_fp_animtime', 'bronze_set_fp_anim_time', 40 );

/**
 * Filter lightbox settings
 */
function bronze_filter_lightbox_settings( $settings ) {

	$settings['transitionEffect'] = 'fade';
	$settings['buttons']          = array(
		'zoom',
		// 'share',
		'close',
	);

	return $settings;
}
add_filter( 'bronze_fancybox_settings', 'bronze_filter_lightbox_settings' );

/**
 * Save modal window content after import
 */
function bronze_set_modal_window_content_after_import() {
	$post = get_page_by_title( 'Modal Window Content', OBJECT, 'wvc_content_block' );

	if ( $post && function_exists( 'wvc_update_option' ) ) {
		wvc_update_option( 'modal_window', 'content_block_id', $post->ID );
	}
}
add_action( 'pt-ocdi/after_import', 'bronze_set_modal_window_content_after_import' );

/**
 * ADD META FIELD TO SEARCH QUERY
 *
 * @param string $field
 */
function bronze_add_meta_field_to_search_query( $field ) {

	if ( isset( $GLOBALS['added_meta_field_to_search_query'] ) ) {
		$GLOBALS['added_meta_field_to_search_query'][] = '\'' . $field . '\'';
		return;
	}

	$GLOBALS['added_meta_field_to_search_query']   = array();
	$GLOBALS['added_meta_field_to_search_query'][] = '\'' . $field . '\'';

	add_filter(
		'posts_join',
		function( $join ) {
			global $wpdb;

			if ( is_search() ) {
				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
			}

			return $join;
		}
	);

	add_filter(
		'posts_groupby',
		function( $groupby ) {
			global $wpdb;

			if ( is_search() ) {
				$groupby = "$wpdb->posts.ID";
			}

			return $groupby;
		}
	);

	add_filter(
		'posts_search',
		function( $search_sql ) {
			global $wpdb;

			$search_terms = get_query_var( 'search_terms' );

			if ( ! empty( $search_terms ) ) {
				foreach ( $search_terms as $search_term ) {
					$old_or     = "OR ({$wpdb->posts}.post_content LIKE '{$wpdb->placeholder_escape()}{$search_term}{$wpdb->placeholder_escape()}')";
					$new_or     = $old_or . " OR ({$wpdb->postmeta}.meta_value LIKE '{$wpdb->placeholder_escape()}{$search_term}{$wpdb->placeholder_escape()}' AND {$wpdb->postmeta}.meta_key IN (" . implode( ', ', $GLOBALS['added_meta_field_to_search_query'] ) . '))';
					$search_sql = str_replace( $old_or, $new_or, $search_sql );
				}
			}

			$search_sql = str_replace( ' ORDER BY ', " GROUP BY $wpdb->posts.ID ORDER BY ", $search_sql );

			return $search_sql;
		}
	);
}
bronze_add_meta_field_to_search_query( '_post_subheading' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function bronze_edit_color_scheme_css( $output, $colors ) {

	extract( $colors );

	$output = '';

	$overlay_accent_bg_color = vsprintf( 'rgba( %s, 0.95)', bronze_hex_to_rgb( $accent_color ) );
	$border_color            = vsprintf( 'rgba( %s, 0.03)', bronze_hex_to_rgb( $strong_text_color ) );
	$overlay_panel_bg_color  = vsprintf( 'rgba( %s, 0.95)', bronze_hex_to_rgb( $submenu_background_color ) );

	$font_skin = ( 'light' === bronze_get_color_scheme_option() ) ? 'dark' : 'light';

	$link_selector       = '.link, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview)';
	$link_selector_after = '.link:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview):after';

	$output .= "/* Color Scheme */

	/* Body Background Color */
	body,
	.frame-border{
		background-color: $body_background_color;
	}

	/* Page Background Color */
	.site-header,
	.post-header-container,
	.content-inner,
	.loading-overlay,
	.no-hero #hero,
	.wvc-font-default{
		background-color: $page_background_color;
	}

	/* Submenu color */
	#site-navigation-primary-desktop .mega-menu-panel,
	#site-navigation-primary-desktop ul.sub-menu,
	#mobile-menu-panel,
	.offcanvas-menu-panel,
	.lateral-menu-panel,
	.cart-panel,
	.wwcs-selector,
	.currency-switcher .woocs-style-1-dropdown .woocs-style-1-dropdown-menu{
		background:$submenu_background_color;
	}

	.currency-switcher .woocs-style-1-dropdown .woocs-style-1-dropdown-menu li{
		background-color:$submenu_background_color!important;
	}

	.cart-panel{
		background:$submenu_background_color!important;
	}

	.panel-closer-overlay{
		//background:$submenu_background_color;
	}

	.overlay-menu-panel{
		background:$overlay_panel_bg_color;
	}

	/* Sub menu Font Color */
	.nav-menu-desktop li ul li:not(.menu-button-primary):not(.menu-button-secondary) .menu-item-text-container,
	.nav-menu-desktop li ul.sub-menu li:not(.menu-button-primary):not(.menu-button-secondary).menu-item-has-children > a:before,
	.nav-menu-desktop li ul li.not-linked > a:first-child .menu-item-text-container,
	.mega-menu-tagline-text,
	.wwcs-selector,
	.currency-switcher .woocs-style-1-dropdown .woocs-style-1-dropdown-menu,
	.widget .woocommerce-Price-amount{
		color: $submenu_font_color;
	}

	.cart-panel,
	.cart-panel a,
	.cart-panel strong,
	.cart-panel b{
		color: $submenu_font_color!important;
	}

	#close-side-panel-icon{
		color: $submenu_font_color!important;
	}

	.nav-menu-vertical li a,
	.nav-menu-mobile li a,
	.nav-menu-vertical li.menu-item-has-children:before,
	.nav-menu-vertical li.page_item_has_children:before,
	.nav-menu-vertical li.active:before,
	.nav-menu-mobile li.menu-item-has-children:before,
	.nav-menu-mobile li.page_item_has_children:before,
	.nav-menu-mobile li.active:before{
		color: $submenu_font_color!important;
	}

	.lateral-menu-panel .wvc-icon:before{
		color: $submenu_font_color!important;
	}

	.nav-menu-desktop li ul.sub-menu li.menu-item-has-children > a:before{
		color: $submenu_font_color;
	}

	.cart-panel,
	.cart-panel a,
	.cart-panel strong,
	.cart-panel b{
		color: $submenu_font_color!important;
	}

	/* Accent Color */
	.accent{
		color:$accent_color;
	}

	.accent-color-is-black .wvc-font-color-light .accent{
		color:white;
	}

	.logo-text:after,
	.side-panel-logo-heading:after{
		background-color:$accent_color;
	}

	/*#staaw-loading-point,
	.star-rating{
		color:$accent_color;
	}*/


	.price-box,
	.category-filter ul li a:after,
	.theme-heading:after,
	.highlight:after,
	.highlight-primary:after,
	span.onsale{
		background-color:$accent_color;
	}

	.product-layout-box-style-1 .quickview-product-add-to-cart-icon:before,
	.wvc-single-image-overlay-title span:after,
	.work-meta-value a:hover{
		color:$accent_color;
	}

	.nav-menu li.sale .menu-item-text-container:before,
	.nav-menu-mobile li.sale .menu-item-text-container:before
	{
		background:$accent_color!important;
	}


	.entry-post-skin-light:not(.entry-post-standard).entry-video:hover .video-play-button {
 	border-left-color:$accent_color!important;
}

	.entry-post-standard .entry-thumbnail-overlay{
		/*background-color:$overlay_accent_bg_color;*/
	}

	.widget_price_filter .ui-slider .ui-slider-range,
	mark,
	p.demo_store,
	.woocommerce-store-notice{
		background-color:$accent_color;
	}

	/* Buttons */

	.theme-button-text-accent,
	.nav-button-text-accent .menu-item-inner{
		color:$accent_color;
	}

	.theme-button-special-accent,
	.theme-button-solid-accent,
	.theme-button-outline-accent:hover,
	.nav-button-special-accent .menu-item-inner,
	.nav-button-solid-accent .menu-item-inner,
	.nav-button-outline-accent:hover .menu-item-inner{
		border-color:$accent_color!important;
		background-color:$accent_color!important;
	}

	.entry-post-standard .entry-title a:hover,
	.entry-post-standard .entry-meta a:hover,
	.entry-post-grid .entry-title a:hover,
	.entry-post-grid .entry-meta a:hover,
	.entry-post-masonry .entry-title a:hover,
	.entry-post-masonry .entry-meta a:hover{
		color:$accent_color!important;
	}

	.wolf-twitter-widget a.wolf-tweet-link:hover,
	.widget.widget_categories a:hover,
	.widget.widget_pages a:hover,
	.widget .tagcloud a:hover,
	.widget.widget_recent_comments a:hover,
	.widget.widget_recent_entries a:hover,
	.widget.widget_archive a:hover,
	.widget.widget_meta a:hover,
	.widget.widget_product_categories a:hover,
	.widget.widget_nav_menu a:hover,
	a.rsswidget:hover,
	.wvc-font-$font_skin .wolf-twitter-widget a.wolf-tweet-link:hover,
	.wvc-font-$font_skin .widget.widget_categories a:hover,
	.wvc-font-$font_skin .widget.widget_pages a:hover,
	.wvc-font-$font_skin .widget .tagcloud a:hover,
	.wvc-font-$font_skin .widget.widget_recent_comments a:hover,
	.wvc-font-$font_skin .widget.widget_recent_entries a:hover,
	.wvc-font-$font_skin .widget.widget_archive a:hover,
	.wvc-font-$font_skin .widget.widget_meta a:hover,
	.wvc-font-$font_skin .widget.widget_product_categories a:hover,
	.wvc-font-$font_skin .widget.widget_nav_menu a:hover,
	.wvc-font-$font_skin a.rsswidget:hover
	{
		color:$accent_color!important;
	}

	.group_table td a:hover{
		color:$accent_color;
	}

	.fancybox-thumbs>ul>li:before{
		border-color:$accent_color;
	}

	.wvc-background-color-accent{
		background-color:$accent_color;
	}

	.accent-color-is-black .wvc-font-color-light .wvc_bar_color_filler{
		background-color:white!important;
	}

	.wvc-highlight-accent{
		background-color:$accent_color;
		color:#fff;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-button-background-color-accent{
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-button-background-color-accent .wvc-button-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-svg-icon-color-accent svg * {
		stroke:$accent_color!important;
	}

	.wvc-one-page-nav-bullet-tip{
		background-color: $accent_color;
	}

	.wvc-one-page-nav-bullet-tip:before{
		border-color: transparent transparent transparent $accent_color;
	}

	.accent,
	.bypostauthor .avatar{
		color:$accent_color;
	}

	.wvc-button-color-button-accent,
	.more-link,
	.buton-accent{
		background-color: $accent_color;
		border-color: $accent_color;
	}

	.wvc-ils-item-title:before {
		background-color: $accent_color!important;
	}

	.widget .tagcloud:before{
		 color:$accent_color;
	}

	.group_table td a:hover{
		color:$accent_color;
	}

	.added_to_cart, .button,
	.button-download,
	.more-link,
	input[type=submit]{
		background-color: $accent_color;
		border-color: $accent_color;
	}

	/* WVC icons */
	.wvc-icon-color-accent{
		color:$accent_color;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	#ajax-progress-bar,
	.cart-icon-product-count{
		background:$accent_color;
	}

	.background-accent{
		background: $accent_color!important;
	}

	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{
	 	background: $accent_color!important;
	}

	.trigger{
		background-color: $accent_color!important;
		border : solid 1px $accent_color;
	}

	.bypostauthor .avatar {
		border: 3px solid $accent_color;
	}

	::selection {
		background: $accent_color;
	}
	::-moz-selection {
		background: $accent_color;
	}

	.spinner{
		color:$strong_text_color;
	}

	.ball-pulse > div,
	.ball-pulse-sync > div,
	.ball-scale > div,
	.ball-scale-random > div,
	.ball-rotate > div,
	.ball-clip-rotate > div,
	.ball-clip-rotate-pulse > div:first-child,
	.ball-beat > div,
	.ball-scale-multiple > div,
	.ball-pulse-rise > div,
	.ball-grid-beat > div,
	.ball-grid-pulse > div,
	.ball-spin-fade-loader > div,
	.ball-zig-zag > div,
	.ball-zig-zag-deflect > div,
	.line-scale > div,
	.line-scale-party > div,
	.line-scale-pulse-out > div,
	.line-scale-pulse-out-rapid > div,
	.line-spin-fade-loader > div {
		background:$strong_text_color;
	}

	.ball-clip-rotate-pulse > div:last-child,
	.ball-clip-rotate-multiple > div,
	.ball-scale-ripple > div,
	.ball-scale-ripple-multiple > div,
	.ball-triangle-path > div{
		border-color:$strong_text_color;
	}

	.ball-clip-rotate-multiple > div:last-child{
		border-color: $strong_text_color transparent $strong_text_color transparent;
	}



	/*********************
		WVC
	***********************/

	.wvc-it-label{
		color:$accent_color;
	}

	.wvc-icon-box.wvc-icon-type-circle .wvc-icon-no-custom-style.wvc-hover-fill-in:hover, .wvc-icon-box.wvc-icon-type-square .wvc-icon-no-custom-style.wvc-hover-fill-in:hover {
		-webkit-box-shadow: inset 0 0 0 1em $accent_color;
		box-shadow: inset 0 0 0 1em $accent_color;
		border-color: $accent_color;
	}

	.wvc-pricing-table-featured-text,
	.wvc-pricing-table-featured .wvc-pricing-table-button a{
		background: $accent_color;
	}

	.wvc-pricing-table-featured .wvc-pricing-table-price,
	.wvc-pricing-table-featured .wvc-pricing-table-currency {
		color: $accent_color;
	}

	.wvc-pricing-table-featured .wvc-pricing-table-price-strike:before {
		background-color: $accent_color;
	}

	.wvc-team-member-social-container a:hover{
		color: $accent_color;
	}

	/* Main Text Color */
	body,
	.wvc-font-$font_skin,
	.nav-label{
		color:$main_text_color;
	}

	.spinner-color, .sk-child:before, .sk-circle:before, .sk-cube:before{
		background-color: $strong_text_color!important;
	}

	/* Strong Text Color */
	a,strong,
	.products li .price,
	.products li .star-rating,
	.wr-print-button,
	table.cart thead, #content table.cart thead,
	.work-meta-label,
	.wwcs-current-currency
	{
		color: $strong_text_color;
	}

	.wolf-alert.success a, .wolf-alert.success a:hover, .wolf-alert.success b, .wolf-alert.success span, .wolf-alert.success strong, .woocommerce-error a, .woocommerce-error a:hover, .woocommerce-error b, .woocommerce-error span, .woocommerce-error strong, .woocommerce-info a, .woocommerce-info a:hover, .woocommerce-info b, .woocommerce-info span, .woocommerce-info strong, .woocommerce-message a, .woocommerce-message a:hover, .woocommerce-message b, .woocommerce-message span, .woocommerce-message strong{
		color: $strong_text_color;
	}

	.category-label,
	.wvc-pricing-table-title{
		color: $strong_text_color!important;
	}

	h1,h2,h3,h4,h5,h6,
	.wvc-font-$font_skin h1:not(.wvc-service-title),
	.wvc-font-$font_skin h2:not(.wvc-service-title),
	.wvc-font-$font_skin h3:not(.wvc-service-title),
	.wvc-font-$font_skin h4:not(.wvc-service-title),
	.wvc-font-$font_skin h5:not(.wvc-service-title)
	.wvc-font-$font_skin h6:not(.wvc-service-title),
	.wvc-font-$font_skin strong,
	.wvc-font-$font_skin b,
	.wvc-font-$font_skin .wvc-counter,
	.wvc-font-$font_skin .wvc-bigtext-link,
	.wvc-font-$font_skin .wvc-fittext-link,
	.wvc-font-$font_skin .wvc-pie-counter,
	.wvc-font-$font_skin .wvc-icon-color-default,
	.sku,
	.wvc-font-$font_skin .wvc-counter-text,
	.wvc-font-$font_skin .wvc-video-opener-caption,
	.wvc-font-$font_skin .wvc-list-has-icon ul li .fa,
	.wvc-font-$font_skin .wvc-process-number.wvc-text-color-default,
	.wvc-font-$font_skin .wvc-process-number.wvc-text-color-default:before,
	.wvc-font-$font_skin .blockquote:before,
	.wvc-font-$font_skin blockquote,
	.post-extra-meta,
	.comment-reply-title,
	.comment-reply-link{
		color: $strong_text_color;
	}

	.wvc-font-dark .wvc-process-icon-container{
		border-color: $strong_text_color;
	}

	.bit-widget-container,
	.entry-link{
		color: $strong_text_color;
	}

	.single-product .entry-summary .woocommerce-Price-amount,
	.entry-post-standard .entry-title{
		color: $strong_text_color!important;
	}

	.wr-stars>span.wr-star-voted:before, .wr-stars>span.wr-star-voted~span:before{
		color: $strong_text_color!important;
	}

	/* Border Color */

	.widget-title,
	.woocommerce-tabs ul.tabs{
		border-bottom-color:$border_color;
	}

	.widget_layered_nav_filters ul li a{
		border-color:$border_color;
	}

	hr{
		background:$border_color;
	}
	";

	$link_selector_after  = '.link:after, .underline:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):after';
	$link_selector_before = '.link:before, .underline:before, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):before';

	$output .= "

		/*$link_selector_after,
		$link_selector_before{
			background: $accent_color!important;
		}*/

		.category-filter ul li a:before{
			//background:$accent_color!important;
		}

		.theme-heading:after{
			color:$accent_color;
		}

		/* Button */


		.entry-mp-event .entry-container,
		.wvc-recipe-instructions o li:before,
		.wvc-recipe .wvc-recipe-counter-circle {
			background:$accent_color;
		}

		.accent-color-light .category-label{
			//color:#333!important;
		}

		.accent-color-dark .category-label{
			//color:#fff!important;
		}

		.coupon .button:hover{
			background:$accent_color!important;
			border-color:$accent_color!important;
		}

		.menu-item-fill{
			background:$accent_color!important;
		}

		.audio-shortcode-container .mejs-container .mejs-controls > .mejs-playpause-button{
			background:$accent_color;
		}

		.menu-hover-style-h-underline .nav-menu-desktop li a span.menu-item-text-container:after{
			background-color:$accent_color!important;
		}


		/*.wvc-accordion-tab.ui-state-active .wvc-at-title-text,
		.wvc-accordion-tab:hover .wvc-at-title-text{
			color:$accent_color!important;
		}*/

		.woocommerce-message .button:hover{
			background-color:$accent_color!important;
		}

		/*.entry-product ins .woocommerce-Price-amount,
		.entry-single-product ins .woocommerce-Price-amount{
			color:$accent_color;
		}*/
	";

	$heading_selectors = apply_filters( 'bronze_heading_selectors', bronze_list_to_array( 'h1:not(.wvc-bigtext), h2:not(.wvc-bigtext), h3:not(.wvc-bigtext), h4:not(.wvc-bigtext), h5:not(.wvc-bigtext), .post-title, .entry-title, h2.entry-title > .entry-link, h2.entry-title, .widget-title, .wvc-counter-text, .wvc-countdown-period, .location-title, .logo-text, .wvc-interactive-links, .wvc-interactive-overlays, .heading-font' ) );

	$heading_selectors = bronze_array_to_list( $heading_selectors );
	$output           .= "$heading_selectors{text-rendering: auto;}";

	$output .= '.wolf-share-buttons-container:before{
		color:' . $strong_text_color . '
	}';

	// If dark
	if ( preg_match( '/dark/', bronze_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-light{
			background-color:$page_background_color;
		}";
	}

	// if light
	if ( preg_match( '/light/', bronze_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-dark{
			background-color:$page_background_color;
		}";
	}

	return $output;
}
add_filter( 'bronze_color_scheme_output', 'bronze_edit_color_scheme_css', 10, 2 );

/**
 * Additional styles
 */
function bronze_output_additional_styles() {

	$output = '';

	/* Content inner background */
	$c_ci_bg_color = bronze_get_inherit_mod( 'content_inner_bg_color' );
	$c_ci_bg_img   = bronze_get_inherit_mod( 'content_inner_bg_img' );

	if ( $c_ci_bg_color ) {
		$output .= ".content-inner{
	background-color: $c_ci_bg_color;
}";

	}

	if ( $c_ci_bg_img ) {
		$output .= '.content-inner{
	background-image:url(' . bronze_get_url_from_attachment_id( $c_ci_bg_img, 'full' ) . ' );
	background-repeat: no-repeat;
    background-position: center 0;
    background-size: cover;}';
	}

	/* Product thumbnail padding */
	$p_t_padding = bronze_get_inherit_mod( 'product_thumbnail_padding' );

	if ( $p_t_padding ) {
		$p_t_padding = bronze_sanitize_css_value( $p_t_padding );
		$output     .= ".entry-product-masonry .product-thumbnail-container,
.entry-product-grid .product-thumbnail-container,
.wwcq-product-quickview-container .product-images .slide-content img{
	padding: $p_t_padding;
}";
	}

	// $output .= '.wolf-share-buttons-container:before{
	// content: "' . esc_html__( 'Share', 'bronze' ) . ':";
	// }';

	/*
	if ( isset( $_COOKIE['bronze_loading_logo_width'] ) ) {
		$output .= '.imgloading-container{
		width: ' . absint( $_COOKIE['bronze_loading_logo_width'] ) . 'px;
		}';
	}*/

	if ( ! SCRIPT_DEBUG ) {
		$output = bronze_compact_css( $output );
	}

	wp_add_inline_style( 'bronze-style', $output );
}
add_action( 'wp_enqueue_scripts', 'bronze_output_additional_styles', 999 );

/*
--------------------------------------------------------------------

	POST HOOKS

----------------------------------------------------------------------
*/

/**
 * Redefine post standard hook
 */
function bronze_remove_loop_post_default_hooks() {

	remove_action( 'bronze_before_post_content_standard_title', 'bronze_output_post_content_standard_date' );
	remove_action( 'bronze_post_content_standard_title', 'bronze_output_post_content_standard_title' );
	remove_action( 'bronze_after_post_content_standard', 'bronze_output_post_content_standard_meta' );

	remove_action( 'bronze_before_post_content_grid_title', 'bronze_output_post_content_grid_date' );
	remove_action( 'bronze_before_post_content_grid_title', 'bronze_output_post_content_grid_media' );
	remove_action( 'bronze_post_content_grid_title', 'bronze_output_post_grid_title' );

	remove_action( 'bronze_before_post_content_masonry_title', 'bronze_output_post_content_grid_date' );
	remove_action( 'bronze_before_post_content_masonry_title', 'bronze_output_post_content_grid_media' );
	remove_action( 'bronze_post_content_masonry_title', 'bronze_output_post_grid_title' );

	remove_action( 'bronze_after_post_content_grid', 'bronze_output_post_content_grid_meta' );
	remove_action( 'bronze_after_post_content_masonry', 'bronze_output_post_content_grid_meta' );

	remove_action( 'bronze_after_post_content_grid_title', 'bronze_output_post_content_grid_excerpt' );
	remove_action( 'bronze_after_post_content_masonry_title', 'bronze_output_post_content_grid_excerpt' );

	// Add title
	add_action( 'bronze_before_post_content_standard_title', 'bronze_overwrite_post_standard_title', 10, 2 );

	add_action( 'bronze_before_post_content_masonry', 'bronze_output_post_content_grid_custom_media', 10, 2 );
	add_action( 'bronze_before_post_content_masonry_title', 'bronze_output_post_content_grid_open_tag', 10, 1 );

	add_action( 'bronze_before_post_content_grid', 'bronze_output_post_content_grid_custom_media', 10, 2 );
	add_action( 'bronze_before_post_content_grid', 'bronze_output_post_content_grid_summary_open_tag', 10, 2 );
	add_action( 'bronze_post_content_grid_title', 'bronze_overwrite_post_standard_title', 10, 2 );
	add_action( 'bronze_after_post_content_grid_title', 'bronze_overwrite_post_content_grid_excerpt', 10, 2 );

	add_action( 'bronze_post_content_masonry_title', 'bronze_overwrite_post_standard_title', 10, 2 );

	// add_action( 'bronze_before_post_content_grid_title', 'bronze_output_post_content_grid_open_tag', 10, 1 );

	add_action( 'bronze_after_post_content_masonry_title', 'bronze_overwrite_post_content_grid_excerpt', 10, 2 );

	add_action( 'bronze_after_post_content_grid', 'bronze_output_post_content_grid_summary_close_tag', 10, 1 );
	add_action( 'bronze_after_post_content_masonry', 'bronze_output_post_content_grid_summary_close_tag', 10, 1 );
}
add_action( 'init', 'bronze_remove_loop_post_default_hooks' );

/**
 * Post open tag
 */
function bronze_output_post_content_grid_summary_open_tag( $post_display_elements ) {
	?>
	<div class="entry-summary">
		<div class="entry-summary-inner">
	<?php
}

/**
 * Post open tag
 */
function bronze_output_post_content_grid_summary_close_tag( $post_display_elements ) {
	?>
		</div><!-- .entry-summary-inner -->
	</div><!-- .entry-summary -->
	<?php
}

/**
 * Post Media
 */
function bronze_output_post_content_grid_custom_media( $post_display_elements, $display ) {
	$show_date               = ( in_array( 'show_date', $post_display_elements, true ) );
	$show_thumbnail              = ( in_array( 'show_thumbnail', $post_display_elements, true ) );
	$show_category               = ( in_array( 'show_category', $post_display_elements, true ) );
	$post_id                     = get_the_ID();
	$secondary_featured_image_id = get_post_meta( $post_id, '_post_secondary_featured_image', true );
	$thumbnail_id                = ( $secondary_featured_image_id ) ? $secondary_featured_image_id : get_post_thumbnail_id();
	?>
	<?php if ( $show_thumbnail ) : ?>
		<?php if ( bronze_has_post_thumbnail() || bronze_is_instagram_post( $post_id ) ) : ?>
			<div class="entry-image">
				<?php
				if ( 'masonry' === $display ) {

					if ( $secondary_featured_image_id ) {

						echo wp_get_attachment_image( $secondary_featured_image_id, 'bronze-masonry' );

					} else {
						echo bronze_post_thumbnail( 'bronze-masonry' );
					}
				} else {
					?>
						<div class="entry-cover">
						<?php
							echo bronze_background_img(
								array(
									'background_img'      => $thumbnail_id,
									'background_img_size' => 'medium',
								)
							);
						?>
						</div><!-- entry-cover -->
						<?php
				}
				?>
			</div><!-- .entry-image -->
		<?php endif; ?>
	<?php endif; ?>
	<?php
}

/**
 * Re-assign post masonry open hook
 */
function bronze_output_post_content_grid_open_tag( $post_display_elements ) {
	$show_date      = ( in_array( 'show_date', $post_display_elements ) );
	$show_thumbnail = ( in_array( 'show_thumbnail', $post_display_elements ) );
	?>
	<div class="entry-summary">
		<div class="entry-summary-inner">
	<?php
}

/**
 * Post Text
 */
function bronze_overwrite_post_content_grid_excerpt( $post_display_elements, $post_excerpt_length, $display = 'grid' ) {

	$show_text = ( in_array( 'show_text', $post_display_elements ) );

	if ( 'metro' === $display ) {
		$post_excerpt_length = 5;
	}
	?>
	<?php if ( $show_text ) : ?>
		<div class="entry-excerpt">
			<?php do_action( 'bronze_post_' . $display . '_excerpt', $post_excerpt_length ); ?>
		</div><!-- .entry-excerpt -->
	<?php endif; ?>
	<?php
}

/**
 * Redefine single post hook
 */
function bronze_remove_single_post_default_hooks() {

	/**
	 * Remove default Hooks
	 */
	remove_action( 'bronze_post_content_start', 'bronze_add_custom_post_meta' );
	remove_action( 'bronze_post_content_end', 'bronze_ouput_single_post_taxonomy' );
	remove_action( 'bronze_related_post_content', 'bronze_output_related_post_content' );

	/**
	 * Add new hooks
	 */
	add_action( 'bronze_post_content_before', 'bronze_output_single_post_featured_image' );
	add_action( 'bronze_post_content_before', 'bronze_output_single_post_meta', 10, 1 );

}
add_action( 'init', 'bronze_remove_single_post_default_hooks' );

/**
 * Output single post meta
 */
function bronze_output_single_post_meta() {
	?>
	<div class="entry-meta">
		<span class="entry-date">
			<?php bronze_entry_date( true, true ); ?>
		</span>
			<?php bronze_get_author_avatar(); ?>
		<span class="entry-category-list">
			<?php echo apply_filters( 'bronze_entry_category_list_icon', '<span class="meta-icon category-icon"></span>' ); ?>
			<?php echo get_the_term_list( get_the_ID(), 'category', '', esc_html__( ', ', 'bronze' ), '' ); ?>
		</span>
		<?php bronze_entry_tags(); ?>
		<?php bronze_get_extra_meta(); ?>
		<?php bronze_edit_post_link(); ?>
	</div><!-- .entry-meta -->
	<?php
}

/**
 * Single Post Featured Image
 */
function bronze_output_single_post_featured_image() {

	if ( bronze_get_inherit_mod( 'hide_single_post_featured_image' ) ) {
		return;
	}

	?>
	<div class="single-featured-image">
	<?php
	the_post_thumbnail( 'large' );
	?>
	</div>
	<?php

}

add_filter(
	'bronze_entry_tag_list_separator',
	function() {
		return ', ';
	}
);

/**
 * Output single post pagination
 */
function bronze_output_custom_single_post_pagination() {

	if ( ! is_singular( 'post' ) || 'no' === bronze_get_inherit_mod( 'single_post_nav' ) ) {
		return; // event are ordered by custom date so it's better to hide the pagination
	}

	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous || ! is_single() || 'wvc_content_block' === get_post_type() ) {
		return;
	}

	$prev_post = get_previous_post();
	$next_post = get_next_post();

	$prev_post_id = ( is_object( $prev_post ) && isset( $prev_post->ID ) ) ? $prev_post->ID : null;
	$next_post_id = ( is_object( $next_post ) && isset( $next_post->ID ) ) ? $next_post->ID : null;

	$prev_post_featured_img_id = ( $prev_post_id ) ? get_post_thumbnail_id( $prev_post_id ) : null;
	$next_post_featured_img_id = ( $next_post_id ) ? get_post_thumbnail_id( $next_post_id ) : null;

	$index_class = 'nav-index';
	$prev_class  = 'nav-previous';
	$next_class  = 'nav-next';
	?>
	<nav class="bronze-single-post-pagination clearfix">
		<?php if ( $prev_post ) : ?>
			<div class="single-post-nav-item post-previous">
				<a href="<?php echo esc_url( get_permalink( $prev_post_id ) ); ?>" class="post-nav-link-overlay"></a>
				<div class="entry-cover">
						<?php echo bronze_background_img( array( 'background_img' => $prev_post_featured_img_id ) ); ?></div>
				<div class="post-nav-content">
					<div class="post-nav-summary">
						<?php if ( bronze_get_first_category( $prev_post_id ) ) : ?>
							<div class="post-nav-category"><?php echo bronze_get_first_category( $prev_post_id ); ?></div>
						<?php endif; ?>
						<div class="post-nav-title"><?php echo get_the_title( $prev_post_id ); ?></div>
						<span class="post-nav-entry-date">
							<?php bronze_entry_date( true, '', $prev_post_id ); ?>
						</span>
					</div>
				</div>
				<?php previous_post_link( '%link', '<span class="nav-label">' . esc_html__( 'Previous Article', 'bronze' ) . ' </span>' ); ?>
			</div><!-- .nav-previous -->
		<?php endif; ?>
		<?php if ( $next_post ) : ?>
			<div class="single-post-nav-item post-next">
				<a href="<?php echo esc_url( get_permalink( $next_post_id ) ); ?>" class="post-nav-link-overlay"></a>
				<div class="entry-cover">
					<?php echo bronze_background_img( array( 'background_img' => $next_post_featured_img_id ) ); ?>
					</div>
				<div class="post-nav-content">
					<div class="post-nav-summary">
						<?php if ( bronze_get_first_category( $next_post_id ) ) : ?>
							<div class="post-nav-category"><?php echo bronze_get_first_category( $next_post_id ); ?></div>
						<?php endif; ?>
						<div class="post-nav-title"><?php echo get_the_title( $next_post_id ); ?></div>
						<span class="post-nav-entry-date">
							<?php bronze_entry_date( true, '', $next_post_id ); ?>
						</span>
					</div>
				</div>
				<?php next_post_link( '%link', '<span class="nav-label">' . esc_html__( 'Next Article', 'bronze' ) . ' </span>' ); ?>
			</div><!-- .nav-next -->
		<?php endif; ?>
	</nav><!-- .single-post-pagination -->
	<?php
}
add_action( 'bronze_post_content_after', 'bronze_output_custom_single_post_pagination', 14 );

/**
 * Output related posts
 */
function bronze_overwrite_related_post_content() {
	?>
	<div class="entry-related-post">
		<a href="<?php the_permalink(); ?>" class="entry-related-post-img-link">
			<?php the_post_thumbnail( apply_filters( 'bronze_related_post_thumbnail_size', 'bronze-related-post-thumbnail' ) ); ?>
		</a>
		<div class="entry-related-post-summary">
			<a href="<?php the_permalink(); ?>" class="entry-related-post-title-link">
				<?php the_title( '<h4 class="entry-title">', '</h4>' ); ?>
			</a>
			<!-- <a class="entry-related-post-category" href="<?php // echo bronze_get_first_category_url(); ?>"><?php // echo bronze_get_first_category(); ?></a> -->
			<span class="entry-related-post-entry-date">
				<?php bronze_entry_date(); ?>
			</span>
		</div><!-- .entry-summary -->
	</div><!-- .entry-box -->
	<?php
}
add_action( 'bronze_related_post_content', 'bronze_overwrite_related_post_content' );

/**
 * Add post meta before title
 */
function bronze_overwrite_post_standard_title( $post_display_elements, $display ) {

	if ( '' == get_post_format() || 'video' === get_post_format() || 'gallery' === get_post_format() || 'image' === get_post_format() || 'audio' === get_post_format() || 'grid' === $display || 'masonry' === $display ) {
		the_title( '<h2 class="entry-title"><a class="entry-link" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	}

	echo '<header class="entry-meta">';

	if ( in_array( 'show_date', $post_display_elements ) && '' == get_post_format() || 'video' === get_post_format() || 'gallery' === get_post_format() || 'image' === get_post_format() || 'audio' === get_post_format() || 'grid' === $display || 'masonry' === $display ) {
		?>
		<span class="entry-date">
			<?php bronze_entry_date( true, true ); ?>
		</span>
		<?php
	}

	$show_author     = ( in_array( 'show_author', $post_display_elements ) );
	$show_category   = ( in_array( 'show_category', $post_display_elements ) );
	$show_tags       = ( in_array( 'show_tags', $post_display_elements ) );
	$show_extra_meta = ( in_array( 'show_extra_meta', $post_display_elements ) );
	?>
	<?php if ( ( $show_author || $show_extra_meta || $show_category || bronze_edit_post_link( false ) ) && 'grid' === $display || 'masonry' === $display || ( ! bronze_is_short_post_format() && 'standard' === $display ) ) : ?>

			<?php if ( $show_author ) : ?>
				<?php bronze_get_author_avatar(); ?>
			<?php endif; ?>
			<?php if ( $show_category ) : ?>
				<span class="entry-category-list">
					<?php echo apply_filters( 'bronze_entry_category_list_icon', '<span class="meta-icon category-icon"></span>' ); ?>
					<?php echo get_the_term_list( get_the_ID(), 'category', '', esc_html__( ', ', 'bronze' ), '' ); ?>
				</span>
			<?php endif; ?>
			<?php if ( $show_tags ) : ?>
				<?php bronze_entry_tags(); ?>
			<?php endif; ?>
			<?php if ( $show_extra_meta ) : ?>
				<?php bronze_get_extra_meta(); ?>
			<?php endif; ?>
			<?php bronze_edit_post_link(); ?>
		<?php endif; ?>
	<?php
	echo '</header>';
}

add_filter(
	'bronze_author_heading_avatar_size',
	function() {
		return 150;
	}
);

add_filter(
	'bronze_author_box_avatar_size',
	function() {
		return 150;
	}
);

/**
 * Post excerpt read more
 */
function bronze_output_post_grid_classic_excerpt_read_more() {
	?>
	<p class="post-grid-read-more-container"><a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( apply_filters( 'bronze_more_link_button_class', 'more-link' ) ); ?>"><small class="wvc-button-background-fill"></small><span><?php esc_html_e( 'Read more', 'bronze' ); ?></span></a></p>
	<?php
}
add_action( 'bronze_post_grid_excerpt', 'bronze_output_post_grid_classic_excerpt_read_more', 44 );
add_action( 'bronze_post_masonry_excerpt', 'bronze_output_post_grid_classic_excerpt_read_more', 44 );
add_action( 'bronze_post_search_excerpt', 'bronze_output_post_grid_classic_excerpt_read_more', 44 );

/*
--------------------------------------------------------------------

	WVC FILTERS

----------------------------------------------------------------------
*/



/**
 *  Set default row skin
 *
 * @param string $font_color
 * @return string $font_color
 */
function bronze_set_default_wvc_row_font_color( $font_color ) {

	$font_color = 'dark';

	// Check default skin
	if ( 'dark' === bronze_get_color_scheme_option() ) {
		$font_color = 'light';
	}

	// check main skin?
	return $font_color;
}
add_filter( 'wvc_default_row_font_color', 'bronze_set_default_wvc_row_font_color', 40 );

/**
 * Add custom elements to theme
 *
 * @param array $elements
 * @return  array $elements
 */
function bronze_add_available_wvc_elements( $elements ) {

	$elements[] = 'audio-button';
	$elements[] = 'album-disc';
	$elements[] = 'album-tracklist';
	$elements[] = 'album-tracklist-item';
	$elements[] = 'artist-lineup';
	$elements[] = 'bandsintown-tracking-button';

	if ( class_exists( 'WooCommerce' ) ) {
		$elements[] = 'wc-searchform';
		$elements[] = 'login-form';
		$elements[] = 'product-presentation';
	}

	return $elements;
}
add_filter( 'wvc_element_list', 'bronze_add_available_wvc_elements', 44 );

/**
 * Filter heading attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_heading_atts( $atts ) {

	// heading
	if ( isset( $atts['style'] ) ) {
		$atts['el_class'] = $atts['el_class'] . ' ' . $atts['style'];
	}

	return $atts;
}
add_filter( 'wvc_heading_atts', 'woltheme_filter_heading_atts' );

/**
 * Remove some params
 */
function bronze_remove_vc_params() {

	if ( function_exists( 'vc_remove_param' ) ) {

		vc_remove_param( 'wvc_product_index', 'product_text_align' );
		vc_remove_param( 'wvc_video_index', 'video_preview' );

		vc_remove_param( 'wvc_work_index', 'caption_text_alignment' );
		// vc_remove_param( 'wvc_work_index', 'work_category_filter_text_alignment' );
		// vc_remove_param( 'wvc_work_index', 'overlay_color' );
		// vc_remove_param( 'wvc_work_index', 'overlay_custom_color' );
		// vc_remove_param( 'wvc_work_index', 'overlay_text_color' );
		// vc_remove_param( 'wvc_work_index', 'overlay_text_custom_color' );
		// vc_remove_param( 'wvc_work_index', 'overlay_opacity' );
		// vc_remove_param( 'wvc_work_index', 'caption_v_align' );

		vc_remove_param( 'wvc_interactive_links', 'align' );
		vc_remove_param( 'wvc_interactive_links', 'display' );
		vc_remove_param( 'wvc_interactive_overlays', 'align' );
		vc_remove_param( 'wvc_interactive_overlays', 'display' );

		vc_remove_param( 'wvc_team_member', 'layout' );
		vc_remove_param( 'wvc_team_member', 'alignment' );
		vc_remove_param( 'wvc_team_member', 'v_alignment' );

		vc_remove_param( 'wvc_testimonial_slider', 'text_alignment' );
	}
}
add_action( 'init', 'bronze_remove_vc_params' );

/**
 * Post slider button text markup
 */
add_filter(
	'wvc_last_posts_big_slide_button_text',
	function( $text ) {
		return '<span>' . $text . '</span>';
	}
);

/**
 * Interactive links
 */
add_filter(
	'wvc_interactive_links_align',
	function( $value ) {
		return 'center';
	},
	44
);

add_filter(
	'wvc_interactive_links_display',
	function( $value ) {
		return 'block';
	},
	100
);

/**
 * Album disc
 */
add_filter(
	'wvc_default_album_disc_rotation_speed',
	function() {
		return 10000;
	}
);

/**
 * Set release taxonomy before string
 *
 * @param  string $string String to append before release taxonomy.
 * @return string
 */
function bronze_set_breadcrump_delimiter( $string ) {

	return ' <i class="fa dripicons-arrow-thin-right"></i> ';

}
add_filter( 'wvc_breadcrumb_delimiter', 'bronze_set_breadcrump_delimiter' );

/**
 * Filter fullPage Transition
 *
 * @return array
 */
function bronze_set_fullpage_transition( $transition ) {

	if ( is_page() || is_single() ) {
		if ( get_post_meta( wvc_get_the_ID(), '_post_fullpage', true ) ) {
			$transition = get_post_meta( wvc_get_the_ID(), '_post_fullpage_transition', true );
		}
	}

	return $transition;
}
add_filter( 'wvc_fp_transition_effect', 'bronze_set_fullpage_transition' );

/**
 * Add style option to tabs element
 */
function bronze_add_vc_accordion_and_tabs_options() {
	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_tabs',
			array(
				array(
					'heading'    => esc_html__( 'Background', 'bronze' ),
					'param_name' => 'background',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Solid', 'bronze' ) => 'solid',
						esc_html__( 'Transparent', 'bronze' ) => 'transparent',
					),
					'weight'     => 1000,
				),
				array(
					'heading'    => esc_html__( 'Accent Color', 'bronze' ),
					'param_name' => 'accent_color',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Primary', 'bronze' ) => 'primary',
						esc_html__( 'Secondary', 'bronze' ) => 'secondary',
					),
					'weight'     => 1000,
				),
			)
		);
	}

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_accordion',
			array(
				array(
					'heading'    => esc_html__( 'Background', 'bronze' ),
					'param_name' => 'background',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Solid', 'bronze' ) => 'solid',
						esc_html__( 'Transparent', 'bronze' ) => 'transparent',
					),
					'weight'     => 1000,
				),
				array(
					'heading'    => esc_html__( 'Accent Color', 'bronze' ),
					'param_name' => 'accent_color',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Primary', 'bronze' ) => 'primary',
						esc_html__( 'Secondary', 'bronze' ) => 'secondary',
					),
					'weight'     => 1000,
				),
			)
		);
	}
}
// add_action( 'init', 'bronze_add_vc_accordion_and_tabs_options' );

/**
 * Filter tabs shortcode attribute
 */
function bronze_add_vc_tabs_params( $params ) {

	if ( isset( $params['background'] ) ) {
		$params['el_class'] = $params['el_class'] . ' wvc-tabs-background-' . $params['background'] . ' wvc-tabs-accent-color-' . $params['accent_color'];
	}

	return $params;
}
add_filter( 'shortcode_atts_vc_tabs', 'bronze_add_vc_tabs_params' );

/**
 * Filter accordion shortcode attribute
 */
function bronze_add_vc_accordion_params( $params ) {

	if ( isset( $params['background'] ) ) {
		$params['el_class'] = $params['el_class'] . ' wvc-accordion-background-' . $params['background'] . ' wvc-accordion-accent-color-' . $params['accent_color'];
	}

	return $params;
}
add_filter( 'shortcode_atts_vc_accordion', 'bronze_add_vc_accordion_params' );

/*
--------------------------------------------------------------------

	WC FILTERS

----------------------------------------------------------------------
*/

/**
 * Quickview product excerpt lenght
 */
add_filter(
	'wwcqv_excerpt_length',
	function() {
		return 28;
	}
);

/**
 * After quickview summary hook
 */
add_action(
	'wwcqv_product_summary',
	function() {
		?>
	<div class="single-add-to-wishlist">
		<span class="single-add-to-wishlist-label"><?php esc_html_e( 'Wishlist', 'bronze' ); ?></span>
		<?php bronze_add_to_wishlist(); ?>
	</div><!-- .single-add-to-wishlist -->
		<?php
	},
	20
);



/**
 * Display sale label condition
 *
 * @param bool $bool
 * @return bool
 */
function bronze_do_show_sale_label( $bool ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$bool = true;
	}

	return $bool;
}
add_filter( 'bronze_show_sale_label', 'bronze_do_show_sale_label' );

/**
 * Sale label text
 *
 * @param string $string
 * @return string
 */
function bronze_sale_label( $string ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {

		$style = '';

		$string = '<span' . $style . ' class="onsale">' . esc_attr( get_post_meta( get_the_ID(), '_post_product_label', true ) ) . '</span>';
	}

	return $string;
}
add_filter( 'woocommerce_sale_flash', 'bronze_sale_label' );

/**
 * Product quickview button
 *
 * @param string $string
 * @return string
 */
function bronze_output_product_quickview_button() {

	if ( function_exists( 'wolf_quickview_button' ) ) {
		wolf_quickview_button();
	}
}
add_filter( 'bronze_product_quickview_button', 'bronze_output_product_quickview_button' );

/**
 * Product wishlist button
 *
 * @param string $string
 * @return string
 */
function bronze_output_product_wishlist_button() {

	if ( function_exists( 'wolf_add_to_wishlist' ) ) {
		wolf_add_to_wishlist();
	}
}
add_filter( 'bronze_add_to_wishlist_button', 'bronze_output_product_wishlist_button' );

/**
 * Product Add to cart button
 *
 * @param string $string
 * @return string
 */
function bronze_output_product_add_to_cart_button() {

	global $product;

	if ( $product->is_type( 'variable' ) ) {

		echo '<a class="product-quickview-button" href="' . esc_url( get_permalink() ) . '"><span class="fa quickview-product-add-to-cart-icon" title="' . esc_attr( __( 'Select option', 'bronze' ) ) . '"></span></a>';

	} elseif ( $product->is_type( 'external' ) || $product->is_type( 'grouped' ) ) {

		echo '<a class="product-quickview-button" href="' . esc_url( get_permalink() ) . '"><span class="fa quickview-product-add-to-cart-icon" title="' . esc_attr( __( 'View product', 'bronze' ) ) . '"></span></a>';

	} else {

		echo bronze_add_to_cart(
			get_the_ID(),
			'quickview-product-add-to-cart product-quickview-button',
			'<span class="fa quickview-product-add-to-cart-icon" title="' . esc_attr( __( 'Add to cart', 'bronze' ) ) . '"></span>'
		);
	}
}
add_filter( 'bronze_product_add_to_cart_button', 'bronze_output_product_add_to_cart_button' );

/**
 * Product more button
 *
 * @param string $string
 * @return string
 */
function bronze_output_product_more_button() {

	?>
	<a class="product-quickview-button product-more-button" href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'More details', 'bronze' ); ?>"><span class="fa ion-android-more-vertical"></span></a>
	<?php
}
add_filter( 'bronze_product_more_button', 'bronze_output_product_more_button' );

/*
--------------------------------------------------------------------

	WC HOOKS

----------------------------------------------------------------------
*/

/**
 * Product Size Chart Image
 */
function bronze_product_size_chart_img() {

	$hide_sizechart = get_post_meta( get_the_ID(), '_post_wc_product_hide_size_chart_img', true );

	if ( $hide_sizechart || ! is_singular( 'product' ) ) {
		return;
	}

	global $post;
	$sc_img = null;
	$terms  = get_the_terms( $post, 'product_cat' );

	foreach ( $terms as $term ) {

		$sizechart_id = absint( get_term_meta( $term->term_id, 'sizechart_id', true ) );

		if ( $sizechart_id ) {
			$sc_img = $sizechart_id;
		}
	}

	if ( get_post_meta( get_the_ID(), '_post_wc_product_size_chart_img', true ) ) {
		$sc_img = get_post_meta( get_the_ID(), '_post_wc_product_size_chart_img', true );
	}

	if ( is_single() && $sc_img ) {
		$href = bronze_get_url_from_attachment_id( $sc_img, 'bronze-XL' );
		?>
		<div class="size-chart-img">
			<a href="<?php echo esc_url( $href ); ?>" class="lightbox"><?php esc_html_e( 'Size Chart', 'bronze' ); ?></a>
		</div>
		<?php
	}
}
add_action( 'woocommerce_single_product_summary', 'bronze_product_size_chart_img', 25 );

/**
 * WC gallery image size overwrite
 */
add_filter(
	'woocommerce_gallery_thumbnail_size',
	function( $size ) {
		return array( 100, 137 );
	},
	40
);

/**
 * Category thumbnail fields.
 */
function bronze_add_category_fields() {
	?>
	<div class="form-field term-thumbnail-wrap">
		<label><?php esc_html_e( 'Size Chart', 'bronze' ); ?></label>
		<div id="sizechart_img" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="product_cat_sizechart_img_id" name="product_cat_sizechart_img_id" />
			<button type="button" id="upload_sizechart_image_button" class="upload_sizechart_image_button button"><?php esc_html_e( 'Upload/Add image', 'bronze' ); ?></button>
				<button type="button" id="remove_sizechart_image_button" class="remove_sizechart_image_button button" style="display:none;"><?php esc_html_e( 'Remove image', 'bronze' ); ?></button>
		</div>
		<script type="text/javascript">

			// Only show the "remove image" button when needed
			if ( ! jQuery( '#product_cat_sizechart_img_id' ).val() ) {
				jQuery( '#remove_sizechart_image_button' ).hide();
			}

			// Uploading files
			var sizechart_frame;

			jQuery( document ).on( 'click', '#upload_sizechart_image_button', function( event ) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( sizechart_frame ) {
					sizechart_frame.open();
					return;
				}

				// Create the media frame.
				sizechart_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e( 'Choose an image', 'bronze' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use image', 'bronze' ); ?>'
					},
					multiple: false
				} );

				// When an image is selected, run a callback.
				sizechart_frame.on( 'select', function() {
					var attachment           = sizechart_frame.state().get( 'selection' ).first().toJSON();
					var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

					jQuery( '#product_cat_sizechart_img_id' ).val( attachment.id );
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
					jQuery( '#remove_sizechart_image_button' ).show();
				} );

				// Finally, open the modal.
				sizechart_frame.open();
			} );

			jQuery( document ).on( 'click', '#remove_sizechart_image_button', function() {
				jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
				jQuery( '#product_cat_sizechart_img_id' ).val( '' );
				jQuery( '#remove_sizechart_image_button' ).hide();
				return false;
			} );

			jQuery( document ).ajaxComplete( function( event, request, options ) {
				if ( request && 4 === request.readyState && 200 === request.status
					&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

					var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
					if ( ! res || res.errors ) {
						return;
					}
					// Clear Thumbnail fields on submit
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_sizechart_img_id' ).val( '' );
					jQuery( '#remove_sizechart_image_button' ).hide();
					// Clear Display type field on submit
					jQuery( '#display_type' ).val( '' );
					return;
				}
			} );

		</script>
		<div class="clear"></div>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'bronze_add_category_fields', 100 );

/**
 * Edit category thumbnail field.
 *
 * @param mixed $term Term (category) being edited
 */
function bronze_edit_category_fields( $term ) {

	$sizechart_id = absint( get_term_meta( $term->term_id, 'sizechart_id', true ) );

	if ( $sizechart_id ) {
		$image = wp_get_attachment_thumb_url( $sizechart_id );
	} else {
		$image = wc_placeholder_img_src();
	}
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php esc_html_e( 'Size Chart', 'bronze' ); ?></label></th>
		<td>
			<div id="sizechart_img" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_cat_sizechart_img_id" name="product_cat_sizechart_img_id" value="<?php echo absint( $sizechart_id ); ?>" />
				<button type="button" id="upload_sizechart_image_button" class="upload_sizechart_image_button button"><?php esc_html_e( 'Upload/Add image', 'bronze' ); ?></button>
				<button type="button" id="remove_sizechart_image_button" class="remove_sizechart_image_button button" style="display:none;"><?php esc_html_e( 'Remove image', 'bronze' ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( jQuery( '#product_cat_sizechart_img_id' ).val() ) {
					jQuery( '#remove_sizechart_image_button' ).show();
				}

				// Uploading files
				var sizechart_frame;

				jQuery( document ).on( 'click', '#upload_sizechart_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( sizechart_frame ) {
						sizechart_frame.open();
						return;
					}

					// Create the media frame.
					sizechart_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php esc_html_e( 'Choose an image', 'bronze' ); ?>',
						button: {
							text: '<?php esc_html_e( 'Use image', 'bronze' ); ?>'
						},
						multiple: false
					} );

					// When an image is selected, run a callback.
					sizechart_frame.on( 'select', function() {
						var attachment           = sizechart_frame.state().get( 'selection' ).first().toJSON();
						var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

						jQuery( '#product_cat_sizechart_img_id' ).val( attachment.id );
						jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
						jQuery( '#remove_sizechart_image_button' ).show();
					} );

					// Finally, open the modal.
					sizechart_frame.open();
				} );

				jQuery( document ).on( 'click', '#remove_sizechart_image_button', function() {
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_sizechart_img_id' ).val( '' );
					jQuery( '#remove_sizechart_image_button' ).hide();
					return false;
				} );

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'bronze_edit_category_fields', 100 );

/**
 * save_category_fields function.
 *
 * @param mixed  $term_id Term ID being saved
 * @param mixed  $tt_id
 * @param string $taxonomy
 */
function bronze_save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

	if ( isset( $_POST['product_cat_sizechart_img_id'] ) && 'product_cat' === $taxonomy ) {
		update_woocommerce_term_meta( $term_id, 'sizechart_id', absint( $_POST['product_cat_sizechart_img_id'] ) );
	}
}
add_action( 'created_term', 'bronze_save_category_fields', 10, 3 );
add_action( 'edit_term', 'bronze_save_category_fields', 10, 3 );

/**
 * Single Product Subheading
 */
function bronze_add_single_product_subheading() {

	$subheading = get_post_meta( get_the_ID(), '_post_subheading', true );

	if ( is_single() && $subheading ) {
		?>
		<div class="product-subheading">
			<?php echo sanitize_text_field( $subheading ); ?>
		</div>
		<?php
	}

}
add_action( 'woocommerce_single_product_summary', 'bronze_add_single_product_subheading', 6 );
add_action( 'wwcqv_product_summary', 'bronze_add_single_product_subheading', 6 );

/**
 * Redefine product hook
 */
function bronze_remove_loop_item_default_wc_hooks() {

	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
	remove_action( 'woocommerce_after_shop_loop_item', 'www_output_add_to_wishlist_button', 15 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

	add_action( 'woocommerce_before_shop_loop_item', 'bronze_wc_loop_thumbnail', 10, 1 );
	add_action( 'woocommerce_after_shop_loop_item', 'bronze_wc_loop_summary' );
}
add_action( 'woocommerce_init', 'bronze_remove_loop_item_default_wc_hooks' );

/**
 * WC loop thumbnail
 */
function bronze_wc_loop_thumbnail( $template_args ) {

	extract(
		wp_parse_args(
			$template_args,
			array(
				'display' => '',
				'layout'  => 'standard',
			)
		)
	);

	$product_thumbnail_size = ( 'metro' === $display ) ? 'bronze-metro' : 'woocommerce_thumbnail';
	$product_thumbnail_size = apply_filters( 'bronze_' . $display . '_thumbnail_size_name', $product_thumbnail_size );
	$product_thumbnail_size = ( bronze_is_gif( get_post_thumbnail_id() ) ) ? 'full' : $product_thumbnail_size;
	$product_thumbnail_bg   = sanitize_hex_color( bronze_get_inherit_mod( 'product_bg_color', '', get_the_ID() ) );
	// $product_thumbnail_bg = 'red';
	?>
	<div class="product-box">

		<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
		<div class="product-thumbnail-container clearfix">
			<?php do_action( 'bronze_product_minimal_player' ); ?>
			<div class="product-thumbnail-inner">
				<?php woocommerce_show_product_loop_sale_flash(); ?>
				<?php echo woocommerce_get_product_thumbnail( $product_thumbnail_size ); ?>
				<?php bronze_woocommerce_second_product_thumbnail( $product_thumbnail_size ); ?>

			</div><!-- .product-thumbnail-inner -->
		</div><!-- .product-thumbnail-container -->
	<?php
}

function bronze_wc_loop_summary() {
	?>
	<div class="product-summary clearfix">
		<div class="product-caption">
			<?php woocommerce_template_loop_product_link_open(); ?>

				<?php woocommerce_template_loop_product_title(); ?>
				<?php
					/**
					 * After title
					 */
					do_action( 'bronze_after_shop_loop_item_title' );
				?>
			<?php woocommerce_template_loop_product_link_close(); ?>
			<?php woocommerce_template_loop_price(); ?>
		</div>
		<div class="product-actions">
			<?php
				/**
				 * Quickview button
				 */
				do_action( 'bronze_product_quickview_button' );

				/**
				 * Wishlist button
				 */
				do_action( 'bronze_add_to_wishlist_button' );
				/**
				 * Add to cart button
				 */
				do_action( 'bronze_product_add_to_cart_button' );
			?>
		</div><!-- .product-actions -->
	</div><!-- .product-summary -->

	</div><!-- .product-box -->
	<?php
}

/**
 * Product stacked images + sticky details
 */
function bronze_single_product_sticky_layout() {

	if ( ! bronze_get_inherit_mod( 'product_sticky' ) || 'no' === bronze_get_inherit_mod( 'product_sticky' ) ) {
		return;
	}

	/* Remove default images */
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

	global $product;

	$product_id = $product->get_id();

	echo '<div class="images">';

	woocommerce_show_product_sale_flash();
	/**
	 * If gallery
	 */
	$attachment_ids = $product->get_gallery_image_ids();

	if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {

		echo '<ul>';

		if ( has_post_thumbnail( $product_id ) ) {

			$caption = get_post_field( 'post_excerpt', get_post_thumbnail_id( $post_thumbnail_id ) );
			?>
			<li class="stacked-image">
				<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
					<?php echo bronze_kses( $product->get_image( 'large' ) ); ?>
				</a>
			</li>
			<?php
		}

		foreach ( $attachment_ids as $attachment_id ) {
			if ( wp_attachment_is_image( $attachment_id ) ) {

				$caption = get_post_field( 'post_excerpt', $attachment_id );
				?>
				<li class="stacked-image">
					<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo wp_get_attachment_url( $attachment_id, 'full' ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
						<?php echo wp_get_attachment_image( $attachment_id, 'large' ); ?>
					</a>
				</li>
				<?php
			}
		}

		echo '</ul>';

		/**
		 * If featured image only
		 */
	} elseif ( has_post_thumbnail( $product_id ) ) {
		?>
		<span class="stacked-image">
			<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>">
				<?php echo bronze_kses( $product->get_image( 'large' ) ); ?>
			</a>
		</span>
		<?php
		/**
		 * Placeholder
		 */
	} else {

		$html  = '<span class="woocommerce-product-gallery__image--placeholder">';
		$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'bronze' ) );
		$html .= '</span>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}

	echo '</div>';
}
add_action( 'woocommerce_before_single_product_summary', 'bronze_single_product_sticky_layout' );



add_action(
	'woocommerce_before_quantity_input_field',
	function() {
		echo '<span class="wt-quantity-plus"></span>';
	}
);

add_action(
	'woocommerce_after_quantity_input_field',
	function() {
		echo '<span class="wt-quantity-minus"></span>';
	}
);

/**
 * Filter WC tab
 *
 * Replace tabs by accordion
 */
function bronze_filter_wc_tabs( $markup, $tabs ) {
	if ( ! empty( $tabs ) ) :
		?>
		<?php ob_start(); ?>
		<div class="woocommerce-tabs">
			<div id="wvc-wc-accordion" class="wvc-accordion tabs-container">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<h2 class="wvc-accordion-tab"><a href="#"><span class="wvc-at-title-container"><span class="wvc-at-title-text"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></span></span></a></h2>
					<div class="wvc-clearfix" ><div class="wbp_wrapper"><?php call_user_func( $tab['callback'], $key, $tab ); ?>
					</div><!--.wbp_wrapper--></div><!--.wvc-text-block-->
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	endif;
	return ob_get_clean();
}
add_filter( 'bronze_wc_tabs', 'bronze_filter_wc_tabs', 10, 2 );


/*
--------------------------------------------------------------------

	PLUGIN SETTINGS

----------------------------------------------------------------------
*/

/**
 * Set portfolio template folder
 */
function bronze_set_portfolio_template_url( $template_url ) {

	return bronze_get_template_url() . '/portfolio/';
}
add_filter( 'wolf_portfolio_template_url', 'bronze_set_portfolio_template_url' );

/**
 * Set discography template folder
 */
function bronze_set_discography_template_url( $template_url ) {

	return bronze_get_template_url() . '/discography/';
}
add_filter( 'wolf_discography_template_url', 'bronze_set_discography_template_url' );
add_filter( 'wolf_discography_url', 'bronze_set_discography_template_url' );

/**
 * Set events template folder
 */
function bronze_set_events_template_url( $template_url ) {

	return bronze_get_template_url() . '/events/';
}
add_filter( 'wolf_events_template_url', 'bronze_set_events_template_url' );

add_filter(
	'we_custom_date_class',
	function( $class ) {
		return '';
	}
);

/**
 * Rewrite band taxonomy slug
 *
 * @param array  $args Array of taxonomy arguments.
 * @param string $taxonomy The taxonomy slug.
 * @return array
 */
function bronze_change_band_taxonomies_slug( $args, $taxonomy ) {
	if ( 'band' === $taxonomy ) {
		$args['rewrite']['slug'] = 'artist-releases';
	}
	return $args;
}
add_filter( 'register_taxonomy_args', 'bronze_change_band_taxonomies_slug', 10, 2 );

/**
 * Rewrite band taxonomy slug
 *
 * @param array  $args Array of taxonomy arguments.
 * @param string $taxonomy The taxonomy slug.
 * @return array
 */
function bronze_band_url_rewrite() {
	add_rewrite_rule( '^artist-releases/([^/]*)$', 'index.php?band=$matches[1]', 'top' );
	flush_rewrite_rules();
}
add_action( 'admin_init', 'bronze_band_url_rewrite' );

/**
 * Add custom fields in work meta
 */
add_action(
	'bronze_work_meta',
	function() {
		bronze_the_work_meta();
	},
	15
);

add_filter(
	'bronze_work_meta_separator',
	function() {
		return ' &bull; ';
	}
);

/**
 * Set videos template folder
 */
function bronze_set_videos_template_url( $template_url ) {

	return bronze_get_template_url() . '/videos/';
}
add_filter( 'wolf_videos_template_url', 'bronze_set_videos_template_url' );

/**
 * Set video display
 *
 * @param string $string
 * @return string
 */
function bronze_set_video_display( $string ) {

	return 'grid';
}
add_filter( 'bronze_mod_video_display', 'bronze_set_video_display', 44 );


/**
 * @link https://wordpress.stackexchange.com/questions/161788/how-to-modify-a-taxonomy-thats-already-registered#answer-161789
 */

/**
 * Disable "label" taxonomy as it is a label theme
 */
function bronze_unregister_label_taxonomy() {

	global $wp_taxonomies;
	$taxonomy = 'label';

	if ( taxonomy_exists( $taxonomy ) ) {
		unset( $wp_taxonomies[ $taxonomy ] );
	}
}
// add_action( 'init', 'bronze_unregister_label_taxonomy');

/*
--------------------------------------------------------------------

	MODS

----------------------------------------------------------------------
*/

/**
 * Add mods
 */
function bronze_add_top_bar( $mods ) {

	if ( class_exists( 'Wolf_Vc_Content_Block' ) && class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {

		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array( '' => esc_html__( 'None', 'bronze' ) );
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'bronze' );
		}

		$mods['layout']['options']['top_bar_block_id'] = array(
			'label'       => esc_html__( 'Top Bar Block', 'bronze' ),
			'id'          => 'top_bar_block_id',
			'type'        => 'select',
			'choices'     => $content_blocks,
			'description' => esc_html__( 'A block to display above the navigation.', 'bronze' ),
		);

		$mods['layout']['options']['top_bar_closable'] = array(
			'label'       => esc_html__( 'Top Bar Closable', 'bronze' ),
			'id'          => 'top_bar_closable',
			'type'        => 'select',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'bronze' ),
				'no'  => esc_html__( 'No', 'bronze' ),
			),
			'description' => esc_html__( 'It will add a close button to the top bar.', 'bronze' ),
		);
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_add_top_bar', 40 );

/**
 * Add mods
 */
function bronze_add_metaboxes( $metaboxes ) {

	if ( class_exists( 'Wolf_Vc_Content_Block' ) && class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {

		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array(
			''     => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
			'none' => esc_html__( 'None', 'bronze' ),
		);
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'bronze' );
		}

		$metaboxes['site_settings']['metafields'][] = array(
			'label'   => esc_html__( 'Top bar Block', 'bronze' ),
			'id'      => '_post_top_bar_block_id',
			'type'    => 'select',
			'choices' => $content_blocks,
		);

		$metaboxes['site_settings']['metafields'][] = array(
			'label'       => esc_html__( 'Top Bar Closable', 'bronze' ),
			'id'          => '_post_top_bar_closable',
			'type'        => 'select',
			'choices'     => array(
				''    => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
				'yes' => esc_html__( 'Yes', 'bronze' ),
				'no'  => esc_html__( 'No', 'bronze' ),
			),
			'description' => esc_html__( 'It will add a close button to the top bar.', 'bronze' ),
		);
	}

		return $metaboxes;
}
add_filter( 'bronze_body_metaboxes', 'bronze_add_metaboxes', 40 );

/**
 * Remove unused mods
 *
 * @param array $mods The default mods.
 * @return void
 */
function bronze_remove_mods( $mods ) {

	// Unset

	unset( $mods['layout']['options']['button_style'] );
	// unset( $mods['layout']['options']['site_layout'] );

	unset( $mods['fonts']['options']['body_font_size'] );

	unset( $mods['wolf_videos']['options']['video_display'] );

	unset( $mods['shop']['options']['product_display'] );

	unset( $mods['navigation']['options']['menu_hover_style'] );
	// unset( $mods['navigation']['options']['menu_layout']['choices']['overlay'] );
	// unset( $mods['navigation']['options']['menu_layout']['choices']['lateral'] );
	unset( $mods['navigation']['options']['menu_layout']['choices']['offcanvas'] );
	unset( $mods['navigation']['options']['menu_skin'] );

	unset( $mods['header_settings']['options']['hero_scrolldown_arrow'] );

	// unset( $mods['navigation']['options']['menu_sticky_type']['choices']['soft'] );

	// unset( $mods['navigation']['options']['side_panel_position'] );

	// unset( $mods['blog']['options']['post_display'] );

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_remove_mods', 20 );

/**
 * Spinners folder
 */
add_filter(
	'bronze_spinners_folder',
	function() {
		return bronze_get_template_dirname() . '/components/spinners/';
	}
);

/**
 * Add mods
 */
function bronze_add_mods( $mods ) {

	$color_scheme = bronze_get_color_scheme();

	/*
	$mods['layout']['options']['custom_cursor'] = array(
		'id' => 'custom_cursor',
		'label' => esc_html__( 'Custom Cursor', 'bronze' ),
		'type' => 'select',
		'choices' => array(
			'' => esc_html__( 'Disabled', 'bronze' ),
			 'enabled' => esc_html__( 'Enabled', 'bronze' ),
		),
	);*/

	$mods['logo']['options']['one_letter_logo'] = array(
		'id'          => 'one_letter_logo',
		'label'       => esc_html__( 'One Letter Logo', 'bronze' ),
		'type'        => 'text',
		'description' => esc_html__( 'Enter just one letter to generate a navigation logo automatically.', 'bronze' ),
	);

	/*
	$mods['colors']['options']['secondary_accent_color'] = array(
		'id' => 'secondary_accent_color',
		'label' => esc_html__( 'Secondary Accent Color', 'bronze' ),
		'type' => 'color',
		'transport' => 'postMessage',
		'default' => $color_scheme[8],
	);*/

	$mods['loading'] = array(

		'id'      => 'loading',
		'title'   => esc_html__( 'Loading', 'bronze' ),
		'icon'    => 'update',
		'options' => array(

			array(
				'label'   => esc_html__( 'Loading Animation Type', 'bronze' ),
				'id'      => 'loading_animation_type',
				'type'    => 'select',
				'choices' => array(
					'none'    => esc_html__( 'None', 'bronze' ),
					'overlay' => esc_html__( 'Overlay', 'bronze' ),
					// 'overlay_logo' => esc_html__( 'Overlay with Logo', 'bronze' ),
				),
			),

			'loading_logo'       => array(
				'id'          => 'loading_logo',
				'description' => esc_html__( 'Add a loading logo to show on first page load.', 'bronze' ),
				'label'       => esc_html__( 'Loading Logo', 'bronze' ),
				'type'        => 'image',
			),

			'loading_overlay_bg' => array(
				'id'    => 'loading_overlay_bg',
				// 'description' => esc_html__( 'Overlay Background Image.', 'bronze' ),
				'label' => esc_html__( 'Overlay Background Image', 'bronze' ),
				'type'  => 'image',
			),
		),
	);

	// $mods['blog']['options']['post_skin'] = array(
	// 'label' => esc_html__( 'Color Tone in Loop', 'bronze' ),
	// 'id'    => 'post_skin',
	// 'type'  => 'select',
	// 'choices' => array(
	// 'dark' => esc_html__( 'Dark', 'bronze' ),
	// 'light' => esc_html__( 'Light', 'bronze' ),
	// ),
	// );

	$mods['blog']['options']['single_post_nav'] = array(
		'label'   => esc_html__( 'Prev/Next Post Pagination', 'bronze' ),
		'id'      => 'single_post_nav',
		'type'    => 'select',
		'choices' => array(
			'yes' => esc_html__( 'Yes', 'bronze' ),
			'no'  => esc_html__( 'No', 'bronze' ),
		),
	);

	$mods['blog']['options']['single_post_nav'] = array(
		'label'   => esc_html__( 'Prev/Next Post Pagination', 'bronze' ),
		'id'      => 'single_post_nav',
		'type'    => 'select',
		'choices' => array(
			'yes' => esc_html__( 'Yes', 'bronze' ),
			'no'  => esc_html__( 'No', 'bronze' ),
		),
	);

	// $mods['blog']['options']['date_format'] = array(
	// 'label' => esc_html__( 'Date Format', 'bronze' ),
	// 'id'    => 'date_format',
	// 'type'  => 'select',
	// 'choices' => array(
	// '' => esc_html__( 'Default', 'bronze' ),
	// 'human_diff' => esc_html__( '"X Time ago"', 'bronze' ),
	// 'custom' => esc_html__( 'Calendar Syle', 'bronze' ),
	// ),
	// );

	$mods['blog']['options']['post_hero_layout'] = array(
		'label'   => esc_html__( 'Single Post Header Layout', 'bronze' ),
		'id'      => 'post_hero_layout',
		'type'    => 'select',
		'choices' => array(
			''           => esc_html__( 'Default', 'bronze' ),
			'standard'   => esc_html__( 'Standard', 'bronze' ),
			'big'        => esc_html__( 'Big', 'bronze' ),
			'small'      => esc_html__( 'Small', 'bronze' ),
			'fullheight' => esc_html__( 'Full Height', 'bronze' ),
			'none'       => esc_html__( 'No header', 'bronze' ),
		),
	);

	$mods['blog']['options']['hide_single_post_featured_image'] = array(
		'label' => esc_html__( 'Hide Featured Image in Post', 'bronze' ),
		'id'    => 'hide_single_post_featured_image',
		'type'  => 'checkbox',
	);

	$content_blocks = array(
		'' => '&mdash; ' . esc_html__( 'None', 'bronze' ) . ' &mdash;',
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && class_exists( 'Wolf_Vc_Content_Block' ) && defined( 'WPB_VC_VERSION' ) ) {

		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'None', 'bronze' ) . ' &mdash;',
		);
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'bronze' );
		}
	}

	$mods['navigation']['options']['nav_overlay_left_block_id'] = array(
		'label'       => esc_html__( 'Navigation Overlay Left Panel Block', 'bronze' ),
		'id'          => 'nav_overlay_left_block_id',
		'type'        => 'select',
		// 'description' => sprintf( bronze_kses( __( 'If you choose the "Toggle Overlay" option above, select the <a href="%s" target="_blank">Content Block</a> to use as overlay content', 'bronze' ) ), 'http://wlfthm.es/content-blocks' ),
			'choices' => $content_blocks,
		'transport'   => 'postMessage',
	);

	$mods['navigation']['options']['nav_overlay_right_block_id'] = array(
		'label'     => esc_html__( 'Navigation Overlay Right Panel Block', 'bronze' ),
		'id'        => 'nav_overlay_right_block_id',
		'type'      => 'select',
		// 'description' => sprintf( bronze_kses( __( 'If you choose the "Toggle Overlay" option above, select the <a href="%s" target="_blank">Content Block</a> to use as overlay content', 'bronze' ) ), 'http://wlfthm.es/content-blocks' ),
		'choices'   => $content_blocks,
		'transport' => 'postMessage',
	);

	$mods['navigation']['options']['overlay_menu_label'] = array(
		'label'     => esc_html__( 'Overlay Menu Label', 'bronze' ),
		'id'        => 'overlay_menu_label',
		'type'      => 'text',
		'transport' => 'postMessage',
	);

	$mods['navigation']['options']['nav_player_mp3'] = array(
		'label' => esc_html__( 'Add a minimalist player to the navbar', 'bronze' ),
		'id'    => 'nav_player_mp3',
		'type'  => 'media',
	);

	$mods['navigation']['options']['show_nav_player'] = array(
		'label'   => esc_html__( 'Show Navigation Player by Default', 'bronze' ),
		'id'      => 'show_nav_player',
		'type'    => 'select',
		'choices' => array(
			''    => esc_html__( 'No', 'bronze' ),
			'yes' => esc_html__( 'Yes', 'bronze' ),
		),
	);

	$mods['navigation']['options']['nav_spotify_button'] = array(
		'label'   => esc_html__( 'Add a Spotify button to the navbar', 'bronze' ),
		'id'      => 'nav_spotify_button',
		'type'    => 'select',
		'choices' => array(
			''    => esc_html__( 'No', 'bronze' ),
			'yes' => esc_html__( 'Yes', 'bronze' ),
		),
	);

	$mods['navigation']['options']['nav_spotify_url'] = array(
		'label'       => esc_html__( 'Your Spotify URL', 'bronze' ),
		'id'          => 'nav_spotify_url',
		'type'        => 'text',
		'description' => sprintf( bronze_kses( __( '<a href="%s" target="_blank">Where to find it</a>', 'bronze' ) ), 'https://streamingcharts.com.au/wp-content/uploads/2018/03/artstlink.png' ),
	);

	$mods['navigation']['options']['hero_font_tone'] = array(
		'label'     => esc_html__( 'Default font tone', 'bronze' ),
		'id'        => 'hero_font_tone',
		'type'      => 'select',
		'choices'   => array(
			''      => esc_html__( 'Default', 'bronze' ),
			'dark'  => esc_html__( 'Dark', 'bronze' ),
			'light' => esc_html__( 'Light', 'bronze' ),
		),
		'transport' => 'postMessage',
	);

	/*
	$mods['navigation']['options']['side_panel_bg_img'] = array(
		'label'	=> esc_html__( 'Side Panel Background', 'bronze' ),
		'id'	=> 'side_panel_bg_img',
		'type'	=> 'image',
	);*/

	// $mods['navigation']['options']['overlay_menu_bg_img'] = array(
	// 'label' => esc_html__( 'Overlay Menu Background', 'bronze' ),
	// 'id'    => 'overlay_menu_bg_img',
	// 'type'  => 'image',
	// );

	// $mods['navigation']['options']['mobile_menu_bg_img'] = array(
	// 'label' => esc_html__( 'Mobile Menu Background', 'bronze' ),
	// 'id'    => 'mobile_menu_bg_img',
	// 'type'  => 'image',
	// );

	// $mods['navigation']['options']['menu_offset'] = array(
	// 'id' => 'menu_offset',
	// 'label' => esc_html__( 'Menu Offset Top', 'bronze' ),
	// 'type' => 'text',
	// 'placeholder' => 400,
	// 'description' => sprintf( bronze_kses( __( 'Enter %s to display the navbar at the bottom of the screen', 'bronze' ) ), '100%' ),
	// );

	if ( isset( $mods['wolf_videos'] ) ) {

		$mods['wolf_videos']['options']['video_skin'] = array(
			'label'   => esc_html__( 'Color Tone in Loop', 'bronze' ),
			'id'      => 'video_skin',
			'type'    => 'select',
			'choices' => array(
				'dark'  => esc_html__( 'Dark', 'bronze' ),
				'light' => esc_html__( 'Light', 'bronze' ),
			),
		);

		$mods['wolf_videos']['options']['video_hero_layout'] = array(
			'label'   => esc_html__( 'Single Video Header Layout', 'bronze' ),
			'id'      => 'video_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'bronze' ),
				'standard'   => esc_html__( 'Standard', 'bronze' ),
				'big'        => esc_html__( 'Big', 'bronze' ),
				'small'      => esc_html__( 'Small', 'bronze' ),
				'fullheight' => esc_html__( 'Full Height', 'bronze' ),
				'none'       => esc_html__( 'No header', 'bronze' ),
			),
		);

		$mods['wolf_videos']['options']['video_category_filter'] = array(
			'id'    => 'video_category_filter',
			'label' => esc_html__( 'Category filter (not recommended with a lot of videos)', 'bronze' ),
			'type'  => 'checkbox',
		);

		$mods['wolf_videos']['options']['products_per_page'] = array(
			'label' => esc_html__( 'Videos per Page', 'bronze' ),
			'id'    => 'videos_per_page',
			'type'  => 'text',
		);

		$mods['wolf_videos']['options']['video_pagination'] = array(
			'id'      => 'video_pagination',
			'label'   => esc_html__( 'Video Archive Pagination', 'bronze' ),
			'type'    => 'select',
			'choices' => array(
				'standard_pagination' => esc_html__( 'Numeric Pagination', 'bronze' ),
				// 'ajax_pagination' => esc_html__( 'AJAX Pagination', 'bronze' ),
				'load_more'           => esc_html__( 'Load More Button', 'bronze' ),
				// 'infinitescroll' => esc_html__( 'Infinite Scroll', 'bronze' ),
			),
		);

		$mods['wolf_videos']['options']['video_display_elements'] = array(
			'id'          => 'video_display_elements',
			'label'       => esc_html__( 'Post meta to show in single video page', 'bronze' ),
			'type'        => 'group_checkbox',
			'choices'     => array(
				'show_date'       => esc_html__( 'Date', 'bronze' ),
				'show_author'     => esc_html__( 'Author', 'bronze' ),
				'show_category'   => esc_html__( 'Category', 'bronze' ),
				'show_tags'       => esc_html__( 'Tags', 'bronze' ),
				'show_extra_meta' => esc_html__( 'Extra Meta', 'bronze' ),
			),
			'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'bronze' ),
		);

		if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {

			$mods['wolf_videos']['options'][] = array(
				'label'   => esc_html__( 'Enable Custom Post Meta', 'bronze' ),
				'id'      => 'video_enable_custom_post_meta',
				'type'    => 'group_checkbox',
				'choices' => array(
					'video_enable_views' => esc_html__( 'Views', 'bronze' ),
					'video_enable_likes' => esc_html__( 'Likes', 'bronze' ),
				),
			);
		}
	}

	if ( isset( $mods['portfolio'] ) ) {
		// $mods['portfolio']['options']['work_skin'] = array(
		// 'label' => esc_html__( 'Color Tone in Loop', 'bronze' ),
		// 'id'    => 'work_skin',
		// 'type'  => 'select',
		// 'choices' => array(
		// 'dark' => esc_html__( 'Dark', 'bronze' ),
		// 'light' => esc_html__( 'Light', 'bronze' ),
		// ),
		// 'transport' => 'postMessage',
		// );
		$mods['portfolio']['options']['work_hero_layout'] = array(
			'label'   => esc_html__( 'Single Work Header Layout', 'bronze' ),
			'id'      => 'work_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'bronze' ),
				'standard'   => esc_html__( 'Standard', 'bronze' ),
				'big'        => esc_html__( 'Big', 'bronze' ),
				'small'      => esc_html__( 'Small', 'bronze' ),
				'fullheight' => esc_html__( 'Full Height', 'bronze' ),
				'none'       => esc_html__( 'No header', 'bronze' ),
			),
			// 'transport' => 'postMessage',
		);
	}

	if ( isset( $mods['wolf_events'] ) ) {
		$mods['wolf_events']['options']['event_hero_layout'] = array(
			'label'   => esc_html__( 'Single Event Header Layout', 'bronze' ),
			'id'      => 'event_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'bronze' ),
				'standard'   => esc_html__( 'Standard', 'bronze' ),
				'big'        => esc_html__( 'Big', 'bronze' ),
				'small'      => esc_html__( 'Small', 'bronze' ),
				'fullheight' => esc_html__( 'Full Height', 'bronze' ),
				'none'       => esc_html__( 'No header', 'bronze' ),
			),
			// 'transport' => 'postMessage',
		);
	}

	if ( isset( $mods['shop'] ) && class_exists( 'WooCommerce' ) ) {

		$mods['shop']['options']['product_skin'] = array(
			'label'   => esc_html__( 'Color Tone in Loop', 'bronze' ),
			'id'      => 'product_skin',
			'type'    => 'select',
			'choices' => array(
				'dark'  => esc_html__( 'Dark', 'bronze' ),
				'light' => esc_html__( 'Light', 'bronze' ),
			),
			// 'transport' => 'postMessage',
		);

		$mods['shop']['options']['product_bg_color'] = array(
			'label' => esc_html__( 'Product Background Color in Loop', 'bronze' ),
			'id'    => 'product_bg_color',
			'type'  => 'color',
			// 'transport' => 'postMessage',
		);

		$mods['shop']['options']['product_sticky'] = array(
			'label'       => esc_html__( 'Stacked Images with Sticky Product Details', 'bronze' ),
			'id'          => 'product_sticky',
			'type'        => 'checkbox',
			'description' => esc_html__( 'Not compatible with sidebar layouts.', 'bronze' ),
		);
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_add_mods', 40 );

/*
--------------------------------------------------------------------

	CUSTOM FUNCTIONS

----------------------------------------------------------------------
*/

/**
 * Custom calendar date format
 */
function bronze_custom_date( $date = '' ) {

	$date = ( $date ) ? $date : get_the_date( 'Y/m/d' );

	list( $year, $monthnbr, $day ) = explode( '/', $date );
	$search                        = array( '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12' );
	$replace                       = array( esc_html__( 'Jan', 'bronze' ), esc_html__( 'Feb', 'bronze' ), esc_html__( 'Mar', 'bronze' ), esc_html__( 'Apr', 'bronze' ), esc_html__( 'May', 'bronze' ), esc_html__( 'Jun', 'bronze' ), esc_html__( 'Jul', 'bronze' ), esc_html__( 'Aug', 'bronze' ), esc_html__( 'Sep', 'bronze' ), esc_html__( 'Oct', 'bronze' ), esc_html__( 'Nov', 'bronze' ), esc_html__( 'Dec', 'bronze' ) );
	$month                         = str_replace( $search, $replace, $monthnbr );

	$output = '<div class="date-format-custom wvc-bigtext"><span class="custom-date-day">' . $day . '</span><span class="custom-date-month">' . $month . '</span>';

	if ( 1 < absint( date( 'Y' ) ) - $year ) {
		$output .= '<span class="custom-date-year">' . $year . '</span>';
	}

	$output .= '</div>';

	return $output;
}

/*
--------------------------------------------------------------------

	DEFAULT MODS & SETTINGS

----------------------------------------------------------------------
*/

/**
 * Filter WVC theme accent color
 *
 * @param string $color
 * @return string $color
 */
function bronze_set_wvc_secondary_theme_accent_color( $color ) {
	return bronze_get_inherit_mod( 'secondary_accent_color' );
}
add_filter( 'wvc_theme_secondary_accent_color', 'bronze_set_wvc_theme_secondary_accent_color' );

/**
 * Add theme secondary accent color to shared colors
 *
 * @param array $colors
 * @return array $colors
 */
function bronze_wvc_add_secondary_accent_color_option( $colors ) {

	$colors = array( esc_html__( 'Theme Secondary Accent Color', 'bronze' ) => 'secondary_accent' ) + $colors;

	return $colors;
}
add_filter( 'wvc_shared_colors', 'bronze_wvc_add_secondary_accent_color_option' );

/**
 * Filter WVC shared color hex
 *
 * @param array $colors
 * @return array $colors
 */
function bronze_add_secondary_accent_color_hex( $colors ) {

	$secondary_accent_color = bronze_get_inherit_mod( 'secondary_accent_color' );

	if ( $secondary_accent_color ) {
		$colors['secondary_accent'] = apply_filters( 'wvc_secondary_theme_accent_color', $secondary_accent_color );
	}

	$colors['darkgrey'] = '#0a0a0a';

	return $colors;
}
add_filter( 'wvc_shared_colors_hex', 'bronze_add_secondary_accent_color_hex' );

/**
 *  Set default icon font
 *
 * @param string $shape
 * @return string $shape
 */
function bronze_set_default_icon_font( $shape ) {
	return 'iconmonstr-iconic-font';
}
add_filter( 'wvc_default_icon_font', 'bronze_set_default_icon_font', 40 );

/**
 *  Set default item overlay color
 *
 * @param string $color
 * @return string $color
 */
function bronze_set_default_item_overlay_color( $color ) {
	return 'auto';
}
add_filter( 'wvc_default_item_overlay_color', 'bronze_set_default_item_overlay_color' );

function bronze_set_default_hero_font_tone( $tone ) {
	return bronze_get_inherit_mod( 'hero_font_tone', 'dark' );
}
add_filter( 'bronze_default_no_header_hero_font_tone', 'bronze_set_default_hero_font_tone' );

/**
 *  Set default item overlay text color
 *
 * @param string $color
 * @return string $color
 */
function bronze_set_item_overlay_text_color( $color ) {
	return 'white';
}
add_filter( 'wvc_default_item_overlay_text_color', 'bronze_set_item_overlay_text_color' );

/**
 *  Set default item overlay opacity
 *
 * @param int $color
 * @return int $color
 */
function bronze_set_item_overlay_opacity( $opacity ) {
	return 30;
}
add_filter( 'wvc_default_item_overlay_opacity', 'bronze_set_item_overlay_opacity' );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function bronze_overwrite_excerpt_length( $length ) {

	return 23;
}
add_filter( 'bronze_excerpt_length', 'bronze_overwrite_excerpt_length' );

/**
 *  Set menu skin
 *
 * @param string $skin
 * @return string $skin
 */
function bronze_set_menu_skin( $skin ) {
	return 'dark';
}
// add_filter( 'bronze_mod_menu_skin', 'bronze_set_menu_skin', 40 );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function bronze_overwrite_sticky_menu_height( $length ) {

	return 66;
}
add_filter( 'bronze_sticky_menu_height', 'bronze_overwrite_sticky_menu_height' );

/**
 * Set menu hover effect
 *
 * @param string $string
 * @return string
 */
function bronze_set_menu_hover_style( $string ) {
	// return 'm-underline';
	return '';
}
add_filter( 'bronze_mod_menu_hover_style', 'bronze_set_menu_hover_style' );

/**
 * Standard row width
 */
add_filter(
	'wvc_row_standard_width',
	function( $string ) {
		return '1400px';
	},
	40
);

add_filter(
	'wvc_row_small_width',
	function( $string ) {
		return '960px';
	},
	40
);

/**
 * Load more pagination hash change
 */
add_filter(
	'bronze_loadmore_pagination_hashchange',
	function( $size ) {
		return false;
	},
	40
);

/**
 *  Set embed video title
 *
 * @param string $title
 * @return string $title
 */
function wvc_set_embed_video_title( $title ) {

	return esc_html__( '&mdash; %s', 'bronze' );
}
add_filter( 'wvc_embed_video_title', 'wvc_set_embed_video_title', 40 );

/**
 *  Set embed video title
 *
 * @param string $title
 * @return string $title
 */
function bronze_set_default_video_opener_button( $title ) {

	return '<span class="video-opener" data-aos="fade" data-aos-once="true"></span>';
}
add_filter( 'wvc_default_video_opener_button', 'bronze_set_default_video_opener_button', 40 );

/**
 *  Set default pie chart line width
 *
 * @param string $width
 * @return string $width
 */
function wvc_set_default_pie_chart_line_width( $width ) {
	return 15;
}
add_filter( 'wvc_default_pie_chart_line_width', 'wvc_set_default_pie_chart_line_width', 40 );



/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function bronze_set_default_wvc_button_shape( $shape ) {
	return 'boxed';
}
add_filter( 'wvc_default_button_shape', 'bronze_set_default_wvc_button_shape', 40 );

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function bronze_set_default_theme_button_shape( $shape ) {
	return 'square';
}
add_filter( 'bronze_mod_button_style', 'bronze_set_default_theme_button_shape', 40 );

/**
 * Default font weight
 */
add_filter(
	'wvc_button_default_font_weight',
	function( $font_weight ) {
		return 700;
	}
);

/**
 *  Set default team member v align
 *
 * @param string $string
 * @return string $string
 */
function wvc_set_default_team_member_text_vertical_alignement( $string ) {

	return 'bottom';
}
add_filter( 'wvc_default_team_member_text_vertical_alignement', 'wvc_set_default_team_member_text_vertical_alignement', 40 );

/**
 *  Set default heading layout
 *
 * @param string $layout
 * @return string $layout
 */
function wvc_set_default_team_member_layout( $layout ) {
	return 'overlay';
}
add_filter( 'wvc_default_team_member_layout', 'wvc_set_default_team_member_layout', 40 );

/**
 *  Set default team member socials_args
 *
 * @param string $args
 * @return string $args
 */
function wvc_set_default_team_member_socials_args( $args ) {

	$args['background_style'] = 'rounded';
	$args['background_color'] = 'white';
	$args['custom_color']     = '#000000';
	$args['size']             = 'fa-1x';

	return $args;
}
add_filter( 'wvc_team_member_socials_args', 'wvc_set_default_team_member_socials_args', 40 );

/**
 *  Set default team member title font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_team_member_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_team_member_title_font_size', 'wvc_set_default_team_member_font_size', 40 );
add_filter( 'wvc_default_single_image_title_font_size', 'wvc_set_default_team_member_font_size', 40 );

/**
 *  Set default heading font size
 *
 * @param int $font_size
 * @return int $font_size
 */
function wvc_set_default_custom_heading_font_size( $font_size ) {
	return 32;
}
add_filter( 'wvc_default_custom_heading_font_size', 'wvc_set_default_custom_heading_font_size', 40 );
add_filter( 'wvc_default_advanced_slide_title_font_size', 'wvc_set_default_custom_heading_font_size', 40 );

/**
 *  Set default heading font family
 *
 * @param string $font_family
 * @return string $font_family
 */
function bronze_set_default_custom_heading_font_family( $font_family ) {
	return 'Staatliches';
}
add_filter( 'wvc_default_bigtext_font_family', 'bronze_set_default_custom_heading_font_family', 40 );
// add_filter( 'wvc_default_advanced_slide_title_font_family', 'bronze_set_default_custom_heading_font_family', 40 );
// add_filter( 'wvc_default_custom_heading_font_family', 'bronze_set_default_custom_heading_font_family', 40 );
// add_filter( 'wvc_default_cta_font_family', 'bronze_set_default_custom_heading_font_family', 40 );

/**
 *  Set default heading font weight
 *
 * @param string $font_weight
 * @return string $font_weight
 */
function bronze_set_default_custom_heading_font_weight( $font_weight ) {
	return '';
}
add_filter( 'wvc_default_advanced_slide_title_font_weight', 'bronze_set_default_custom_heading_font_weight', 40 );
add_filter( 'wvc_default_custom_heading_font_weight', 'bronze_set_default_custom_heading_font_weight', 40 );
add_filter( 'wvc_default_bigtext_font_weight', 'bronze_set_default_custom_heading_font_weight', 40 );
add_filter( 'wvc_default_cta_font_weight', 'bronze_set_default_custom_heading_font_weight', 40 );
add_filter( 'wvc_default_pie_font_weight', 'bronze_set_default_custom_heading_font_weight', 40 );

/**
 *  Set default heading font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_cta_font_size( $font_size ) {
	return 22;
}
add_filter( 'wvc_default_cta_font_size', 'wvc_set_default_cta_font_size', 40 );

/**
 * Post Slider color tone
 */
function bronze_add_post_slider_color_block() {
	?>
	<div class="wvc-big-slide-color-block" style="background-color:<?php echo wvc_color_brightness( wvc_get_image_dominant_color( get_post_thumbnail_id() ), 10 ); ?>"></div>
	<?php
}
add_action( 'wvc_post_big_slide_start', 'bronze_add_post_slider_color_block' );

/*
--------------------------------------------------------------------

	BUTTONS

----------------------------------------------------------------------
*/

/**
 * Custom button types
 */
function bronze_custom_button_types() {
	return array(
		esc_html__( 'Custom', 'bronze' )           => 'default',
		// esc_html__( 'Special Accent', 'bronze' ) => 'theme-button-special-accent',
		// esc_html__( 'Special Secondary Accent', 'bronze' ) => 'theme-button-special-accent-secondary',
		esc_html__( 'Solid Accent', 'bronze' )     => 'theme-button-solid-accent',
		esc_html__( 'Solid Accent Alt', 'bronze' ) => 'theme-button-outline-accent',
		// esc_html__( 'Solid Accent Secondary', 'bronze' ) => 'theme-button-solid-accent-secondary',
		// esc_html__( 'Solid Accent Secondary Alt', 'bronze' ) => 'theme-button-outline-accent-secondary',
		// esc_html__( 'Simple Text Accent', 'bronze' ) => 'theme-button-text-accent',
		// esc_html__( 'Simple Text Accent Secondary', 'bronze' ) => 'theme-button-text-accent-secondary',
		// esc_html__( 'Special', 'bronze' ) => 'theme-button-special',
		esc_html__( 'Solid', 'bronze' )            => 'theme-button-solid',
		esc_html__( 'Outline', 'bronze' )          => 'theme-button-outline',
		esc_html__( 'Simple Text', 'bronze' )      => 'theme-button-text',
		// esc_html__( 'Simple Text Alt', 'bronze' ) => 'theme-button-simple-alt',
	);
}

/**
 * Primary Special buttons class
 *
 * @param string $string
 * @return string
 */
function bronze_set_primary_special_button_class( $class ) {

	$milu_button_class = 'theme-button-solid';

	$class = $milu_button_class . ' wvc-button wvc-button-size-sm';

	return $class;
}
add_filter( 'wvc_last_posts_big_slide_button_class', 'bronze_set_primary_special_button_class' );

/**
 * Primary Special buttons class
 *
 * @param string $string
 * @return string
 */
function bronze_set_load_more_button_class( $class ) {

	$milu_button_class = 'theme-button-solid';

	$class = $milu_button_class . ' wvc-button wvc-button-size-sm';

	return $class;
}
add_filter( 'bronze_loadmore_button_class', 'bronze_set_load_more_button_class' );

/**
 * Primary Outline buttons class
 *
 * @param string $string
 * @return string
 */
function bronze_set_primary_button_class( $class ) {

	$milu_button_class = 'theme-button-solid';

	$class = $milu_button_class . ' wvc-button wvc-button-size-sm';

	return $class;
}
add_filter( 'bronze_404_button_class', 'bronze_set_primary_button_class' );
add_filter( 'bronze_single_event_buy_ticket_button_class', 'bronze_set_primary_button_class' );

/**
 * Event ticket button class
 *
 * @param string $string
 * @return string
 */
function bronze_set_single_add_to_cart_button_class( $class ) {

	$class = 'single_add_to_cart_button button theme-button-solid-accent';

	return $class;
}
add_filter( 'bronze_single_add_to_cart_button_class', 'bronze_set_single_add_to_cart_button_class', 40 );

/**
 * Main buttons class
 *
 * @param string $string
 * @return string
 */
function bronze_set_alt_button_class( $class ) {

	$milu_button_class = 'theme-button-solid';

	$class = $milu_button_class . ' wvc-button wvc-button-size-xs';

	return $class;
}
add_filter( 'bronze_release_button_class', 'bronze_set_alt_button_class' );

/**
 * Text buttons class
 *
 * @param string $string
 * @return string
 */
function bronze_set_more_link_button_class( $class ) {

	$milu_button_class = 'theme-button-text';

	$class = $milu_button_class . ' wvc-button wvc-button-size-xs';

	return $class;
}
add_filter( 'bronze_more_link_button_class', 'bronze_set_more_link_button_class' );
add_filter( 'wvc_showcase_vertical_carousel_button_class', 'bronze_set_more_link_button_class' );

/**
 * Author box buttons class
 *
 * @param string $string
 * @return string
 */
function bronze_set_author_box_button_class( $class ) {

	$class = ' wvc-button wvc-button-size-xs theme-button-text';

	return $class;
}
add_filter( 'bronze_author_page_link_button_class', 'bronze_set_author_box_button_class' );

/**
 * Add button dependencies
 */
function bronze_add_button_dependency_params() {

	if ( ! class_exists( 'WPBMap' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WVC_OK' ) || ! WVC_OK ) {
		return;
	}

	$param               = WPBMap::getParam( 'vc_button', 'color' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_button', 'shape' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_button', 'hover_effect' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_color' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_shape' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_hover_effect' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b1_color' );
	$param['dependency'] = array(
		'element' => 'b1_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b1_shape' );
	$param['dependency'] = array(
		'element' => 'b1_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b1_hover_effect' );
	$param['dependency'] = array(
		'element' => 'b1_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b2_color' );
	$param['dependency'] = array(
		'element' => 'b2_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b2_shape' );
	$param['dependency'] = array(
		'element' => 'b2_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b2_hover_effect' );
	$param['dependency'] = array(
		'element' => 'b2_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );
}
add_action( 'init', 'bronze_add_button_dependency_params', 15 );

add_filter(
	'wvc_default_testimonial_slider_text_alignment',
	function() {
		return 'left';
	},
	100
);

/**
 *  Add background loader effect
 *
 * @param string $effects
 * @return string $effects
 */
function bronze_add_wvc_custom_background_effect( $effects ) {

	if ( function_exists( 'vc_add_param' ) ) {

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Filmgrain Overlay', 'bronze' ),
				'param_name' => 'add_filmgrain',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Grunge Overlay', 'bronze' ),
				'param_name' => 'add_grunge',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Noise Overlay', 'bronze' ),
				'param_name' => 'add_noise',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Filmgrain Overlay', 'bronze' ),
				'param_name' => 'add_filmgrain',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Grunge Overlay', 'bronze' ),
				'param_name' => 'add_grunge',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Noise Overlay', 'bronze' ),
				'param_name' => 'add_noise',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'wvc_advanced_slide',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Filmgrain Overlay', 'bronze' ),
				'param_name' => 'add_filmgrain',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'wvc_advanced_slide',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Grunge Overlay', 'bronze' ),
				'param_name' => 'add_grunge',
				// 'group' => esc_html__( 'Background', 'bronze' ),
			)
		);

		vc_add_param(
			'wvc_advanced_slide',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Noise Overlay', 'bronze' ),
				'param_name' => 'add_noise',
				// 'group' => esc_html__( 'Background', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Filmgrain Overlay', 'bronze' ),
				'param_name' => 'add_filmgrain',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Grunge Overlay', 'bronze' ),
				'param_name' => 'add_grunge',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Noise Overlay', 'bronze' ),
				'param_name' => 'add_noise',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column_inner',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Filmgrain Overlay', 'bronze' ),
				'param_name' => 'add_filmgrain',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column_inner',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Grunge Overlay', 'bronze' ),
				'param_name' => 'add_grunge',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'vc_column_inner',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Noise Overlay', 'bronze' ),
				'param_name' => 'add_noise',
				'group'      => esc_html__( 'Style', 'bronze' ),
			)
		);

		vc_add_param(
			'rev_slider_vc',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Preloader Background', 'bronze' ),
				'param_name' => 'preloader_bg',
			)
		);
	}
}
add_action( 'init', 'bronze_add_wvc_custom_background_effect' );

/**
 *  Add work gallery
 *
 * @param string $effects
 * @return string $effects
 */
function bronze_add_work_gallery_param( $effects ) {

	if ( function_exists( 'vc_add_param' ) ) {
		vc_add_param(
			'wvc_work_index',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Use as gallery', 'bronze' ),
				'param_name' => 'work_is_gallery',
				'desc'       => esc_html__( 'The first gallery in the posts will open directly in a lightbox.', 'bronze' ),
			)
		);
	}
}
add_action( 'init', 'bronze_add_work_gallery_param' );

/**
 * Filter button attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_button_atts( $atts ) {

	// button
	if ( isset( $atts['button_type'] ) && 'default' !== $atts['button_type'] ) {
		$atts['shape']        = '';
		$atts['color']        = '';
		$atts['hover_effect'] = '';
		$atts['el_class']    .= ' ' . $atts['button_type'];
	}

	return $atts;
}
add_filter( 'wvc_button_atts', 'woltheme_filter_button_atts' );

/**
 * Filter banner button attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $btn_params the button attribute to filter
 * @return array $btn_params
 */
function woltheme_filter_banner_button_atts( $btn_params, $atts ) {

	// button
	if ( isset( $atts['btn_button_type'] ) && 'default' !== $atts['btn_button_type'] ) {
		$btn_params['shape']        = '';
		$btn_params['color']        = '';
		$btn_params['hover_effect'] = '';
		$btn_params['el_class']    .= ' ' . $atts['btn_button_type'];
	}

	return $btn_params;
}
add_filter( 'wvc_banner_button_atts', 'woltheme_filter_banner_button_atts', 10, 2 );

/**
 * Filter audio button attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_audio_button_atts( $atts ) {

	// button
	if ( isset( $atts['btn_button_type'] ) && 'default' !== $atts['btn_button_type'] ) {
		$atts['shape']        = '';
		$atts['color']        = '';
		$atts['hover_effect'] = '';
		$atts['el_class']    .= ' ' . $atts['btn_button_type'];
	}

	return $atts;
}
add_filter( 'wvc_audio_button_atts', 'woltheme_filter_audio_button_atts' );

add_filter(
	'wvc_revslider_container_class',
	function( $class, $atts ) {

		if ( isset( $atts['preloader_bg'] ) && 'true' === $atts['preloader_bg'] ) {
			$class .= ' wvc-preloader-bg';
		}

		return $class;

	},
	10,
	2
);

/**
 * Filter CTA button attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $btn_params the button attribute to filter
 * @return array $btn_params
 */
function woltheme_filter_cta_button_atts( $btn_params, $atts ) {

	// button
	if ( isset( $atts['btn_button_type'] ) && 'default' !== $atts['btn_button_type'] ) {
		$btn_params['shape']        = '';
		$btn_params['color']        = '';
		$btn_params['hover_effect'] = '';
		$btn_params['el_class']    .= ' ' . $atts['btn_button_type'];
	}

	return $btn_params;
}
add_filter( 'wvc_cta_button_atts', 'woltheme_filter_cta_button_atts', 10, 2 );

/**
 * Filter advanced slider button 1 attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $b1_params the button attribute to filter
 * @return array $b1_params
 */
function woltheme_filter_b1_button_atts( $b1_params, $atts ) {

	// button
	if ( isset( $atts['b1_button_type'] ) && 'default' !== $atts['b1_button_type'] ) {
		$b1_params['shape']        = '';
		$b1_params['color']        = '';
		$b1_params['hover_effect'] = '';
		$b1_params['el_class']    .= ' ' . $atts['b1_button_type'];
	}

	return $b1_params;
}
add_filter( 'wvc_advanced_slider_b1_button_atts', 'woltheme_filter_b1_button_atts', 10, 2 );

/**
 * Filter advanced slider button 1 attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $b2_params the button attribute to filter
 * @return array $b2_params
 */
function woltheme_filter_b2_button_atts( $b2_params, $atts ) {

	// button
	if ( isset( $atts['b2_button_type'] ) && 'default' !== $atts['b2_button_type'] ) {
		$b2_params['shape']        = '';
		$b2_params['color']        = '';
		$b2_params['hover_effect'] = '';
		$b2_params['el_class']    .= ' ' . $atts['b2_button_type'];
	}

	return $b2_params;
}
add_filter( 'wvc_advanced_slider_b2_button_atts', 'woltheme_filter_b2_button_atts', 10, 2 );

/**
 * Add theme button option to Button element
 */
function bronze_add_theme_buttons() {

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_button',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'bronze' ),
					'param_name' => 'button_type',
					'type'       => 'dropdown',
					'value'      => bronze_custom_button_types(),
					'weight'     => 1000,
				),
			)
		);

		vc_add_params(
			'vc_cta',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'bronze' ),
					'param_name' => 'btn_button_type',
					'type'       => 'dropdown',
					'value'      => bronze_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button', 'bronze' ),
				),
			)
		);

		vc_add_params(
			'wvc_audio_button',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'bronze' ),
					'param_name' => 'btn_button_type',
					'type'       => 'dropdown',
					'value'      => bronze_custom_button_types(),
					'weight'     => 10,
					// 'group' => esc_html__( 'Button', 'bronze' ),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'bronze' ),
					'param_name' => 'b1_button_type',
					'type'       => 'dropdown',
					'value'      => bronze_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button 1', 'bronze' ),
					'dependency' => array(
						'element' => 'add_button_1',
						'value'   => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'bronze' ),
					'param_name' => 'b2_button_type',
					'type'       => 'dropdown',
					'value'      => bronze_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button 2', 'bronze' ),
					'dependency' => array(
						'element' => 'add_button_2',
						'value'   => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'wvc_banner',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'bronze' ),
					'param_name' => 'btn_button_type',
					'type'       => 'dropdown',
					'value'      => bronze_custom_button_types(),
					// 'weight' => 10,
					'group'      => esc_html__( 'Button', 'bronze' ),
				),
			)
		);

		// vc_add_params(
		// 'vc_custom_heading',
		// array(
		// array(
		// 'heading' => esc_html__( 'Style', 'bronze' ),
		// 'param_name' => 'style',
		// 'type' => 'dropdown',
		// 'value' => array(
		// esc_html__( 'Default', 'bronze' ) => '',
		// esc_html__( 'Theme Style', 'bronze' ) => 'theme-heading',
		// ),
		// 'weight' => 10,
		// ),
		// )
		// );

		/*
		vc_add_params(
			'wvc_product_index',
			array(
				array(
					'heading' => esc_html__( 'Layout', 'bronze' ),
					'param_name' => 'product_layout',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Standard', 'bronze' ) => 'standard',
						esc_html__( 'Overlay', 'bronze' ) => 'overlay',
						esc_html__( 'Label', 'bronze' ) => 'label',
					),
					'weight' => 10,
				),
			)
		);*/

		vc_add_params(
			'wvc_work_index',
			array(
				array(
					'heading'    => esc_html__( 'Filter Alignement', 'bronze' ),
					'param_name' => 'work_category_filter_text_alignment',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Centered', 'bronze' ) => 'center',
						esc_html__( 'Spread', 'bronze' ) => 'spread',
					),
					'dependency' => array(
						'element' => 'work_category_filter',
						'value'   => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'wvc_video_index',
			array(
				array(
					'heading'    => esc_html__( 'Filter Alignement', 'bronze' ),
					'param_name' => 'video_category_filter_text_alignment',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Centered', 'bronze' ) => 'center',
						esc_html__( 'Spread', 'bronze' ) => 'spread',
					),
					'dependency' => array(
						'element' => 'video_category_filter',
						'value'   => array( 'true' ),
					),
				),
			)
		);
	}
}
add_action( 'init', 'bronze_add_theme_buttons' );

function bronze_filter_menu_custom_field( $output, $item_id ) {

	ob_start();
	?>
	<p class="field-_mega-menu description description-wide">
		<label for="edit-_mega-menu-<?php echo esc_attr( $item_id ); ?>">
			<input name="_mega-menu[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_mega-menu', true ), 'on' ); ?>>
			<?php esc_html_e( 'Mega Menu (only available for first level items)', 'bronze' ); ?>
		</label>
	</p>

	<p class="field-_menu-item-not-linked description description-wide">
		<label for="edit-_menu-item-not-linked-<?php echo esc_attr( $item_id ); ?>">
			<input name="_menu-item-not-linked[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-not-linked', true ), 'on' ); ?>>
			<?php esc_html_e( 'Mega Menu 2nd level or dropdown item', 'bronze' ); ?>
		</label>
	</p>

	<p class="field-_menu-item-hidden description description-wide">
		<label for="edit-_menu-item-hidden-<?php echo esc_attr( $item_id ); ?>">
			<input name="_menu-item-hidden[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-hidden', true ), 'on' ); ?>>
			<?php esc_html_e( 'Hide item on mega menu (for mega menu 2nd level only)', 'bronze' ); ?>
		</label>
	</p>

	<p class="field-_menu-item-button-class description description-wide">
		<label for="edit-_menu-item-button-class-<?php echo esc_attr( $item_id ); ?>">
			<select name="_menu-item-button-class[<?php echo esc_attr( $item_id ); ?>]">
				<option value=""><?php esc_html_e( 'None', 'bronze' ); ?></option>
				<?php
				echo 'test';
				$button_types = bronze_custom_button_types();
					array_shift( $button_types );
				foreach ( $button_types as $key => $btn_class ) {
					$btn_class = str_replace( 'theme-', 'nav-', $btn_class );
					?>
						<option value="<?php echo esc_attr( $btn_class ); ?>" <?php selected( get_post_meta( $item_id, '_menu-item-button-class', true ), $btn_class ); ?>><?php echo esc_attr( $key ); ?></option>
						<?php
				}
				?>
			</select>
			<?php esc_html_e( 'Button Style (only available for first level items)', 'bronze' ); ?>
		</label>
	</p>
	<p class="field-_menu-item-new description description-wide">
		<label for="edit-_menu-item-new-<?php echo esc_attr( $item_id ); ?>">
			<input name="_menu-item-new[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-new', true ), 'on' ); ?>>
			<?php esc_html_e( 'New', 'bronze' ); ?>
		</label>
	</p>
	<p class="field-_menu-item-hot description description-wide">
		<label for="edit-_menu-item-hot-<?php echo esc_attr( $item_id ); ?>">
			<input name="_menu-item-hot[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-hot', true ), 'on' ); ?>>
			<?php esc_html_e( 'Hot', 'bronze' ); ?>
		</label>
	</p>
	<p class="field-_menu-item-sale description description-wide">
		<label for="edit-_menu-item-sale-<?php echo esc_attr( $item_id ); ?>">
			<input name="_menu-item-sale[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-sale', true ), 'on' ); ?>>
			<?php esc_html_e( 'Sale', 'bronze' ); ?>
		</label>
	</p>
	<p class="field-_menu-item-scroll description description-wide">
		<label for="edit-_menu-item-scroll-<?php echo esc_attr( $item_id ); ?>">
			<input name="_menu-item-scroll[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-scroll', true ), 'on' ); ?>>
			<?php esc_html_e( 'Scroll to an anchor', 'bronze' ); ?>
		</label>
	</p>
	<p class="field-_mega-menu-cols description description-wide">
			<label for="edit-_mega-menu-cols-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Mega Menu Columns', 'bronze' ); ?></label>
				<br>
				<select name="_mega-menu-cols[<?php echo esc_attr( $item_id ); ?>]">
					<option value="4" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 4 ); ?>>4</option>
					<option value="5" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 5 ); ?>>5</option>
					<option value="6" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 6 ); ?>>6</option>
					<option value="3" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 3 ); ?>>3</option>
					<option value="2" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 2 ); ?>>2</option>
				</select>
		</p>
	<p class="field-_mega-menu-tagline description description-wide">
		<label for="edit-_mega-menu-tagline-<?php echo esc_attr( $item_id ); ?>">
			<input type="text" name="_mega-menu-tagline[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( get_post_meta( $item_id, '_mega-menu-tagline', true ) ); ?>">
		</label><br>
		<?php esc_html_e( 'Optional Mega Menu Tagline (only available for first level items)', 'bronze' ); ?>
	</p>
	<?php if ( function_exists( 'wvc_get_fontawesome_icons' ) ) : ?>
		<?php
			$wvc_icons = wvc_get_fontawesome_icons();
		?>
		<p class="field-custom description description-wide bronze-searchable-container">
			<label for="edit-_menu-item-icon-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Icon', 'bronze' ); ?></label><br />
				<span>
				<?php
				printf(
					'<select data-placeholder="%1$s" name="_menu-item-icon[%2$d]" class="bronze-searchable edit-_menu-item-icon" id="edit-_menu-item-icon-%2$d">',
					esc_html__( 'None', 'bronze' ),
					$item_id
				);
					  echo '<option value="">' . esc_html__( 'None', 'bronze' ) . '</option>';
					  // esc_attr( get_post_meta( $item_id, '_menu-item-icon', true ) )
				foreach ( $wvc_icons as $key => $value ) {
					echo '<option value="' . esc_attr( $key ) . '"';
					selected( esc_attr( get_post_meta( $item_id, '_menu-item-icon', true ) ), $key );
					echo ">$value</option>";
				}
					  echo '</select>'
				?>
				</span>
		</p>

		<p class="field-_menu-item-icon-position description description-wide">
			<label for="edit-_menu-item-icon-position-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Icon position', 'bronze' ); ?></label>
				<br>
				<select name="_menu-item-icon-position[<?php echo esc_attr( $item_id ); ?>]">
					<option value="before" <?php selected( get_post_meta( $item_id, '_menu-item-icon-position', true ), 'before' ); ?>><?php esc_html_e( 'before', 'bronze' ); ?></option>
					<option value="after" <?php selected( get_post_meta( $item_id, '_menu-item-icon-position', true ), 'after' ); ?>><?php esc_html_e( 'after', 'bronze' ); ?></option>
				</select>
		</p>
		<?php
	endif;

	return ob_get_clean();
}
add_filter( 'bronze_menu_meta_fields_markup', 'bronze_filter_menu_custom_field', 10, 2 );

/*
--------------------------------------------------------------------

	CUSTOM WVC ELEMENT

----------------------------------------------------------------------
*/

// if ( defined( 'WVC_OK' ) ) {

// $wvc_custom_heading_params = [];

// if ( function_exists( 'wvc_heading_params' ) && function_exists( 'vc_map_integrate_shortcode' ) ) {

// $wvc_custom_heading_params = vc_map_integrate_shortcode( wvc_heading_params(),
// '',
// '',
// array(
// 'exclude' => array(
// 'add_background',
// 'background_img',
// 'background_position',
// 'background_repeat',
// 'background_size',
// ),
// ) );

// if ( is_array( $wvc_custom_heading_params ) && ! empty( $wvc_custom_heading_params ) ) {
// foreach ( $wvc_custom_heading_params as $key => $param ) {
// if ( is_array( $param ) && ! empty( $param ) ) {

// if ( 'responsive' == $param['param_name'] ) {
// force dependency
// $wvc_custom_heading_params[ $key ]['std'] = 'no';
// }

// if ( 'font_size' == $param['param_name'] ) {
// force dependency
// $wvc_custom_heading_params[ $key ]['std'] = 24;
// }
// }
// }
// }
// }
// }

/**
 * Add MP3 player on single product page
 *
 * @return string
 */
function bronze_add_audio_player_on_single_product_page() {

	$output     = '';
	$audio_meta = get_post_meta( get_the_ID(), '_post_product_mp3', true );

	if ( $audio_meta ) {
		$audio_attrs = array(
			'src'      => esc_url( $audio_meta ),
			'loop'     => false,
			'autoplay' => false,
			'preload'  => 'auto',
		);

		$output = wp_audio_shortcode( $audio_attrs );
	}

	echo bronze_kses( $output );
}
add_action( 'woocommerce_single_product_summary', 'bronze_add_audio_player_on_single_product_page', 14 );

/**
 * Minimal player
 *
 * Displays a play/pause audio player on product grid
 */
function bronze_minimal_player( $post_id = null ) {
	$post_id    = ( $post_id ) ? $post_id : get_the_ID();
	$audio_meta = get_post_meta( get_the_ID(), '_post_product_mp3', true );
	$rand       = rand( 0, 99999 );

	if ( ! $audio_meta ) {
		return;
	}
	?>
	<a href="#" class="minimal-player-play-button">
	<i class="minimal-player-icon minimal-player-play"></i><i class="minimal-player-icon minimal-player-pause"></i>
	</a>
	<audio class="minimal-player-audio" id="minimal-player-audio-<?php echo absint( $rand ); ?>" src="<?php echo esc_url( $audio_meta ); ?> "></audio>
	<?php
}
/* Output player in loop */
add_action( 'bronze_product_minimal_player', 'bronze_minimal_player' );

function bronze_add_menu_cta_content_type_options( $array ) {

	$array['custom'] = esc_html__( 'Mixed (cart, socials and search icon)', 'bronze' );

	return $array;
}
add_filter( 'bronze_menu_cta_content_type_options', 'bronze_add_menu_cta_content_type_options' );

/**
 * Wishlist menu item
 */
function bronze_wishlist_menu_item_markup( $html ) {
	if ( ! function_exists( 'wolf_get_wishlist_url' ) ) {
		return;
	}

	$wishlist_url = wolf_get_wishlist_url();
	ob_start();
	?>
		<a href="<?php echo esc_url( $wishlist_url ); ?>" title="<?php esc_attr_e( 'My Wishlist', 'bronze' ); ?>" class="wishlist-item-icon"><img class="svg" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/t/svg/bronze/heart.svg' ); ?>" alt="<?php esc_attr_e( 'Wishlist Icon', 'bronze' ); ?>"></a>
	<?php
	$wishlist_item = ob_get_clean();

	return bronze_kses( $wishlist_item );
}
add_filter( 'bronze_wishlist_menu_item_html', 'bronze_wishlist_menu_item_markup' );

/**
 * Cart menu item
 */
function bronze_cart_menu_item_markup( $html ) {

	if ( ! function_exists( 'wc_get_cart_url' ) ) {
		return;
	}

	$product_count = WC()->cart->get_cart_contents_count();

	ob_start();
	?>
		<a href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'Cart', 'bronze' ); ?>" class="cart-item-icon toggle-cart">
			<span class="cart-icon-product-count"><?php echo absint( $product_count ); ?></span>
		</a>
	<?php
	$cart_item = ob_get_clean();

	return bronze_kses( $cart_item );
}
add_filter( 'bronze_cart_menu_item_html', 'bronze_cart_menu_item_markup' );
add_filter( 'bronze_cart_menu_item_mobile_html', 'bronze_cart_menu_item_markup' );

/**
 * Account menu item
 */
function bronze_account_menu_item_markup( $html ) {
	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$icon_name = 'user';
	$label     = esc_html__( 'Sign In or Register', 'bronze' );
	$class     = 'account-item-icon';

	if ( is_user_logged_in() ) {
		$label  = esc_html__( 'My account', 'bronze' );
		$class .= ' account-item-icon-user-logged-in';
		// $icon_name = 'unlock';
	} else {
		$label  = esc_html__( 'Sign In or Register', 'bronze' );
		$class .= ' account-item-icon-user-not-logged-in';
		// $icon_name = 'lock';
	}

	if ( WP_DEBUG ) {
		$class .= ' account-item-icon-user-not-logged-in';
	}

	$account_url = get_permalink( wc_get_page_id( 'myaccount' ) );

	ob_start();
	?>
		<a class="<?php echo bronze_sanitize_html_classes( $class ); ?>" href="<?php echo esc_url( $account_url ); ?>" title="<?php echo esc_attr( $label ); ?>"><img class="svg" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/t/svg/bronze/' . $icon_name . '.svg' ); ?>" alt="<?php esc_attr_e( 'Account Icon', 'bronze' ); ?>">
		</a>
	<?php
	$account_item = ob_get_clean();

	return bronze_kses( $account_item );
}
add_filter( 'bronze_account_menu_item_html', 'bronze_account_menu_item_markup' );

/**
 * Output old style CTA
 */
function bronze_output_mixed_cta_content() {
	?>
	<div class="cart-container cta-item">
		<?php
			/**
			 * Cart icon
			 */
			bronze_cart_menu_item();

			/**
			 * Cart panel
			 */
			echo bronze_cart_panel();
		?>
	</div><!-- .cart-container -->
	<div class="search-container cta-item">
		<?php
			/**
			 * Search
			 */
			echo bronze_search_menu_item();
		?>
	</div><!-- .search-container -->
	<?php
	if ( function_exists( 'wvc_socials' ) ) {
		echo wvc_socials( array( 'services' => bronze_get_inherit_mod( 'menu_socials', 'facebook,twitter,instagram' ) ) );
	}
	?>
	<?php
}
add_action( 'bronze_custom_menu_cta_content', 'bronze_output_mixed_cta_content' );


function bronze_add_play_pause_button_to_secondary_menu( $context ) {

	$mp3_id      = bronze_get_inherit_mod( 'nav_player_mp3' );
	$show_player = bronze_get_inherit_mod( 'show_nav_player' );

	if ( $mp3_id && 'yes' === $show_player && 'desktop' === $context ) {
		$mp3_url = wp_get_attachment_url( $mp3_id );
		echo '<div id="nav-player-container" class="nav-player-container cta-item">';
		echo '<span class="fa nav-play-icon nav-play-button" title="' . esc_attr( __( 'Play', 'bronze' ) ) . '"></span>';
		echo '<audio class="nav-player" id="' . uniqid( 'nav-player-' ) . '" src="' . esc_url( $mp3_url ) . '"></audio>';
		echo '</div>';
	}

}
add_action( 'bronze_secondary_menu', 'bronze_add_play_pause_button_to_secondary_menu', 10, 1 );

function bronze_add_spotify_button_to_secondary_menu( $context ) {

	$show_button = bronze_get_inherit_mod( 'nav_spotify_button' );
	$spotify_url = bronze_get_inherit_mod( 'nav_spotify_url' );

	// debug( $show_button );
	// debug( $spotify_url );

	// https://open.spotify.com/artist/1gYdjzLQVIKiyEzE1Ku5MQ
	// https://open.spotify.com/artist/6rBvjnvdsRxFRSrq1StGOM

	if ( 'yes' === $show_button && $spotify_url ) {

		if ( preg_match( '/https:\/\/open.spotify.com\/artist\/([A-Za-z0-9]+)/', $spotify_url, $match ) ) {

			// debug( $match );

			if ( isset( $match[1] ) ) {
				?>
		<div class="spotiy-button-container">
			<iframe src="https://open.spotify.com/follow/1/?uri=spotify:artist:<?php echo esc_attr( $match[1] ); ?>&size=basic&theme=light&show-count=0" width="200" height="25" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowtransparency="true"></iframe>
		</div>
				<?php
			}
		}
	}

}
add_action( 'bronze_secondary_menu', 'bronze_add_spotify_button_to_secondary_menu', 10, 1 );

if ( ! function_exists( 'bronze_release_meta' ) ) {
	/**
	 * Display release meta
	 */
	function bronze_release_meta() {

		if ( ! class_exists( 'Wolf_Discography' ) ) {
			return;
		}

		$meta            = wd_get_meta();
		$release_title   = $meta['title'];
		$release_date    = $meta['date'];
		$release_catalog = $meta['catalog'];
		$release_format  = $meta['format'];
		$artists         = get_the_terms( get_the_ID(), 'band' );
		$artist_tax      = get_taxonomy( 'band' );
		$genre           = get_the_terms( get_the_ID(), 'release_genre' );
		$genre_tax       = get_taxonomy( 'release_genre' );
		$rewrite         = '';
		$artist_tax_slug = '';
		$genre_tax_slug  = '';

		if ( taxonomy_exists( 'band' ) && isset( $artist_tax->rewrite['slug'] ) ) {

			$artist_tax_slug = $artist_tax->rewrite['slug'];
		}

		if ( taxonomy_exists( 'release_genre' ) && isset( $genre_tax->rewrite['slug'] ) ) {

			$genre_tax_slug = $genre_tax->rewrite['slug'];
		}

		// Date
		if ( $release_date ) :
			?>
		<strong><?php esc_html_e( 'Release Date', 'bronze' ); ?></strong> : <?php echo sanitize_text_field( $release_date ); ?><br>
		<?php endif; ?>

		<?php
		if ( $artists ) {
			$artist_label = ( 1 < count( $artists ) ) ? esc_html__( 'Artists', 'bronze' ) : esc_html__( 'Artist', 'bronze' );
			?>
				<strong><?php echo sanitize_text_field( $artist_label ); ?></strong> :
				<?php
				$artists_html = '';
				foreach ( $artists as $artist ) {
					$artist_slug   = $artist->slug;
					$artist_name   = $artist->name;
					$artists_html .= '<a href="' . esc_url( home_url( '/' . $artist_tax_slug . '/' . $artist_slug ) ) . '">' . sanitize_text_field( $artist_name ) . '</a>, ';
				}

				echo rtrim( $artists_html, ', ' );
				echo '<br>';
		}
		?>
		<?php

		if ( $genre ) {
			$genre_label = ( 1 < count( $genre ) ) ? esc_html__( 'Genres', 'bronze' ) : esc_html__( 'Genre', 'bronze' );
			?>
				<strong><?php echo sanitize_text_field( $genre_label ); ?></strong> :
				<?php
				$genre_html = '';
				foreach ( $genre as $g ) {
					// debug( $g );
					$genre_slug  = $g->slug;
					$genre_name  = $g->name;
					$genre_html .= '<a href="' . esc_url( home_url( '/' . $genre_tax_slug . '/' . $genre_slug ) ) . '">' . sanitize_text_field( $genre_name ) . '</a>, ';
				}

				echo rtrim( $genre_html, ', ' );
				echo '<br>';
		}
		?>
		<?php
		// Catalog number
		if ( $release_catalog ) :
			?>
		<strong><?php esc_html_e( 'Catalog ref.', 'bronze' ); ?></strong> : <?php echo sanitize_text_field( $release_catalog ); ?><br>
		<?php endif; ?>

		<?php
		// Type
		if ( $release_format && wolf_get_release_option( 'display_format' ) ) :
			?>
		<strong><?php esc_html_e( 'Format', 'bronze' ); ?></strong> : <?php echo sanitize_text_field( $release_format ); ?><br>
		<?php endif; ?>
		<?php
		edit_post_link( esc_html__( 'Edit', 'bronze' ), '<span class="edit-link">', '</span>' );
	}
}

/**
 * Overwrite release button
 */
function bronze_release_buttons( $html ) {

	$meta                = wd_get_meta();
	$release_itunes      = $meta['itunes'];
	$release_google_play = $meta['google_play'];
	$release_amazon      = $meta['amazon'];
	$release_spotify     = $meta['spotify'];
	$release_buy         = $meta['buy'];
	$release_free        = $meta['free'];

	$product_id = get_post_meta( get_the_ID(), '_post_wc_product_id', true );

	ob_start();
	?>
	<span class="wolf-release-buttons">
		<?php if ( $release_free ) : ?>
		<span class="wolf-release-button">
			<a class="wolf-release-free <?php echo apply_filters( 'bronze_release_button_class', 'button' ); ?>" title="<?php esc_html_e( 'Download Now', 'bronze' ); ?>" href="<?php echo esc_url( $release_free ); ?>"><?php esc_html_e( 'Free Download', 'bronze' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_spotify ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php printf( esc_html__( 'Listen on %s', 'bronze' ), 'Spotify' ); ?>" class="wolf-release-spotify <?php echo apply_filters( 'bronze_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_spotify ); ?>"><?php esc_html_e( 'Spotify', 'bronze' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_itunes ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php printf( esc_html__( 'Buy on %s', 'bronze' ), 'iTunes' ); ?>" class="wolf-release-itunes <?php echo apply_filters( 'bronze_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_itunes ); ?>"><?php esc_html_e( 'iTunes', 'bronze' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_amazon ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php printf( esc_html__( 'Buy on %s', 'bronze' ), 'amazon' ); ?>" class="wolf-release-amazon <?php echo apply_filters( 'bronze_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_amazon ); ?>"><?php esc_html_e( 'Amazon', 'bronze' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_google_play ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php printf( esc_html__( 'Buy on %s', 'bronze' ), 'YouTube Music' ); ?>" class="wolf-release-google_play <?php echo apply_filters( 'bronze_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_google_play ); ?>"><?php esc_html_e( 'YouTube Music', 'bronze' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_buy ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php esc_html_e( 'Buy Now', 'bronze' ); ?>" class="wolf-release-buy <?php echo apply_filters( 'bronze_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_buy ); ?>"><?php esc_html_e( 'Buy', 'bronze' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $product_id && 0 != $product_id ) : ?>
			<span class="wolf-release-button">
				<?php echo bronze_add_to_cart( $product_id, 'wolf-release-add-to-cart ' . apply_filters( 'bronze_release_button_class', 'button' ), '<span class="wolf-release-add-to-cart-button-title" title="' . esc_html__( 'Add to cart', 'bronze' ) . '"></span>' ); ?>
			</span>
		<?php endif; ?>
	</span><!-- .wolf-release-buttons -->
	<?php
	$html = ob_get_clean();

	return $html;
}
add_filter( 'wolf_discography_release_buttons', 'bronze_release_buttons' );

if ( ! function_exists( 'bronze_gallery_meta' ) ) {
	/**
	 * Gallery meta
	 */
	function bronze_gallery_meta() {

		?>
		<a href="#" data-gallery-params="<?php echo esc_js( wp_json_encode( bronze_get_gallery_params() ) ); ?>" class="gallery-quickview" title="<?php esc_html_e( 'Quickview', 'bronze' ); ?>">
		<?php
			/**
			 * Photo count
			 */
			printf( esc_html__( '%d photos', 'bronze' ), bronze_get_first_gallery_image_count() );
		?>
		</a>
		<?php
		if ( get_the_term_list( get_the_ID(), 'gallery_type', '', ' / ', '' ) ) {
			?>
			<span class="gallery-meta-separator">&mdash;</span>
			<?php
				/**
				 * Gallery taxonomy
				 */
				echo get_the_term_list( get_the_ID(), 'gallery_type', '', ' / ', '' );

		}
	}
}

function bronze_remove_gallery_post_type_comment( $args, $post_type ) {
	if ( 'gallery' === $post_type ) {
		$args['supports'] = array( 'title', 'editor', 'thumbnail' );
	}

	return $args;
}
add_filter( 'register_post_type_args', 'bronze_remove_gallery_post_type_comment', 10, 2 );

/*
----------------------------------------------------------------------------------

	Playlist function

--------------------------------------------------------------------------------------
*/

// add_theme_support( 'wpm_bar' );

/**
 * Can we display a player?
 *
 * @return bool
 */
function bronze_sticky_playlist_id() {
	if ( is_page() && get_post_meta( get_the_ID(), '_post_sticky_playlist_id', true ) ) {
		$playlist_id = get_post_meta( get_the_ID(), '_post_sticky_playlist_id', true );

		if ( $playlist_id && 'none' !== $playlist_id ) {
			return $playlist_id;
		}
	}
}

/**
 * Add body classes
 *
 * @param  array $classes
 * @return array
 */
function bronze_sticky_player_body_class( $classes ) {

	if ( bronze_sticky_playlist_id() ) {
		$classes[] = 'is-wpm-bar-player';
	}

	return $classes;
}
add_filter( 'body_class', 'bronze_sticky_player_body_class' );

/**
 * Output bottom bar holder
 *
 * @param  array $classes
 * @return array
 */
function bronze_output_sticky_playlist_holder() {

	if ( bronze_sticky_playlist_id() ) {
		echo '<div class="wpm-bar-holder"></div>';
	}
}
add_action( 'wp_footer', 'bronze_output_sticky_playlist_holder' );

/**
 * Output bottom bar player
 */
function bronze_output_sticky_playlist() {

	if ( bronze_sticky_playlist_id() ) {

		$playlist_id = bronze_sticky_playlist_id();
		$skin        = get_post_meta( get_the_ID(), '_post_sticky_playlist_skin', true );

		$attrs = array(
			'show_tracklist'   => false,
			'is_sticky_player' => true,
		);

		if ( $skin ) {
			$attrs['theme'] = $skin;
		}

		if ( function_exists( 'wpm_playlist' ) ) {
			wpm_playlist( $playlist_id, $attrs );
		}
	}
}
add_action( 'bronze_body_start', 'bronze_output_sticky_playlist' );
