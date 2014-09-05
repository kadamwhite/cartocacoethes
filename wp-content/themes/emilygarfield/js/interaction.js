(function( $ ) {
	var $copyright = $('.copyright-more-info');
	$('#copyright-more-info-toggle').on('click', function( e ) {
		e.preventDefault();
		$copyright.slideToggle();
	});

	var $commentsForm = $('#comments');
	$('#comment-toggle').on('click', function( e ) {
		e.preventDefault();
		$commentsForm.slideToggle();
		$(this).find('span').toggle();
	});
})( jQuery );
