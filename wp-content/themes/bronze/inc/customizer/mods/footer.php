<?php
/**
 * Bronze footer
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_footer_mods( $mods ) {

	$mods['footer'] = array(

		'id'      => 'footer',
		'title'   => esc_html__( 'Footer', 'bronze' ),
		'icon'    => 'welcome-widgets-menus',
		'options' => array(

			'footer_type'    => array(
				'label'     => esc_html__( 'Footer Type', 'bronze' ),
				'id'        => 'footer_type',
				'type'      => 'select',
				'choices'   => array(
					'standard' => esc_html__( 'Standard', 'bronze' ),
					'uncover'  => esc_html__( 'Uncover', 'bronze' ),
					'hidden'   => esc_html__( 'No Footer', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Footer Width', 'bronze' ),
				'id'        => 'footer_layout',
				'type'      => 'select',
				'choices'   => array(
					'boxed' => esc_html__( 'Boxed', 'bronze' ),
					'wide'  => esc_html__( 'Wide', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Foot Widgets Layout', 'bronze' ),
				'id'        => 'footer_widgets_layout',
				'type'      => 'select',
				'choices'   => array(
					'3-cols'               => esc_html__( '3 Columns', 'bronze' ),
					'4-cols'               => esc_html__( '4 Columns', 'bronze' ),
					'one-half-two-quarter' => esc_html__( '1 Half/2 Quarters', 'bronze' ),
					'two-quarter-one-half' => esc_html__( '2 Quarters/1 Half', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Bottom Bar Layout', 'bronze' ),
				'id'        => 'bottom_bar_layout',
				'type'      => 'select',
				'choices'   => array(
					'centered' => esc_html__( 'Centered', 'bronze' ),
					'inline'   => esc_html__( 'Inline', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			'footer_socials' => array(
				'id'          => 'footer_socials',
				'label'       => esc_html__( 'Socials', 'bronze' ),
				'type'        => 'text',
				'description' => esc_html__( 'The list of social services to display in the bottom bar. (eg: facebook,twitter,instagram)', 'bronze' ),
			),

			'copyright'      => array(
				'id'    => 'copyright',
				'label' => esc_html__( 'Copyright Text', 'bronze' ),
				'type'  => 'text',
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['footer']['options']['footer_type']['description'] = sprintf(
			bronze_kses(
				__( 'This is the default footer settings. You can leave the fields below empty and use a <a href="%s" target="_blank">content block</a> instead for more flexibility. See the customizer "Layout" tab or the page options below your text editor.', 'bronze' )
			),
			'http://wlfthm.es/content-blocks'
		);
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_footer_mods' );
