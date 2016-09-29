
var documentReady = function() {
	// Initialize the map
	initializeQuickNav();
};

window.addEventListener('load', documentReady);
document.addEventListener('turbolinks:load', documentReady);

function initializeQuickNav () {
	$('body').on('click', '#nav-toggle', function () {
		$('#quick-nav').toggleClass('open');
	});

	$('body').on('change', '.filter-category', function() {
		updateStores();
	});

	$('body').on('click', '.clear-filters', function(e) {
		e.preventDefault();

		var clearIdentifier = $(this).data('clear-identifier');
		var clearType = $(this).data('clear-type');

		if (clearType == 'checkbox') {
			$('.filter-'+clearIdentifier).each(function () {
				$(this).prop('checked', false); // Unchecks it
			});
			updateStores();
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
	if ($content === undefined) {
		$content = '<div class="loader" data-loader="ball-pulse"></div>';
	}
	contentContainer.fadeOut('fast', function() {
		contentContainer.html($content);
		contentContainer.fadeIn('fast');
	});

}

function updateStores() {

	fadeNewsFeed();

	var categoryFilters = getCategoryFilters();

	var categories = '';

	if (categoryFilters.length) {
		$.each(categoryFilters, function (key, value) {
			categories = categories + value + ':';
		});
		categories = 'categories=' + categories.substr(0, (categories.length - 1)) + '&';
	}

	var data = encodeURI(categories);

	// TO UPDATE : We need to make this super dynamic with the filter functions
	// We will get the list stories to display on the home map
	$.ajax({
		type: "GET",
		url: "stories/ajax/stories_list",
		data: data.substr(0, (data.length - 1)),
		dataType: "json",
		success: function(stories){
			console.log(stories);
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
			returnStories += '<div id="story">'+
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
