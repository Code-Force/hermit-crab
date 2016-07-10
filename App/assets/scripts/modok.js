/*
* M.O.D.O.K.
* Modal Object Displaying the Offered Key
*/

/* start event binding */
$(document).on('click', '.modok-trigger', function(e) {
	e.preventDefault();
	modokActivate($(this));
});

$(document).on('click', '.modok-close', function(e) {
	modokClose($(this));
});
/* end event binding */

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
		callType = elementCallType;
	}
	
	if(elementAJAXURL !== undefined) {
		$.ajax({
			type: callType,
			url: elementAJAXURL,
			success: function(data) {
				modokCloseAll();
				
				/* Create a unique id for the modal to prevent affecting multiple modals */
				var modalID = 'modok-' + (Math.floor((Math.random() * 1000) + 1));
				/* Create the modal element */
				var modal = ''+
					'<div id="' + modalID + '" class="modok">' +
						'<div class="modok__overlay modok-close"></div>' +
						'<button class="modok__close-button modok-close"><i class="fa fa-times" aria-hidden="true"></i></button>' +
						'<div class="modok__content">' + data + '</div>' +
					'</div>';
				$('body').append(modal).addClass('modok--lock');
				/* Activate modal */
				setTimeout(function() {
					$('#' + modalID).addClass('modok--active');
				}, 0);
			},
			error: function() {
				/* On failure, redirect to original link if it exists */
				if (elementFallbackURL !== undefined) {
					window.location.href = elementFallbackURL;
				}
			}
		});
	}
}
function modokClose($this) {
	$this.parents('.modok').removeClass('modok--active');
	$('body').removeClass('modok--lock');
	setTimeout(function() {
		$this.parents('.modok').remove();
	}, 300);
}
function modokCloseAll() {
	$('body').removeClass('modok--lock');
	$('.modok').remove();
}