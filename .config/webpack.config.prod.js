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
			'customizer': filePath( 'wp-content/themes/ehg/src/customizer.js' ),
			'theme': filePath( 'wp-content/themes/ehg/src/theme.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: true,
			path: filePath( 'wp-content/themes/ehg/build' ),
			filename: '[name].js',
		},
	} ),

	// /**
	//  * Gutenberg block production build configuration.
	//  */
	// prodConfig( {
	// 	entry: {
	// 		editor: filePath( 'mu-plugins/ehg-blocks/src/editor.js' ),
	// 		frontend: filePath( 'mu-plugins/ehg-blocks/src/frontend.js' ),
	// 	},
	// 	output: {
	// 		// Add /* filename */ comments to generated require()s in the output.
	// 		pathinfo: true,
	// 		path: filePath( 'mu-plugins/ehg-blocks/build' ),
	// 		filename: '[name].bundle.js',
	// 	},
	// } ),
];
