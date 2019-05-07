<?php
/**
 * WP Rig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ehg
 */
namespace EHG;

/**
 * Set up theme features.
 */
require __DIR__ . '/inc/namespace.php';
setup();

/**
 * Set up frontend scripts, and styles.
 */
if ( ! function_exists( 'Asset_Loader\\autoenqueue' ) ) {
	require __DIR__ . '/vendor/asset-loader/asset-loader.php';
}
require __DIR__ . '/inc/assets.php';
Assets\setup();

/**
 * Integrate with Art Gallery plugin.
 */
if ( defined( 'ARTGALLERY_VERSION' ) ) {
	require __DIR__ . '/inc/artgallery.php';
	ArtGallery\setup();
}

/**
 * Custom responsive image sizes.
 */
require __DIR__ . '/inc/image-sizes.php';
Image_Sizes\setup();

/**
 * Implement the Custom Header feature.
 */
require __DIR__ . '/inc/pluggable/custom-header.php';
Pluggable\Custom_Header\setup();

/**
 * Custom template tags for this theme.
 */
require __DIR__ . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require __DIR__ . '/inc/template-functions.php';
Template_Functions\setup();

/**
 * Customizer additions.
 */
require __DIR__ . '/inc/customizer.php';
Customizer\setup();

/**
 * Optional: Add theme support for lazyloading images.
 *
 * @link https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/
 */
require __DIR__ . '/inc/pluggable/lazyload.php';
Pluggable\Lazyload\setup();
