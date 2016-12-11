<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
$subtitle_options = explode( '|', get_bloginfo( 'description', 'display' ) );
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png">

<?php /* JavaScript detection */ ?>
<script>
(function(html){
    html.className = html.className.replace(/\bno-js\b/,'js')}
)(document.documentElement);
</script>

<?php
    /* We add some JavaScript to pages with the comment form
     * to support sites with threaded comments (when in use).
     */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    /* Always have wp_head() just before the closing </head>
     * tag of your theme, or you will break many plugins, which
     * generally use this hook to add elements to <head> such
     * as styles, scripts, and meta tags.
     */
    wp_head();
?>
</head>

<body <?php body_class(); ?>>

<?php /* Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
<div class="skip-link">
    <a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>">
        <?php _e( 'Skip to primary content', 'twentyeleven' ); ?>
    </a>
</div>
<div class="skip-link">
    <a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>">
        <?php _e( 'Skip to secondary content', 'twentyeleven' ); ?>
    </a>
</div>

<?php if ( ehg_new_theme() && has_nav_menu( 'primary' ) ) : ?>
    <header id="masthead" class="navigation-top" role="banner">
        <div class="wrap">
            <?php get_template_part( 'components/navigation', 'top' ); ?>
        </div><!-- .wrap -->
    </header><!-- #masthead.navigation-top -->
<?php endif; ?>

<div id="page" class="hfeed">

    <header id="branding" role="banner">
        <div class="hgroup">
            <h1 id="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
                       rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
            </h1>
            <h2 id="site-description">
                <?php echo $subtitle_options[ mt_rand( 0, count( $subtitle_options ) - 1 ) ]; ?>
            </h2>
        </div>

        <?php if ( ! is_front_page() ) : ?>
        <?php
            // Check to see if the header image has been removed
            $header_image = get_header_image();
            if ( $header_image ) :
                // Compatibility with versions of WordPress prior to 3.4.
                if ( function_exists( 'get_custom_header' ) ) {
                    // We need to figure out what the minimum width should be for our featured image.
                    // This result would be the suggested width if the theme were to implement flexible widths.
                    $header_image_width = get_theme_support( 'custom-header', 'width' );
                } else {
                    $header_image_width = HEADER_IMAGE_WIDTH;
                }
                ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php
                // The header image
                // Check if this is a post or page, if it has a thumbnail, and if it's a big one
                if ( ! ( is_singular() && get_post_type() == 'ag_artwork_item' ) ) :
                    // Compatibility with versions of WordPress prior to 3.4.
                    if ( function_exists( 'get_custom_header' ) ) {
                        $header_image_width  = get_custom_header()->width;
                        $header_image_height = get_custom_header()->height;
                    } else {
                        $header_image_width  = HEADER_IMAGE_WIDTH;
                        $header_image_height = HEADER_IMAGE_HEIGHT;
                    }
                    ?>
                <img src="<?php header_image(); ?>" width="<?php echo $header_image_width; ?>" height="<?php echo $header_image_height; ?>" alt="" />
            <?php endif; // end check for featured image or standard header ?>
        </a>
        <?php endif; // end check for removed header image ?>
        <?php endif; // end check for front page (front page uses new design) ?>

        <?php
            // Has the text been hidden?
            if ( 'blank' == get_header_textcolor() ) :
        ?>
            <div class="only-search<?php if ( $header_image ) : ?> with-image<?php endif; ?>">
            <?php get_search_form(); ?>
            </div>
        <?php
            else :
        ?>
            <?php get_search_form(); ?>
        <?php endif; ?>

        <?php if ( ! ehg_new_theme() ) : ?>
            <nav id="access" role="navigation">
                <h3 class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></h3>
                <?php /* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */ ?>
                <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
            </nav><!-- #access -->
        <?php endif; ?>
    </header><!-- #branding -->


    <div id="main">
