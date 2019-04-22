/**
 * This file defines the configuration for development and dev-server builds.
 */
const { helpers, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, cleanOnExit, filePath } = helpers;

const projects = [
	'wp-content/plugins/artgallery',
	// 'wp-content/plugins/featured-item-blocks',
	'wp-content/themes/ehg2',
];

// Clean up manifests on exit.
cleanOnExit( projects.map( relPath => filePath( `${ relPath }/build/asset-manifest.json` ) ) );

// Build array of partial config objects.
const configs = projects.map( relPath => require( `../${ relPath }/.config/webpack.config.dev` ) );

if ( process.argv[1].indexOf( 'webpack-dev-server' ) !== -1 ) {
	// Webpack DevServer is loading this configuration: automatically detect & bind to an open port.
	const cwdRelativePublicPath = ( path, port ) => `http://localhost:${ port }${ path.replace( process.cwd(), '' ) }/`;

	module.exports = choosePort( 9090 ).then( port => {
		return configs.map( config => presets.development( {
			...config,
			devServer: {
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
