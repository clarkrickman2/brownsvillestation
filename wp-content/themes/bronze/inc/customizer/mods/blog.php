<?php
/**
 * Bronze customizer blog mods
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Blog mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_post_mods( $mods ) {

	$mods['blog'] = array(
		'id'      => 'blog',
		'icon'    => 'welcome-write-blog',
		'title'   => esc_html__( 'Blog', 'bronze' ),
		'options' => array(

			'post_layout'           => array(
				'id'          => 'post_layout',
				'label'       => esc_html__( 'Blog Archive Layout', 'bronze' ),
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

			'post_display'          => array(
				'id'      => 'post_display',
				'label'   => esc_html__( 'Blog Archive Display', 'bronze' ),
				'type'    => 'select',
				'choices' => apply_filters(
					'bronze_post_display_options',
					array(
						'standard' => esc_html__( 'Standard', 'bronze' ),
					)
				),
			),

			'post_grid_padding'     => array(
				'id'        => 'post_grid_padding',
				'label'     => esc_html__( 'Padding (for grid style display only)', 'bronze' ),
				'type'      => 'select',
				'choices'   => array(
					'yes' => esc_html__( 'Yes', 'bronze' ),
					'no'  => esc_html__( 'No', 'bronze' ),
				),
				'transport' => 'postMessage',
			),

			'date_format'           => array(
				'id'      => 'date_format',
				'label'   => esc_html__( 'Blog Date Format', 'bronze' ),
				'type'    => 'select',
				'choices' => array(
					''           => esc_html__( 'Default', 'bronze' ),
					'human_diff' => esc_html__( '"X Time ago"', 'bronze' ),
				),
			),

			'post_pagination'       => array(
				'id'      => 'post_pagination',
				'label'   => esc_html__( 'Blog Archive Pagination', 'bronze' ),
				'type'    => 'select',
				'choices' => array(
					'standard_pagination' => esc_html__( 'Numeric Pagination', 'bronze' ),
					'load_more'           => esc_html__( 'Load More Button', 'bronze' ),
				),
			),

			'post_excerpt_type'     => array(
				'id'          => 'post_excerpt_type',
				'label'       => esc_html__( 'Blog Archive Post Excerpt Type', 'bronze' ),
				'type'        => 'select',
				'choices'     => array(
					'auto'   => esc_html__( 'Auto', 'bronze' ),
					'manual' => esc_html__( 'Manual', 'bronze' ),
				),
				'description' => sprintf( bronze_kses( __( 'Only for the "Standard" display type. To split your post manually, you can use the <a href="%s" target="_blank">"read more"</a> tag.', 'bronze' ) ), 'https://codex.wordpress.org/Customizing_the_Read_More' ),
			),

			'post_single_layout'    => array(
				'id'      => 'post_single_layout',
				'label'   => esc_html__( 'Single Post Layout', 'bronze' ),
				'type'    => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Sidebar Right', 'bronze' ),
					'sidebar-left'  => esc_html__( 'Sidebar Left', 'bronze' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'bronze' ),
					'fullwidth'     => esc_html__( 'Full width', 'bronze' ),
				),
			),

			'post_author_box'       => array(
				'id'      => 'post_author_box',
				'label'   => esc_html__( 'Single Post Author Box', 'bronze' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'bronze' ),
					'no'  => esc_html__( 'No', 'bronze' ),
				),
			),

			'post_related_posts'    => array(
				'id'      => 'post_related_posts',
				'label'   => esc_html__( 'Single Post Related Posts', 'bronze' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'bronze' ),
					'no'  => esc_html__( 'No', 'bronze' ),
				),
			),

			'post_item_animation'   => array(
				'label'   => esc_html__( 'Blog Archive Item Animation', 'bronze' ),
				'id'      => 'post_item_animation',
				'type'    => 'select',
				'choices' => bronze_get_animations(),
			),

			'post_display_elements' => array(
				'id'          => 'post_display_elements',
				'label'       => esc_html__( 'Elements to show by default', 'bronze' ),
				'type'        => 'group_checkbox',
				'choices'     => array(
					'show_thumbnail'  => esc_html__( 'Thumbnail', 'bronze' ),
					'show_date'       => esc_html__( 'Date', 'bronze' ),
					'show_text'       => esc_html__( 'Text', 'bronze' ),
					'show_category'   => esc_html__( 'Category', 'bronze' ),
					'show_author'     => esc_html__( 'Author', 'bronze' ),
					'show_tags'       => esc_html__( 'Tags', 'bronze' ),
					'show_extra_meta' => esc_html__( 'Extra Meta', 'bronze' ),
				),
				'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'bronze' ),
			),
		),
	);

	if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {

		$mods['blog']['options'][] = array(
			'label'   => esc_html__( 'Enable Custom Post Meta', 'bronze' ),
			'id'      => 'enable_custom_post_meta',
			'type'    => 'group_checkbox',
			'choices' => array(
				'post_enable_views'        => esc_html__( 'Views', 'bronze' ),
				'post_enable_likes'        => esc_html__( 'Likes', 'bronze' ),
				'post_enable_reading_time' => esc_html__( 'Reading Time', 'bronze' ),
			),
		);
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_post_mods' );
