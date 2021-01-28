<?php
/**
 * Bronze shop
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shop mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function bronze_set_product_mods( $mods ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$mods['shop'] = array(
			'id'      => 'shop',
			'title'   => esc_html__( 'Shop', 'bronze' ),
			'icon'    => 'cart',
			'options' => array(

				'product_layout'            => array(
					'id'        => 'product_layout',
					'label'     => esc_html__( 'Products Layout', 'bronze' ),
					'type'      => 'select',
					'choices'   => array(
						'standard'      => esc_html__( 'Standard', 'bronze' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'bronze' ),
						'fullwidth'     => esc_html__( 'Full width', 'bronze' ),
					),
					'transport' => 'postMessage',
				),

				'product_display'           => array(
					'id'      => 'product_display',
					'label'   => esc_html__( 'Products Archive Display', 'bronze' ),
					'type'    => 'select',
					'choices' => apply_filters(
						'bronze_product_display_options',
						array(
							'grid_classic' => esc_html__( 'Grid', 'bronze' ),
						)
					),
				),
				'product_single_layout'     => array(
					'id'        => 'product_single_layout',
					'label'     => esc_html__( 'Single Product Layout', 'bronze' ),
					'type'      => 'select',
					'choices'   => array(
						'standard'      => esc_html__( 'Standard', 'bronze' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'bronze' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'bronze' ),
						'fullwidth'     => esc_html__( 'Full Width', 'bronze' ),
					),
					'transport' => 'postMessage',
				),

				'product_columns'           => array(
					'id'      => 'product_columns',
					'label'   => esc_html__( 'Columns', 'bronze' ),
					'type'    => 'select',
					'choices' => array(
						'default' => esc_html__( 'Auto', 'bronze' ),
						3         => 3,
						2         => 2,
						4         => 4,
						6         => 6,
					),
				),

				'product_item_animation'    => array(
					'label'   => esc_html__( 'Shop Archive Item Animation', 'bronze' ),
					'id'      => 'product_item_animation',
					'type'    => 'select',
					'choices' => bronze_get_animations(),
				),

				'product_zoom'              => array(
					'label' => esc_html__( 'Single Product Zoom', 'bronze' ),
					'id'    => 'product_zoom',
					'type'  => 'checkbox',
				),

				'related_products_carousel' => array(
					'label' => esc_html__( 'Related Products Carousel', 'bronze' ),
					'id'    => 'related_products_carousel',
					'type'  => 'checkbox',
				),

				'cart_menu_item'            => array(
					'label' => esc_html__( 'Add a "Cart" Menu Item', 'bronze' ),
					'id'    => 'cart_menu_item',
					'type'  => 'checkbox',
				),

				'account_menu_item'         => array(
					'label' => esc_html__( 'Add a "Account" Menu Item', 'bronze' ),
					'id'    => 'account_menu_item',
					'type'  => 'checkbox',
				),

				'shop_search_menu_item'     => array(
					'label' => esc_html__( 'Search Menu Item', 'bronze' ),
					'id'    => 'shop_search_menu_item',
					'type'  => 'checkbox',
				),

				'products_per_page'         => array(
					'label'       => esc_html__( 'Products per Page', 'bronze' ),
					'id'          => 'products_per_page',
					'type'        => 'text',
					'placeholder' => 12,
				),
			),
		);
	}

	if ( class_exists( 'Wolf_WooCommerce_Currency_Switcher' ) || defined( 'WOOCS_VERSION' ) ) {
		$mods['shop']['options']['currency_switcher'] = array(
			'label' => esc_html__( 'Add Currency Switcher to Menu', 'bronze' ),
			'id'    => 'currency_switcher',
			'type'  => 'checkbox',
		);
	}

	if ( class_exists( 'Wolf_WooCommerce_Wishlist' ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['wishlist_menu_item'] = array(
			'label' => esc_html__( 'Wishlist Menu Item', 'bronze' ),
			'id'    => 'wishlist_menu_item',
			'type'  => 'checkbox',
		);
	}

	return $mods;
}
add_filter( 'bronze_customizer_mods', 'bronze_set_product_mods' );
