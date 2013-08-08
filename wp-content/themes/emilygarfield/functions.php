<?php

/**
 * Enqueue the child & parent theme's stylesheets
 */
function ehg_enqueue_styles() {
    wp_register_style(
        'ehg_parent_stylesheet',
        get_template_directory_uri() . "/style.css",
        array(),
        '1.5'
    );

    wp_register_style(
        'ehg_stylesheet',
        get_stylesheet_directory_uri() . "/style.css",
        array( 'ehg_parent_stylesheet' ),
        '0.1.0'
    );

    wp_enqueue_style( 'ehg_stylesheet' );
}
add_action( 'wp_enqueue_scripts', 'ehg_enqueue_styles' );


/**
 * Show 20 thumbnails per page when browsing artwork archives
 *
 * If we're looking at an archive for artwork or for any custom artwork
 * taxonomies, it is visually preferable to show a thumbnail grid instead
 * of the traditional post list. Because thumbnails take up less space,
 * we can display twice as many of them without undue scrolling.
 */
function ehg_artwork_per_page( $query ) {
    if ( is_admin() || !$query->is_main_query() ) {
        return;
    }
    if ( $query->is_post_type_archive('ag_artwork_item') ||
         $query->is_tax('ag_artwork_dimensions') ||
         $query->is_tax('ag_artwork_media') ) {
        $query->set( 'posts_per_page', 20 );
    }
}
add_action( 'pre_get_posts', 'ehg_artwork_per_page' );