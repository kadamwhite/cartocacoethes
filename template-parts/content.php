<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ehg
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail( 'landscape_md' ); ?>
		</div>
		<?php
		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
					ehg_posted_on();
					ehg_posted_by();
					ehg_comments_link();
				?>
			</div><!-- .entry-meta -->
			<?php
		endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( ehg_is_archive() ) {
			the_excerpt();
		} else {
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ehg' ),
						[
							'span' => [
								'class' => [],
							],
						]
					),
					get_the_title()
				)
			);
		}

		wp_link_pages( [
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ehg' ),
			'after'  => '</div>',
		] );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		ehg_post_categories();
		ehg_post_tags();
		ehg_edit_post_link();
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php
if ( is_singular() ) :
	the_post_navigation( [
		'prev_text' => '<div class="post-navigation-sub"><span>' . esc_html__( 'Previous:', 'ehg' ) . '</span></div>%title',
		'next_text' => '<div class="post-navigation-sub"><span>' . esc_html__( 'Next:', 'ehg' ) . '</span></div>%title',
	] );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endif;
