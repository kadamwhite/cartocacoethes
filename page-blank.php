<?php
/**
 * Template Name: Blank page
 * Template Post Type: post, page
 *
 * This template defines a completely blank document with nothing but the page content.
 *
 * @package ehg
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php if ( ! ehg_is_amp() ) : ?>
		<script>document.documentElement.classList.remove("no-js");</script>
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php the_content(); ?>

<?php wp_footer(); ?>

</body>
</html>
