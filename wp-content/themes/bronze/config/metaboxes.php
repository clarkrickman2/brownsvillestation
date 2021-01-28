<?php
/**
 * Bronze metaboxes
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register metaboxes
 *
 * Pass a metabox array to generate metabox with the  Wolf Metaboxes plugin
 */
function bronze_register_metabox() {

	$content_blocks = array(
		'' => '&mdash; ' . esc_html__( 'None', 'bronze' ) . ' &mdash;',
	);

	$body_metaboxes = array(
		'site_settings' => array(
			'title'      => esc_html__( 'Layout', 'bronze' ),
			'page'       => apply_filters( 'bronze_site_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist', 'mp-event' ) ),

			'metafields' => array(

				array(
					'label' => '',
					'id'    => '_post_subheading',
					'type'  => 'text',
				),

				/*
				array(
					'label'	=> esc_html__( 'Scroll to second row on mousewheel down.', 'bronze' ),
					'id'	=> '_hero_mousewheel',
					'type'	=> 'checkbox',
				),*/

				array(
					'label' => esc_html__( 'Content Background Color', 'bronze' ),
					'id'    => '_post_content_inner_bg_color',
					'type'  => 'colorpicker',
					'desc'  => esc_html__( 'If you use the page builder and set your row background setting to "no background", you may want to change the overall content background color.', 'bronze' ),
				),

				array(
					'label' => esc_html__( 'Content Background Image', 'bronze' ),
					'id'    => '_post_content_inner_bg_img',
					'type'  => 'image',
					'desc'  => esc_html__( 'If you use the page builder and set your row background setting to "no background", you may want to change the overall content background image.', 'bronze' ),
				),

				array(
					'label'   => esc_html__( 'Loading Animation Type', 'bronze' ),
					'id'      => '_post_loading_animation_type',
					'type'    => 'select',
					'choices' => array(
						''        => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'none'    => esc_html__( 'None', 'bronze' ),
						'overlay' => esc_html__( 'Overlay', 'bronze' ),
					),
				),

				'loading_logo'       => array(
					'id'          => '_post_loading_logo',
					'description' => esc_html__( 'Add a loading logo to show on first page load.', 'bronze' ),
					'label'       => esc_html__( 'Loading Logo', 'bronze' ),
					'type'        => 'image',
				),

				'loading_overlay_bg' => array(
					'id'    => '_post_loading_overlay_bg',
					// 'description' => esc_html__( 'Overlay Background Image.', 'bronze' ),
					'label' => esc_html__( 'Overlay Background Image', 'bronze' ),
					'type'  => 'image',
				),

				// array(
				// 'label' => esc_html__( 'Body Background', 'bronze' ),
				// 'id'    => '_post_body_background_img',
				// 'type'  => 'image',
				// ),

				// array(
				// 'label' => esc_html__( 'Body Background Position', 'bronze' ),
				// 'id'    => '_post_body_background_img_position',
				// 'type' => 'select',
				// 'choices' => array(
				// '' => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
				// 'center top' => esc_html__( 'center top', 'bronze' ),
				// 'center center' => esc_html__( 'center center', 'bronze' ),
				// 'left top'  => esc_html__( 'left top', 'bronze' ),
				// 'right top'  => esc_html__( 'right top', 'bronze' ),
				// 'center bottom' => esc_html__( 'center bottom', 'bronze' ),
				// 'left bottom'  => esc_html__( 'left bottom', 'bronze' ),
				// 'right bottom'  => esc_html__( 'right bottom', 'bronze' ),
				// 'left center'  => esc_html__( 'left center', 'bronze' ),
				// 'right center' => esc_html__( 'right center', 'bronze' ),
				// ),
				// ),
				// array(
				// 'label' => esc_html__( 'Body Background Attachment', 'bronze' ),
				// 'id'    => '_post_body_background_img_attachment',
				// 'type' => 'select',
				// 'choices' => array(
				// '' => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
				// 'scroll' => esc_html__( 'Scroll', 'bronze' ),
				// 'fixed' => esc_html__( 'Fixed', 'bronze' ),
				// ),
				// ),

				array(
					'label' => esc_html__( 'Accent Color', 'bronze' ),
					'id'    => '_post_accent_color',
					'type'  => 'colorpicker',
					'desc'  => esc_html__( 'It will overwrite the main accent color set in the customizer.', 'bronze' ),
				),

			),
		),
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && class_exists( 'Wolf_Vc_Content_Block' ) && defined( 'WPB_VC_VERSION' ) ) {
		// Content block option
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

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'   => esc_html__( 'Post-header Block', 'bronze' ),
			'id'      => '_post_after_header_block',
			'type'    => 'select',
			'choices' => $content_blocks,
		);

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'   => esc_html__( 'Pre-footer Block', 'bronze' ),
			'id'      => '_post_before_footer_block',
			'type'    => 'select',
			'choices' => $content_blocks,
		);
	}

	$header_metaboxes = array(
		'header_settings' => array(
			'title'      => esc_html__( 'Header', 'bronze' ),
			'page'       => apply_filters( 'bronze_header_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist', 'mp-event' ) ),

			'metafields' => array(

				array(
					'label'   => esc_html__( 'Header Layout', 'bronze' ),
					'id'      => '_post_hero_layout',
					'type'    => 'select',
					'choices' => array(
						''           => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'standard'   => esc_html__( 'Standard', 'bronze' ),
						'big'        => esc_html__( 'Big', 'bronze' ),
						'small'      => esc_html__( 'Small', 'bronze' ),
						'fullheight' => esc_html__( 'Full Height', 'bronze' ),
						'none'       => esc_html__( 'No Header', 'bronze' ),
					),
				),

				array(
					'label' => esc_html__( 'Title Font Family', 'bronze' ),
					'id'    => '_post_hero_title_font_family',
					'type'  => 'font_family',
				),

				array(
					'label'   => esc_html__( 'Font Transform', 'bronze' ),
					'id'      => '_post_hero_title_font_transform',
					'type'    => 'select',
					'choices' => array(
						''          => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'uppercase' => esc_html__( 'Uppercase', 'bronze' ),
						'none'      => esc_html__( 'None', 'bronze' ),
					),
				),

				array(
					'label' => esc_html__( 'Big Text', 'bronze' ),
					'id'    => '_post_hero_title_bigtext',
					'type'  => 'checkbox',
					'desc'  => esc_html__( 'Enable "Big Text" for the title?', 'bronze' ),
				),

				array(
					'label'   => esc_html__( 'Background Type', 'bronze' ),
					'id'      => '_post_hero_background_type',
					'type'    => 'select',
					'choices' => array(
						'featured-image' => esc_html__( 'Featured Image', 'bronze' ),
						'image'          => esc_html__( 'Image', 'bronze' ),
						'video'          => esc_html__( 'Video', 'bronze' ),
						'slideshow'      => esc_html__( 'Slideshow', 'bronze' ),
					),
				),

				array(
					'label'      => esc_html__( 'Slideshow Images', 'bronze' ),
					'id'         => '_post_hero_slideshow_ids',
					'type'       => 'multiple_images',
					'dependency' => array(
						'element' => '_post_hero_background_type',
						'value'   => array( 'slideshow' ),
					),
				),

				array(
					'label'      => esc_html__( 'Background', 'bronze' ),
					'id'         => '_post_hero_background',
					'type'       => 'background',
					'dependency' => array(
						'element' => '_post_hero_background_type',
						'value'   => array( 'image' ),
					),
				),

				array(
					'label'      => esc_html__( 'Background Effect', 'bronze' ),
					'id'         => '_post_hero_background_effect',
					'type'       => 'select',
					'choices'    => array(
						''         => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'zoomin'   => esc_html__( 'Zoom', 'bronze' ),
						'parallax' => esc_html__( 'Parallax', 'bronze' ),
						'none'     => esc_html__( 'None', 'bronze' ),
					),
					'dependency' => array(
						'element' => '_post_hero_background_type',
						'value'   => array( 'image' ),
					),
				),

				array(
					'label'      => esc_html__( 'Video URL', 'bronze' ),
					'id'         => '_post_hero_background_video_url',
					'type'       => 'video',
					'dependency' => array(
						'element' => '_post_hero_background_type',
						'value'   => array( 'video' ),
					),
					'desc'       => esc_html__( 'A mp4 or YouTube URL. The featured image will be used as image fallback when the video cannot be displayed.', 'bronze' ),
				),

				array(
					'label'   => esc_html__( 'Overlay', 'bronze' ),
					'id'      => '_post_hero_overlay',
					'type'    => 'select',
					'choices' => array(
						''       => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'custom' => esc_html__( 'Custom', 'bronze' ),
						'none'   => esc_html__( 'None', 'bronze' ),
					),
				),

				array(
					'label'      => esc_html__( 'Overlay Color', 'bronze' ),
					'id'         => '_post_hero_overlay_color',
					'type'       => 'colorpicker',
					// 'value'   => '#000000',
					'dependency' => array(
						'element' => '_post_hero_overlay',
						'value'   => array( 'custom' ),
					),
				),

				array(
					'label'       => esc_html__( 'Overlay Opacity (in percent)', 'bronze' ),
					'id'          => '_post_hero_overlay_opacity',
					'desc'        => esc_html__( 'Adapt the header overlay opacity if needed', 'bronze' ),
					'type'        => 'int',
					'placeholder' => 40,
					'dependency'  => array(
						'element' => '_post_hero_overlay',
						'value'   => array( 'custom' ),
					),
				),

			),
		),
	);

	$menu_metaboxes = array(
		'menu_settings' => array(
			'title'      => esc_html__( 'Menu', 'bronze' ),
			'page'       => apply_filters( 'bronze_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist', 'mp-event' ) ),

			'metafields' => array(

				array(
					'label'   => esc_html__( 'Menu Font Tone', 'bronze' ),
					'id'      => '_post_hero_font_tone',
					'type'    => 'select',
					'choices' => array(
						''      => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'bronze' ),
						'dark'  => esc_html__( 'Dark', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Menu Layout', 'bronze' ),
					'id'      => '_post_menu_layout',
					'type'    => 'select',
					'choices' => array(
						''                 => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						// 'top-logo' => esc_html__( 'Top Logo', 'bronze' ),
						'top-right'        => esc_html__( 'Top Right', 'bronze' ),
						'top-justify'      => esc_html__( 'Top Justify', 'bronze' ),
						'top-justify-left' => esc_html__( 'Top Justify Left', 'bronze' ),
						'centered-logo'    => esc_html__( 'Centered', 'bronze' ),
						'top-left'         => esc_html__( 'Top Left', 'bronze' ),
						// 'offcanvas' => esc_html__( 'Off Canvas', 'bronze' ),
						 'overlay'         => esc_html__( 'Overlay', 'bronze' ),
						// 'lateral' => esc_html__( 'Lateral', 'bronze' ),
						'none'             => esc_html__( 'No Menu', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Menu Width', 'bronze' ),
					'id'      => '_post_menu_width',
					'type'    => 'select',
					'choices' => array(
						''      => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'wide'  => esc_html__( 'Wide', 'bronze' ),
						'boxed' => esc_html__( 'Boxed', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Megamenu Width', 'bronze' ),
					'id'      => '_post_mega_menu_width',
					'type'    => 'select',
					'choices' => array(
						''          => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'boxed'     => esc_html__( 'Boxed', 'bronze' ),
						'wide'      => esc_html__( 'Wide', 'bronze' ),
						'fullwidth' => esc_html__( 'Full Width', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Menu Style', 'bronze' ),
					'id'      => '_post_menu_style',
					'type'    => 'select',
					'choices' => array(
						''                       => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'solid'                  => esc_html__( 'Solid', 'bronze' ),
						'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'bronze' ),
						'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'bronze' ),
						'transparent'            => esc_html__( 'Transparent', 'bronze' ),
						// 'none' => esc_html__( 'No Menu', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Navigation Overlay Left Panel Block', 'bronze' ),
					'id'      => '_post_nav_overlay_left_block_id',
					'type'    => 'select',
					'choices' => $content_blocks,
				),

				array(
					'label'   => esc_html__( 'Navigation Overlay Right Panel Block', 'bronze' ),
					'id'      => '_post_nav_overlay_right_block_id',
					'type'    => 'select',
					'choices' => $content_blocks,
				),

				array(
					'label'     => esc_html__( 'Overlay Menu Label', 'bronze' ),
					'id'        => '_post_overlay_menu_label',
					'type'      => 'text',
					'transport' => 'postMessage',
				),

				'menu_sticky_type'        => array(
					'id'      => '_post_menu_sticky_type',
					'label'   => esc_html__( 'Sticky Menu', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						''     => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'none' => esc_html__( 'Disabled', 'bronze' ),
						'soft' => esc_html__( 'Sticky on scroll up', 'bronze' ),
						'hard' => esc_html__( 'Always sticky', 'bronze' ),
					),
				),

				'sticky_menu_transparent' => array(
					'id'    => '_post_sticky_menu_transparent',
					'label' => esc_html__( 'Transparent Sticky Menu', 'bronze' ),
					'type'  => 'checkbox',
				),

				// array(
				// 'label' => esc_html__( 'Sticky Menu Skin', 'bronze' ),
				// 'id'    => '_post_menu_skin',
				// 'type'  => 'select',
				// 'choices' => array(
				// '' => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
				// 'light' => esc_html__( 'Light', 'bronze' ),
				// 'dark' => esc_html__( 'Dark', 'bronze' ),
				// 'none' => esc_html__( 'No Menu', 'bronze' ),
				// ),
				// ),

				array(
					'id'      => '_post_menu_cta_content_type',
					'label'   => esc_html__( 'Additional Content', 'bronze' ),
					'type'    => 'select',
					'default' => 'icons',
					'choices' => array_merge(
						array(
							'' => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						),
						apply_filters(
							'bronze_menu_cta_content_type_options',
							array(
								'search_icon'    => esc_html__( 'Search Icon', 'bronze' ),
								'secondary-menu' => esc_html__( 'Secondary Menu', 'bronze' ),
							)
						),
						array( 'none' => esc_html__( 'None', 'bronze' ) )
					),
				),

				array(
					'id'      => '_post_show_nav_player',
					'label'   => esc_html__( 'Show Navigation Player', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						''    => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'bronze' ),
						'no'  => esc_html__( 'No', 'bronze' ),
					),
				),

				array(
					'id'      => '_post_nav_spotify_button',
					'label'   => esc_html__( 'Show Spotify Button', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						''    => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'bronze' ),
						'no'  => esc_html__( 'No', 'bronze' ),
					),
				),

				array(
					'id'    => '_post_nav_spotify_url',
					'label' => esc_html__( 'Spotify URL', 'bronze' ),
					'type'  => 'text',
					'desc'  => sprintf( bronze_kses( __( '<a href="%s" target="_blank">Where to find it</a>', 'bronze' ) ), 'https://streamingcharts.com.au/wp-content/uploads/2018/03/artstlink.png' ),
				),

				array(
					'id'      => '_post_side_panel_position',
					'label'   => esc_html__( 'Side Panel', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						''      => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'none'  => esc_html__( 'None', 'bronze' ),
						'right' => esc_html__( 'At Right', 'bronze' ),
						'left'  => esc_html__( 'At Left', 'bronze' ),
					),
					'desc'    => esc_html__( 'Note that it will be disable with a vertical menu layout (overlay, offcanvas etc...).', 'bronze' ),
				),

				array(
					'label' => esc_html__( 'Side Panel Background', 'bronze' ),
					'id'    => '_post_side_panel_bg_img',
					'type'  => 'image',
				),

				array(
					'id'      => '_post_logo_visibility',
					'label'   => esc_html__( 'Logo Visibility', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						''            => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'always'      => esc_html__( 'Always', 'bronze' ),
						'sticky_menu' => esc_html__( 'When menu is sticky only', 'bronze' ),
						'hidden'      => esc_html__( 'Hidden', 'bronze' ),
					),
				),

				array(
					'id'      => '_post_menu_items_visibility',
					'label'   => esc_html__( 'Menu Items Visibility', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						''       => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'show'   => esc_html__( 'Visible', 'bronze' ),
						'hidden' => esc_html__( 'Hidden', 'bronze' ),
					),
					'desc'    => esc_html__( 'If, for some reason, you need to hide the menu items but leave the logo, additional content and side panel.', 'bronze' ),
				),

				'menu_breakpoint'         => array(
					'id'    => '_post_menu_breakpoint',
					'label' => esc_html__( 'Mobile Menu Breakpoint', 'bronze' ),
					'type'  => 'text',
					'desc'  => esc_html__( 'Use this field if you want to overwrite the mobile menu breakpoint.', 'bronze' ),
				),
			),
		),
	);

	$footer_metaboxes = array(
		'footer_settings' => array(
			'title'      => esc_html__( 'Footer', 'bronze' ),
			'page'       => apply_filters( 'bronze_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event' ) ),

			'metafields' => array(
				array(
					'label'   => esc_html__( 'Page Footer', 'bronze' ),
					'id'      => '_post_footer_type',
					'type'    => 'select',
					'choices' => array(
						''       => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'hidden' => esc_html__( 'No Footer', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Hide Bottom Bar', 'bronze' ),
					'id'      => '_post_bottom_bar_hidden',
					'type'    => 'select',
					'choices' => array(
						''    => esc_html__( 'No', 'bronze' ),
						'yes' => esc_html__( 'Yes', 'bronze' ),
					),
				),
			),
		),
	);

	/************** Post options */

	$product_options   = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'bronze' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {

			$product_options[] = esc_html__( 'Not linked', 'bronze' );

			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'bronze' ) ] = 0;
		}
	}

	$post_metaboxes = array(
		'post_settings' => array(
			'title'      => esc_html__( 'Post', 'bronze' ),
			'page'       => array( 'post' ),
			'metafields' => array(

				/*
				array(
					'label'	=> esc_html__( 'Font Color Tone', 'bronze' ),
					'id'	=> '_post_post_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'light' => esc_html__( 'Dark', 'bronze' ),
						'dark' => esc_html__( 'Light', 'bronze' ),
					),
					'desc'	=> esc_html__( 'The font color tone of the post in the loop.', 'bronze' ),
				),*/

				// array(
				// 'label' => esc_html__( 'Secondary Featured Image', 'bronze' ),
				// 'id'    => '_post_secondary_featured_image',
				// 'type'  => 'image',

				// ),

				array(
					'label'   => esc_html__( 'Post Layout', 'bronze' ),
					'id'      => '_post_layout',
					'type'    => 'select',
					'choices' => array(
						''              => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'sidebar-right' => esc_html__( 'Sidebar Right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Sidebar Left', 'bronze' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'bronze' ),
						'fullwidth'     => esc_html__( 'Full width', 'bronze' ),
					),
				),

				// array(
				// 'label' => esc_html__( 'Feature a Product', 'bronze' ),
				// 'id'    => '_post_wc_product_id',
				// 'type'  => 'select',
				// 'choices' => $product_options,
				// 'desc'  => esc_html__( 'A "Shop Now" buton will be displayed in the metro layout.', 'bronze' ),
				// ),

				array(
					'label' => esc_html__( 'Hide Featured Image in Post', 'bronze' ),
					'id'    => '_post_hide_single_post_featured_image',
					'type'  => 'checkbox',
				),
			),
		),
	);

	/************** Product options */
	$product_metaboxes = array(

		'product_options' => array(
			'title'      => esc_html__( 'Product', 'bronze' ),
			'page'       => array( 'product' ),
			'metafields' => array(

				array(
					'label'   => esc_html__( 'Font Color Tone', 'bronze' ),
					'id'      => '_post_product_skin',
					'type'    => 'select',
					'choices' => array(
						''      => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'light' => esc_html__( 'Dark', 'bronze' ),
						'dark'  => esc_html__( 'Light', 'bronze' ),
					),
					'desc'    => esc_html__( 'The font color tone of the post in the loop.', 'bronze' ),
				),

				array(
					'label' => esc_html__( 'Secondary Featured Image', 'bronze' ),
					'id'    => '_post_secondary_featured_image',
					'type'  => 'image',
					'desc'  => sprintf( bronze_kses( __( 'If set, this image will be used as featured image for the "%s" layouts.', 'bronze' ) ), 'Box Style 4' ),
				),

				array(
					'label' => esc_html__( 'Background color', 'bronze' ),
					'id'    => '_post_product_bg_color',
					'type'  => 'colorpicker',
					'desc'  => esc_html__( 'The background color of the post in the loop. Useful only if you featured image is a transparent PNG image.', 'bronze' ),
				),

				array(
					'label'       => esc_html__( 'Label', 'bronze' ),
					'id'          => '_post_product_label',
					'type'        => 'text',
					'placeholder' => esc_html__( '-30%', 'bronze' ),
				),

				array(
					'label'   => esc_html__( 'Layout', 'bronze' ),
					'id'      => '_post_product_single_layout',
					'type'    => 'select',
					'choices' => array(
						''              => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'standard'      => esc_html__( 'Standard', 'bronze' ),
						'sidebar-right' => esc_html__( 'Sidebar Right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Sidebar Left', 'bronze' ),
						'fullwidth'     => esc_html__( 'Full Width', 'bronze' ),
					),
				),

				array(
					'label' => esc_html__( 'MP3', 'bronze' ),
					'id'    => '_post_product_mp3',
					'type'  => 'file',
					'desc'  => esc_html__( 'If you want to display a player for a song you want to sell, paste the mp3 URL here.', 'bronze' ),
				),

				array(
					'label' => esc_html__( 'MP3 Label', 'bronze' ),
					'id'    => '_post_product_mp3_label',
					'type'  => 'text',
					'desc'  => esc_html__( 'An optional label to describe the song.', 'bronze' ),
				),

				array(
					'label' => esc_html__( 'Hide Player on Single Product Page', 'bronze' ),
					'id'    => '_post_wc_product_hide_mp3_player',
					'type'  => 'checkbox',
				),

				array(
					'label' => esc_html__( 'Size Chart Image', 'bronze' ),
					'id'    => '_post_wc_product_size_chart_img',
					'type'  => 'image',
					'desc'  => esc_html__( 'You can set a size chart image in the product category options. You can overwrite the category size chart for this product by uploading another image here.', 'bronze' ),
				),

				array(
					'label' => esc_html__( 'Hide Size Chart Image', 'bronze' ),
					'id'    => '_post_wc_product_hide_size_chart_img',
					'type'  => 'checkbox',
				),

				array(
					'label'   => esc_html__( 'Menu Font Tone', 'bronze' ),
					'id'      => '_post_hero_font_tone',
					'type'    => 'select',
					'choices' => array(
						''      => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'bronze' ),
						'dark'  => esc_html__( 'Dark', 'bronze' ),
					),
					'desc'    => esc_html__( 'By default the menu style is set to "solid" on single product page. If you change the menu style, you may need to adujst the menu color tone here.', 'bronze' ),
				),

				'menu_sticky_type' => array(
					'id'      => '_post_product_sticky',
					'label'   => esc_html__( 'Stacked Images', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						''    => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'bronze' ),
						'no'  => esc_html__( 'No', 'bronze' ),
					),
				),

				array(
					'label' => esc_html__( 'Disable Image Zoom', 'bronze' ),
					'id'    => '_post_product_disable_easyzoom',
					'type'  => 'checkbox',
					'desc'  => esc_html__( 'Disable image zoom on this product if it\'s enabled in the customizer.', 'bronze' ),
				),
			),
		),
	);

	/************** Product options */

	$product_options   = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'bronze' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {

			$product_options[] = esc_html__( 'Not linked', 'bronze' );

			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'bronze' ) ] = 0;
		}
	}

	/************** Video options */
	$video_metaboxes = array(
		'video_settings' => array(
			'title'      => esc_html__( 'Video', 'bronze' ),
			'page'       => array( 'video' ),
			'metafields' => array(

				array(
					'label' => esc_html__( 'Video Preview', 'bronze' ),
					'id'    => '_wvc_video_post_preview',
					'type'  => 'video',
					'desc'  => esc_html__( 'A mp4, Vimeo, or YouTube URL that will be used as preview in the video post slider.', 'bronze' ),
				),

				array(
					'label'   => esc_html__( 'Layout', 'bronze' ),
					'id'      => '_post_layout',
					'type'    => 'select',
					'choices' => array(
						''              => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'standard'      => esc_html__( 'Standard', 'bronze' ),
						'sidebar-right' => esc_html__( 'Sidebar Right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Sidebar Left', 'bronze' ),
						'fullwidth'     => esc_html__( 'Full Width', 'bronze' ),
					),
				),

				/*
				array(
					'label'	=> esc_html__( 'Menu Font Tone', 'bronze' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'bronze' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'bronze' ),
						'dark' => esc_html__( 'Dark', 'bronze' ),
					),
					'desc' => esc_html__( 'By default the menu style is set to "solid" on single video page. If you change the menu style, you may need to adujst the menu color tone here.', 'bronze' ),
				),*/
			),
		),
	);

	$release_metaboxes = array(
		'release_options' => array(
			'title'      => esc_html__( 'Release', 'bronze' ),
			'page'       => array( 'release' ),
			'metafields' => array(

				array(
					'label'   => esc_html__( 'Type', 'bronze' ),
					'id'      => '_post_release_meta',
					'type'    => 'select',
					'choices' => array(
						''         => esc_html__( 'Standard', 'bronze' ),
						'featured' => esc_html__( 'Featured', 'bronze' ),
						'upcoming' => esc_html__( 'Upcoming', 'bronze' ),
					),
				),

				array(
					'label' => esc_html__( 'Secondary Feature image', 'bronze' ),
					'id'    => '_release_secondary_featured_image',
					'type'  => 'image',
					'desc'  => esc_html__( 'If set, this image will be used as disc image for the album cover layouts.', 'bronze' ),
				),

				array(
					'label'   => esc_html__( 'Cover Type', 'bronze' ),
					'id'      => '_release_cover_type',
					'type'    => 'select',
					'choices' => array(
						'cd'    => esc_html__( 'CD', 'bronze' ),
						'vinyl' => esc_html__( 'Vinyl', 'bronze' ),
						// 'fullwidth' => esc_html__( 'Full Width', 'bronze' ),
					),
					'desc'    => esc_html__( 'You must set a type in the release types taxonmy on the left as well if you want to classify this release by type.', 'bronze' ),
				),

				array(
					'label'   => esc_html__( 'Release Width', 'bronze' ),
					'id'      => '_post_width',
					'type'    => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'bronze' ),
						'wide'     => esc_html__( 'Wide', 'bronze' ),
						// 'fullwidth' => esc_html__( 'Full Width', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Release Layout', 'bronze' ),
					'id'      => '_post_layout',
					'type'    => 'select',
					'choices' => array(
						'sidebar-left'  => esc_html__( 'Content Right', 'bronze' ),
						'sidebar-right' => esc_html__( 'Content Left', 'bronze' ),
						// 'centered' => esc_html__( 'Centered', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'WooCommerce Product ID', 'bronze' ),
					'id'      => '_post_wc_product_id',
					'type'    => 'select',
					'choices' => $product_options,
					'desc'    => esc_html__( 'You can link this release to a WooCommerce product to add an "Add to cart" button.', 'bronze' ),
				),

				// array(
				// 'label' => esc_html__( 'Featured', 'bronze' ),
				// 'id'    => '_post_featured',
				// 'type'  => 'checkbox',
				// 'desc'  => esc_html__( 'May be used depending on layout option.', 'bronze' ),
				// ),
			),
		),
	);

		/************** Portfolio options */
	$work_metaboxes = array(

		'work_options' => array(
			'title'      => esc_html__( 'Work', 'bronze' ),
			'page'       => array( 'work' ),
			'metafields' => array(

				array(
					'label' => esc_html__( 'Client', 'bronze' ),
					'id'    => '_work_client',
					'type'  => 'text',
				),

				array(
					'label' => esc_html__( 'Link', 'bronze' ),
					'id'    => '_work_link',
					'type'  => 'text',
				),

				array(
					'label'   => esc_html__( 'Width', 'bronze' ),
					'id'      => '_post_width',
					'type'    => 'select',
					'choices' => array(
						'standard'  => esc_html__( 'Standard', 'bronze' ),
						'wide'      => esc_html__( 'Wide', 'bronze' ),
						'fullwidth' => esc_html__( 'Full Width', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Layout', 'bronze' ),
					'id'      => '_post_layout',
					'type'    => 'select',
					'choices' => array(
						'centered'      => esc_html__( 'Centered', 'bronze' ),
						'sidebar-right' => esc_html__( 'Excerpt & Info at Right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Excerpt & Info at Left', 'bronze' ),
					),
				),

				array(
					'label'   => esc_html__( 'Excerpt & Info Position', 'bronze' ),
					'id'      => '_post_work_info_position',
					'type'    => 'select',
					'choices' => array(
						'after'  => esc_html__( 'After Content', 'bronze' ),
						'before' => esc_html__( 'Before Content', 'bronze' ),
						'none'   => esc_html__( 'Hidden', 'bronze' ),
					),
				),

				// array(
				// 'label' => esc_html__( 'Featured', 'bronze' ),
				// 'id'    => '_post_featured',
				// 'type'  => 'checkbox',
				// 'desc'  => esc_html__( 'The featured image will be display bigger in the "metro" layout.', 'bronze' ),
				// ),
			),
		),
	);

	/************** One pager options */
	$one_page_metaboxes = array(
		'one_page_settings' => array(
			'title'      => esc_html__( 'One-Page', 'bronze' ),
			'page'       => array( 'post', 'page', 'work', 'product', 'release', 'artist' ),
			'metafields' => array(
				array(
					'label'   => esc_html__( 'One-Page Navigation', 'bronze' ),
					'id'      => '_post_one_page_menu',
					'type'    => 'select',
					'choices' => array(
						''                 => esc_html__( 'No', 'bronze' ),
						'replace_main_nav' => esc_html__( 'Yes', 'bronze' ),
					),
					'desc'    => bronze_kses( __( 'Activate to replace the main menu by a one-page scroll navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'bronze' ) ),
				),
				array(
					'label' => esc_html__( 'One-Page Bullet Navigation', 'bronze' ),
					'id'    => '_post_scroller',
					'type'  => 'checkbox',
					'desc'  => bronze_kses( __( 'Activate to create a section scroller navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'bronze' ) ),
				),
				array(
					'label'   => sprintf( esc_html__( 'Enable %s animations', 'bronze' ), 'fullPage' ),
					'id'      => '_post_fullpage',
					'type'    => 'select',
					'choices' => array(
						''    => esc_html__( 'No', 'bronze' ),
						'yes' => esc_html__( 'Yes', 'bronze' ),
					),
					'desc'    => esc_html__( 'Activate to enable advanced scroll animations between sections. Some of your row setting may be disabled to suit the global page design.', 'bronze' ),
				),

				array(
					'label'      => sprintf( esc_html__( '%s animation transition', 'bronze' ), 'fullPage' ),
					'id'         => '_post_fullpage_transition',
					'type'       => 'select',
					'choices'    => array(
						'mix'      => esc_html__( 'Special', 'bronze' ),
						'parallax' => esc_html__( 'Parallax', 'bronze' ),
						'fade'     => esc_html__( 'Fade', 'bronze' ),
						'zoom'     => esc_html__( 'Zoom', 'bronze' ),
						'curtain'  => esc_html__( 'Curtain', 'bronze' ),
						'slide'    => esc_html__( 'Slide', 'bronze' ),
					),
					'dependency' => array(
						'element' => '_post_fullpage',
						'value'   => array( 'yes' ),
					),
				),

				array(
					'label'       => sprintf( esc_html__( '%s animation duration', 'bronze' ), 'fullPage' ),
					'id'          => '_post_fullpage_animtime',
					'type'        => 'text',
					'placeholder' => 1000,
					'dependency'  => array(
						'element' => '_post_fullpage',
						'value'   => array( 'yes' ),
					),
				),
			),
		),
	);

	$all_metaboxes = array_merge(
		apply_filters( 'bronze_body_metaboxes', $body_metaboxes ),
		apply_filters( 'bronze_post_metaboxes', $post_metaboxes ),
		apply_filters( 'bronze_product_metaboxes', $product_metaboxes ),
		apply_filters( 'bronze_release_metaboxes', $release_metaboxes ),
		apply_filters( 'bronze_video_metaboxes', $video_metaboxes ),
		apply_filters( 'bronze_work_metaboxes', $work_metaboxes ),
		apply_filters( 'bronze_header_metaboxes', $header_metaboxes ),
		apply_filters( 'bronze_menu_metaboxes', $menu_metaboxes ),
		apply_filters( 'bronze_footer_metaboxes', $footer_metaboxes )
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		$all_metaboxes = $all_metaboxes + apply_filters( 'bronze_one_page_metaboxes', $one_page_metaboxes );
	}

	if ( class_exists( 'Wolf_Metaboxes' ) ) {
		new Wolf_Metaboxes( apply_filters( 'bronze_metaboxes', $all_metaboxes ) );
	}
}
bronze_register_metabox();
