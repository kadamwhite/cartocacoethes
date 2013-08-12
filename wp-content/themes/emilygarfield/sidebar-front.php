<?php
/**
 * The Front Page widget areas.
 *
 */
?>

<?php
    /* The front page widget area is triggered if either of the areas
     * have widgets. So let's check that first.
     *
     * If neither of the sidebars have widgets, then let's bail early.
     */
    if (   ! is_active_sidebar( 'sidebar-front-1' ) 
        && ! is_active_sidebar( 'sidebar-4' ) )
        return;
    // If we get this far, we have widgets. Let do this.
?>
<div id="front-page-widgets" <?php twentyeleven_footer_sidebar_class(); ?>>
    <?php if ( is_active_sidebar( 'sidebar-front-1' ) ) : ?>
    <div id="front-page-left" class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-front-1' ); ?>
    </div><!-- #front-page-left.widget-area -->
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'sidebar-front-2' ) ) : ?>
    <div id="front-page-right"  class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-front-2' ); ?>
    </div><!-- #front-page-right.widget-area -->
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'sidebar-front-3' ) ) : ?>
    <div id="front-page-bottom" class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-front-3' ); ?>
    </div>
    <?php endif; ?>
</div><!-- #supplementary -->