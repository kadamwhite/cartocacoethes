<?php
/**
 * Emily Garfield Art functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Emily_Garfield_Art
 */
namespace EHG;

/**
 * Namespace functions.
 */
require_once( __DIR__ . '/inc/namespace.php' );

/**
 * Custom template tags for this theme.
 */
require_once( get_template_directory() . '/inc/template-tags.php' );

// Bind hooks defined in EHG namespace.
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
add_action( 'after_setup_theme', __NAMESPACE__ . '\\register_image_sizes' );
add_action( 'widgets_init', __NAMESPACE__ . '\\widgets_init' );

/**
 * Bootstrap Gutenberg blocks.
 */
// require_once( __DIR__ . '/inc/blocks.php' );
// Blocks\bootstrap();

/**
 * Customizer additions.
 */
require_once( get_template_directory() . '/inc/customizer.php' );
Customizer\setup();

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require_once( get_template_directory() . '/inc/jetpack.php' );
	Jetpack\setup();
}
