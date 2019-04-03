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
require_once( __DIR__ . '/inc/asset-loader.php' );
require_once( __DIR__ . '/inc/namespace.php' );
// Bind hooks defined in EHG namespace.
add_action( 'init', __NAMESPACE__ . '\\init' );
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );

/**
 * Custom template tags for this theme.
 */
require_once( get_template_directory() . '/inc/template-tags.php' );


/**
 * Bootstrap Gutenberg blocks.
 */
require_once( __DIR__ . '/inc/blocks.php' );
Blocks\setup();

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
