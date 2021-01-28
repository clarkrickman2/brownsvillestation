<?php
/**
 * Bronze discography
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Discography mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_release_mods( $mods ) {

	if ( class_exists( 'Wolf_Discography' ) ) {
		$mods['wolf_discography'] = array(
			'priority' => 45,
			'id'       => 'wolf_discography',
			'title'    => esc_html__( 'Discography', 'bronze' ),
			'icon'     => 'album',
			'options'  => array(
				'release_layout'       => array(
					'id'          => 'release_layout',
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

				'release_display'      => array(
					'id'      => 'release_display',
					'label'   => esc_html__( 'Display', 'bronze' ),
					'type'    => 'select',
					'choices' => apply_filters(
						'bronze_release_display_options',
						array(
							'grid' => esc_html__( 'Grid', 'bronze' ),
						)
					),
				),

				'release_grid_padding' => array(
					'id'        => 'release_grid_padding',
					'label'     => esc_html__( 'Padding (for grid display)', 'bronze' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'bronze' ),
						'no'  => esc_html__( 'No', 'bronze' ),
					),
					'transport' => 'postMessage',
				),

				'release_pagination'   => array(
					'id'          => 'release_pagination',
					'label'       => esc_html__( 'Discography Archive Pagination', 'bronze' ),
					'type'        => 'select',
					'choices'     => array(
						'none'                => esc_html__( 'None', 'bronze' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'bronze' ),
						'load_more'           => esc_html__( 'Load More Button', 'bronze' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'bronze' ),
				),

				'releases_per_page'    => array(
					'label'       => esc_html__( 'Releases per Page', 'bronze' ),
					'id'          => 'releases_per_page',
					'type'        => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;

}
add_filter( 'bronze_customizer_mods', 'bronze_set_release_mods' );
