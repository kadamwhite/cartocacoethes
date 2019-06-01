/**
 * This file defines the externals, entry, and output Webpack config properties.
 */
const { resolve } = require( 'path' );
const { externals } = require( '@humanmade/webpack-helpers' );

const themePath = ( ...pathParts ) => resolve( __dirname, '..', ...pathParts );

module.exports = {
	externals,
	entry: {
		comments: themePath( 'src/css/comments.scss' ),
		'editor-styles': themePath( 'src/css/editor-styles.scss' ),
		'front-page': themePath( 'src/css/front-page.scss' ),
		sidebar: themePath( 'src/css/sidebar.scss' ),
		customizer: themePath( 'src/customizer.js' ),
		editor: [
			themePath( 'src/blocks.js' ),
		],
		theme: [
			themePath( 'src/css/theme.scss' ),
			themePath( 'src/theme/comments.js' ),
			themePath( 'src/theme/navigation.js' ),
			themePath( 'src/theme/skip-link-focus-fix.js' ),
		],
	},
	output: {
		path: themePath( 'build' ),
	},
};
