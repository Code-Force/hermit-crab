$(document).on('click', '.modok-trigger', function(e) {
	e.preventDefault();
	modokActivate($(this));
});

function modokActivate($this) {
	/* Default values */
	var acceptableCallTypes = ['GET','POST'];
	var callType = 'GET';
	
	/* Element data */
	var elementAJAXURL = $this.data('url');
	var elementFallbackURL = $this.attr('href');
	var elementCallType = $this.data('call-type');
	/* Validate the call type passed as data */
	if(elementCallType !== undefined && elementCallType.inArray(acceptableCallTypes) > 0) {
		callType = $this.data('call-type');
	}
	
	if(elementAJAXURL !== undefined) {
		$.ajax({
			type: callType,
			url: elementAJAXURL,
			success: function(data) {
				/* Create a unique id for the modal to prevent affecting multiple modals */
				var modalID = 'modok-' + (Math.floor((Math.random() * 1000) + 1));
				/* Create the modal element */
				var modal = '<div id="' + modalID + '" class="modok"><div class="modok__content">' + data + '</div></div>';
				$('body').append(modal);
				/* Activate modal */
				$('#' + modalID).addClass('modok--active');
			},
			error: function() {
				/* On failure, redirect to original link if it exists */
				if (elementFallbackURL !== undefined) {
					window.location.href = elementFallbackURL;
				}
			}
		})
	}
}