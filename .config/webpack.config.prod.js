/**
 * This file defines the base configuration that is used for the production build.
 */
const { filePath } = require( './config-utils' );
const prodConfig = require( './webpack-shared.prod' );

module.exports = [
	/**
	 * Theme production build configuration.
	 */
	prodConfig( {
		entry: {
			customizer: filePath( 'themes/ehg/src/customizer.js' ),
			theme: filePath( 'themes/ehg/src/index.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: false,
			path: filePath( 'themes/ehg/build' ),
			filename: '[name].js',
		},
	} ),

	/**
	 * Gutenberg block production build configuration.
	 */
	prodConfig( {
		entry: {
			editor: filePath( 'themes/ehg/blocks/index.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: false,
			path: filePath( 'themes/ehg/build' ),
			filename: '[name].js',
		},
	} ),
];
