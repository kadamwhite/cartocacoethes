<?php
/**
 * Template Name: Page with Sidebar
 * Template Post Type: post, page
 *
 * This template defines a single page with a sidebar.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use
 *
 * @package wprig
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) {
			the_post();

			/*
			 * Include the component stylesheet for the content.
			 * This call runs only once on index and archive pages.
			 * At some point, override functionality should be built in similar to the template part below.
			 */
			wp_print_styles( [ 'ehg2-content' ] ); // Note: If this was already done it will be skipped.

			get_template_part( 'template-parts/content', get_post_type() );

		} // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
