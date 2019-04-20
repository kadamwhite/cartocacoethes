/**
 * This file defines the configuration for development and dev-server builds.
 */
const { resolve } = require( 'path' );
const { externals, helpers, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, cleanOnExit, filePath } = helpers;

const themePath = ( ...pathParts ) => resolve( __dirname, '..', ...pathParts );

// Clean up manifests on exit.
cleanOnExit( [
	themePath( 'build/asset-manifest.json' ),
] );

const config = {
	externals: {
		...externals,
		jquery: 'jQuery',
	},
	entry: {
		comments: themePath( 'src/css/comments.scss' ),
		content: themePath( 'src/css/content.scss' ),
		'editor-styles': themePath( 'src/css/editor-styles.scss' ),
		'front-page': themePath( 'src/css/front-page.scss' ),
		sidebar: themePath( 'src/css/sidebar.scss' ),
		style: [
			themePath( 'src/css/style.scss' ),
			themePath( 'src/css/content.scss' ),
		],
		widgets: themePath( 'src/css/widgets.scss' ),
		customizer: themePath( 'src/customizer.js' ),
		theme: [
			themePath( 'src/theme/navigation.js' ),
			themePath( 'src/theme/skip-link-focus-fix.js' ),
		],
	},
	output: {
		path: themePath( 'build' ),
	},
};

// If this is the top-level Webpack file loaded by the Webpack DevServer,
// automatically detect & bind to an open port.
if (
	process.argv[1].indexOf( 'webpack-dev-server' ) !== -1
	&& themePath( '.config' ) === __dirname
) {
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
} else {
	module.exports = presets.development( config );
}
