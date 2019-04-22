<?php
/**
 * WP Rig Theme Customizer
 *
 * @package ehg
 */
namespace EHG\Customizer;

function setup() {
	add_action( 'customize_register', __NAMESPACE__ . '\\customize_register' );
	add_action( 'customize_preview_init', __NAMESPACE__ . '\\enqueue_customize_preview_js' );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			[
				'selector'        => '.site-title a',
				'render_callback' => __NAMESPACE__ . '\\customize_partial_blogname',
			]
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			[
				'selector'        => '.site-description',
				'render_callback' => __NAMESPACE__ . '\\customize_partial_blogdescription',
			]
		);
	}

	/**
	 * Theme options.
	 */
	$wp_customize->add_section(
		'theme_options', [
			'title'    => __( 'Theme Options', 'ehg' ),
			'priority' => 130, // Before Additional CSS.
		]
	);

	if ( function_exists( 'ehg_lazyload_images' ) ) {
		$wp_customize->add_setting( 'lazy_load_media', [
			'default'           => 'lazyload',
			'sanitize_callback' => __NAMESPACE__ . '\\sanitize_lazy_load_media',
			'transport'         => 'postMessage',
		] );

		$wp_customize->add_control( 'lazy_load_media', [
			'label'           => __( 'Lazy-load images', 'ehg' ),
			'section'         => 'theme_options',
			'type'            => 'radio',
			'description'     => __( 'Lazy-loading images means images are loaded only when they are in view. Improves performance, but can result in content jumping around on slower connections.', 'ehg' ),
			'choices'         => [
				'lazyload'    => __( 'Lazy-load on (default)', 'ehg' ),
				'no-lazyload' => __( 'Lazy-load off', 'ehg' ),
			],
		] );
	}
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function enqueue_customize_preview_js() {
	wp_enqueue_script(
		'ehg-customizer',
		get_theme_file_uri( '/build/customizer.js' ),
		[ 'customize-preview' ],
		'20151215',
		true
	);
}

/**
 * Sanitize the lazy-load media options.
 *
 * @param string $input Lazy-load setting.
 */
function sanitize_lazy_load_media( $input ) {
	$valid = [
		'lazyload'    => __( 'Lazy-load images', 'ehg' ),
		'no-lazyload' => __( 'Load images immediately', 'ehg' ),
	];

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
}
