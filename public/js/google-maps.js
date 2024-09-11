let map;
let marker;
let geocoder;
let autocomplete;

function initMap() {
    const cords = { lat: 4.710988599999999, lng: -74.072092 };
    const mapOptions = {
        center: cords,
        zoom: 11,
        streetViewControl: false,
        fullscreenControl: false,
        mapTypeControlOptions: {
            mapTypeIds: ["roadmap", "satellite"],
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_LEFT
        },
        zoomControlOptions: {
            position: google.maps.ControlPosition.TOP_RIGHT
        }
    };
    map = new google.maps.Map(document.getElementById("map"), mapOptions);

    marker = new google.maps.Marker({
        position: map.getCenter(),
        map: map,
        draggable: true
    });

    geocoder = new google.maps.Geocoder();
    autocomplete = new google.maps.places.Autocomplete(document.getElementById("address_sale"));

    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
            console.log("No details available for input: '" + place.name + "'");
            return;
        }
        updateMapAndMarker(place.geometry.location);
    });

    marker.addListener('dragend', () => updateMapAndMarker(marker.getPosition()));
    map.addListener('click', (event) => updateMapAndMarker(event.latLng));
}

function updateMapAndMarker(position) {
    marker.setPosition(position);
    geocoder.geocode({ location: position }, (results, status) => {
        if (status === "OK" && results[0]) {
            document.getElementById("address_sale").value = results[0].formatted_address;
            map.setCenter(marker.getPosition());
            map.setZoom(map.getZoom() + 2);
        } else {
            console.log("Geocoder failed due to: " + status);
        }
    });
    saveLocation(position.lat(), position.lng());
}

function saveLocation(lat, lng) {
    const cordsForm = { lat: lat, lng: lng };
    document.getElementById("cords").value = JSON.stringify(cordsForm);
}
