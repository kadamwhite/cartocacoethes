<?php

namespace EHG;

/**
 * EHG namespace bootstrap.
 *
 * @return void
 */
function setup() {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\register_image_sizes' );
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup_theme_support' );
	add_action( 'widgets_init', __NAMESPACE__ . '\\widgets_init' );
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
function setup_theme_support() {
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
