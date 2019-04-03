const { withSelect } = wp.data;

console.log( 'here' );

/**
 * Accept a posts list and className and render the editing interface.
 *
 * @param {Object} props React properties object.
 * @returns {Object} JSX component tree.
 */
const EditFeaturedPostsBlock = ( { posts, className } ) => {
	if ( ! posts ) {
	 return (
		 'Loading...'
	 );
	}
	if ( ! posts.lengh ) {
	 return (
		 'No Posts'
	 );
	}
	const post = posts[0];
	return (
	 <a className={ className } href={ post }>
		 { post.title.rendered }
	 </a>
	);
};

export const name = 'my-plugin/latest-post';

export const options = {
	title: 'Latest Post',
	icon: 'megaphone',
	category: 'widgets',

	// edit: withSelect( select => ( {
	// 	posts: select( 'core' ).getEntityRecords( 'postType', 'post' ),
	// } ) )( EditFeaturedPostsBlock ),
	edit() {
		return (
			<div><p>Placeholder woo!</p></div>
		);
	},

	save: function() {
		// Rendering in PHP
		return null;
	},
};
