/**
 * This file defines the configuration that is used for the production build.
 */
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const UglifyJsPlugin = require( 'uglifyjs-webpack-plugin' );

const { filePath, loaders } = require( './config-utils' );

/**
 * Merge in the default prod server configuration options.
 *
 * Note: This abstraction is predicated on having half of the code live in
 * an mu-plugin, rather than in a monolothic theme. That's OK. We'll just
 * leave things as they are rather than anger the Jenga gods.
 *
 * @param {Object} config A basic Webpack configuration object.
 * @returns {Object} A complete Webpack configuration object.
 */
const prodConfig = config => ( {
	mode: 'production',
	devtool: 'hidden-source-map',
	context: process.cwd(),
	module: {
		strictExportPresence: true,
		rules: [
			// First, run the linter before Babel processes the JS.
			loaders.eslint,
			{
				// "oneOf" will traverse all following loaders until one will
				// match the requirements. If no loader matches, it will fall
				// back to the "file" loader at the end of the loader list.
				oneOf: [
					// Inline any assets below a specified limit as data URLs to avoid requests.
					loaders.url,
					// Process JS with Babel.
					loaders.js,
					{
						test: /\.scss$/,
						use: [
							// Instead of using style-loader, extract CSS to its own file.
							MiniCssExtractPlugin.loader,
							// Process SASS into CSS.
							loaders.css,
							loaders.postcss,
							loaders.sass,
						],
					},
					// "file" loader makes sure any non-matching assets still get served.
					// When you `import` an asset you get its filename.
					loaders.file,
				],
			},
		],
	},

	// Clean up build output
	stats: {
		all: false,
		assets: true,
		colors: true,
		errors: true,
		performance: true,
		timings: true,
		warnings: true,
	},

	// Optimize output bundle.
	optimization: {
		minimizer: [ new UglifyJsPlugin( {
			sourceMap: true,
			uglifyOptions: {
				output: {
					comments: false,
				},
			},
		} ) ],
		noEmitOnErrors: true,
		nodeEnv: 'production',
	},

	// If any of the above properties conflict, the version from the passed-in config will be used.
	...config,

	// Allow config to add plugins.
	plugins: [
		new MiniCssExtractPlugin( {
			filename: '[name].css',
		} ),
		...( config.plugins || [] ),
	],
} );

/**
 * Theme production build configuration.
 */
module.exports = prodConfig( {
	entry: {
		customizer: filePath( 'wp-content/themes/ehg/src/customizer.js' ),
		theme: filePath( 'wp-content/themes/ehg/src/index.js' ),
		editor: filePath( 'wp-content/themes/ehg/blocks/index.js' ),
	},
	output: {
		// Add /* filename */ comments to generated require()s in the output.
		pathinfo: false,
		path: filePath( 'wp-content/themes/ehg/build' ),
		filename: '[name].js',
	},
} );
