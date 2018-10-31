/**
 * Given the results of a require.context() call, require all those files.
 *
 * @param {Object} r The results of running require.context().
 */
const importAll = r => r.keys().forEach( r );

// Load all block index files.
importAll( require.context( __dirname, true, /index\.js$/ ) );
