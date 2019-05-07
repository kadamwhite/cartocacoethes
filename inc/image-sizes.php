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
 * Sets up custom thumbnail sizes for use in this theme
 */
function register_image_sizes() {
	$aspect = 3 / 2;

	foreach ( [
		'xs' => 160,
		'sm' => 320,
		'md' => 640,
		'lg' => 960,
		'xl' => 1280,
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
	update_option( 'thumbnail_size_w', 160 );
	update_option( 'thumbnail_size_h', 160 );

	update_option( 'medium_size_w', 420 );
	update_option( 'medium_size_h', 420 );

	update_option( 'large_size_w', 1200 );
	update_option( 'large_size_h', 1200 );

	update_option( 'medium_large_size_w', 768 );
	update_option( 'medium_large_size_h', 768 );
}

/**
 * Specify which image size to use when rendering a featured items block column.
 */
function featured_items_image_size() {
	return 'landscape_sm';
}

/**
 * Specify the sizes attribute to use when rendering a featured items block image.
 */
function featured_items_sizes_attr() {
	return '(max-width: 45rem) 50vw, (max-width: 1200px) 230px, 320px';
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
function content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '100vw';
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sizes = '(min-width: 960px) 75vw, 100vw';
	}

	return $sizes;
}

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function header_image_tag( $html, $header, $attr ) {
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
 * @return array The filtered attributes for the image markup.
 */
function post_thumbnail_sizes_attr( $attr, $attachment, $size ) {

	$attr['sizes'] = '100vw';

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$attr['sizes'] = '(min-width: 1040px) 75vw, 100vw';
	}
	if ( ehg_is_archive() ) {
		$attr['sizes'] = '(min-width: 600px) 320px, (min-width: 960) 465px, 100vw';
	}

	return $attr;
}

