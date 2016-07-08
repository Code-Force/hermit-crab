var documentReady = function() {
    init();
}
$(document).ready(documentReady);
$(document).on('turbolinks:load', documentReady);

// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', init);


function init() {
    // Basic options for a simple Google Map
    // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 6,

        // The latitude and longitude to center the map (always required)
         center: new google.maps.LatLng(45.4949419, -73.6786729), // New York

        // How you would like to style the map.
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
    };

    // Get the HTML DOM element that will contain your map
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('map');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);


    var iconBase = 'http://sandbox.travelledwriters.com/assets/map/icons/';
    var icons = {
        city: {
            icon: iconBase + 'pin.png'
        },
        plane: {
            icon: iconBase + 'paper-plane.png'
        },
        university: {
            icon: iconBase + 'university.png'
        }
    };

    var features = [
        {
            position: new google.maps.LatLng(45.4949419, -73.6786729),
            type: 'university'
        },
        {
            position: new google.maps.LatLng(45.5316091, -73.6126166),
            type: 'university'
        },
        {
            position: new google.maps.LatLng(45.6104245, -73.6786729),
            type: 'university'
        },
        {
            position: new google.maps.LatLng(45.6008911, -73.5048079),
            type: 'plane'
        },
        {
            position: new google.maps.LatLng(45.5395364, -73.3544291),
            type: 'plane'
        },
        {
            position: new google.maps.LatLng(45.4416976, -73.4452091),
            type: 'plane'
        }
    ];
    function addMarker(feature) {

        var contentString = '<div id="infopopupcontent">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
            'sandstone rock formation in the southern part of the '+
            'Northern Territorand ancient paintings. Uluru is listed as a World '+
            'Heritage Site.</p>'+
            '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
            'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
            '(last visited June 22, 2009).</p>'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map,
            title: 'Zing Design'
        });

        marker.addListener('click', function() {
            infowindow.open(map, marker);
            var l = $('#infopopupcontent').parent().parent().parent().siblings().addClass('outer-box');
            console.log(l);
        });
    }
    for (var i = 0, feature; feature = features[i]; i++) {
        addMarker(feature);
    }

}

