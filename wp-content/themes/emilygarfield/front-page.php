<?php
/*
Front Page template (News posts, extra sidebar area)
*/

get_header();

$featured_posts = ehg_get_homepage_content();

// Show the two most recent posts from each of the 4 most recent categories on homepage
$args= array(
    'category_name' => 'news',
    'posts_per_page' => 2
);
?>

        <div id="home-news-banner">
            <h2><?php _e( 'Latest Updates', 'emilygarfield' ); ?></h2>
        </div>

        <div id="primary">
            <div id="content" role="main">

            <?php if ( ! count ( $featured_posts['posts'] ) ) : ?>

                <article id="post-0" class="post no-results not-found">
                    <header class="entry-header">
                        <h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
                        <?php get_search_form(); ?>
                    </div><!-- .entry-content -->
                </article><!-- #post-0 -->

            <?php else : ?>

                <div class="flex-container">
                <?php foreach ( $featured_posts['posts_by_category'] as $category_id => $post_ids ) :
                    $category = $featured_posts['categories'][ $category_id ];
                    ?>
                    <div class="featured-category flex-item">
                        <h2 class="featured-category-title"><?php echo $category->name; ?></h2>

                        <?php foreach ( $post_ids as $idx=>$post_id ) :
                            $post = $featured_posts[ 'posts' ][ $post_id ];
                            ?>
                            <article id="<?php echo $post_id; ?>" <?php post_class( $post_id ); ?>>
                                <?php if ( 0 === $idx ) : ?>
                                <div class="featured-image">
                                    <?php echo get_the_post_thumbnail( $post_id, 'medium' ); ?>
                                </div>
                                <?php endif; ?>
                                <header class="entry-header">
                                    <h1 class="entry-title">
                                        <a href="<?php echo get_permalink( $post_id ); ?>" rel="bookmark">
                                            <?php echo $post->post_title; ?>
                                        </a>
                                    </h1>
                                    <div class="entry-meta">
                                        <?php twentyeleven_posted_on(); ?>
                                    </div><!-- .entry-meta -->
                                </header><!-- .entry-header -->
                                <div class="entry-summary">
                                    <?php echo $post->post_excerpt; ?>
                                    <a href="<?php echo get_permalink( $post_id ); ?>" rel="bookmark">Continue Reading &rarr;</a>
                                </div><!-- .entry-summary -->
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif;
            ?>

            </div><!-- #content -->
        </div><!-- #primary -->

<?php get_sidebar( 'front-page' ); ?>
<?php get_footer( 'front-page' ); ?>
