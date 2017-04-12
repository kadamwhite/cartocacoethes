<?php
/**
 * The template for displaying the footer on the front page of the site.
 *
 * Contains the closing of the id=main div and all content after
 *
 */
?>

    </div><!-- #main -->

    <footer id="colophon" role="contentinfo">

            <?php
                /* A sidebar in the footer? Yep. You can can customize
                 * your footer with three columns of widgets.
                 */
                if ( ! is_404() )
                    get_sidebar( 'front-page-footer' );
            ?>

            <div id="site-generator">
                <?php do_action( 'twentyeleven_credits' ); ?>
            </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
