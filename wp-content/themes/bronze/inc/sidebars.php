<?php
/**
 * Bronze sidebars
 *
 * Register default sidebar for the theme with the bronze_sidebars_init function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage Bronze
 * @since 1.0.0
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register blog and page sidebar and footer widget area.
 */
function bronze_sidebars_init() {

	/* Blog Sidebar */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'bronze' ),
			'id'            => 'sidebar-main',
			'description'   => esc_html__( 'Add widgets here to appear in your blog sidebar.', 'bronze' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		/* Page Sidebar */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Page Sidebar', 'bronze' ),
				'id'            => 'sidebar-page',
				'description'   => esc_html__( 'Add widgets here to appear in your page sidebar.', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="clearfix widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	if ( apply_filters( 'bronze_allow_side_panel', true ) ) {
		/* Side Panel Sidebar */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Side Panel Sidebar', 'bronze' ),
				'id'            => 'sidebar-side-panel',
				'description'   => esc_html__( 'Add widgets here to appear in your side panel if enabled.', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Footer Sidebar */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area', 'bronze' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'bronze' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	/* Discography sidebar */
	if ( class_exists( 'Wolf_Discography' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Discography Sidebar', 'bronze' ),
				'id'            => 'sidebar-discography',
				'description'   => esc_html__( 'Appears on the discography pages if a layout with sidebar is set', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Videos sidebar */
	if ( class_exists( 'Wolf_Videos' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Videos Sidebar', 'bronze' ),
				'id'            => 'sidebar-videos',
				'description'   => esc_html__( 'Appears on the videos pages if a layout with sidebar is set', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Albums sidebar */
	if ( class_exists( 'Wolf_Albums' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Albums Sidebar', 'bronze' ),
				'id'            => 'sidebar-albums',
				'description'   => esc_html__( 'Appears on the albums pages if a layout with sidebar is set', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Photos sidebar */
	if ( class_exists( 'Wolf_Photos' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Photo Sidebar', 'bronze' ),
				'id'            => 'sidebar-attachment',
				'description'   => esc_html__( 'Appears before the image details on single photo pages', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Photo Sidebar Secondary', 'bronze' ),
				'id'            => 'sidebar-attachment-secondary',
				'description'   => esc_html__( 'Appears after the image details on single photo pages', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Events sidebar */
	if ( class_exists( 'Wolf_Events' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Events Sidebar', 'bronze' ),
				'id'            => 'sidebar-events',
				'description'   => esc_html__( 'Appears on the events pages if a layout with sidebar is set', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* MP Timetable sidebar */
	if ( class_exists( 'Mp_Time_Table' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Timetable Event Sidebar', 'bronze' ),
				'id'            => 'sidebar-mp-event',
				'description'   => esc_html__( 'Appears on the single event pages if a layout with sidebar is set', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Timetable Column Sidebar', 'bronze' ),
				'id'            => 'sidebar-mp-column',
				'description'   => esc_html__( 'Appears on the single column pages if a layout with sidebar is set', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Artists sidebar */
	if ( class_exists( 'Wolf_Artists' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Artists Sidebar', 'bronze' ),
				'id'            => 'sidebar-artists',
				'description'   => esc_html__( 'Appears on the artists pages if a layout with sidebar is set', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Woocommerce sidebar */
	if ( class_exists( 'Woocommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop Sidebar', 'bronze' ),
				'id'            => 'sidebar-shop',
				'description'   => esc_html__( 'Add widgets here to appear in your shop page if a sidebar is visible.', 'bronze' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'bronze_sidebars_init' );
