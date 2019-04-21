<?php
/**
 * The template for displaying category archives.
 *
 * When active, applies to all category archives.
 * To target a specific category, rename file to category-{slug/id}.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#category
 *
 * @package ehg2
 */

get_header(); ?>

	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) {

		/* Display the appropriate header when required. */
		ehg2_index_header();

		/* Start the Loop */
		while ( have_posts() ) {
			the_post();

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_type() );

		}

		the_posts_navigation();

	} else {
		get_template_part( 'template-parts/content', 'none' );
	}
	?>

	</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
