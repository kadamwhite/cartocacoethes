<?php
/**
 * EHG\Blocks Namespace.
 *
 * @package EHG.
 */

namespace EHG\Blocks;

use Asset_Loader;

/**
 * EHG\Blocks Bootstrap.
 */
function bootstrap() {
	// Register all blocks defined in this plugin.
	// register_blocks();

	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_editor_assets' );
	add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\enqueue_block_frontent_assets' );
}

/**
 * Enqueue the JS and CSS for blocks in the editor.
 *
 * @return void
 */
function enqueue_block_editor_assets() {
	$plugin_path = plugin_dir_path( dirname( __FILE__ ) );
	$plugin_url = plugin_dir_url( dirname( __FILE__ ) );
	$dev_manifest = $plugin_path . 'build/asset-manifest.json';
	$bundle = [
		'handle' => 'ehg-editor-blocks',
		'scripts' => [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
		/**
		 * Filter function to select only blocks whose names include the word "editor".
		 */
		'filter' => function( $script_key ) {
			return strpos( $script_key, 'editor' ) !== false;
		},
	];

	$loaded_dev_assets = Asset_Loader\enqueue_assets( $dev_manifest, $bundle );

	if ( ! $loaded_dev_assets ) {
		// Production mode. Manually enqueue script bundles.
		wp_enqueue_script(
			$bundle['handle'],
			$plugin_url . 'build/editor.js',
			$bundle['scripts'],
			'20181031',
			true
		);

		wp_enqueue_style(
			$bundle['handle'],
			$plugin_url . 'build/editor.css',
			null,
			'20181031'
		);
	}
}

/**
 * Enqueue the JS and CSS for blocks on the frontend.
 *
 * @return void
 */
function enqueue_block_frontent_assets() {
	/**
	 * Filter function to select only blocks whose names include the word "frontend".
	 */
	$frontend_blocks_only = function( $script_key ) {
		return strpos( $script_key, 'frontend' ) !== false;
	};

	$plugin_path  = plugin_dir_path( dirname( __FILE__ ) );
	$plugin_url   = plugin_dir_url( dirname( __FILE__ ) );
	$dev_manifest = $plugin_path . 'build/asset-manifest.json';
	$script_deps  = [ 'wp-editor', 'wp-i18n' ];

	$loaded_dev_assets = Asset_Loader\enqueue_assets( $dev_manifest, [
		'handle' => 'ehg-frontend-blocks',
		'filter' => $frontend_blocks_only,
		'scripts' => $script_deps,
	] );

	if ( ! $loaded_dev_assets ) {
		// Production mode. Manually enqueue script bundles.
		wp_enqueue_script(
			'ehg-frontend-blocks',
			$plugin_url . 'build/frontend.bundle.js',
			$script_deps,
			filemtime( $plugin_path . '/build/frontend.bundle.js' ),
			true
		);

		wp_enqueue_style(
			'ehg-frontend-blocks',
			$plugin_url . 'build/frontend.bundle.css',
			null,
			filemtime( $plugin_path . 'build/frontend.bundle.css' )
		);
	}

	register_i18n_textdomain();
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
