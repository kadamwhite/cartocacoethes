/**
 * This file defines the configuration for development and dev-server builds.
 */
const { resolve } = require( 'path' );
const { helpers, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, cleanOnExit, filePath } = helpers;

const config = require( './webpack.config.shared' );

const themePath = ( ...pathParts ) => resolve( __dirname, '..', ...pathParts );

// Clean up manifests on exit.
cleanOnExit( [
	themePath( 'build/asset-manifest.json' ),
] );

if (
	process.argv[1].indexOf( 'webpack-dev-server' ) !== -1
	&& filePath( '.config' ) === __dirname
) {
	// Webpack DevServer is being run from within this project: automatically
	// detect & bind to an open port.
	const cwdRelativePublicPath = ( path, port ) => `http://localhost:${ port }${ path.replace( process.cwd(), '' ) }/`;
	module.exports = choosePort( 9090 ).then( port => presets.development( {
		...config,
		devServer: {
			port,
		},
		output: {
			...config.output,
			publicPath: cwdRelativePublicPath( config.output.path, port ),
		},
	} ) );
} else if ( filePath( '.config' ) === __dirname ) {
	// Dev-mode static file build is being run from within this project.
	module.exports = presets.development( config );
} else {
	// This configuration is being injested by a parent project's build process.
	module.exports = config;
}
