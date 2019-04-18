/**
 * This file defines the configuration for development and dev-server builds.
 */
const { resolve } = require( 'path' );
const { externals, helpers, loaders, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, cleanOnExit, filePath } = helpers;

// Customize plugins for this Webpack build alone.
const defaultPostCSSPlugins = [ ...loaders.postcss.defaults.options.plugins ];
loaders.postcss.defaults.options.plugins.push( postcssPresetEnv( {
	stage: 3,
	browsers: require( '../package.json' ).browserslist,
	features: {
		'custom-properties': {
			preserve: false,
			variables: require( '../dev/config/cssVariables.json' ).variables,
		},
		'custom-media-queries': {
			preserve: false,
			variables: require( '../dev/config/cssVariables.json' ).queries,
		}
	}
} ) );

const themePath = ( ...pathParts ) => resolve( __dirname, '..', ...pathParts );

// Clean up manifests on exit.
cleanOnExit( [
	themePath( 'build/asset-manifest.json' ),
] );

module.exports = presets.development( {
	externals: {
		...externals,
		jquery: 'jQuery',
	},
	entry: {
		customizer: themePath( 'src/customizer.js' ),
		theme: themePath( 'src/navigation.js' ),
		editor: themePath( 'src/skip-link-focus-fix.js' ),
	},
	output: {
		path: themePath( 'build' ),
	},
} );

// Restore status quo.
loaders.postcss.defaults.options.plugins = defaultPostCSSPlugins;

// If this is the top-level Webpack file loaded by the Webpack DevServer,
// automatically detect & bind to an open port.
const devServerRunning = process.argv[1].indexOf( 'webpack-dev-server' ) !== -1;

if ( devServerRunning && filePath( '.config' ) === __dirname ) {
	const cwdRelativePublicPath = ( path, port ) => `http://localhost:${ port }${ path.replace( process.cwd(), '' ) }`;
	const devConfig = module.exports;

	module.exports = choosePort( 9090 ).then( port => ( {
		...devConfig,
		devServer: {
			...devConfig.devServer,
			port,
		},
		output: {
			...devConfig.output,
			publicPath: cwdRelativePublicPath( devConfig.output.path, port ),
		},
	} ) );
}
