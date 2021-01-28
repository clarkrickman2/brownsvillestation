<?php
/**
 * Bronze frontend utility functions
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get current page URL
 */
function bronze_get_current_url() {
	global $wp;
	return esc_url( home_url( add_query_arg( array(), $wp->request ) ) );
}

/**
 * Returns the latest post ID (handles sticky post for blog)
 * Allows to display the first image in the metro style grid bigger disregarding the post type
 *
 * @param string $post_type The post type.
 * @return int
 */
function bronze_get_last_post_id( $post_type = 'post' ) {

	$post_id = null;

	if ( '' === $post_type ) {
		$args = array(
			'posts_per_page'      => 1,
			'post_type'           => 'post',
			'post__in'            => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1,
		);

	} elseif ( 'work' === $post_type ) {

		$args = array(
			'numberposts' => 1,
			'post_type'   => 'work',
		);

	} elseif ( 'gallery' === $post_type ) {

		$args = array(
			'numberposts' => 1,
			'post_type'   => 'gallery',
		);
	}

	$recent_post = wp_get_recent_posts( $args, OBJECT );

	if ( $recent_post && isset( $recent_post[0] ) ) {
		$post_id = $recent_post[0]->ID;
	}

	if ( 'post' === $post_type ) {
		wp_reset_postdata();
	}

	return $post_id;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bronze_content_width() {

	$content_width = 1140;

	$GLOBALS['content_width'] = apply_filters( 'bronze_content_width', $content_width );
}
add_action( 'after_setup_theme', 'bronze_content_width', 0 );

/**
 * WooCommerce AJAX search result
 *
 * @param string $typed The typed string.
 */
function bronze_ajax_search_query( $typed = null ) {

	$args = array(
		'post_type'      => apply_filters( 'wollftheme_live_search_post_types', array( 'post' ) ),
		'post_status'    => 'publish',
		'posts_per_page' => 5,
		's'              => $typed,
	);

	return new WP_Query( $args );
}

if ( ! function_exists( 'bronze_get_image_dominant_color' ) ) {
	/**
	 * Get dominant color image
	 *
	 * @param int $attachment_id the media ID.
	 */
	function bronze_get_image_dominant_color( $attachment_id ) {

		if ( ! $attachment_id || ! extension_loaded( 'gd' ) ) {
			return;
		}

		$metadata = wp_get_attachment_metadata( $attachment_id );

		if ( ! isset( $metadata['file'] ) ) {
			return 'transparent';
		}

		$upload_dir = wp_upload_dir();
		$filename   = $upload_dir['basedir'] . '/' . $metadata['file'];

		if ( ! is_file( $filename ) ) {
			return 'transparent';
		}

		$ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

		if ( 'jpg' === $ext || 'jpeg' === $ext ) {

			$image = imagecreatefromjpeg( $filename );

		} elseif ( 'png' === $ext ) {

			$image = imagecreatefrompng( $filename );

		} elseif ( 'gif' === $ext ) {

			$image = imagecreatefromgif( $filename );
		} else {

			return 'transparent';
		}

		$thumb = imagecreatetruecolor( 1, 1 );
		imagecopyresampled( $thumb, $image, 0, 0, 0, 0, 1, 1, imagesx( $image ), imagesy( $image ) );
		$main_color = strtoupper( dechex( imagecolorat( $thumb, 0, 0 ) ) );

		$main_color = ( 6 === strlen( $main_color ) ) ? '#' . $main_color : 'transparent';

		return $main_color;
	}
}

/**
 * Sanitize html style attribute
 *
 * @param string $string The string to escape.
 * @param bool   $compact Compact it or not.
 * @return string
 */
function bronze_sanitize_style_attr( $string, $compact = true ) {

	if ( $compact ) {
		$string = bronze_compact_css( $string );
	}

	return esc_attr( trim( $string ) );
}

/**
 * Create a formatted sample of any text
 *
 * Remove HTML and shortcode, sanitize and shorten a string
 *
 * @param string $text The text to sample.
 * @param int    $num_words The number of word to keep.
 * @param string $more The string to add at the end of the sample.
 * @return string
 */
function bronze_sample( $text, $num_words = 55, $more = '...' ) {
	$text = wp_strip_all_tags( wp_trim_words( bronze_clean_post_content( $text ), $num_words, $more ) );
	$text = preg_replace( '/(http:|https:)?\/\/[a-zA-Z0-9\/.?&=-]+/', '', $text );
	return esc_attr( $text );
}

/**
 *  Check the type of video from URL
 *
 * Chek if a YouTube, mp4 or Vimeo URL
 *
 * @param string The video URL.
 * @return string|void
 */
function bronze_get_video_url_type( $url ) {

	if ( preg_match( '#youtu#', $url, $match ) ) {

		return 'youtube';

	} elseif ( preg_match( '#vimeo#', $url, $match ) ) {

		return 'vimeo';

	} elseif ( preg_match( '#.mp4#', $url, $match ) ) {

		return 'selfhosted';
	}
}

/**
 * Sanitize color input
 *
 * @link https://github.com/redelivre/wp-divi/blob/master/includes/functions/sanitization.php
 *
 * @param string $color the color string to sanitize.
 * @return string $color
 */
function bronze_sanitize_color( $color ) {
	$color = str_replace( ' ', '', $color );
	if ( 1 === preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}
	elseif ( 'rgb(' === substr( $color, 0, 4 ) ) {
		sscanf( $color, 'rgb(%d,%d,%d)', $red, $green, $blue );
		if ( ( $red >= 0 && $red <= 255 ) &&
			 ( $green >= 0 && $green <= 255 ) &&
			 ( $blue >= 0 && $blue <= 255 )
			) {
			return "rgb({$red},{$green},{$blue})";
		}
	}
	elseif ( 'rgba(' === substr( $color, 0, 5 ) ) {
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		if ( ( $red >= 0 && $red <= 255 ) &&
			 ( $green >= 0 && $green <= 255 ) &&
			 ( $blue >= 0 && $blue <= 255 ) &&
			   $alpha >= 0 && $alpha <= 1
			) {
			return "rgba({$red},{$green},{$blue},{$alpha})";
		}
	}
}

/**
 * sanitize_html_class works just fine for a single class
 * Some times le wild <span class="blue hedgehog"> appears, which is when you need this function,
 * to validate both blue and hedgehog,
 * Because sanitize_html_class doesn't allow spaces.
 *
 * @uses sanitize_html_class
 * @param (mixed: string/array) $class   "blue hedgehog goes shopping" or ["blue", "hedgehog", "goes", "shopping")
 * @param (mixed)               $fallback Anything you want returned in case of a failure
 * @return (mixed: string / $fallback )
 */
function bronze_sanitize_html_classes( $class, $fallback = null ) {
	if ( is_string( $class ) ) {
		$class = explode( ' ', $class );
	}

	if ( is_array( $class ) && count( $class ) > 0 ) {
		$class = array_unique( array_map( 'sanitize_html_class', $class ) );
		return trim( implode( ' ', $class ) );
	} else {
		return trim( sanitize_html_class( $class, $fallback ) );
	}
}

/**
 * Sanitize html style attribute
 *
 * @param string $style
 * @return string
 */
function bronze_esc_style_attr( $style ) {

	return esc_attr( trim( bronze_clean_spaces( $style ) ) );
}

/**
 * Clean post content to get post sample from WPBakery Page Builder Extension content
 *
 * Remove all HTML, shortcode tags and URLs and retrieve any text content from text blocks
 * This function is useful to create an excerpt from a complex post content
 *
 * @param $string
 * @return $string
 */
function bronze_clean_post_content( $string ) {
	$shortcode_regex = '/\[[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-яц一-龯= {}0-9#@|\%_\.:;,+\/\/\?!\'%&€^¨°¤£$§~()`*"-]+\]/';

	$string = wp_strip_all_tags( $string ); // remove HTML
	$string = preg_replace( $shortcode_regex, '', $string ); // remove shortcodes
	$string = preg_replace( '/(http:|https:)?\/\/[a-zA-Z0-9\/.?&=-]+/', '', $string ); // remove URL's

	return $string;
}

/**
 * Get specific shortcode pattern
 */
function bronze_shortcode_preg_match( $shortcode, $content = '' ) {
	$content = ( $content ) ? $content : get_the_content();

	$pattern = '/\[' . $shortcode . '[a-zA-Z0-9_ -=]+\]/';

	if ( preg_match( $pattern, $content, $match ) ) {
		return $match;
	}
}

/**
 * Wrap audio shortcode
 *
 * @param string $html The audio shortcode HTML markup.
 * @return string
 */
function bronze_filter_audio_shortcode_output( $html ) {

	return '<div class="audio-shortcode-container">' . $html . '</div>';
}
add_filter( 'wp_audio_shortcode', 'bronze_filter_audio_shortcode_output' );

/**
 * Wrap oembed object
 *
 * @param string $html The oembed shortcode HTML markup.
 * @return string $html
 */
function bronze_filter_oembed_output( $html, $url, $attr, $post_id ) {

	$oembed_type = 'default';
	$wrap        = false;

	if ( preg_match( '/spotify/', $url, $match ) ) {

		$oembed_type = 'spotify';
		$wrap        = true;

	} elseif ( preg_match( '/soundcloud/', $url, $match ) ) {

		$oembed_type = 'soundcloud';
		$wrap        = true;

	}

	if ( $wrap ) {
		$html = '<p class="oembed-container oembed-type-' . $oembed_type . '">' . $html . '</p>';
	}

	return $html;
}
add_filter( 'embed_oembed_html', 'bronze_filter_oembed_output', 10, 4 );

/**
 * Wrap video shortcode
 *
 * @param string $html The video shortcode HTML markup.
 * @return string $html
 */
function bronze_filter_video_shortcode_output( $html ) {

	return '<div class="video-shortcode-container">' . $html . '</div>';
}
add_filter( 'wp_video_shortcode', 'bronze_filter_video_shortcode_output' );

if ( ! function_exists( 'bronze_format_number' ) ) {
	/**
	 * Format number : 1000 -> 1K
	 *
	 * @param int $n The number to format.
	 * @return string
	 */
	function bronze_format_number( $n ) {

		$s   = array( 'K', 'M', 'G', 'T' );
		$out = '';
		while ( $n >= 1000 && count( $s ) > 0 ) {
			$n   = $n / 1000.0;
			$out = array_shift( $s );
		}
		return round( $n, max( 0, 3 - strlen( (int) $n ) ) ) . " $out";
	}
}

/**
 * Get color brightness to adjust font color
 *
 * Used to determine if a background is light enough to use a dark font
 *
 * @param string $hex The color hex value.
 * @return string light|dark
 */
function bronze_get_color_brightness( $hex ) {

	$hex = str_replace( '#', '', sanitize_hex_color( $hex ) ); // remove #.

	$c_r        = hexdec( substr( $hex, 0, 2 ) );
	$c_g        = hexdec( substr( $hex, 2, 2 ) );
	$c_b        = hexdec( substr( $hex, 4, 2 ) );
	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	return $brightness;
}

/**
 * Get color brightness to adjust font color
 *
 * Used to determine if a background is light enough to use a dark font
 *
 * @param string $hex The color hex value.
 * @return string
 */
function bronze_get_color_tone( $hex, $index = 210 ) {

	$hex = str_replace( '#', '', sanitize_hex_color( $hex ) ); // remove #

	$c_r        = hexdec( substr( $hex, 0, 2 ) );
	$c_g        = hexdec( substr( $hex, 2, 2 ) );
	$c_b        = hexdec( substr( $hex, 4, 2 ) );
	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	if ( $index < $brightness ) {
		return 'light';
	} else {
		return 'dark';
	}
}

/**
 * Check if color is close to black
 *
 * @param string $hex The color hex value to check.
 * @return bool
 */
function bronze_color_is_black( $hex ) {

	$hex = str_replace( '#', '', sanitize_hex_color( $hex ) ); // remove #.

	$c_r        = hexdec( substr( $hex, 0, 2 ) );
	$c_g        = hexdec( substr( $hex, 2, 2 ) );
	$c_b        = hexdec( substr( $hex, 4, 2 ) );
	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	if ( 30 > $brightness ) {
		return true;
	}
}

/**
 * Check if color is close to white
 *
 * @param string $hex The color hex value.
 * @return bool
 */
function bronze_color_is_white( $hex ) {

	$hex = str_replace( '#', '', sanitize_hex_color( $hex ) ); // remove #

	$c_r        = hexdec( substr( $hex, 0, 2 ) );
	$c_g        = hexdec( substr( $hex, 2, 2 ) );
	$c_b        = hexdec( substr( $hex, 4, 2 ) );
	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	if ( 220 < $brightness ) {
		return true;
	}
}

/**
 * Brightness color function simiar to sass lighten and darken
 *
 * @param string $hex The color hex value.
 * @param int    $percent The darken or lignten percentage.
 * @return string
 */
function bronze_color_brightness( $hex, $percent ) {

	$steps = ( ceil( ( $percent * 200 ) / 100 ) ) * 2;
	$steps = max( -255, min( 255, $steps ) );
	$hex = str_replace( '#', '', bronze_sanitize_color( $hex ) );
	if ( strlen( $hex ) === 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) );
	$b = max( 0, min( 255, $b + $steps ) );

	$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
	$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
	$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

	return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Increases or decreases the brightness of a color by a percentage of the current brightness.
 *
 * @param   string $hex_code        Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
 * @param   float  $adjust_percent  A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
 * @return  string
 * @link https://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function bronze_adjust_brightness( $hex_code, $adjust_percent ) {
	$hex_code = ltrim( $hex_code, '#' );

	if ( strlen( $hex_code ) == 3 ) {
		$hex_code = $hex_code[0] . $hex_code[0] . $hex_code[1] . $hex_code[1] . $hex_code[2] . $hex_code[2];
	}

	$hex_code = array_map( 'hexdec', str_split( $hex_code, 2 ) );

	foreach ( $hex_code as & $color ) {
		$adjustable_limit = $adjust_percent < 0 ? $color : 255 - $color;
		$adjust_amount    = ceil( $adjustable_limit * $adjust_percent );

		$color = str_pad( dechex( $color + $adjust_amount ), 2, '0', STR_PAD_LEFT );
	}

	return '#' . implode( $hex_code );
}

/**
 * Sanitize css value
 *
 * Be sure that the unit of a value ic correct (e.g: 100px)
 *
 * @param string $value
 * @param string $default_unit
 * @param string $default_value
 * @return string $value
 */
function bronze_sanitize_css_value( $value, $default_unit = 'px', $default_value = '1' ) {

	$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
	$regexr = preg_match( $pattern, $value, $matches );
	$value  = isset( $matches[1] ) ? absint( $matches[1] ) : $default_value;
	$unit   = isset( $matches[2] ) ? esc_attr( $matches[2] ) : $default_unit;
	$value  = $value . $unit;

	return $value;
}

