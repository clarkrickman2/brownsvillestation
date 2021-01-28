<?php
/**
 * Bronze events
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Events mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_event_mods( $mods ) {

	if ( class_exists( 'Wolf_Events' ) ) {
		$mods['wolf_events'] = array(
			'priority' => 45,
			'id'       => 'wolf_events',
			'title'    => esc_html__( 'Events', 'bronze' ),
			'icon'     => 'calendar-alt',
			'options'  => array(

				'event_layout'       => array(
					'id'          => 'event_layout',
					'label'       => esc_html__( 'Layout', 'bronze' ),
					'type'        => 'select',
					'choices'     => array(
						'standard'      => esc_html__( 'Standard', 'bronze' ),
						'fullwidth'     => esc_html__( 'Full width', 'bronze' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'bronze' ),
					),
					'transport'   => 'postMessage',
					'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'bronze' ),
				),

				'event_display'      => array(
					'id'      => 'event_display',
					'label'   => esc_html__( 'Display', 'bronze' ),
					'type'    => 'select',
					'choices' => apply_filters(
						'bronze_list_display_options',
						array(
							'list' => esc_html__( 'List', 'bronze' ),
						)
					),
				),

				'event_grid_padding' => array(
					'id'        => 'event_grid_padding',
					'label'     => esc_html__( 'Padding', 'bronze' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'bronze' ),
						'no'  => esc_html__( 'No', 'bronze' ),
					),
					'transport' => 'postMessage',
				),
			),
		);
	}

	return $mods;

}
add_filter( 'bronze_customizer_mods', 'bronze_set_event_mods' );
