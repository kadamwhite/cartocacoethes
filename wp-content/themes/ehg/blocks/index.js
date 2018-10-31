/**
 * Dynamically locate, load & register all Gutenberg blocks.
 *
 * Entry point for the "editor.js" bundle.
 */
import { disposeBlock, registerBlock } from './lib/hmr-helpers';

/**
 * Given the results of a require.context() call, require all those files.
 *
 * @param {Object} r The results of running require.context().
 */
const importAll = requireContext => requireContext.keys().forEach( module => {
	const { name, options } = requireContext();

	if ( module.hot ) {
		module.hot.accept();

		// When accepting hot updates we must unregister blocks before re-registering them.
		disposeBlock( name, module.hot );
	}

	registerBlock( name, options, module.hot );
} );

// Load all block index files.
importAll( require.context( __dirname, true, /index\.js$/ ) );
