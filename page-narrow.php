<?php
/**
 * Template Name: Long-Form Prose
 * Template Post Type: post, page
 *
 * This template defines a single page with a narrower content area than a
 * standard page. Good for longer-form prose.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use
 *
 * @package ehg
 */

get_header(); ?>

	<main id="primary" class="site-main narrow-content">

		<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		} // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_footer();
