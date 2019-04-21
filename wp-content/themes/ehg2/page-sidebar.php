<?php
/**
 * Template Name: Page with Sidebar
 * Template Post Type: post, page
 *
 * This template defines a single page with a sidebar.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use
 *
 * @package ehg2
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		} // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
