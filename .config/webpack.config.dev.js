/**
 * This file defines the configuration for development and dev-server builds.
 */
const { helpers, loaders, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, cleanOnExit, filePath } = helpers;

// Remove automatic .babelrc.js ingestion in favor of manually setting the
// top-level options (which match those used in the child projects).
loaders.js.defaults.options = {
	babelrc: false,
	...require( '../.babelrc.js' ),
};

const projects = require( './project-roots' );

// Clean up manifests on exit.
cleanOnExit( projects.map( projectRoot => filePath( projectRoot, 'build/asset-manifest.json' ) ) );

// Build array of partial config objects.
const configs = projects.map( projectRoot => require( `../${ projectRoot }/.config/webpack.config.dev` ) );

if ( process.argv[1].indexOf( 'webpack-dev-server' ) !== -1 ) {
	// Webpack DevServer is loading this configuration: automatically detect & bind to an open port.
	const cwdRelativePublicPath = ( path, port ) => `http://localhost:${ port }${ path.replace( process.cwd(), '' ) }/`;

	module.exports = choosePort( 9090 ).then( port => {
		return configs.map( config => presets.development( {
			...config,
			devServer: {
				publicPath: '/',
				port,
			},
			output: {
				...config.output,
				publicPath: cwdRelativePublicPath( config.output.path, port ),
			},
		} ) );
	} );
} else {
	// A dev-mode static file build is in progress.
	module.exports = configs.map( config => presets.development( config ) );
}
