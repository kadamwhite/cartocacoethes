/**
 * Accept a posts list and className and render the editing interface.
 */
export default ( { posts, className } ) => {
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
