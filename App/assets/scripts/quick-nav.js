
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

        updateMarkers();

    });

    $('body').on('click', '.clear-filters', function(e) {
        e.preventDefault();

        var clearIdentifier = $(this).data('clear-identifier');
        var clearType = $(this).data('clear-type');

        if (clearType == 'checkbox') {
            $('.filter-'+clearIdentifier).each(function () {
                $(this).prop('checked', false); // Unchecks it
            });
            updateMarkers();

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

function fadeFilterLoader() {

    $('#filter-overlay').toggleClass('show');

}

function updateMarkers() {

    fadeFilterLoader();

    deleteMarkers();

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
            // TO UPDATE : We need to add lat and long for each story when they are added
            // This for loop will cycle through the stories that we have in order to get their
            // geo locations. In the end, we want all stories to have geolocations and this will be a backup.
            createNewStories(stories, 1, 0);
            fadeFilterLoader();

        }
    });


}