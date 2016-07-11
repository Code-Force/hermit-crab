var documentReady = function() {
    // Initialize the map
   initializeMap();
}
$(document).on('turbolinks:load', documentReady);
$(document).on('ready', documentReady);

// When the window has finished loading create our google map below
/*google.maps.event.addDomListener(window, 'load', initializeMap);*/

function initializeMap() {

    // Basic options for a simple Google Map
    var mapOptions = {

        // How zoomed in you want the map to start at (always required)
        center: new google.maps.LatLng(0, 0),
        zoom: 3,
        minZoom:3,
        maxZoom:6,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,

        // How you would like to style the map.
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"water","stylers":[{"lightness":50}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]

           /* [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},,{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
*/

    };
    var widths = ["256px", "512px", "1024px", "100%"];
    var markerOpacityIncrement = 0.05;
    var markerOpacity = 0.05;

    // Let's set up the prev_infowindow variable that we use to close the
    // previously opened info window if a new info window is opened.
    var prev_infowindow =false;

    // Get the HTML DOM element that will contain your map
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('map');

    // Create the Google Map using our element and options defined above
    map = new google.maps.Map(mapElement, mapOptions);

    // Setting up the boundaries that the user can view North max is 85 and south max is -85
    var northBoundary = 78
    var southBoundary = -75

    // We need a listener to detect when the map has been dragged and make sure to bound
    // the user within the map's limits.
    google.maps.event.addListener(map, 'center_changed', function() {
        var bounds = map.getBounds();
        var ne = bounds.getNorthEast()
        var sw = bounds.getSouthWest()
        var center = map.getCenter()

        if(ne.lat() > northBoundary) {
            map.setCenter({lat: center.lat() - (ne.lat() - northBoundary), lng: center.lng()})
        }

        if(sw.lat() < southBoundary) {
            map.setCenter({lat: center.lat() - (sw.lat() - southBoundary), lng: center.lng()})
        }
    });

    // When the map is zoomed, the map needs to be resized to make sure that the
    // map looks good and not out of the box.
    google.maps.event.addListener(map, 'zoom_changed', function() {
        zoom = map.getZoom();
        if (zoom < 4) {
            mapElement.style.width = widths[zoom];
        }
        else {
            mapElement.style.width = widths[3];
        }
        google.maps.event.trigger(map, "resize");
    });

    // TO UPDATE : We need to make this more robust and dynamic.
    // Icons for displaying on the map
    var iconBase = 'http://sandbox.travelledwriters.com/assets/map/icons/';
    var icons = {
        continent: {
            icon: iconBase + 'pin.png'
        },
        paperplane: {
            icon: iconBase + 'paper-plane.png'
        },
        mountains: {
            icon: iconBase + 'mountains.png'
        },
        scubadiving: {
            icon: iconBase + 'scubadiving.png'
        },
        restaurant: {
            icon: iconBase + 'restaurant.png'
        },
        cooking: {
            icon: iconBase + 'cooking.png'
        },
        train: {
            icon: iconBase + 'train.png'
        },
        airplane: {
            icon: iconBase + 'airplane.png'
        },
        bus: {
            icon: iconBase + 'bus.png'
        },
        religious: {
            icon: iconBase + 'religious.png'
        }
    };


    var fadeInMarkers = function(marker, markerOpacity) {


        if (markerOpacity <= 1) {

            marker.setOpacity(markerOpacity);

            // increment opacity
            markerOpacity += markerOpacityIncrement;

            // call this method again
            setTimeout(function() {
                fadeInMarkers(marker, markerOpacity);
            }, 15);

        } else {
            markerOpacity = 0.05; // reset for next use
        }
    }


    // This function will add a new marker to the map. Make sure the appropriate information
    // is in the marker to make sure it format correctly.
    function addMarker(feature) {

        var story = feature.story;

        // Build the content of the infoWinfow.
        var contentString = '<div id="story-popup">'+
            '<h1>'+story.story_title+'</h1>'+
            '<div class="story-popup_content-box">'+
            '<p>'+story.description+'</p>'+
            '<p><a href="/stories/'+story.slug+'">View Story</a></p>'+
            '</div>'+
            '</div>';

        // If the position isn't null, we need to add the marker to the map.
        // We don't want the marker to show up if it has no position giving it an
        // inaccurate location on the map.
        if (feature.position != null) {

            // Assign the content to the infoWindow
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            // Create the marker
            var marker = new google.maps.Marker({
                position: feature.position,
                icon: icons[feature.type].icon,
                map: map
            });

            // Fade in the markers
            /*marker.setOpacity(0);
            fadeInMarkers(marker, 0.05);*/


            // We have to add the event for the marker to make the info window popup
            marker.addListener('click', function() {

                if( prev_infowindow ) {
                    prev_infowindow.close();
                }
                prev_infowindow = infowindow;
                infowindow.open(map, marker);

                // This will add the style to the outer box so we can style it differently than the
                // basic Google Popup.
                $('#story-popup').parent().parent().parent().siblings().addClass('outer-box');
                $('.outer-box > div:nth-child(2)').addClass('out-box__inner-box');
                $('.outer-box div:nth-child(3) div').addClass('box-arrow');

            });
        }

    }

    // This function is used to display the stories that are pulled from the endpoint.
    // Before adding them as markers, we need to take the data returned from the google geolocation point
    // and the stories generated from the endpoint.
    function createNewStory(stories, story_number) {
        return function(data) {

            var p = data.results[0].geometry.location
            var latlng = new google.maps.LatLng(p.lat, p.lng);

            var newFeature = {
                position: latlng,
                type: stories.category,
                story: stories,
            };

            setTimeout(function() {
                addMarker(newFeature);
            }, story_number * 15);

        };
    }

    // TO UPDATE : We need to make this super dynamic with the filter functions
    // We will get the list stories to display on the home map
    $.ajax({
        type: "POST",
        url: "stories/ajax/stories_list",
        dataType: "json",
        success: function(stories){

            // TO UPDATE : We need to add lat and long for each story when they are added
            // This for loop will cycle through the stories that we have in order to get their
            // geo locations. In the end, we want all stories to have geolocations and this will be a backup.
            for (var x = 0; x < stories.length; x++) {
                $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+encodeURI(stories[x].location+','+stories[x].country)+'&sensor=false', createNewStory(stories[x], x));
            }
        }
    });


}

