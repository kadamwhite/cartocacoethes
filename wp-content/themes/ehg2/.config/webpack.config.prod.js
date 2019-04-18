/**
 * This file defines the configuration that is used for the production build.
 */
const { resolve } = require( 'path' );
const { externals, presets } = require( '@humanmade/webpack-helpers' );
const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );

const themePath = ( ...pathParts ) => resolve( __dirname, '..', ...pathParts );

/**
 * Theme production build configuration.
 */
module.exports = presets.production( {
	externals: {
		...externals,
		jquery: 'jQuery',
	},
	entry: {
		comments: themePath( 'src/css/comments.scss' ),
		content: themePath( 'src/css/content.scss' ),
		'editor-styles': themePath( 'src/css/editor-styles.scss' ),
		'front-page': themePath( 'src/css/front-page.scss' ),
		sidebar: themePath( 'src/css/sidebar.scss' ),
		style: themePath( 'src/css/style.scss' ),
		widgets: themePath( 'src/css/widgets.scss' ),
		customizer: themePath( 'src/js/customizer.js' ),
		navigation: themePath( 'src/js/navigation.js' ),
		'skip-link-focus-fix': themePath( 'src/js/skip-link-focus-fix.js' ),
	},
	output: {
		path: themePath( 'build' ),
	},
	plugins: [
		new FixStyleOnlyEntriesPlugin(),
	],
} );
