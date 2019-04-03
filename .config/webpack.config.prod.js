/**
 * This file defines the configuration that is used for the production build.
 */
const { externals, helpers, presets } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

/**
 * Theme production build configuration.
 */
module.exports = presets.production( {
	externals: {
		...externals,
		jquery: 'jQuery',
	},
	entry: {
		customizer: filePath( 'wp-content/themes/ehg/src/customizer.js' ),
		theme: filePath( 'wp-content/themes/ehg/src/index.js' ),
		editor: filePath( 'wp-content/themes/ehg/src/editor.js' ),
	},
	output: {
		path: filePath( 'wp-content/themes/ehg/build' ),
	},
} );
