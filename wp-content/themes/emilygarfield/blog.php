<?php
/*
Template Name: Blog (Page of Posts)
*/

get_header();

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args= array(
    'category__not_in' => 21 // ID of News category
    // 'paged' => $paged
);

$q = new WP_Query( $args ); ?>

        <div id="primary">
            <div id="content" role="main">

            <?php if ( $q->have_posts() ) : ?>
                
                <?php twentyeleven_content_nav( 'nav-above' ); ?>

                <?php /* Start the Custom Loop */ ?>
                <?php while ( $q->have_posts() ) : $q->the_post(); ?>

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
            <?php wp_reset_postdata(); ?>

            </div><!-- #content -->
        </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>