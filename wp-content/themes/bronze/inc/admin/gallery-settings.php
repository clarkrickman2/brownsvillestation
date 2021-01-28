<?php
/**
 * Bronze gallery settings
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'bronze_add_media_manager_options' ) ) {
	/**
	 * Add settings to gallery media manager using Underscore
	 *
	 * @see http://wordpress.stackexchange.com/questions/90114/enhance-media-manager-for-gallery
	 */
	function bronze_add_media_manager_options() {
		/**
		 * Define your backbone template;
		 * the "tmpl-" prefix is required,
		 * and your input field should have a data-setting attribute
		 * matching the shortcode name
		 */
		?>
		<script type="text/html" id="tmpl-custom-gallery-setting">

			<label class="setting">
				<span><?php esc_html_e( 'Layout', 'bronze' ); ?></span>
				<select data-setting="layout">
					<option value="simple"><?php esc_html_e( 'Simple', 'bronze' ); ?></option>
					<option value="mosaic"><?php esc_html_e( 'Mosaic', 'bronze' ); ?></option>
					<option value="slider"><?php esc_html_e( 'Slider (settings below won\'t be applied)', 'bronze' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Custom size', 'bronze' ); ?></span>
				<select data-setting="size">
					<option value="bronze-thumb"><?php esc_html_e( 'Standard', 'bronze' ); ?></option>
					<option value="bronze-2x2"><?php esc_html_e( 'Square', 'bronze' ); ?></option>
					<option value="bronze-portrait"><?php esc_html_e( 'Portrait', 'bronze' ); ?></option>
					<option value="thumbnail"><?php esc_html_e( 'Thumbnail', 'bronze' ); ?></option>
					<option value="medium"><?php esc_html_e( 'Medium', 'bronze' ); ?></option>
					<option value="large"><?php esc_html_e( 'Large', 'bronze' ); ?></option>
					<option value="full"><?php esc_html_e( 'Full', 'bronze' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Padding', 'bronze' ); ?></span>
				<select data-setting="padding">
					<option value="yes"><?php esc_html_e( 'Yes', 'bronze' ); ?></option>
					<option value="no"><?php esc_html_e( 'No', 'bronze' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Hover effect', 'bronze' ); ?></span>
				<select data-setting="hover_effect">
					<option value="default"><?php esc_html_e( 'Default', 'bronze' ); ?></option>
					<option value="scale-to-greyscale"><?php esc_html_e( 'Scale + Colored to Black and white', 'bronze' ); ?></option>
					<option value="greyscale"><?php esc_html_e( 'Black and white to colored', 'bronze' ); ?></option>
					<option value="to-greyscale"><?php esc_html_e( 'Colored to Black and white', 'bronze' ); ?></option>
					<option value="scale-greyscale"><?php esc_html_e( 'Scale + Black and white to colored', 'bronze' ); ?></option>
					<option value="none"><?php esc_html_e( 'None', 'bronze' ); ?></option>
				</select>
				<small><?php esc_html_e( 'Note that not all browser support the black and white effect', 'bronze' ); ?></small>
			</label>
		</script>

		<script>
		jQuery( document ).ready( function() {
			/* add your shortcode attribute and its default value to the
			gallery settings list; $.extend should work as well... */
			_.extend( wp.media.gallery.defaults, {
				size : 'standard',
				padding : 'no',
				hover_effet : 'default'
			} );

			/* merge default gallery settings template with yours */
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend( {
				template: function( view ) {
					return wp.media.template( 'gallery-settings' )( view )
					+ wp.media.template( 'custom-gallery-setting' )( view );
				}
			} );
		} );
		</script>
		<?php
	}
	add_action( 'print_media_templates', 'bronze_add_media_manager_options' );
}
