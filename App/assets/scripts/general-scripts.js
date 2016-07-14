head(function() {
	var documentReady = function() {
		$('body').smoothWheel();
	}
	
	window.addEventListener('load', documentReady);
	document.addEventListener('turbolinks:load', documentReady);
	
	function stripHTML(oldString) {
		var content = $(oldString).text();
		return content;
	}
	
	/* Global Exports */
	window.stripHTML = stripHTML;
})