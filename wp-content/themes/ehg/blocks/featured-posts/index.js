import { disposeBlock, registerBlock } from '../hmr-helpers';
import EditFeaturedPostsBlock from './edit';

const { withSelect } = wp.data;

export const name = 'my-plugin/latest-post';

export const options = {
	title: 'Latest Post',
	icon: 'megaphone',
	category: 'widgets',

	edit: withSelect( select => ( {
		posts: select( 'core' ).getEntityRecords( 'postType', 'post' ),
	} ) )( EditFeaturedPostsBlock ),

	save: function() {
		// Rendering in PHP
		return null;
	},
};

if ( module.hot ) {
	module.hot.accept();

	// When accepting hot updates we must unregister blocks before re-registering them.
	disposeBlock( name, module.hot );
}

registerBlock( name, options, module.hot );
