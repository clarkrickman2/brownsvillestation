<?php
/**
 * Bronze videos
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Video mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_video_mods( $mods ) {

	if ( class_exists( 'Wolf_Videos' ) ) {
		$mods['wolf_videos'] = array(
			'id'      => 'wolf_videos',
			'title'   => esc_html__( 'Videos', 'bronze' ),
			'icon'    => 'editor-video',
			'options' => array(

				'video_layout'         => array(
					'id'          => 'video_layout',
					'label'       => esc_html__( 'Layout', 'bronze' ),
					'type'        => 'select',
					'choices'     => array(
						'standard'      => esc_html__( 'Standard', 'bronze' ),
						'fullwidth'     => esc_html__( 'Full width', 'bronze' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'bronze' ),
					),
					'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'bronze' ),
				),

				'video_grid_padding'   => array(
					'id'        => 'video_grid_padding',
					'label'     => esc_html__( 'Padding', 'bronze' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'bronze' ),
						'no'  => esc_html__( 'No', 'bronze' ),
					),
					'transport' => 'postMessage',
				),

				'video_display'        => array(
					'id'      => 'video_display',
					'label'   => esc_html__( 'Display', 'bronze' ),
					'type'    => 'select',
					'choices' => apply_filters(
						'bronze_video_display_options',
						array(
							'grid' => esc_html__( 'Grid', 'bronze' ),
						)
					),
				),

				'video_item_animation' => array(
					'label'   => esc_html__( 'Video Archive Item Animation', 'bronze' ),
					'id'      => 'video_item_animation',
					'type'    => 'select',
					'choices' => bronze_get_animations(),
				),

				'video_onclick'        => array(
					'label'   => esc_html__( 'On Click', 'bronze' ),
					'id'      => 'video_onclick',
					'type'    => 'select',
					'choices' => apply_filters(
						'bronze_video_onclick',
						array(
							'lightbox' => esc_html__( 'Open Video in Lightbox', 'bronze' ),
							'default'  => esc_html__( 'Go to the Video Page', 'bronze' ),
						)
					),
				),

				'video_pagination'     => array(
					'id'          => 'video_pagination',
					'label'       => esc_html__( 'Video Archive Pagination', 'bronze' ),
					'type'        => 'select',
					'choices'     => array(
						'none'                => esc_html__( 'None', 'bronze' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'bronze' ),
						'load_more'           => esc_html__( 'Load More Button', 'bronze' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'bronze' ),
				),

				'videos_per_page'      => array(
					'label'       => esc_html__( 'Videos per Page', 'bronze' ),
					'id'          => 'videos_per_page',
					'type'        => 'text',
					'placeholder' => 6,
				),

				'video_single_layout'  => array(
					'id'      => 'video_single_layout',
					'label'   => esc_html__( 'Single Post Layout', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						'sidebar-right' => esc_html__( 'Sidebar Right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Sidebar Left', 'bronze' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'bronze' ),
						'fullwidth'     => esc_html__( 'Full width', 'bronze' ),
					),
				),

				/*
				'video_columns' => [
					'id' => 'video_columns',
					'label' => esc_html__( 'Columns', 'bronze' ),
					'type' => 'select',
					'choices' => [
						3 => 3,
						2 => 2,
						4 => 4,
						5 => 5,
						6 => 6,
					),
					'transport' => 'postMessage',
				),*/
			),
		);
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_video_mods' );
