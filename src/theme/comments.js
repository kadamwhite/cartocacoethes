const commentToggle = document.querySelector( '[data-comments-toggle]' );
if ( commentToggle ) {
	commentToggle.addEventListener( 'click', () => {
		const comments = document.getElementById( 'comments' );
		if ( comments ) {
			comments.classList.toggle( 'screen-reader-text' );
		}
	} );
}
