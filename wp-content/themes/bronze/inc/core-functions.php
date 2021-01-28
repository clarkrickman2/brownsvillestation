<?php
/**
 * Core functions
 *
 * General core functions available on admin and frontend
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Gets the ID of the post, even if it's not inside the loop.
 *
 * @uses WP_Query
 * @uses get_queried_object()
 * @extends get_the_ID()
 * @see get_the_ID()
 *
 * @return int
 */
function bronze_get_the_id() {

	global $wp_query;

	$post_id = null;
	if ( is_object( $wp_query ) && isset( $wp_query->queried_object ) && isset( $wp_query->queried_object->ID ) ) {
		$post_id = $wp_query->queried_object->ID;
	} else {
		$post_id = get_the_ID();
	}

	return $post_id;
}

/**
 * Get the content of a file using wp_remote_get
 *
 * @param string $file path from theme folder.
 */
function bronze_file_get_contents( $file ) {

	if ( is_file( $file ) ) {

		$file_uri = bronze_get_theme_uri( $file );

		$response = wp_remote_get( $file_uri );

		if ( is_array( $response ) ) {
			return wp_remote_retrieve_body( $response );
		}
	}
}

/**
 * Check if Wolf WPBakery Page Builder Extension is activated
 *
 * @return bool
 */
function bronze_is_wvc_activated() {
	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) && defined( 'WVC_OK' ) && WVC_OK ) {
		return true;
	} elseif ( class_exists( 'Wolf_Core' ) && defined( 'WOLF_CORE_VERSION' ) && defined( 'WVCWOLF_CORE_OK_OK' ) && WOLF_CORE_OK ) {
		return true;
	}
}

/**
 * Check if WooCommerce is activated
 *
 * @return bool
 */
function bronze_is_wc_activated() {
	if ( class_exists( 'WooCommerce' ) ) {
		return true;
	}
}

/**
 * Get default post types to use with VC
 */
function bronze_get_default_post_types() {
	return array(
		'post',
		'page',
		'work',
		'product',
		'release',
		'gallery',
		'event',
		'video',
		'wvc_content_block',
	);
}

/**
 * Get all available animations
 *
 * @return array
 */
function bronze_get_animations() {

	return apply_filters(
		'bronze_item_animations',
		array(
			'none'            => esc_html__( 'None', 'bronze' ),
			'fade'            => esc_html__( 'Fade', 'bronze' ),
			'fade-up'         => esc_html__( 'Fade Up', 'bronze' ),
			'fade-down'       => esc_html__( 'Fade Down', 'bronze' ),
			'fade-left'       => esc_html__( 'Fade Left', 'bronze' ),
			'fade-right'      => esc_html__( 'Fade Right', 'bronze' ),
			'fade-up-right'   => esc_html__( 'Fade Up Right', 'bronze' ),
			'fade-up-left'    => esc_html__( 'Fade Up Left', 'bronze' ),
			'fade-down-right' => esc_html__( 'Fade Down Right', 'bronze' ),
			'fade-down-left'  => esc_html__( 'Fade Down Left', 'bronze' ),

			'flip-up'         => esc_html__( 'Flip Up', 'bronze' ),
			'flip-down'       => esc_html__( 'Flip Down', 'bronze' ),
			'flip-left'       => esc_html__( 'Flip Left', 'bronze' ),
			'flip-right'      => esc_html__( 'Flip Right', 'bronze' ),

			'slide-up'        => esc_html__( 'Slide Up', 'bronze' ),
			'slide-down'      => esc_html__( 'Slide Down', 'bronze' ),
			'slide-left'      => esc_html__( 'Slide Left', 'bronze' ),
			'slide-right'     => esc_html__( 'Slide Right', 'bronze' ),

			'zoom-in'         => esc_html__( 'Zoom In', 'bronze' ),
			'zoom-in-up'      => esc_html__( 'Zoom In Up', 'bronze' ),
			'zoom-in-down'    => esc_html__( 'Zoom In Down', 'bronze' ),
			'zoom-in-left'    => esc_html__( 'Zoom In Left', 'bronze' ),
			'zoom-in-right'   => esc_html__( 'Zoom In Right', 'bronze' ),
			'zoom-out'        => esc_html__( 'Zoom Out', 'bronze' ),
			'zoom-out-up'     => esc_html__( 'Zoom Out Up', 'bronze' ),
			'zoom-out-down'   => esc_html__( 'Zoom Out Down', 'bronze' ),
			'zoom-out-left'   => esc_html__( 'Zoom Out Left', 'bronze' ),
			'zoom-out-right'  => esc_html__( 'Zoom Out Right', 'bronze' ),
		)
	);
}

/**
 * Minimium requirements variables
 *
 * @return array
 */
function bronze_get_minimum_required_server_vars() {

	$variables = array(
		'REQUIRED_PHP_VERSION'         => '7.0.0',
		'REQUIRED_WP_VERSION'          => '5.0',
		'REQUIRED_WP_MEMORY_LIMIT'     => '128M',
		'REQUIRED_SERVER_MEMORY_LIMIT' => '128M',
		'REQUIRED_MAX_INPUT_VARS'      => 3000,
		'REQUIRED_MAX_EXECUTION_TIME'  => 300,
		'REQUIRED_UPLOAD_MAX_FILESIZE' => '128M',
		'REQUIRED_POST_MAX_SIZE'       => '128M',
	);

	return $variables;
}

/**
 * Get theme root
 */
function bronze_get_theme_dirname() {
	return basename( dirname( dirname( __FILE__ ) ) );
}

/**
 * Get theme name
 *
 * @return string
 */
function bronze_get_theme_name() {
	$theme = wp_get_theme();
	return $theme->get( 'Name' );
}

/**
 * Get parent theme name
 *
 * @return string
 */
function bronze_get_parent_theme_name() {
	$theme = wp_get_theme( bronze_get_theme_dirname() );
	return $theme->get( 'Name' );
}

/**
 * Get theme version
 *
 * @return string
 */
function bronze_get_theme_version() {
	$theme = wp_get_theme();
	return $theme->get( 'Version' );
}

/**
 * Get parent theme version
 *
 * @return string
 */
function bronze_get_parent_theme_version() {
	$theme = wp_get_theme( bronze_get_theme_dirname() );
	return $theme->get( 'Version' );
}

/**
 * Get the theme slug
 *
 * @return string
 */
function bronze_get_theme_slug() {

	return apply_filters( 'bronze_theme_slug', esc_attr( sanitize_title_with_dashes( get_template() ) ) );
}

/**
 * Get styling option
 *
 * First check if the option is set in post options (metabox) else return theme mod
 * Option key must have the same slug ( e.g '_post_my_option' for metabox and 'my_option' for theme mod )
 *
 * @param  string $key the mod key.
 * @param  string $default the default value.
 * @param  int    $post_id the post ID.
 * @return string
 */
function bronze_get_inherit_mod( $key, $default = '', $post_id = null ) {
	$option = bronze_get_theme_mod( $key, $default );

	$post_id = ( $post_id ) ? $post_id : bronze_get_inherit_post_id();
	if ( get_post_meta( $post_id, '_post_' . $key, true ) ) {
		$option = get_post_meta( $post_id, '_post_' . $key, true );
	}

	return apply_filters( 'bronze_' . $key, $option );
}

if ( ! function_exists( 'bronze_get_theme_mod' ) ) {
	/**
	 * Get theme mod
	 *
	 * @param  string $key the mod key.
	 * @param  string $default the default value.
	 * @return string
	 */
	function bronze_get_theme_mod( $key, $default = '' ) {

		if ( isset( $_GET[ $key ] ) && preg_match( '#^[a-zA-Z0-9-_\/]+$#', $_GET[ $key ] ) ) {

			return esc_attr( $_GET[ $key ] );
		} elseif ( $default && '' === get_theme_mod( $key, $default ) ) {

			return $default;

		} else {
			return apply_filters( 'bronze_mod_' . $key, get_theme_mod( $key, $default ) );
		}
	}
}

/**
 * Get theme option
 *
 * @param  string $index the option index.
 * @param  string $key the option key.
 * @param  string $default the option default value.
 * @return string
 */
function bronze_get_option( $index, $key, $default = null ) {
	$theme_slug  = bronze_get_theme_slug();
	$option_name = $theme_slug . '_' . $index . '_settings';
	$settings    = get_option( $option_name );

	if ( isset( $settings[ $key ] ) ) {

		return $settings[ $key ];

	} elseif ( $default ) {

		return $default;
	}
}

/**
 * Inject/update an option in the theme options array
 *
 * @param  string $index the option index.
 * @param  string $key the option key.
 * @param  string $value The option default value.
 */
function bronze_update_option( $index, $key, $value ) {

	$theme_slug            = bronze_get_theme_slug();
	$option_name           = $theme_slug . '_' . $index . '_settings';
	$theme_options         = ( get_option( $option_name ) ) ? get_option( $option_name ) : array();
	$theme_options[ $key ] = $value;
	update_option( $option_name, $theme_options );
}

/**
 * Check if a file exists before including it
 *
 * Check if the file exists in the child theme with bronze_locate_file or else check if the file exists in the parent theme
 *
 * @param string $file the file to include.
 */
function bronze_include( $file ) {
	if ( bronze_locate_file( $file ) ) {
		return include bronze_locate_file( $file );
	}
}

/**
 * Get config dir
 */
function bronze_get_config_dir() {

	$config_dir = 'config/';
	$theme_slug = bronze_get_theme_slug();

	if ( is_dir( get_parent_theme_file_path( 'THEMES/' . $theme_slug . '/config' ) ) ) {
		$config_dir = 'THEMES/' . $theme_slug . '/config/';
	}

	return $config_dir;
}

/**
 * Check if a file exists before including it
 *
 * Check if the file exists in the child theme with bronze_locate_file or else check if the file exists in the parent theme
 *
 * @param string $file the file to include from the config folder.
 */
function bronze_include_config( $file ) {

	return bronze_include( bronze_get_config_dir() . $file );
}

/**
 * Locate a file and return the path for inclusion.
 *
 * Used to check if the file exists, is in a parent or child theme folder
 *
 * @param  string $filename the file to locate.
 * @return string
 */
function bronze_locate_file( $filename ) {

	$file = null;

	if ( is_file( get_stylesheet_directory() . '/' . untrailingslashit( $filename ) ) ) {

		$file = get_stylesheet_directory() . '/' . untrailingslashit( $filename );

	} elseif ( is_file( get_template_directory() . '/' . untrailingslashit( $filename ) ) ) {

		$file = get_template_directory() . '/' . untrailingslashit( $filename );
	}

	return apply_filters( 'bronze_locate_file', $file );
}

/**
 * Check if a file exists in a child theme
 * else returns the URL of the parent theme file
 * Mainly uses for images
 *
 * @param  string $file the file to add to the theme URI.
 * @return string
 */
function bronze_get_theme_uri( $file = null ) {

	$file = untrailingslashit( $file );

	$file = str_replace( get_template_directory(), '', $file );

	return esc_url( get_stylesheet_directory_uri() . $file );
}

/**
 * Check if a string is an external URL to prevent hot linking when importing default mods on theme activation
 *
 * @param  string $string the URL to check.
 * @return bool
 */
function bronze_is_external_url( $string ) {

	if ( filter_var( $string, FILTER_VALIDATE_URL ) && parse_url( site_url(), PHP_URL_HOST ) != parse_url( $string, PHP_URL_HOST ) ) {
		return parse_url( $string, PHP_URL_HOST );
	}
}

/**
 * Get the URL of an attachment from its id
 *
 * @param  int    $id the attachemnt ID.
 * @param  string $size the thumbnail size.
 * @return string $url
 */
function bronze_get_url_from_attachment_id( $id, $size = 'thumbnail' ) {

	$src = wp_get_attachment_image_src( $id, $size );
	if ( isset( $src[0] ) ) {
		return esc_url( $src[0] );
	}
}

/**
 * Remove spaces in inline CSS
 *
 * @param  string $css the CSS to format.
 * @param  bool   $hard whether to compact the string or not. Remo either double spaces or all spaces.
 * @return string
 */
function bronze_compact_css( $css, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $css );
}

/**
 * Clean a list
 *
 * Remove first and last comma of a list and remove spaces before and after separator
 *
 * @param  string $list The list to clean up.
 * @param  string $separator The item delimiter.
 * @return string $list
 */
function bronze_clean_list( $list, $separator = ',' ) {
	$list = str_replace( array( $separator . ' ', ' ' . $separator ), $separator, $list );
	$list = ltrim( $list, $separator );
	$list = rtrim( $list, $separator );
	return $list;
}

/**
 * Helper method to determine if an attribute is true or false.
 *
 * @param string|int|bool $var Attribute value.
 * @return bool
 */
function bronze_attr_bool( $var ) {
	$falsey = array( 'false', '0', 'no', 'n', '', ' ' );
	return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
}

/**
 * Remove all double spaces
 *
 * This function is mainly used to clean up inline CSS
 *
 * @param string $string The string to clean up.
 * @param bool   $hard Clean up all spaces or just double spaces. Not used ATM.
 * @return string
 */
function bronze_clean_spaces( $string, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $string );
}

/**
 * Convert list of IDs to array
 *
 * @param string $list The list to convert to an array.
 * @param  string $separator The item delimiter.
 * @return array
 */
function bronze_list_to_array( $list, $separator = ',' ) {
	return ( $list ) ? explode( ',', trim( bronze_clean_spaces( bronze_clean_list( $list ) ) ) ) : array();
}

/**
 * Convert array of ids to list
 *
 * @param string $array The array to convert to a list.
 * @return array
 */
function bronze_array_to_list( $array, $separator = ',' ) {
	$list = '';

	if ( is_array( $array ) ) {
		$list = rtrim( implode( $separator, $array ), $separator );
	}

	return bronze_clean_list( $list );
}

/**
 * Check if a file exists in a child theme
 * else returns the path of the parent theme file
 * Mainly uses for config files
 *
 * @param string $file The file to check.
 * @return string
 */
function wolf_get_theme_dir( $file = null ) {

	$file = untrailingslashit( $file );

	if ( is_file( get_stylesheet_directory() . '/' . $file ) ) {

		return get_stylesheet_directory() . '/' . $file;

	} elseif ( is_file( get_template_directory() . '/' . $file ) ) {

		return get_template_directory() . '/' . $file;
	}
}

/**
 * Get post attributes
 *
 * @param int $post_id The post ID.
 * @return array $post_attrs
 */
function bronze_get_post_attr( $post_id ) {

	$post_attrs = array();

	$post_attrs['id']           = 'post-' . $post_id;
	$post_attrs['class']        = bronze_array_to_list( get_post_class(), ' ' );
	$post_attrs['data-post-id'] = $post_id;

	if ( 'work' === get_post_type() ) {
		$post_attrs['itemscope'] = '';
		$post_attrs['itemtype']  = 'https://schema.org/CreativeWork';
	}

	if ( 'release' === get_post_type() ) {
		$post_attrs['itemscope'] = '';
		$post_attrs['itemtype']  = 'https://schema.org/MusicAlbum';
	}

	if ( 'event' === get_post_type() ) {
		$post_attrs['itemscope'] = '';
		$post_attrs['itemtype']  = 'https://schema.org/' . apply_filters( 'bronze_microdata_event_itemtype', 'MusicEvent' );
	}

	if ( 'product' === get_post_type() ) {
	}

	return apply_filters( 'bronze_post_attrs', $post_attrs, $post_id );
}

/**
 * Output post attributes
 *
 * @param int $post_id The post ID.
 */
function bronze_post_attr( $class = '', $post_id = null ) {

	$post_id = ( $post_id ) ? $post_id : get_the_ID();
	$attrs   = bronze_get_post_attr( $post_id );
	$output  = '';

	$classes = array();

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
			$classes = array_map( 'esc_attr', $class );
	} else {
		$class = array();
	}

	foreach ( $attrs as $attr => $value ) {
		if ( $value ) {

			if ( array() !== $classes && 'class' === $attr ) {
				$classes = array_unique( $classes );

				foreach ( $classes as $class ) {
					$value .= ' ' . $class;
				}
			}

			$output .= esc_attr( $attr ) . '="' . esc_attr( $value ) . '" ';

		} else {
			$output .= esc_attr( $attr ) . ' ';
		}
	}

	echo trim( $output );
}

/**
 * Sanitize string with wp_kses
 *
 * @param string $output The string to sanitize.
 * @return sring $output
 */
function bronze_kses( $output ) {

	return wp_kses(
		$output,
		array(
			'div'        => array(
				'style'     => array(),
				'class'     => array(),
				'id'        => array(),
				'itemscope' => array(),
				'itemtype'  => array(),
			),
			'p'          => array(
				'class' => array(),
				'id'    => array(),
			),
			'ul'         => array(
				'class' => array(),
				'id'    => array(),
				'style' => array(),
			),
			'ol'         => array(
				'class' => array(),
				'id'    => array(),
				'style' => array(),
			),
			'li'         => array(
				'class' => array(),
				'id'    => array(),
			),
			'span'       => array(
				'class'        => array(),
				'id'           => array(),
				'data-post-id' => array(),
				'itemprop'     => array(),
				'title'        => array(),
			),
			'i'          => array(
				'class'       => array(),
				'id'          => array(),
				'aria-hidden' => array(),
			),
			'time'       => array(
				'class'    => array(),
				'datetime' => array(),
				'itemprop' => array(),
			),
			'blockquote' => array(
				'class' => array(),
				'id'    => array(),
			),
			'hr'         => array(
				'class' => array(),
				'id'    => array(),
			),
			'strong'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'sup'        => array(
				'class' => array(),
				'id'    => array(),
				'style' => array(),
			),
			'br'         => array(),
			'img'        => array(
				'src'      => array(),
				'srcset'   => array(),
				'class'    => array(),
				'id'       => array(),
				'width'    => array(),
				'height'   => array(),
				'sizes'    => array(),
				'alt'      => array(),
				'title'    => array(),
				'data-src' => array(),
			),
			'audio'      => array(
				'src'      => array(),
				'class'    => array(),
				'id'       => array(),
				'style'    => array(),
				'loop'     => array(),
				'autoplay' => array(),
				'preload'  => array(),
				'controls' => array(),
			),
			'source'     => array(
				'type' => array(),
				'src'  => array(),
			),
			'a'          => array(
				'class'                  => array(),
				'id'                     => array(),
				'href'                   => array(),
				'data-fancybox'          => array(),
				'rel'                    => array(),
				'title'                  => array(),
				'target'                 => array(),
				'data-mega-menu-tagline' => array(),
				'itemprop'               => array(),
			),
			'h1'         => array(
				'class'    => array(),
				'id'       => array(),
				'itemprop' => array(),
				'style'    => array(),
			),
			'h2'         => array(
				'class'    => array(),
				'id'       => array(),
				'itemprop' => array(),
				'style'    => array(),
			),
			'h3'         => array(
				'class'    => array(),
				'id'       => array(),
				'itemprop' => array(),
				'style'    => array(),
			),
			'h4'         => array(
				'class'    => array(),
				'id'       => array(),
				'itemprop' => array(),
				'style'    => array(),
			),
			'h5'         => array(
				'class'    => array(),
				'id'       => array(),
				'itemprop' => array(),
				'style'    => array(),
			),
			'h6'         => array(
				'class'    => array(),
				'id'       => array(),
				'itemprop' => array(),
				'style'    => array(),
			),
			'ins'        => array(
				'class'    => array(),
				'id'       => array(),
				'itemprop' => array(),
				'style'    => array(),
			),
			'del'        => array(
				'class'    => array(),
				'id'       => array(),
				'itemprop' => array(),
				'style'    => array(),
			),
			'code'       => array(
				'class' => array(),
				'id'    => array(),
			),
			'iframe'     => array(
				'align'        => array(),
				'width'        => array(),
				'height'       => array(),
				'frameborder'  => array(),
				'name'         => array(),
				'src'          => array(),
				'id'           => array(),
				'class'        => array(),
				'style'        => array(),
				'scrolling'    => array(),
				'marginwidth'  => array(),
				'marginheight' => array(),
			),
		)
	);
}

/**
 * Check if the home page is set to posts
 *
 * @return bool
 */
function bronze_is_home_as_blog() {
	return ( 'posts' === get_option( 'show_on_front' ) && is_home() );
}

/**
 * Check if we're on the blog index page
 *
 * @return bool
 */
function bronze_is_blog_index() {

	return bronze_is_home_as_blog() || ( absint( bronze_get_the_id() ) === absint( get_option( 'page_for_posts' ) ) );
}

/**
 * Check if we're on a blog page
 *
 * @return bool
 */
function bronze_is_blog() {

	$is_blog = ( bronze_is_home_as_blog() || bronze_is_blog_index() || is_search() || is_archive() ) && ! bronze_is_woocommerce_page() && 'post' == get_post_type();
	return ( true === $is_blog );
}

/**
 * Get the post ID to use to display a header
 *
 * For example, if a header is set for the blog, we will use it for the archive and search page
 *
 * @return int $id
 */
function bronze_get_inherit_post_id() {

	if ( is_404() ) {
		return;
	}

	$post_id      = null;
	$shop_page_id = ( function_exists( 'bronze_get_woocommerce_shop_page_id' ) ) ? bronze_get_woocommerce_shop_page_id() : false;

	$is_shop_page = function_exists( 'is_shop' ) ? is_shop() || is_cart() || is_checkout() || is_account_page() || is_product_category() || is_product_tag() || ( function_exists( 'wolf_wishlist_get_page_id' ) && is_page( wolf_wishlist_get_page_id() ) ) : false;

	$is_product_taxonomy = function_exists( 'is_product_taxonomy' ) ? is_product_taxonomy() : false;
	$is_single_product   = function_exists( 'is_product' ) ? is_product() : false;
	if ( ( bronze_is_blog() || is_search() ) && false === $is_shop_page && false === $is_product_taxonomy ) {

		$post_id = get_option( 'page_for_posts' );
	} elseif ( $is_shop_page ) {

		$post_id = $shop_page_id;
	} elseif ( ( is_tax( 'band' ) || is_tax( 'label' ) ) && function_exists( 'wolf_discography_get_page_id' ) ) {

		$post_id = wolf_discography_get_page_id();
	} elseif ( is_tax( 'video_type' ) || is_tax( 'video_tag' ) && function_exists( 'wolf_videos_get_page_id' ) ) {

		$post_id = wolf_videos_get_page_id();
	} elseif ( is_tax( 'we_artist' ) && function_exists( 'wolf_events_get_page_id' ) ) {

		$post_id = wolf_events_get_page_id();
	} elseif ( is_tax( 'work_type' ) && function_exists( 'wolf_portfolio_get_page_id' ) ) {

		$post_id = wolf_portfolio_get_page_id();
	} elseif ( is_tax( 'gallery_type' ) && function_exists( 'wolf_albums_get_page_id' ) ) {

		$post_id = wolf_albums_get_page_id();

	} else {
		$post_id = bronze_get_the_id();
	}

	return $post_id;
}

/**
 * Get attachment ID from title
 *
 * @param string $title the attachment title
 * @return int | null the attachment ID
 */
function bronze_get_attachement_id_from_title( $title ) {

	global $wpdb;

	$_attachment = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_title = '$title' AND post_type = 'attachment' ", OBJECT ) );

	$attachment = $_attachment ? array_pop( $_attachment ) : null;

	return ( $attachment && is_object( $attachment ) ) ? $attachment->ID : '';
}

/**
 * Add to cart tag
 *
 * @param int    $product_id
 * @param string $text link text content
 * @param string $class button class
 * @return string
 */
function bronze_add_to_cart( $product_id, $classes = '', $text = '' ) {
	$wc_url = untrailingslashit( bronze_get_current_url() ) . '/?add-to-cart=' . absint( $product_id );

	$classes .= ' product_type_simple add_to_cart_button ajax_add_to_cart';

	return '<a
		href="' . esc_url( $wc_url ) . '"
		rel="nofollow"
		data-quantity="1" data-product_id="' . absint( $product_id ) . '"
		class="' . bronze_sanitize_html_classes( $classes ) . '">' . $text . '</a>';
}

/**
 * gets the current post type in the WordPress Admin
 */
function bronze_get_admin_current_post_type() {

	$post_type = null;

	if ( is_admin() ) {

		if ( isset( $_GET['post'] ) ) {
			$post_type = get_post_type( absint( $_GET['post'] ) );

		} elseif ( isset( $_GET['post_type'] ) ) {
			$post_type = esc_attr( $_GET['post_type'] );
		}
	}

	return $post_type;
}


/**
 * Get lists of categories.
 *
 * @see js_composer/include/classes/vendors/class-vc-vendor-woocommerce.php
 *
 * @param $parent_id
 * @param array     $array
 * @param $level
 * @param array     $dropdown - passed by  reference
 */
function bronze_get_category_childs_full( $parent_id, $array, $level, &$dropdown ) {
	$keys = array_keys( $array );
	$i    = 0;
	while ( $i < count( $array ) ) {
		$key  = $keys[ $i ];
		$item = $array[ $key ];
		$i ++;
		if ( $item->category_parent == $parent_id ) {
			$name       = str_repeat( '- ', $level ) . $item->name;
			$value      = $item->term_id;
			$dropdown[] = array(
				'label' => $name . ' (' . $item->term_id . ')',
				'value' => $value,
			);
			unset( $array[ $key ] );
			$array = bronze_get_category_childs_full( $item->term_id, $array, $level + 1, $dropdown );
			$keys  = array_keys( $array );
			$i     = 0;
		}
	}

	return $array;
}

/**
 * Get product category dropdown options
 */
function bronze_get_product_cat_dropdown_options() {

	$product_categories_dropdown = array();
	$product_cat_args            = array(
		'type'         => 'post',
		'child_of'     => 0,
		'parent'       => '',
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => false,
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'number'       => '',
		'taxonomy'     => 'product_cat',
		'pad_counts'   => false,

	);

	$categories = get_categories( $product_cat_args );

	$product_categories_dropdown = array();
	bronze_get_category_childs_full( 0, $categories, 0, $product_categories_dropdown );

	return $product_categories_dropdown;
}

/**
 * Get product category dropdown options
 */
function bronze_get_video_cat_dropdown_options() {

	$video_categories_dropdown = array();
	$video_cat_args            = array(
		'type'         => 'post',
		'child_of'     => 0,
		'parent'       => '',
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => false,
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'number'       => '',
		'taxonomy'     => 'video_type',
		'pad_counts'   => false,

	);

	$categories = get_categories( $video_cat_args );

	$video_categories_dropdown = array();
	bronze_get_category_childs_full( 0, $categories, 0, $video_categories_dropdown );

	return $video_categories_dropdown;
}

/**
 * Get metro pattern options
 */
function bronze_get_metro_patterns() {
	return array_flip(
		apply_filters(
			'bronze_metro_pattern_options',
			array(
				'auto'      => esc_html__( 'Auto', 'bronze' ),
				'pattern-1' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'bronze' ), 1, 6 ),
				'pattern-2' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'bronze' ), 2, 8 ),
				'pattern-3' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'bronze' ), 3, 10 ),
				'pattern-4' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'bronze' ), 4, 8 ),
				'pattern-5' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'bronze' ), 5, 5 ),
				'pattern-6' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'bronze' ), 6, 5 ),
				'pattern-7' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'bronze' ), 7, 6 ),
			)
		)
	);
}

/**
 * Get default color skin
 *
 * Get old option name if empty
 *
 * @return string
 */
function bronze_get_color_scheme_option() {
	return apply_filters( 'bronze_color_scheme_option', get_theme_mod( 'color_scheme', get_theme_mod( 'skin', 'default' ) ) );
}

/**
 * Check if Elementor fonts are enabled.
 *
 * Disable all font related option if it is.
 */
function bronze_is_elementor_fonts_enabled() {
	return class_exists( 'Wolf_Core' ) && ! get_option( 'disable_typography_schemes' );
}

/**
 * Check if Elementor colors are enabled.
 *
 * Disable all colors related option if it is.
 */
function bronze_is_elementor_colors_enabled() {
}
