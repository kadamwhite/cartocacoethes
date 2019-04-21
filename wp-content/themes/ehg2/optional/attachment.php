<?php
/**
 * The template for displaying attachments and their metadata.
 *
 * Attachments are a special post type that holds information
 * about a file uploaded through the WordPress media upload system.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/attachment-template-files/
 *
 * @package wprig
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', 'attachment' );

		} // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_footer();
