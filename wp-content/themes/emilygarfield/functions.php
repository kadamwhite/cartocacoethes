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
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( ehg_is_artwork_query( $query ) ) {
        $query->set( 'posts_per_page', 28 );
    }
}
add_action( 'pre_get_posts', 'ehg_artwork_per_page' );

function ehg_body_classes( $classes ) {
    // If we're on the homepage template,
    if ( ! is_front_page() ) {
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
           $query->is_tax('ag_artwork_availability') ||
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

// ==========================================
//    HOMEPAGE FEATURED CONTENT MANAGEMENT
// ==========================================

/**
 * Get an array of content representing the featured posts to display on the
 * site homepage, as determined by a provided number of categories to display,
 * a provided number of posts per category to show, and the presence of posts
 * with a _featured meta key set to 'yes'. This generates many queries and can
 * therefore be expensive to run, so the results of this method will usually
 * be saved to (and read from) a transient to reduce unnecessary DB interaction.
 *
 * @param array[string]int $opts Array with integer values set for the keys
 * "category_count" and "posts_per_category"
 * @returns array[string]array Array with keys "posts" and "categories" holding
 * arrays of objects keyed by the IDs for those posts and categories, and key
 * "posts_by_category" containing a dictionary of posts to show for each category
 */
function ehg_get_featured_posts( $opts ) {
    $category_count = $opts['category_count'];
    $posts_per_category = $opts['posts_per_category'];

    // Ordered numeric array of IDs of categories to be featured
    $featured_category_ids = array();

    // Associative array of category objects keyed by category ID
    $featured_categories = array();

    // Associative array of ordered arrays of post IDs for that category, keyed by
    // category ID: in the below example, posts 120 & 134 from category 24, and
    // post 145 from category 34 are to be included
    //     {
    //         '24': [ 120, 134 ],
    //         '34': [ 145 ]
    //     }
    $featured_posts_by_category = array();

    // Numeric array of IDs of posts to be featured (order does not matter)
    $featured_post_ids = array();

    // Associative array of post objects keyed by post ID
    $featured_posts = array();

    while ( count( $featured_category_ids ) < $category_count ) {
        $args = array(
            'post_type'        => 'post',
            'posts_per_page'   => 1,
            'meta_key'         => '_featured',
            'meta_value'       => 'yes',
            'post__not_in'     => $featured_post_ids,
            'category__not_in' => $featured_category_ids
        );
        $featured_post_query = new WP_Query( $args );
        $post = $featured_post_query->posts[ 0 ];
        $categories = get_the_category( $post->ID );
        $first_category = $categories[ 0 ];

        // Store the post ID for future __not_in usage
        array_push( $featured_post_ids, $post->ID );

        // Store the category ID for future __not_in usage
        array_push( $featured_category_ids, $first_category->term_id );

        // Store the actual content so we can find it later without re-querying
        $featured_categories[ $first_category->term_id ] = $first_category;
        $featured_posts[ $post->ID ] = $post;
        // This should be safe because category__not_in ensures we won't be stomping
        // on any category record that already has data
        $featured_posts_by_category[ $first_category->term_id ] = array( $post->ID );

        // Restore original Post Data (even though we aren't stomping the main query)
        wp_reset_postdata();
    }

    foreach ( $featured_category_ids as $category_id ) {
        $args = array(
            'post_type'      => 'post',
            'meta_key'       => '_featured',
            'meta_value'     => 'yes',
            // Get as many more in this category as are available, up to the
            // specified maximum number of posts per category: one post has
            // already been retrieved for every category.
            'posts_per_page' => $posts_per_category - 1,
            'category__in'   => array( $category_id ),
            // Don't repeat posts
            'post__not_in'   => $featured_post_ids
        );
        $additional_posts_query = new WP_Query( $args );

        foreach ( $additional_posts_query->posts as $post ) {
            // Store the post ID for future __not_in usage
            array_push( $featured_post_ids, $post->ID );
            // Store the actual content so we can find it later without re-querying
            $featured_posts[ $post->ID ] = $post;
            // Add the post ID to the dictionary of posts by category
            array_push( $featured_posts_by_category[ $category_id ], $post->ID );
        }

        // Restore original Post Data (even though we aren't stomping the main query)
        wp_reset_postdata();
    }

    // Expose the three most relevant structures in the returned data
    return array(
        'posts' => $featured_posts,
        'categories' => $featured_categories,
        'posts_by_category' => $featured_posts_by_category
    );
}

/**
 * Get up to 2 posts for each of the four most recent categories, for display
 * on the homepage. Retrieve the data from a transient if possible to reduce
 * repeat DB interactions; this generates a lot of queries under the hood!
 *
 * @returns array[string]array Array with keys "posts" and "categories" holding
 * arrays of objects keyed by the IDs for those posts and categories, and key
 * "posts_by_category" containing a dictionary of posts to show for each category
 */
function ehg_get_homepage_content() {
    $featured_posts = get_transient( 'ehg_homepage_content' );
    if ( false === $featured_posts ) {
        // Execute the queries
        $featured_posts = ehg_get_featured_posts( array(
            'category_count' => 4,
            'posts_per_category' => 2
        ) );

        // store the transient
        set_transient( 'ehg_homepage_content', $featured_posts );
    }

    return $featured_posts;
}

// Delete our homepage content transient whenever a post is published or updated
add_action( 'save_post', function( $post_id ) {
    if ( 'post' === get_post_type( $post_id ) ) {
        delete_transient( 'ehg_homepage_content' );
    }
});
