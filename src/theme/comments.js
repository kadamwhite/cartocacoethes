document.querySelector( '[data-comments-toggle]' ).addEventListener( 'click', () => {
	const comments = document.getElementById( 'comments' );
	if ( comments ) {
		comments.classList.toggle( 'screen-reader-text' );
	}
} );
