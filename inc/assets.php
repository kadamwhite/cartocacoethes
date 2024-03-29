<?php

namespace EHG\Assets;

use Asset_Loader;

/**
 * Action to run on theme load, used to register additional action callbacks.
 *
 * @return void
 */
function setup() {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles' );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\dequeue_jetpack_scripts', 20 );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_styles' );
}

/**
 * Return the file system path to the theme's Webpack asset manifest.
 *
 * @return string
 */
function manifest_path() {
	return get_stylesheet_directory() . '/build/production-asset-manifest.json';
}

/**
 * Register Google Fonts
 */
function fonts_url() {
	$fonts_url = '';

	/**
	 * Translator: If Roboto Sans does not support characters in your language, translate this to 'off'.
	 */
	$roboto = esc_html_x( 'on', 'Roboto Condensed font: on or off', 'ehg' );

	$font_families = [];

	if ( 'off' !== $roboto ) {
		$font_families[] = 'Roboto Condensed:400,400i,700,700i';
	}

	if ( in_array( 'on', [ $roboto ] ) ) {
		$query_args = [
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		];

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function enqueue_block_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'ehg-fonts', fonts_url(), [], null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue editor stylesheet. Use the same handle as for the frontend main style.css file.
	Asset_Loader\enqueue_asset( manifest_path(), 'editor-styles.css', [
		'handle' => 'ehg-base-style',
	] );

	// Enqueue custom block transforms.
	Asset_Loader\enqueue_asset( manifest_path(), 'editor.js', [
		'handle' => 'ehg-editor-scripts',
	] );
}

/**
 * Enqueue styles.
 */
function enqueue_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'ehg-fonts', fonts_url(), [], null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Register component styles that are printed as needed.
	Asset_Loader\register_asset( manifest_path(), 'comments.css', [
		'handle' => 'ehg-comments',
	] );
	Asset_Loader\register_asset( manifest_path(), 'front-page.css', [
		'handle' => 'ehg-front-page',
	] );

	// Enqueue main stylesheet.
	Asset_Loader\enqueue_asset( manifest_path(), 'theme.css', [
		'handle' => 'ehg-theme',
	] );

	if ( \EHG\page_has_sidebar() ) {
		Asset_Loader\enqueue_asset( manifest_path(), 'sidebar.css', [
			'handle' => 'ehg-sidebar',
		] );
	}
}

/**
 * Enqueue scripts.
 */
function enqueue_scripts() {

	// If the AMP plugin is active, return early.
	if ( ehg_is_amp() ) {
		return;
	}

	// Enqueue the global theme navigation and link focus script.
	Asset_Loader\enqueue_asset( manifest_path(), 'theme.js', [
		'handle' => 'ehg-theme',
	] );
	wp_script_add_data( 'ehg-theme', 'async', true );
	wp_script_add_data( 'ehg-theme', 'defer', true );
	wp_localize_script( 'ehg-theme', 'ehgScreenReaderText', [
		'expand'   => __( 'Expand child menu', 'ehg' ),
		'collapse' => __( 'Collapse child menu', 'ehg' ),
	] );

	// Enqueue comment script on singular post/page views only.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

/**
 * Un-hook scripts which Jetpack injects regardless of whether their associated
 * functionality is used.
 *
 * @return void
 */
function dequeue_jetpack_scripts() {
	wp_dequeue_script( 'milestone' );
}
