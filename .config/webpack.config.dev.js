/**
 * This file defines the configuration for development and dev-server builds.
 */
const { externals, helpers, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, cleanOnExit, filePath } = helpers;

// Clean up manifests on exit.
cleanOnExit( [
	filePath( 'wp-content/themes/ehg/asset-manifest.json' ),
] );

module.exports = choosePort( 9090 ).then( port => presets.development( {
	devServer: {
		port,
	},
	externals: {
		...externals,
		jquery: 'jQuery',
	},
	entry: {
		customizer: filePath( 'wp-content/themes/ehg/src/customizer.js' ),
		theme: filePath( 'wp-content/themes/ehg/src/index.js' ),
		editor: filePath( 'wp-content/themes/ehg/blocks/index.js' ),
	},
	output: {
		path: filePath( 'wp-content/themes/ehg/build' ),
		publicPath: `http://localhost:${ port }/wp-content/themes/ehg/build/`,
	},
} ) );
