head.ready(function() {
	$('#home-grid').masonry();

	$(document).on('click', '.home-story__quick-action--description', function() {
		$(this).closest('.home-story').toggleClass('excerpt');
	});
});
