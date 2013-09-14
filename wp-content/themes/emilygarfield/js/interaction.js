(function( $ ) {
	var $copyright = $('.copyright-more-info');
	$('#copyright-more-info-toggle').on('click', function( e ) {
		e.preventDefault();
		$copyright.slideToggle();
	});
})( jQuery );