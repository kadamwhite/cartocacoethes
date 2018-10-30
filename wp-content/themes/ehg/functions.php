<?php
// phpcs:disable PSR1.Files.SideEffects
// phpcs:disable HM.Functions.NamespacedFunctions.MissingNamespace
/**
 * Emily Garfield Art functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Emily_Garfield_Art
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ehg_setup() {
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
	add_theme_support( 'custom-background', apply_filters( 'ehg_custom_background_args', [
		'default-color' => 'ffffff',
		'default-image' => '',
	] ) );

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
		'flex-width'  => true,
		'flex-height' => true,
	] );
}
add_action( 'after_setup_theme', 'ehg_setup' );


/**
 * Define the custom thumbnail sizes for use in this theme.
 */
function ehg_register_image_sizes() {
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
add_action( 'after_setup_theme', 'ehg_register_image_sizes' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ehg_widgets_init() {
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
add_action( 'widgets_init', 'ehg_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ehg_scripts() {
	wp_enqueue_style( 'ehg-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ehg-navigation', get_template_directory_uri() . '/js/navigation.js', [], '20151215', true );

	wp_enqueue_script( 'ehg-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', [], '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ehg_scripts' );

// /**
//  * Implement the Custom Header feature.
//  */
// require_once( get_template_directory() . '/inc/custom-header.php' );
// HM\CustomHeader\setup();

// /**
//  * Custom template tags for this theme.
//  */
// require_once( get_template_directory() . '/inc/template-tags.php' );
// HM\TemplateTags\setup();

// /**
//  * Functions which enhance the theme by hooking into WordPress.
//  */
// require_once( get_template_directory() . '/inc/template-functions.php' );
// HM\TemplateFunctions\setup();

// /**
//  * Customizer additions.
//  */
// require_once( get_template_directory() . '/inc/customizer.php' );
// HM\Customizer\setup();

// /**
//  * Load Jetpack compatibility file.
//  */
// if ( defined( 'JETPACK__VERSION' ) ) {
// 	require_once( get_template_directory() . '/inc/jetpack.php' );
// 	HM\Jetpack\setup();
// }
