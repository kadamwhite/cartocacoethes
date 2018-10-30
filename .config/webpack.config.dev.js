/**
 * This file defines the configuration for development and dev-server builds.
 */
const { unlinkSync } = require( 'fs' );
const ManifestPlugin = require( 'webpack-manifest-plugin' );
const onExit = require( 'signal-exit' );

const { devServerPort, filePath } = require( './config-utils' );
const devConfig = require( './shared-config.dev' );

// Run the plugin dev server on a separate port to avoid conflicts with theme HMR.
const devServer = {
	theme: {
		port: devServerPort(),
		uri: serverPath => `http://localhost:${ devServer.theme.port }${ serverPath }`,
	},
	plugin: {
		port: devServerPort() + 1,
		uri: serverPath => `http://localhost:${ devServer.plugin.port }${ serverPath }`,
	},
}

// Clean up manifest on exit.
onExit( () => {
	[
		filePath( 'themes', 'ehg', 'build', 'asset-manifest.json' ),
		filePath( 'mu-plugins', 'ehg-blocks', 'build', 'asset-manifest.json' ),
	].forEach( path => {
		try {
			unlinkSync( path );
		} catch ( e ) {
			// Silently ignore unlinking errors: so long as the file is gone, that is good.
		}
	} );
} );

const buildTargets = [
	/**
	 * Theme development build configuration.
	 */
	devConfig( {
		name: 'ehg-theme',
		devServer: {
			port: devServer.theme.port,
		},
		entry: {
			'editor': filePath( 'themes/ehg/src/editor.js' ),
			'frontend': filePath( 'themes/ehg/src/theme.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: true,
			path: filePath( 'themes/ehg/build' ),
			publicPath: devServer.theme.uri( '/themes/ehg/build/' ),
			filename: '[name].bundle.js',
		},
		plugins: [
			// Generate a manifest file which contains a mapping of all asset filenames
			// to their corresponding output file so that PHP can pick up their paths.
			new ManifestPlugin( {
				publicPath: devServer.theme.uri( '/themes/ehg/build/' ),
				fileName: 'asset-manifest.json',
				writeToFileEmit: true,
			} ),
		],
	} ),

	/**
	 * Gutenberg block build configuration.
	 */
	devConfig( {
		name: 'ehg-blocks',
		devServer: {
			port: devServer.plugin.port,
		},
		entry: {
			editor: filePath( 'mu-plugins/ehg-blocks/src/editor.js' ),
			frontend: filePath( 'mu-plugins/ehg-blocks/src/frontend.js' ),
		},
		output: {
			// Add /* filename */ comments to generated require()s in the output.
			pathinfo: true,
			path: filePath( 'mu-plugins/ehg-blocks/build' ),
			publicPath: devServer.plugin.uri( '/mu-plugins/ehg-blocks/build/' ),
			filename: '[name].bundle.js',
		},
		plugins: [
			// Generate a manifest file which contains a mapping of all asset filenames
			// to their corresponding output file so that PHP can pick up their paths.
			new ManifestPlugin( {
				publicPath: devServer.plugin.uri( '/mu-plugins/ehg-blocks/build/' ),
				fileName: 'asset-manifest.json',
				writeToFileEmit: true,
			} ),
		],
	} ),
];

// Permit this same config file to be used by a full CLI build or a theme- or
// plugin-specific dev server instance: If run with `webpack --config=...` as
// normal, export all build targets together as a Webpack multi-config array.
// If a specific target is specified with `BUILD_TARGET=blocks` or
// `BUILD_TARGET=theme`, only export that specific build target configuration.
module.exports = buildTargets
	.filter( target => target.name.indexOf( process.env.BUILD_TARGET ) > -1 );
