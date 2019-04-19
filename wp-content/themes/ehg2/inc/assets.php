<?php

namespace EHG2\Assets;

use Asset_Loader;

/**
 * Action to run on theme load, used to register additional action callbacks.
 *
 * @return void
 */
function setup() {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles' );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_styles' );
}

/**
 * Register Google Fonts
 */
function fonts_url() {
	$fonts_url = '';

	/**
	 * Translator: If Roboto Sans does not support characters in your language, translate this to 'off'.
	 */
	$roboto = esc_html_x( 'on', 'Roboto Condensed font: on or off', 'wprig' );
	/**
	 * Translator: If Crimson Text does not support characters in your language, translate this to 'off'.
	 */
	$crimson_text = esc_html_x( 'on', 'Crimson Text font: on or off', 'wprig' );

	$font_families = [];

	if ( 'off' !== $roboto ) {
		$font_families[] = 'Roboto Condensed:400,400i,700,700i';
	}

	if ( 'off' !== $crimson_text ) {
		$font_families[] = 'Crimson Text:400,400i,600,600i';
	}

	if ( in_array( 'on', [ $roboto, $crimson_text ] ) ) {
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
	wp_enqueue_style( 'ehg2-fonts', fonts_url(), [], null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue main stylesheet.
	wp_enqueue_style( 'ehg2-base-style', get_theme_file_uri( '/build/editor-styles.css' ), [], '20180514' );
}

/**
 * Enqueue styles.
 */
function enqueue_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'ehg2-fonts', fonts_url(), [], null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue main stylesheet.
	wp_enqueue_style( 'ehg2-base-style', get_theme_file_uri( '/build/style.css' ), [], '20180514' );

	// Register component styles that are printed as needed.
	wp_register_style( 'ehg2-comments', get_theme_file_uri( '/build/comments.css' ), [], '20180514' );
	wp_register_style( 'ehg2-content', get_theme_file_uri( '/build/content.css' ), [], '20180514' );
	wp_register_style( 'ehg2-sidebar', get_theme_file_uri( '/build/sidebar.css' ), [], '20180514' );
	wp_register_style( 'ehg2-widgets', get_theme_file_uri( '/build/widgets.css' ), [], '20180514' );
	wp_register_style( 'ehg2-front-page', get_theme_file_uri( '/build/front-page.css' ), [], '20180514' );
}

/**
 * Enqueue scripts.
 */
function enqueue_scripts() {

	// If the AMP plugin is active, return early.
	if ( ehg2_is_amp() ) {
		return;
	}

	// Enqueue the navigation script.
	wp_enqueue_script( 'ehg2-navigation', get_theme_file_uri( '/build/navigation.js' ), [], '20180514', false );
	wp_script_add_data( 'ehg2-navigation', 'async', true );
	wp_localize_script( 'ehg2-navigation', 'wprigScreenReaderText', [
		'expand'   => __( 'Expand child menu', 'wprig' ),
		'collapse' => __( 'Collapse child menu', 'wprig' ),
	] );

	// Enqueue skip-link-focus script.
	wp_enqueue_script( 'ehg2-skip-link-focus-fix', get_theme_file_uri( '/build/skip-link-focus-fix.js' ), [], '20180514', false );
	wp_script_add_data( 'ehg2-skip-link-focus-fix', 'defer', true );

	// Enqueue comment script on singular post/page views only.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
