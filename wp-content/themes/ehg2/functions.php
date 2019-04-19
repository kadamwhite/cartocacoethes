<?php
/**
 * WP Rig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wprig
 */
namespace EHG2;

/**
 * Set up theme features, scripts, and styles.
 */
require get_template_directory() . '/inc/namespace.php';
setup();

/**
 * Custom responsive image sizes.
 */
require get_template_directory() . '/inc/image-sizes.php';
Image_Sizes\setup();

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/pluggable/custom-header.php';
Pluggable\Custom_Header\setup();

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
Template_Functions\setup();

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
Customizer\setup();

/**
 * Optional: Add theme support for lazyloading images.
 *
 * @link https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/
 */
require get_template_directory() . '/inc/pluggable/lazyload.php';
Pluggable\Lazyload\setup();
