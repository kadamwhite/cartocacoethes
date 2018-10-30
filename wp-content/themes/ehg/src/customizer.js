/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
/* global jQuery: false */

( $ => {
	// Site title and description.
	wp.customize( 'blogname', value => {
		value.bind( to => {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', value => {
		value.bind( to => {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', value => {
		value.bind( to => {
			if ( to === 'blank' ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute',
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to,
				} );
			}
		} );
	} );
} )( jQuery );
