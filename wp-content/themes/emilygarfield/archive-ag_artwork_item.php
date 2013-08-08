<?php
/**
 * The template for displaying Artwork Archive pages.
 *
 * Used to display archive-type pages for posts of type ag_artwork_item.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

<?php get_template_part( 'archive-artwork' ); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>