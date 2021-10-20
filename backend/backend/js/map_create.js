var map;
console.log('latitude: '+activity_latitude);
console.log('longitude: ' + activity_longitude);
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

function showPosition(position)
{
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    var center = new google.maps.LatLng(lat, lng);

    var markerOption = {
        map: map,
        position: center,
        draggable: true
    };

    var marker = new google.maps.Marker(markerOption);
    
    

    google.maps.event.addListener(marker, 'dragend', function (event) {
        $(id_lat).val(event.latLng.lat());
        $(id_lng).val(event.latLng.lng());
    });
}

