<?php
/**
 * Emily Garfield Art functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Emily_Garfield_Art
 */
namespace EHG;

// Load root namespace file.
require_once( __DIR__ . '/inc/namespace.php' );
// All other modules use "setup" as their action-binding function name.
setup();

// Use a highly DIY auto-loader to load in the rest!
foreach ( [
	'assets',
	'blocks',
	'customizer',
	'template-functions',
	'template-tags',
] as $path ) {
	require_once( __DIR__ . "/inc/$path.php" );

	$namespaces = join( '\\', array_map( function( $module ) {
		return str_replace( ' ', '_', ucwords( preg_replace( '/[^a-z0-9]+/', ' ', $module ) ) );
	}, explode( '/', $path ) ) );

	$setup_function = "EHG\\$namespaces\\setup";

	if ( function_exists( $setup_function ) ) {
		call_user_func( $setup_function );
	}
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require_once( __DIR__ . '/inc/jetpack.php' );
	Jetpack\setup();
}
