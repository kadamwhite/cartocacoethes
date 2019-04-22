<?php
/**
 * WP Rig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ehg
 */
namespace EHG;

function setup() {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup_theme_support' );
	add_filter( 'embed_defaults', __NAMESPACE__ . '\\set_embed_dimensions' );
	add_filter( 'wp_resource_hints', __NAMESPACE__ . '\\add_resource_hints', 10, 2 );
	add_action( 'widgets_init', __NAMESPACE__ . '\\register_theme_sidebars' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function setup_theme_support() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
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
		'primary' => esc_html__( 'Primary', 'ehg' ),
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
	add_theme_support( 'custom-background', apply_filters(
		'ehg_custom_background_args',
		[
			'default-color' => 'ffffff',
			'default-image' => '',
		]
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', [
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => false,
		'flex-height' => false,
	] );

	/**
	 * Add support for default block styles.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#default-block-styles
	 */
	add_theme_support( 'wp-block-styles' );
	/**
	 * Add support for wide aligments.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#wide-alignment
	 */
	add_theme_support( 'align-wide' );

	/**
	 * Optional: Disable custom colors in block color palettes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 *
	 * add_theme_support( 'disable-custom-colors' );
	 */

	/**
	 * Add support for font sizes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#block-font-sizes
	 */
	add_theme_support( 'editor-font-sizes', [
		[
			'name'      => __( 'small', 'ehg' ),
			'shortName' => __( 'S', 'ehg' ),
			'size'      => 16,
			'slug'      => 'small',
		],
		[
			'name'      => __( 'regular', 'ehg' ),
			'shortName' => __( 'M', 'ehg' ),
			'size'      => 20,
			'slug'      => 'regular',
		],
		[
			'name'      => __( 'large', 'ehg' ),
			'shortName' => __( 'L', 'ehg' ),
			'size'      => 36,
			'slug'      => 'large',
		],
		[
			'name'      => __( 'larger', 'ehg' ),
			'shortName' => __( 'XL', 'ehg' ),
			'size'      => 48,
			'slug'      => 'larger',
		],
	] );

	/**
	 * Optional: Add AMP support.
	 *
	 * Add built-in support for the AMP plugin and specific AMP features.
	 * Control how the plugin, when activated, impacts the theme.
	 *
	 * @link https://wordpress.org/plugins/amp/
	 */
	add_theme_support( 'amp', [
		'comments_live_list' => true,
	] );

}

/**
 * Set the embed width in pixels, based on the theme's design and stylesheet.
 *
 * @param array $dimensions An array of embed width and height values in pixels (in that order).
 * @return array
 */
function set_embed_dimensions( array $dimensions ) {
	$dimensions['width'] = 720;
	return $dimensions;
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function add_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'ehg-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = [
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		];
	}

	return $urls;
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function register_theme_sidebars() {
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

/**
 * Determine whether a sidebar should be shown on the current page.
 */
function page_has_sidebar() {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		global $template;

		$template_forces_sidebar = in_array( basename( $template ), [
			'page-sidebar.php',
		], true );

		if ( is_archive() || $template_forces_sidebar ) {
			return true;
		}
	}
	return false;
}
