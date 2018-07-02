<?php
/**
 * The Footer widget areas.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<?php
    /* The footer widget area is triggered if any of the areas
     * have widgets. So let's check that first.
     *
     * If none of the sidebars have widgets, then let's bail early.
     */
    if (   ! is_active_sidebar( 'homepage-footer-widgets-1'  )
        && ! is_active_sidebar( 'homepage-footer-widgets-2' )
        && ! is_active_sidebar( 'homepage-footer-widgets-3'  )
        && ! is_active_sidebar( 'homepage-footer-full-width'  )
    )
        return;
    // If we get this far, we have widgets. Let do this.

    $has_homepage_widget_columns = (
        is_active_sidebar( 'homepage-footer-widgets-1'  )
        && is_active_sidebar( 'homepage-footer-widgets-2' )
        && is_active_sidebar( 'homepage-footer-widgets-3'  )
    );
?>
<?php if ( $has_homepage_widget_columns ) : ?>
<div id="supplementary" <?php twentyeleven_footer_sidebar_class(); ?>>
<?php endif; ?>
    <?php if ( is_active_sidebar( 'homepage-footer-widgets-1' ) ) : ?>
    <div class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'homepage-footer-widgets-1' ); ?>
    </div><!-- #first .widget-area -->
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'homepage-footer-widgets-2' ) ) : ?>
    <div class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'homepage-footer-widgets-2' ); ?>
    </div><!-- #second .widget-area -->
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'homepage-footer-widgets-3' ) ) : ?>
    <div class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'homepage-footer-widgets-3' ); ?>
    </div><!-- #third .widget-area -->
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'homepage-footer-full-width' ) ) : ?>
    <div class="widget-area widget-area-full-width" role="complementary">
        <?php dynamic_sidebar( 'homepage-footer-full-width' ); ?>
    </div><!-- #third .widget-area -->
    <?php endif; ?>
<?php if ( $has_homepage_widget_columns ) : ?>
</div><!-- #supplementary -->
<?php endif;
