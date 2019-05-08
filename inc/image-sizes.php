<?php
/**
 * Responsive Images configuration
 *
 * @package ehg
 */
namespace EHG\Image_Sizes;

function setup() {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\register_image_sizes' );
	add_action( 'after_switch_theme', __NAMESPACE__ . '\\update_default_image_sizes' );

	add_filter( 'wp_calculate_image_sizes', __NAMESPACE__ . '\\content_image_sizes_attr', 10, 2 );
	add_filter( 'get_header_image_tag', __NAMESPACE__ . '\\header_image_tag', 10, 3 );
	add_filter( 'wp_get_attachment_image_attributes', __NAMESPACE__ . '\\post_thumbnail_sizes_attr', 10, 3 );

	// Plugin integration.
	add_filter( 'featured_item_blocks_thumbnail_size', __NAMESPACE__ . '\\featured_items_image_size', 10 );
	add_filter( 'featured_item_blocks_image_sizes', __NAMESPACE__ . '\\featured_items_sizes_attr', 10 );
}

/**
 * Helper method to assemble a complete object of all registered image sizes.
 *
 * @return array
 */
function get_registered_image_sizes() : array {
	$image_sizes = [];
	foreach ( get_intermediate_image_sizes() as $size ) {
		$image_sizes[ $size ] = [];
		$image_sizes[ $size ]['width'] = intval( get_option( "{$size}_size_w" ) );
		$image_sizes[ $size ]['height'] = intval( get_option( "{$size}_size_h" ) );
		$image_sizes[ $size ]['crop'] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
	}

	global $_wp_additional_image_sizes;
	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
		$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
	}

	return $image_sizes;
}

/**
 * Sets up custom thumbnail sizes for use in this theme.
 *
 * For each value, define a size that will constrain an image to that length
 * on its longest edge.
 */
function register_image_sizes() {
	$aspect = 3 / 2;

	foreach ( [
		// All values should be evenly divisible by 1.5.
		'xs' => 240,
		'sm' => 321,
		'md' => 480,
		'lg' => 720,
	] as $size => $width ) {
		add_image_size( "landscape_$size", $width, floor( $width / $aspect ), true );
	}
}

/**
 * Update the site image size options when the theme is activated.
 *
 * @return void
 */
function update_default_image_sizes() {
	update_option( 'thumbnail_size_w', 320 );
	update_option( 'thumbnail_size_h', 320 );

	update_option( 'medium_size_w', 480 );
	update_option( 'medium_size_h', 480 );

	update_option( 'medium_large_size_w', 720 );
	update_option( 'medium_large_size_h', 720 );

	update_option( 'large_size_w', 1080 );
	update_option( 'large_size_h', 1080 );
}

/**
 * Given an array of sizes string values, implode that array into a
 * comma-separated sizes string.
 *
 * @param array $sizes An array of sizes (e.g. '(min-width: 960px) 50vw')
 * @return string A concatenated sizes string.
 */
function sizes( array $sizes ) : string {
	return implode( ', ', $sizes );
}

/**
 * Specify which image size to use when rendering a featured items block column.
 */
function featured_items_image_size() : string {
	return 'landscape_md';
}

/**
 * Specify the sizes attribute to use when rendering a featured items block image.
 */
function featured_items_sizes_attr() : string {
	return sizes( [
		'(max-width: 368px) 320px',
		'(max-width: 450px) 380px',
		'(max-width: 1360px) 240px',
		'(max-width: 1980px) 320px',
		'385px',
	] );
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function content_image_sizes_attr( $sizes, $size ) : string {
	$width = $size[0];

	if ( 720 <= $width ) {
		$sizes = '100vw';
	}

	return $sizes;
}

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 *
 * @return string The filtered header image HTML.
 */
function header_image_tag( $html, $header, $attr ) : string {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 *
 * @return array The filtered attributes for the image markup.
 */
function post_thumbnail_sizes_attr( array $attr, $attachment, $size ) : array {

	$attr['sizes'] = '100vw';

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$attr['sizes'] = '(min-width: 1040px) 75vw, 100vw';
	}
	if ( ehg_is_archive() ) {
		$attr['sizes'] = implode( ', ', [
			'(min-width: 960px) 465px',
			'(min-width: 600px) 320px',
			'100vw',
		] );
	}

	return $attr;
}

