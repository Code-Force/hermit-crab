
var documentReady = function() {
	// Initialize the map
	initializeQuickNav();
};

window.addEventListener('load', documentReady);
document.addEventListener('turbolinks:load', documentReady);

function initializeQuickNav () {

	window.is_fetching = false;

	$('body').on('click', '#nav-toggle', function () {
		$('#quick-nav').toggleClass('open');
	});

	$('body').on('change', '.filter-category', function() {
		if(!window.is_fetching) {
			$('#quick-nav input').prop('disabled', true);
			window.is_fetching = true;
			updateStories();
		} else {

		}
	});

	$('body').on('click', '.clear-filters', function(e) {
		e.preventDefault();

		var clearIdentifier = $(this).data('clear-identifier');
		var clearType = $(this).data('clear-type');

		if (clearType == 'checkbox') {
			$('.filter-'+clearIdentifier).each(function () {
				$(this).prop('checked', false); // Unchecks it
			});
			updateStories();
		}
	});
}

// Get all of the category values that are selected
function getCategoryFilters () {

	var allVals = [];
	$('.filters__mood-container :checked').each(function() {
		allVals.push($(this).val());
	});

	return allVals;

}

function fadeNewsFeed($content) {
	var contentContainer = $('#home-grid');
	var loadingResults = false;
	if ($content === undefined) {
		$content = '<div class="loader" data-loader="ball-pulse"></div>';
	} else {
		loadingResults = true;
	}
	contentContainer.fadeOut('fast', function() {
		contentContainer.html($content);
		contentContainer.fadeIn('fast');
		if (loadingResults) {
			$('#quick-nav input').prop('disabled', false);
			window.is_fetching = false;
		}
	});

}

function updateStories(append) {

	fadeNewsFeed();

	var categoryFilters = getCategoryFilters();

	var categories = '';

	if (categoryFilters.length) {
		$.each(categoryFilters, function (key, value) {
			categories = categories + value + ':';
		});
		categories = 'categories=' + categories.substr(0, (categories.length - 1)) + '&';
	}

	// If append is set to true (like from scrolling down the page), we need to get the last
	// story and return its date to the search
	if (append == true) {
		var date = 'last_date=' + $('.home__element').last().data('date') + '&';
	} else {
		var date = '';
	}
	console.log($('.home__element:last-child').data('date'));
	var data = encodeURI(categories) + encodeURI(date);

	// TO UPDATE : We need to make this super dynamic with the filter functions
	// We will get the list stories to display on the home map
	$.ajax({
		type: "GET",
		url: "stories/ajax/stories_list",
		data: data.substr(0, (data.length - 1)),
		dataType: "json",
		success: function(stories){
			// TO UPDATE : We need to add lat and long for each story when they are added
			// This for loop will cycle through the stories that we have in order to get their
			// geo locations. In the end, we want all stories to have geolocations and this will be a backup.
			var stories = createNewStories(stories, 1, 0);
			fadeNewsFeed(stories);
		}
	});

	function createNewStories(stories) {

		var returnStories = '';

		$.each(stories, function(key, story) {
			returnStories += '<div class="home__element" data-date="'+story.date_posted+'">' +
				'<h3>'+story.story_title+'</h3>'+
				'<div class="story--content-box">'+
				'<p>'+story.description+'</p>'+
				'<p><a href="/stories/'+story.slug+'">View Story</a></p>'+
				'</div>'+
				'</div>';
		});

		return returnStories;
	}
}
