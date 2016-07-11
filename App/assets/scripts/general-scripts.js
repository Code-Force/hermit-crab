head(function() {
	var documentReady = function() {
		$('body').smoothWheel();
	}
	
	window.addEventListener('load', documentReady);
	document.addEventListener('turbolinks:load', documentReady);
})