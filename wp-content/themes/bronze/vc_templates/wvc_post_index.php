<?php
/**
 * Post index WPBakery Page Builder Template
 *
 * The arguments are passed to the bronze_posts hook so we can do whatever we want with it
 *
 * @author WolfThemes
 * @category Core
 * @package Bronze/Templates
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/* retrieve shortcode attributes */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

$atts['post_type'] = 'post';

/* hook passing VC arguments */
do_action( 'bronze_posts', $atts );
