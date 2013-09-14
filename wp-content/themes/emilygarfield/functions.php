<?php

/**
 * Enqueue the child & parent theme's stylesheets
 */
function ehg_enqueue_scripts_and_styles() {
    wp_register_script(
        'ehg_interaction',
        get_stylesheet_directory_uri() . "/js/interaction.js",
        array( 'jquery' ),
        '0.1.0',
        true // Load in footer
    );

    wp_register_style(
        'ehg_parent_stylesheet',
        get_template_directory_uri() . "/style.css",
        array(),
        '1.5'
    );

    wp_register_style(
        'mailchimp',
        'http://cdn-images.mailchimp.com/embedcode/slim-081711.css',
        array(),
        ''
    );

    wp_register_style(
        'ehg_stylesheet',
        get_stylesheet_directory_uri() . "/style.css",
        array( 'ehg_parent_stylesheet', 'mailchimp' ),
        '0.1.0'
    );

    wp_enqueue_script( 'ehg_interaction' );
    wp_enqueue_style( 'ehg_stylesheet' );
}
add_action( 'wp_enqueue_scripts', 'ehg_enqueue_scripts_and_styles' );

/**
 * Register and initialize the two custom Homepage widget areas
 */
function ehg_widgets_init() {

    // Top left of homepage widget area
    register_sidebar( array(
        'name' => __( 'Homepage Content Area, Left Side', 'emilygarfield' ),
        'id' => 'sidebar-front-1',
        'description' => __( 'The large left-hand front page widget area', 'emilygarfield' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ) );

    // Top right of homepage widget area
    register_sidebar( array(
        'name' => __( 'Homepage Content Area, Right Side', 'emilygarfield' ),
        'id' => 'sidebar-front-2',
        'description' => __( 'The small right-hand front page widget area', 'emilygarfield' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ) );

    // Bottom (full width) of homepage widget area
    register_sidebar( array(
        'name' => __( 'Homepage Main Sidebar', 'emilygarfield' ),
        'id' => 'sidebar-homepage',
        'description' => __( 'Widgets to display next to the News column on the homepage', 'emilygarfield' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Homepage Footer Area One', 'emilygarfield' ),
        'id' => 'homepage-footer-widgets-1',
        'description' => __( 'An optional widget area for the site footer on your homepage', 'emilygarfield' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Homepage Footer Area Two', 'emilygarfield' ),
        'id' => 'homepage-footer-widgets-2',
        'description' => __( 'An optional widget area for the site footer on your homepage', 'emilygarfield' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Homepage Footer Area Three', 'emilygarfield' ),
        'id' => 'homepage-footer-widgets-3',
        'description' => __( 'An optional widget area for the site footer on your homepage', 'emilygarfield' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

}
add_action( 'widgets_init', 'ehg_widgets_init', 20 );

/**
 * Show 24 thumbnails per page when browsing artwork archives
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
    if ( ehg_is_artwork_query( $query ) ) {
        $query->set( 'posts_per_page', 24 );
    }
}
add_action( 'pre_get_posts', 'ehg_artwork_per_page' );

function ehg_news_only_front_page( $query ) {
    if ( is_admin() || !$query->is_main_query() ) {
        return;
    }
    if ( $query->is_home() ) {
        $query->set( 'category_name', 'news' );
        $query->set( 'posts_per_page', 2 );
    }
}
add_action( 'pre_get_posts', 'ehg_news_only_front_page' );

function ehg_hide_news_from_recent_posts( $args ) {
    // Don't show "News", which happens to have an ID of 21
    $args['category__not_in'] = 21;
    return $args;
}
add_filter( 'widget_posts_args', 'ehg_hide_news_from_recent_posts' );

function ehg_body_classes( $classes ) {
    // If we're on the Blog page template,
    if ( ! is_page_template( 'blog.php' ) ) {
        return $classes;
    }
    // don't render the "singular" class
    return array_diff( $classes, array( 'singular' ) );
}
// Ensure filter runs AFTER `twentyeleven_body_classes`
add_filter( 'body_class', 'ehg_body_classes', 20 );

function ehg_footer_copyright() {
    get_template_part( 'copyright-notice' );
}
add_action( 'twentyeleven_credits', 'ehg_footer_copyright' );

function ehg_is_artwork_query( $query ) {
    return $query->is_post_type_archive('ag_artwork_item') ||
           $query->is_tax('ag_artwork_categories') ||
           $query->is_tax('ag_artwork_dimensions') ||
           $query->is_tax('ag_artwork_media');
}

/**
 * Override for twentyeleven_content_nav
 * Display navigation to next/previous pages when applicable, and correctly labels artwork items
 */
function twentyeleven_content_nav( $html_id ) {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) :

        if ( ehg_is_artwork_query( $wp_query ) && ! wp_is_mobile() ) {
            $next_posts_text = __( '<span class="meta-nav">&larr;</span> Older artwork', 'emilygarfield' );
            $previous_posts_text = __( 'Newer artwork <span class="meta-nav">&rarr;</span>', 'emilygarfield' );
        } else {
            $next_posts_text = __( '<span class="meta-nav">&larr;</span> Older posts', 'emilygarfield' );
            $previous_posts_text = __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'emilygarfield' );
        }
    ?>
        <nav id="<?php echo esc_attr( $html_id ); ?>">
            <h3 class="assistive-text"><?php _e( 'Post navigation', 'emilygarfield' ); ?></h3>
            <div class="nav-previous"><?php next_posts_link( $next_posts_text     ); ?></div>
            <div class="nav-next"><?php previous_posts_link( $previous_posts_text ); ?></div>
        </nav><!-- #nav-above -->
    <?php endif;
}
