var map;

function myMap() {
    var mapProp = {
        center: new google.maps.LatLng(14.988017, 102.117759),
        zoom: 6
    };
    getLocation();
    map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
}

function getLocation()
{
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

function showPosition()
{
    var lat = activity_latitude;
    var lng = activity_longitude;
    var center = new google.maps.LatLng(lat, lng);

    var markerOption = {
        map: map,
        position: center,
        draggable: true
    };

    var marker = new google.maps.Marker(markerOption);

    google.maps.event.addListener(marker, 'dragend', function (event) {
        $('#activity-activity_latitude').val(event.latLng.lat());
        $('#activity-activity_longitude').val(event.latLng.lng());
    });
}

