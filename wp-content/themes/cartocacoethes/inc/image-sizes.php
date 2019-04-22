<?php
/**
 * Responsive Images configuration
 *
 * @package ehg
 */
namespace EHG\Image_Sizes;

function setup() {
	add_filter( 'wp_calculate_image_sizes', __NAMESPACE__ . '\\content_image_sizes_attr', 10, 2 );
	add_filter( 'get_header_image_tag', __NAMESPACE__ . '\\header_image_tag', 10, 3 );
	add_filter( 'wp_get_attachment_image_attributes', __NAMESPACE__ . '\\post_thumbnail_sizes_attr', 10, 3 );
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
		$attr['sizes'] = '(min-width: 960px) 75vw, 100vw';
	}

	return $attr;
}

