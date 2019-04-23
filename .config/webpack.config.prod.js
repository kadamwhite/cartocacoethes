/**
 * This file defines the configuration that is used for the production build.
 */
const { loaders, presets } = require( '@humanmade/webpack-helpers' );

loaders.js.defaults.options = {
	babelrc: false,
	...require( '../.babelrc.js' ),
};

const projects = require( './project-roots' );

// Build array of partial config objects.
module.exports = projects
	.map( projectRoot => require( `../${ projectRoot }/.config/webpack.config.prod` ) )
	.map( config => presets.production( config ) );
