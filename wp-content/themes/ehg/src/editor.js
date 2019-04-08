/**
 * Dynamically locate, load & register all Gutenberg blocks.
 *
 * Entry point for the "editor.js" bundle.
 */
// import autoload from 'require-context-hmr';
import { registerBlockType, unregisterBlockType } from '@wordpress/blocks';
import { select, dispatch } from '@wordpress/data';

/**
 * No-op function for use as a default argument value.
 */
const noop = () => {};

/**
 * Require a set of modules and configure them for hot module replacement.
 *
 * The first argument should be a function returning a `require.context()`
 * call. All modules loaded from this context are cached, and on each rebuild
 * the incoming updated modules are checked against the cache. Updated modules
 * which already exist in the cache are unregistered with the provided function,
 * then any incoming (new or updated) modules will be registered.
 *
 * @param {Function} getContext Execute and return a `require.context()` call.
 * @param {Function} register   Function to register accepted modules.
 * @param {Function} unregister Function to unregister replaced modules.
 * @param {Function} [before]   Function to run before updating moules.
 * @param {Function} [after]    Function to run after updating moules.
 */
const autoload = ( {
	getContext,
	register,
	unregister,
	before = noop,
	after = noop,
} ) => {
	const cache = {};
	const loadModules = () => {
		before();

		const context = getContext();
		const changed = [];
		context.keys().forEach( key => {
			const module = context( key );
			if ( module === cache[ key ] ) {
				// Module unchanged: no further action needed.
				return;
			}
			if ( cache[ key ] ) {
				// Module changed, and prior copy detected: unregister old module.
				unregister( cache[ key ] );
			}
			// Register new module and update cache.
			register( module );
			changed.push( module );
			cache[ key ] = module;
		} );

		after( changed );

		// Return the context for HMR initialization.
		return context;
	};

	const context = loadModules();

	if ( module.hot ) {
		module.hot.accept( context.id, loadModules );
	}
};

// Maintain the selected block ID across HMR updates.
let selectedBlockId = null;
// Load all block index files.
autoload( {
	/**
	 * Return a project-specific require.context.
	 */
	getContext: () => require.context( './blocks', true, /index\.js$/ ),

	/**
	 * Register a new or updated block.
	 */
	register: ( { name, options } ) => registerBlockType( name, options ),

	/**
	 * Unregister an updated or removed block.
	 */
	unregister: ( { name } ) => unregisterBlockType( name ),

	/**
	 * Store the selected block to persist selection across block-swaps.
	 */
	before: () => {
		selectedBlockId = select( 'core/editor' ).getSelectedBlockClientId();
		dispatch( 'core/editor' ).clearSelectedBlock();
	},

	/**
	 * Trigger a re-render on all blocks which have changed.
	 *
	 * @param {Object[]} changed Array of changed module objects.
	 */
	after: ( changed = [] ) => {
		const changedNames = changed.map( module => module.name );

		// Refresh all blocks by iteratively selecting each one that has changed.
		select( 'core/editor' ).getBlocks().forEach( ( { name, clientId } ) => {
			if ( changedNames.includes( name ) ) {
				dispatch( 'core/editor' ).selectBlock( clientId );
			}
		} );

		// Reselect whatever was selected in the beginning.
		if ( selectedBlockId ) {
			dispatch( 'core/editor' ).selectBlock( selectedBlockId );
		} else {
			dispatch( 'core/editor' ).clearSelectedBlock();
		}
		selectedBlockId = null;
	},
} );