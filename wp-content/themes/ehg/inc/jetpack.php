<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Emily_Garfield_Art
 */
namespace EHG\Jetpack;

function setup() {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\ehg_jetpack_setup' );
}

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', [
		'container' => 'main',
		'render'    => __NAMESPACE__ . '\\infinite_scroll_render',
		'footer'    => 'page',
	] );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', [
		'post-details' => [
			'stylesheet' => 'ehg-style',
			'date'       => '.posted-on',
			'categories' => '.cat-links',
			'tags'       => '.tags-links',
			'author'     => '.byline',
			'comment'    => '.comments-link',
		],
		'featured-images' => [
			'archive'    => true,
			'post'       => true,
			'page'       => true,
		],
	] );
}

/**
 * Custom render function for Infinite Scroll.
 */
function infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', get_post_type() );
		endif;
	}
}
