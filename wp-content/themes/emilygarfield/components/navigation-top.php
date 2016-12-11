<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php _e( 'Top Menu', 'emilygarfield' ); ?>">
  <button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
    <?php
    echo ehg_get_svg( array( 'icon' => 'bars' ) );
    echo ehg_get_svg( array( 'icon' => 'close' ) );
    _e( 'Menu', 'emilygarfield' );
    ?>
  </button>
  <?php wp_nav_menu( array(
    'theme_location' => 'primary',
    'menu_id'        => 'top-menu',
  ) ); ?>

  <?php if ( is_home() && is_front_page() ) : ?>
    <a href="#content" class="menu-scroll-down">
      <?php
      echo ehg_get_svg( array( 'icon' => 'next' ) );
      ?>
      <span class="screen-reader-text"><?php _e( 'Scroll Down', 'emilygarfield' ); ?></span>
    </a>
  <?php endif; ?>
</nav><!-- #site-navigation -->
