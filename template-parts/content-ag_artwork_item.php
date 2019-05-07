<?php
/**
 * Template part for displaying ArtGallery Artwork items.
 *
 * @link https://github.com/kadamwhite/artgallery
 */
/* phpcs:disable WordPress.Files.FileName */// Underscores necessary to match the post type.

use ArtGallery\Markup;

if ( is_archive() ) {
	// Use the ArtGallery thumbnail markup for archive pages.
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php echo Markup\artwork_thumbnail( $post, 'artwork-archive' ); ?>
	</article>
	<?php
} else {
	// Use the default content template for single posts.
	get_template_part( 'template-parts/content' );
}
