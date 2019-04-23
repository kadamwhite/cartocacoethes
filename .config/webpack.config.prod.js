/**
 * This file defines the configuration that is used for the production build.
 */
const { resolve } = require( 'path' );
const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );
const { helpers, externals, presets } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

const themePath = ( ...pathParts ) => resolve( __dirname, '..', ...pathParts );

/**
 * Theme production build configuration.
 */
const config = {
	externals: {
		...externals,
		jquery: 'jQuery',
	},
	entry: {
		comments: themePath( 'src/css/comments.scss' ),
		'editor-styles': themePath( 'src/css/editor-styles.scss' ),
		'front-page': themePath( 'src/css/front-page.scss' ),
		sidebar: themePath( 'src/css/sidebar.scss' ),
		customizer: themePath( 'src/customizer.js' ),
		editor: [
			themePath( 'src/blocks.js' ),
		],
		theme: [
			themePath( 'src/css/theme.scss' ),
			themePath( 'src/theme/navigation.js' ),
			themePath( 'src/theme/skip-link-focus-fix.js' ),
		],
	},
	output: {
		path: themePath( 'build' ),
	},
	plugins: [
		new FixStyleOnlyEntriesPlugin(),
	],
};

if ( filePath( '.config' ) === __dirname ) {
	// Prod-mode static file build is being run from within this project.
	module.exports = presets.production( config );
} else {
	// This configuration is being injested by a parent project's build process.
	module.exports = config;
}
