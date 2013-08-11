<?php
/*
  This component is still experimental and it's still loading MP6's default colors,
  to be overwritten by the color scheme styles. The behavior of this component
  might change in the future!
*/

// register additonal MP6 color schemes
add_action( is_admin() ? 'admin_init' : 'wp', 'mp6_colors_register_schemes' );
function mp6_colors_register_schemes() {

	wp_admin_css_color(
		'blue',
		_x( 'Blue', 'admin color scheme' ),
		plugins_url( 'schemes/blue/colors-blue.css', __FILE__ ),
		array( '#0074a2', '#1e8cbe', '#36a3ca', '#f6f6f6' )
	);

}

// load default `colors-mp6.css` as well
add_action( 'admin_init', 'mp6_colors_load_mp6_default_css', 20 );
function mp6_colors_load_mp6_default_css() {

	global $wp_styles, $_wp_admin_css_colors;

	$color_scheme = get_user_option( 'admin_color' );
	if ( $color_scheme == 'mp6' )
		return;

	// add `colors-mp6.css` and make it a dependency of the current color scheme
	$wp_styles->add( 'colors-mp6', $_wp_admin_css_colors[ 'mp6' ]->url, false, filemtime( realpath( dirname( __DIR__ ) . '/../css/' .basename( $_wp_admin_css_colors[ 'mp6' ]->url ) ) ) );
	$wp_styles->registered[ 'colors' ]->deps[] = 'colors-mp6';

	// set modification time based on current colors file
	$wp_styles->registered[ 'colors' ]->ver = filemtime( mp6_colors_get_scheme_path( $color_scheme, basename( $_wp_admin_css_colors[ $color_scheme ]->url ) ) );

}

// enqueue additional admin-bar styles
add_action( 'wp_enqueue_scripts', 'mp6_colors_enqueue_adminbar_css' );
add_action( 'admin_enqueue_scripts', 'mp6_colors_enqueue_adminbar_css' );
function mp6_colors_enqueue_adminbar_css() {

	global $_wp_admin_css_colors;

	$color_scheme = get_user_option( 'admin_color' );
	if ( $color_scheme == 'mp6' )
		return;

	if ( file_exists( mp6_colors_get_scheme_path( $color_scheme, '/admin-bar.css' ) ) ) {
		$modtime = filemtime( mp6_colors_get_scheme_path( $color_scheme, '/admin-bar.css' ) );
		wp_register_style( 'admin-bar-' . $color_scheme, str_replace( basename( $_wp_admin_css_colors[ $color_scheme ]->url ), '', $_wp_admin_css_colors[ $color_scheme ]->url ) . '/admin-bar.css', false, $modtime );
		wp_enqueue_style( 'admin-bar-' . $color_scheme );
	}

}

// turn `scheme.json` into `mp6_color_scheme` javascript variable
add_action( 'admin_head', 'mp6_colors_set_script_colors' );
function mp6_colors_set_script_colors() {

	$color_scheme = get_user_option( 'admin_color' );
	if ( $color_scheme == 'mp6' )
		return;

	if ( file_exists( mp6_colors_get_scheme_path( $color_scheme, '/scheme.json' ) ) ) {
		if ( $json = json_decode( file_get_contents( mp6_colors_get_scheme_path( $color_scheme, '/scheme.json' ) ) ) ) {
			echo '<script type="text/javascript">var mp6_color_scheme = ' . json_encode( $json ) . ';</script>';
		}
	}

}

function mp6_colors_get_scheme_path( $color_scheme, $path = null ) {

	global $_wp_admin_css_colors;

	if ( isset( $_wp_admin_css_colors[ $color_scheme ]->path ) ) {
		return trailingslashit( $_wp_admin_css_colors[ $color_scheme ]->path ) . $path;
	}

	return plugin_dir_path( __FILE__ ) . 'schemes/' . $color_scheme . '/' . $path;

}
