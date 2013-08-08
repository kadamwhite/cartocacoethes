<section id="primary">
    <div id="content" role="main">

    <?php if ( have_posts() ) : ?>

        <header class="page-header">
            <h1 class="page-title">
                <?php if ( is_tax() ) : ?>
                    <?php printf(
                        __( '%s: %s', 'twentyeleven' ),
                        get_taxonomy( get_query_var( 'taxonomy' ) )->labels->name,
                        '<span>' . single_tag_title( '', false ) . '</span>'
                    ); ?>
                <?php else : ?>
                    <?php _e( 'Art', 'twentyeleven' ); ?>
                <?php endif; ?>
            </h1>
        </header>

        <?php twentyeleven_content_nav( 'nav-above' ); ?>

        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
            
            <?php get_template_part( 'content-artwork-thumbnail' ); ?>

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
</section><!-- #primary -->
