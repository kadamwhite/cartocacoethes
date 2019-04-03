<?php
namespace EHG;

use EHG\Asset_Loader;

/**
 * Action to run on the 'init' hook, used to register additional action callbacks.
 *
 * @return void
 */
function init() {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\register_image_sizes' );
	add_action( 'widgets_init', __NAMESPACE__ . '\\widgets_init' );
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_editor_assets' );
	add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\enqueue_block_frontent_assets' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @return void
 */
function setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Emily Garfield Art, use a find and replace
		* to change 'ehg' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ehg', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( [
		'menu-primary' => esc_html__( 'Primary', 'ehg' ),
	] );

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	] );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'custom_background_args', [
		'default-color' => 'ffffff',
		'default-image' => '',
	] ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add theme support for wide Gutenberg images.
	add_theme_support( 'align-wide' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', [
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	] );
}

/**
 * Define the custom thumbnail sizes for use in this theme.
 */
function register_image_sizes() {
	foreach ( [
		'xs' => 160,
		'sm' => 320,
		'md' => 640,
		'lg' => 960,
		'xl' => 1280,
	] as $size => $width ) {
		// Aspect ratio 3:2 => 1.5
		add_image_size( "landscape_$size", $width, floor( $width / 1.5 ), true );
	}
}

/**
 * Attempt to load a particular script bundle from a manifest, falling back
 * to wp_enqueue_script when the manifest is not available.
 *
 * @param string $script_handle   The handle to use for the script (and associated stylesheet).
 * @param array  $script_deps     An array of script dependencies for this JS bundle.
 * @param string $manifest_path   The absolute file system path to the manifest file.
 * @param string $bundle_filename The expected string filename of the file to load.
 * @return void
 */
function autoenqueue(
	string $script_handle,
	array $script_deps,
	string $manifest_path,
	string $bundle_filename
) {
	/**
	 * Filter function to select only blocks whose names include the word "frontend".
	 */
	$manifest_filter = function( $script_key ) use ( $bundle_filename ) {
		return strpos( $script_key, $bundle_filename ) !== false;
	};

	$theme_path = get_stylesheet_directory();

	$loaded_dev_assets = Asset_Loader\enqueue_assets( $manifest_path, [
		'handle'  => $script_handle,
		'filter'  => $manifest_filter,
		'scripts' => $script_deps,
	] );

	if ( ! $loaded_dev_assets ) {
		$js_bundle = $theme_path . 'build/' . $bundle_filename;
		$css_bundle_filename = preg_replace( '\/js$/', '.css', $bundle_filename );
		$css_bundle = $theme_path . 'build/' . $css_bundle_filename;

		// Production mode. Manually enqueue script bundles.
		if ( file_exists( $js_bundle ) ) {
			wp_enqueue_script(
				$script_handle,
				get_theme_file_uri( 'build/' . $bundle_filename ),
				$script_deps,
				filemtime( $js_bundle ),
				true
			);
		}

		if ( file_exists( $css_bundle ) ) {
			wp_enqueue_style(
				$script_handle,
				get_theme_file_uri( 'build/' . $css_bundle_filename ),
				null,
				filemtime( $css_bundle )
			);
		}
	}
}

/**
 * Enqueue the JS and CSS for blocks in the editor.
 *
 * @return void
 */
function enqueue_block_editor_assets() {
	autoenqueue(
		'ehg-editor',
		[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
		get_stylesheet_directory() . '/build/asset-manifest.json',
		'editor.js'
	);
}

/**
 * Enqueue the JS and CSS for blocks on the frontend.
 *
 * @return void
 */
function enqueue_block_frontent_assets() {
	autoenqueue(
		'ehg-theme',
		[ 'wp-editor', 'wp-i18n' ],
		get_stylesheet_directory() . '/build/asset-manifest.json',
		'theme.js'
	);
}

/**
 * Enqueue scripts and styles.
 */
function enqueue_scripts() {
	// wp_enqueue_style( 'ehg-style', get_stylesheet_uri() );

	// Asset_Loader\enqueue_assets( get_stylesheet_directory() );

	// wp_enqueue_script(
	// 	'ehg-theme',
	// 	get_template_directory_uri() . '/build/theme.js',
	// 	[],
	// 	'20181030',
	// 	true
	// );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function widgets_init() {
	register_sidebar( [
		'name'          => esc_html__( 'Sidebar', 'ehg' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ehg' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
}
