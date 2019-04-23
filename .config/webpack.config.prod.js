/**
 * This file defines the configuration that is used for the production build.
 */
const { helpers, loaders, presets } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

// Adjust Babel config file resolution logic.
loaders.js.defaults.options = {
	...loaders.js.defaults.options,
	babelrcRoots: [
		// Use the top-level project folder as the root.
		process.cwd(),
	],
	babelrc: false,
	// configFile: filePath( '.babelrc.js' )
};

const projects = [
	'wp-content/plugins/artgallery',
	'wp-content/plugins/featured-item-blocks',
	'wp-content/themes/cartocacoethes',
];

// Build array of partial config objects.
module.exports = projects
	.map( relPath => require( `../${ relPath }/.config/webpack.config.prod` ) )
	.map( config => presets.production( {
		resolve: {
			modules: [ filePath( 'node_modules' ) ],
		},
		...config,
	} ) );
