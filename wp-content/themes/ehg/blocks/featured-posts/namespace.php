<?php
/**
 * Server-rendered three-column Featured Posts block.
 */
// phpcs:disable WordPress.VIP.SlowDBQuery
namespace EHG\Blocks\Featured_Posts;

function setup() {
	register_block_type( 'ehg/featured-posts', [
		'render_callback' => __NAMESPACE__ . '\\my_plugin_render_block_latest_post',
	] );
	add_action( 'save_post', __NAMESPACE__ . '\\clear_featured_posts_transient' );
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
	$featured_category_ids = [];

	// Associative array of category objects keyed by category ID
	$featured_categories = [];

	// Associative array of ordered arrays of post IDs for that category, keyed by
	// category ID: in the below example, posts 120 & 134 from category 24, and
	// post 145 from category 34 are to be included
	//     {
	//         '24': [ 120, 134 ],
	//         '34': [ 145 ]
	//     }
	$featured_posts_by_category = [];

	// Numeric array of IDs of posts to be featured (order does not matter)
	$featured_post_ids = [];

	// Associative array of post objects keyed by post ID
	$featured_posts = [];

	while ( count( $featured_category_ids ) < $category_count ) {
		$args = [
			'post_type'        => 'post',
			'posts_per_page'   => 1,
			'meta_key'         => '_featured',
			'meta_value'       => 'yes',
			'post__not_in'     => $featured_post_ids,
			'category__not_in' => $featured_category_ids,
		];
		$featured_post_query = new WP_Query( $args );
		$post = $featured_post_query->posts[0];
		$categories = get_the_category( $post->ID );
		$first_category = $categories[0];

		// Store the post ID for future __not_in usage
		array_push( $featured_post_ids, $post->ID );

		// Store the category ID for future __not_in usage
		array_push( $featured_category_ids, $first_category->term_id );

		// Store the actual content so we can find it later without re-querying
		$featured_categories[ $first_category->term_id ] = $first_category;
		$featured_posts[ $post->ID ] = $post;
		// This should be safe because category__not_in ensures we won't be stomping
		// on any category record that already has data
		$featured_posts_by_category[ $first_category->term_id ] = [ $post->ID ];

		// Restore original Post Data (even though we aren't stomping the main query)
		wp_reset_postdata();
	}

	foreach ( $featured_category_ids as $category_id ) {
		$args = [
			'post_type'      => 'post',
			'meta_key'       => '_featured',
			'meta_value'     => 'yes',
			// Get as many more in this category as are available, up to the
			// specified maximum number of posts per category: one post has
			// already been retrieved for every category.
			'posts_per_page' => $posts_per_category - 1,
			'category__in'   => [ $category_id ],
			// Don't repeat posts
			'post__not_in'   => $featured_post_ids,
		];
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
	return [
		'posts' => $featured_posts,
		'categories' => $featured_categories,
		'posts_by_category' => $featured_posts_by_category,
	];
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
		$featured_posts = ehg_get_featured_posts( [
			'category_count' => 4,
			'posts_per_category' => 3,
		] );

		// store the transient
		set_transient( 'ehg_homepage_content', $featured_posts );
	}

	return $featured_posts;
}

// Delete our homepage content transient whenever a post is published or updated
function clear_featured_posts_transient( int $post_id ) {
	if ( 'post' === get_post_type( $post_id ) ) {
		delete_transient( 'ehg_homepage_content' );
	}
}

function render_featured_posts_block( $attributes, $content ) {
	$recent_posts = wp_get_recent_posts( [
		'numberposts' => 1,
		'post_status' => 'publish',
	] );
	if ( count( $recent_posts ) === 0 ) {
		return 'No posts';
	}
	$post = $recent_posts[0];
	$post_id = $post['ID'];
	return sprintf(
		'<a class="wp-block-my-plugin-latest-post" href="%1$s">%2$s</a>',
		esc_url( get_permalink( $post_id ) ),
		esc_html( get_the_title( $post_id ) )
	);
}
