<?php
/**
 * Bronze navigation
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Navigation mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_navigation_mods( $mods ) {

	$mods['navigation'] = array(
		'id'      => 'navigation',
		'icon'    => 'menu',
		'title'   => esc_html__( 'Navigation', 'bronze' ),
		'options' => array(

			'menu_layout'           => array(
				'id'      => 'menu_layout',
				'label'   => esc_html__( 'Main Menu Layout', 'bronze' ),
				'type'    => 'select',
				'default' => 'top-justify',
				'choices' => array(
					'top-right'        => esc_html__( 'Top Right', 'bronze' ),
					'top-justify'      => esc_html__( 'Top Justify', 'bronze' ),
					'top-justify-left' => esc_html__( 'Top Justify Left', 'bronze' ),
					'centered-logo'    => esc_html__( 'Centered', 'bronze' ),
					'top-left'         => esc_html__( 'Top Left', 'bronze' ),
					'offcanvas'        => esc_html__( 'Off Canvas', 'bronze' ),
					'overlay'          => esc_html__( 'Overlay', 'bronze' ),
					'lateral'          => esc_html__( 'Lateral', 'bronze' ),
				),
			),

			'menu_width'            => array(
				'id'        => 'menu_width',
				'label'     => esc_html__( 'Main Menu Width', 'bronze' ),
				'type'      => 'select',
				'choices'   => array(
					'wide'  => esc_html__( 'Wide', 'bronze' ),
					'boxed' => esc_html__( 'Boxed', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			'menu_style'            => array(
				'id'        => 'menu_style',
				'label'     => esc_html__( 'Main Menu Style', 'bronze' ),
				'type'      => 'select',
				'choices'   => array(
					'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'bronze' ),
					'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'bronze' ),
					'solid'                  => esc_html__( 'Solid', 'bronze' ),
					'transparent'            => esc_html__( 'Transparent', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			'menu_hover_style'      => array(
				'id'        => 'menu_hover_style',
				'label'     => esc_html__( 'Main Menu Hover Style', 'bronze' ),
				'type'      => 'select',
				'choices'   => apply_filters(
					'bronze_main_menu_hover_style_options',
					array(
						'none'               => esc_html__( 'None', 'bronze' ),
						'opacity'            => esc_html__( 'Opacity', 'bronze' ),
						'underline'          => esc_html__( 'Underline', 'bronze' ),
						'underline-centered' => esc_html__( 'Underline Centered', 'bronze' ),
						'border-top'         => esc_html__( 'Border Top', 'bronze' ),
						'plain'              => esc_html__( 'Plain', 'bronze' ),
					)
				),
				'transport' => 'postMessage',
			),

			'mega_menu_width'       => array(
				'id'        => 'mega_menu_width',
				'label'     => esc_html__( 'Mega Menu Width', 'bronze' ),
				'type'      => 'select',
				'choices'   => array(
					'boxed'     => esc_html__( 'Boxed', 'bronze' ),
					'wide'      => esc_html__( 'Wide', 'bronze' ),
					'fullwidth' => esc_html__( 'Full Width', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			'menu_breakpoint'       => array(
				'id'          => 'menu_breakpoint',
				'label'       => esc_html__( 'Main Menu Breakpoint', 'bronze' ),
				'type'        => 'text',
				'description' => esc_html__( 'Below each width would you like to display the mobile menu? 0 will always show the desktop menu and 99999 will always show the mobile menu.', 'bronze' ),
			),

			'menu_sticky_type'      => array(
				'id'        => 'menu_sticky_type',
				'label'     => esc_html__( 'Sticky Menu', 'bronze' ),
				'type'      => 'select',
				'choices'   => array(
					'none' => esc_html__( 'Disabled', 'bronze' ),
					'soft' => esc_html__( 'Sticky on scroll up', 'bronze' ),
					'hard' => esc_html__( 'Always sticky', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			'menu_skin'             => array(
				'id'          => 'menu_skin',
				'label'       => esc_html__( 'Menu Skin', 'bronze' ),
				'type'        => 'select',
				'choices'     => array(
					'light' => esc_html__( 'Light', 'bronze' ),
					'dark'  => esc_html__( 'Dark', 'bronze' ),
				),
				'transport'   => 'postMessage',
				'description' => esc_html__( 'Can be overwite on single page.', 'bronze' ),
			),

			'menu_cta_content_type' => array(
				'id'      => 'menu_cta_content_type',
				'label'   => esc_html__( 'Additional Content', 'bronze' ),
				'type'    => 'select',
				'default' => 'icons',
				'choices' => apply_filters(
					'bronze_menu_cta_content_type_options',
					array(
						'search_icon'    => esc_html__( 'Search Icon', 'bronze' ),
						'secondary-menu' => esc_html__( 'Secondary Menu', 'bronze' ),
						'none'           => esc_html__( 'None', 'bronze' ),
					)
				),
			),
		),
	);

	$mods['navigation']['options']['menu_socials'] = array(
		'id'          => 'menu_socials',
		'label'       => esc_html__( 'Menu Socials', 'bronze' ),
		'type'        => 'text',
		'description' => esc_html__( 'The list of social services to display in the menu. (eg: facebook,twitter,instagram)', 'bronze' ),
	);

	$mods['navigation']['options']['side_panel_position'] = array(
		'id'          => 'side_panel_position',
		'label'       => esc_html__( 'Side Panel', 'bronze' ),
		'type'        => 'select',
		'choices'     => array(
			'none'  => esc_html__( 'None', 'bronze' ),
			'right' => esc_html__( 'At Right', 'bronze' ),
			'left'  => esc_html__( 'At Left', 'bronze' ),
		),
		'description' => esc_html__( 'Note that it will be disable with a vertical menu layout (offcanvas and lateral layout).', 'bronze' ),
	);

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_navigation_mods' );
