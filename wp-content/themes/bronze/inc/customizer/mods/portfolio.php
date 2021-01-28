<?php
/**
 * Bronze customizer work mods
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Portoflio mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_work_mods( $mods ) {

	if ( class_exists( 'Wolf_Portfolio' ) ) {

		$mods['portfolio'] = [
			'id' => 'portfolio',
			'icon' => 'portfolio',
			'title' => esc_html__( 'Portfolio', 'bronze' ),
			'options' => [

				'work_layout' => [
					'id' =>'work_layout',
					'label' => esc_html__( 'Portfolio Layout', 'bronze' ),
					'type' => 'select',
					'choices' => [
						'standard' => esc_html__( 'Standard', 'bronze' ),
						'fullwidth' => esc_html__( 'Full width', 'bronze' ),
					],
				],

				'work_display' => [
					'id' =>'work_display',
					'label' => esc_html__( 'Portfolio Display', 'bronze' ),
					'type' => 'select',
					'choices' => apply_filters( 'bronze_work_display_options', [
						'grid' => esc_html__( 'Grid', 'bronze' ),
					] ),
				],

				'work_grid_padding' => [
					'id' => 'work_grid_padding',
					'label' => esc_html__( 'Padding (for grid style display only)', 'bronze' ),
					'type' => 'select',
					'choices' => [
						'yes' => esc_html__( 'Yes', 'bronze' ),
						'no' => esc_html__( 'No', 'bronze' ),
					],
					'transport' => 'postMessage',
				],

				'work_item_animation' => [
					'label' => esc_html__( 'Portfolio Post Animation', 'bronze' ),
					'id' => 'work_item_animation',
					'type' => 'select',
					'choices' => bronze_get_animations(),
				],

				'work_pagination' => [
					'id' => 'work_pagination',
					'label' => esc_html__( 'Portfolio Archive Pagination', 'bronze' ),
					'type' => 'select',
					'choices' => [
						'none' => esc_html__( 'None', 'bronze' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'bronze' ),
						'load_more' => esc_html__( 'Load More Button', 'bronze' ),
					],
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'bronze' ),
				],

				'works_per_page' => [
					'label' => esc_html__( 'Works per Page', 'bronze' ),
					'id' => 'works_per_page',
					'type' => 'text',
					'placeholder' => 6,
				],
			],
		];
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_work_mods' );
