head(function() {
	var documentReady = function() {
		var scroll = new IScroll('body');
	}
	$(document).ready(documentReady);
	$(document).on('turbolinks:load', documentReady);
})