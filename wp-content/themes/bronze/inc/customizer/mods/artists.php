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
 * Set artists mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_artist_mods( $mods ) {

	if ( class_exists( 'Wolf_Artists' ) ) {
		$mods['wolf_artists'] = array(
			'priority' => 45,
			'id'       => 'wolf_artists',
			'title'    => esc_html__( 'Artists', 'bronze' ),
			'icon'     => 'admin-users',
			'options'  => array(

				'artist_layout'       => array(
					'id'          => 'artist_layout',
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

				'artist_display'      => array(
					'id'      => 'artist_display',
					'label'   => esc_html__( 'Display', 'bronze' ),
					'type'    => 'select',
					'choices' => apply_filters(
						'bronze_artist_display_options',
						array(
							'list' => esc_html__( 'List', 'bronze' ),
						)
					),
				),

				'artist_grid_padding' => array(
					'id'        => 'artist_grid_padding',
					'label'     => esc_html__( 'Padding', 'bronze' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'bronze' ),
						'no'  => esc_html__( 'No', 'bronze' ),
					),
					'transport' => 'postMessage',
				),

				'artist_pagination'   => array(
					'id'          => 'artist_pagination',
					'label'       => esc_html__( 'Artists Archive Pagination', 'bronze' ),
					'type'        => 'select',
					'choices'     => array(
						'none'                => esc_html__( 'None', 'bronze' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'bronze' ),
						'load_more'           => esc_html__( 'Load More Button', 'bronze' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'bronze' ),
				),

				'artists_per_page'    => array(
					'label'       => esc_html__( 'Artists per Page', 'bronze' ),
					'id'          => 'artists_per_page',
					'type'        => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;

}
add_filter( 'bronze_customizer_mods', 'bronze_set_artist_mods' );
