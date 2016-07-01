$(document).on('click', '.modok', function(e) {
	e.preventDefault();
	/* Default values */
	var acceptableCallTypes = ['GET','POST'];
	var callType = 'GET';
	
	/* Element data */
	var elementAJAXURL = $(this).data('url');
	var elementFallbackURL = $(this).attr('href');
	var elementCallType = $(this).data('call-type');
	/* Validate the call type passed as data */
	if(elementCallType !== undefined && elementCallType.inArray(acceptableCallTypes) > 0) {
		callType = $(this).data('call-type');
	}
	
	if(modalContent !== undefined) {
		$.ajax({
			type: callType,
			url: elementAJAXURL,
			success: function(data) {
				var modal = '<div class="modal"><div class="modal__content>' + data + '</div></div>';
				$(body).append(modal);
			},
			error: function() {
				if (elementFallbackURL !== undefined) {
					window.location.href = elementFallbackURL;
				}
			}
		})
	}
})