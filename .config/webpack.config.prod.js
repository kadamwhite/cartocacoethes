/**
 * This file defines the configuration that is used for the production build.
 */
const { helpers, plugins, presets } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

const sharedConfig = require( './webpack.config.shared' );

/**
 * Theme production build configuration.
 */
const config = {
	...sharedConfig,
	plugins: [
		plugins.fixStyleOnlyEntries(),
	],
};

if ( filePath( '.config' ) === __dirname ) {
	// Prod-mode static file build is being run from within this project.
	module.exports = presets.production( config );
} else {
	// This configuration is being injested by a parent project's build process.
	module.exports = config;
}
