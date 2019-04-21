<?php
/**
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wprig
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		} // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_footer();
