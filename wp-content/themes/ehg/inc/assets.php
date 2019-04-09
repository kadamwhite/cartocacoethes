<?php

namespace EHG\Assets;

use Asset_Loader;

/**
 * Action to run on the 'init' hook, used to register additional action callbacks.
 *
 * @return void
 */
function setup() {
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_editor_assets' );
	add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\enqueue_block_frontend_assets' );
}

/**
 * Enqueue the JS and CSS for blocks in the editor.
 *
 * @return void
 */
function enqueue_block_editor_assets() {
	Asset_Loader\autoenqueue(
		get_stylesheet_directory() . '/build/asset-manifest.json',
		'editor.js',
		[
			'scripts' => [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
			'handle'  => 'ehg-editor',
		]
	);
}

/**
 * Enqueue the JS and CSS for blocks on the frontend.
 *
 * @return void
 */
function enqueue_block_frontend_assets() {
	Asset_Loader\autoenqueue(
		get_stylesheet_directory() . '/build/asset-manifest.json',
		'theme.js',
		[
			'scripts' => [ 'wp-editor', 'wp-i18n' ],
			'handle'  => 'ehg-theme',
		]
	);
}
