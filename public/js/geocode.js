var geocoder = new google.maps.Geocoder();

/**
 * Geocodes a given latitude and longitude as position or an address.
 *
 * @param data
 * @param callback
 */
function geocode(data, callback) {
    geocoder.geocode(data, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            callback(results[0]);
        } else if (status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            setTimeout(function() {
                geocode(data, callback);
            }, 200);
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
            callback(null);
        }
    });
}

function initMap(mapId, center) {
    if (!center) {
        center = {lat: -24.345, lng: 134.46};
    }
    var map = new google.maps.Map(document.getElementById(mapId), {
        zoom: 11,
        center: center,
        mapTypeId: google.maps.MapTypeId.TERRAIN
    });
    map.setTilt(45);
    return map;
}

function setPolyline(map, coordinates) {
    var flightPath = new google.maps.Polyline({
        path: coordinates,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
    });

    flightPath.setMap(map);
}

function setMarker(map, latLng, title, icon = null, info = null) {
    var marker = marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: title,
        icon: icon,
        animation: google.maps.Animation.DROP
    });

    if (info) {
        var infoWindow = new google.maps.InfoWindow({
            content: info
        });
        marker.addListener('click', function() {
            infoWindow.open(map, marker);
        });
    }

    return marker;
}

function initMapDirectionsRenderer(map, draggable = false) {
    return new google.maps.DirectionsRenderer({
        draggable: draggable,
        map: map,
        suppressMarkers: true
    });
}

function initMapDirectionsService() {
    return new google.maps.DirectionsService;
}

function calculateAndDisplayRoute(directionsService, directionsDisplay, start, finish, checkpoints) {
    var waypts = [];
    for (var i = 0; i < checkpoints.length; i++) {
        waypts.push({
            location: {lat: checkpoints[i].latitude, lng: checkpoints[i].longitude},
            stopover: false
        });
    }

    directionsService.route({
        origin: {lat: start.latitude, lng: start.longitude},
        destination: {lat: finish.latitude, lng: finish.longitude},
        waypoints: waypts,
        optimizeWaypoints: false,
        travelMode: google.maps.TravelMode.WALKING
    }, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        } else {
            console.error('Directions request failed due to ' + status);
        }
    });
}