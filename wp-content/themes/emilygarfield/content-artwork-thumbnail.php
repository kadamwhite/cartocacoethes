<?php
// Build the title attribute
if ( function_exists('ag_artwork_title_attribute') ) {
    $title = ag_artwork_title_attribute( get_the_ID() );
} else {
    $title = sprintf( __( '%s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) );
}
?>
<a class="artwork-thumbnail"
   href="<?php the_permalink(); ?>"
   title="<?php echo esc_attr( $title ); ?>"
   rel="bookmark">
    <?php the_post_thumbnail( 'thumbnail' ); ?>
    <div class="artwork-thumbnail-meta">
        <h2 class="entry-title"><?php the_title(); ?></h2>
    </div>
</a>
