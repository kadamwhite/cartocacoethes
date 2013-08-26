<?php
/*
Front Page template (News posts, extra sidebar area)
*/

get_header();

// $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

// // Show 6 most recent news posts on homepage
// $args= array(
//     'category_name' => 'news',
//     'posts_per_page' => 6
// );

// $q = new WP_Query( $args ); ?>

        <?php if ( ! is_paged() ) :
            get_sidebar( 'front-page-content' ); ?>

        <div id="home-news-banner">
            <h2><a href="/category/news/">
                <?php _e( 'News & Events', 'emilygarfield' ); ?>
            </a></h2>
        </div>

        <?php endif; ?>

        <div id="primary">
            <div id="content" role="main">

            <?php if ( have_posts() ) : ?>
                
                <?php twentyeleven_content_nav( 'nav-above' ); ?>

                <?php /* Start the Custom Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', get_post_format() ); ?>

                <?php endwhile; ?>

                <?php twentyeleven_content_nav( 'nav-below' ); ?>

            <?php else : ?>

                <article id="post-0" class="post no-results not-found">
                    <header class="entry-header">
                        <h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
                        <?php get_search_form(); ?>
                    </div><!-- .entry-content -->
                </article><!-- #post-0 -->

            <?php endif; ?>

            </div><!-- #content -->
        </div><!-- #primary -->

<?php get_sidebar( 'front-page' ); ?>
<?php get_footer( 'front-page' ); ?>