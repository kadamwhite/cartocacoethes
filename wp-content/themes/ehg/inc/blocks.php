<?php
/**
 * EHG\Blocks Namespace.
 *
 * @package EHG.
 */

namespace EHG\Blocks;

/**
 * EHG\Blocks Bootstrap.
 */
function setup() {
	// Register all blocks defined in this plugin.
	// register_blocks();
}

/**
 * Dynamically register blocks if a registration file exists.
 */
function register_blocks() {

	// Each block registered must have an entrypoint in /blocks/{blockname}/namespace.php.
	foreach ( glob( __DIR__ . '../../blocks/**/namespace.php' ) as $file ) {
		require_once $file;
		$block_handle = get_block_name_from_path( $file );
		$bootstrap    = get_namespace_from_block_name( $block_handle ) . '\\bootstrap';

		if ( function_exists( $bootstrap ) ) {
			add_action( 'init', $bootstrap );
		}

		add_action(
			'init',
			function () use ( $block_handle ) {
				register_block( $block_handle );
			}
		);
	}
}

/**
 * Register a block with Gutenberg's PHP API.
 *
 * Necessary in order for server-side functionality like `gutenberg_parse_blocks()`
 * to know about our custom blocks when parsing post grammar.
 *
 * TODO: When we decide what to do about server-side rendering, we'll probably want to
 * pass a render_callback along with the editor_script argument.
 *
 * @param string $block_handle Block slug (ie. directory path segment).
 */
function register_block( $block_handle ) {

	if ( ! function_exists( '\register_block_type' ) ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions
		error_log( 'register_block() call failed: register_block_type function does not exist.' );
		return;
	}

	$block_registration_options = [
		'editor_script' => "ehg-{$block_handle}-edit",
	];

	// Register the block through Gutenberg's PHP API, so block grammar can be parsed server-side.
	\register_block_type(
		"ehg/{$block_handle}",
		/**
		 * Filter the arguments used to register the block.
		 *
		 * @param array $block_registration_options Options passed to register_block_type function.
		 * @return array Filtered block registration options.
		 */
		// phpcs:ignore WordPress.NamingConventions.ValidHookName
		apply_filters( "ehg\\blocks\\register\\{$block_handle}", $block_registration_options )
	);
}

/**
 * Extract the block name from a directory path
 *
 * @param string $directory_path Path to a block's namespace.php file
 * @return string The name of the block, in Pascal case.
 */
function get_block_name_from_path( $directory_path ) {
	return str_replace(
		[ __DIR__ . '/blocks/', '/namespace.php' ],
		[ '', '' ],
		$directory_path
	);
}

/**
 * Get the expected PHP namespace from the block name.
 *
 * @param string $block_name Block handle name, harpoon-case.
 * @return string Expected PHP namespace, in PascalCase.
 */
function get_namespace_from_block_name( $block_name ) {
	return sprintf(
		'EHG\\Blocks\\%s',
		str_replace( '-', '', ucwords( $block_name ) )
	);
}
