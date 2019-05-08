<?php
/**
 * Integrate with the ArtGallery plugin, if installed.
 * https://github.com/kadamwhite/artgallery
 */
namespace EHG\ArtGallery;

use ArtGallery\Post_Types;
use ArtGallery\Taxonomies;
use WP_Query;

/**
 * Action to run on theme load, used to register additional action callbacks.
 *
 * @return void
 */
function setup() {
	add_action( 'pre_get_posts', __NAMESPACE__ . '\\set_artwork_per_page' );
	add_filter( 'ehg_posts_navigation', __NAMESPACE__ . '\\posts_navigation_arguments', 10, 1 );
}

/**
 * Filter the arguments used to render archive page post navigation.
 *
 * @param array $args The arguments array to be passed to the_posts_navigation.
 * @return array The filtered arguments.
 */
function posts_navigation_arguments( array $args = [] ) : array {
	if ( ! is_artwork_archive() ) {
		return $args;
	}
	return array_merge( $args, [
		'prev_text'          => __( 'Older artworks', 'ehg' ),
		'next_text'          => __( 'Newer artworks', 'ehg' ),
		'screen_reader_text' => __( 'Artwork navigation', 'ehg' ),
	] );
}

/**
 * Determine whether we're on a single artwork page.
 */
function is_single_artwork() {
	return is_singular( Post_Types\ARTWORK_POST_TYPE );
}

/**
 * Determine whether the current page is an archive for ArtGallery artwork items.
 *
 * @return bool Whether to consider this an archive page.
 */
function is_artwork_archive() : bool {
	return (
		is_post_type_archive( Post_Types\ARTWORK_POST_TYPE ) ||
		is_tax( Taxonomies\ARTWORK_CATEGORIES_TAXONOMY ) ||
		is_tax( Taxonomies\AVAILABILITY_TAXONOMY ) ||
		is_tax( Taxonomies\MEDIA_TAXONOMY )
	);
}

/**
 * Determine whether a WP_Query is going to return ArtGallery artwork items.
 *
 * @param WP_Query $query A WP_Query object.
 * @return bool Whether this query will return artwork items.
 */
function is_artwork_query( WP_Query $query ) : bool {
	return (
		$query->is_post_type_archive( Post_Types\ARTWORK_POST_TYPE ) ||
		$query->is_tax( Taxonomies\ARTWORK_CATEGORIES_TAXONOMY ) ||
		$query->is_tax( Taxonomies\AVAILABILITY_TAXONOMY ) ||
		$query->is_tax( Taxonomies\MEDIA_TAXONOMY )
	);
}

/**
 * Show 28 thumbnails per page when browsing artwork archives.
 *
 * If we're looking at an archive for artwork or for any custom artwork
 * taxonomies, it is visually preferable to show a thumbnail grid instead
 * of the traditional post list. Because thumbnails take up less space,
 * we can display more of them without undue scrolling.
 *
 * @param WP_Query $query A WP_Query object.
 * @return void
 */
function set_artwork_per_page( WP_Query $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( is_artwork_query( $query ) ) {
		$query->set( 'posts_per_archive_page', 28 );
	}
}
