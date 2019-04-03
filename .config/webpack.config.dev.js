/**
 * This file defines the configuration for development and dev-server builds.
 */
const { join } = require( 'path' );
const { externals, helpers, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, cleanOnExit } = helpers;

/**
 * Return the absolute file system path to a file within the content/ folder.
 * @param  {...String} relPaths Strings describing a file relative to the content/ folder.
 * @returns {String} An absolute file system path.
 */
const filePath = ( ...relPaths ) => join( process.cwd(), ...relPaths );

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
		path: filePath( 'wp-content/themes/ehg' ),
		publicPath: `http://localhost:${ port }/wp-content/themes/ehg`,
	},
} ) );
