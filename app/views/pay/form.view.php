<?php
// Calculate total price of items in the cart
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += floatval($item['price']) * intval($item['quantity']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen flex justify-center items-center bg-gray-100">
    <form id="sale-form" class="w-full lg:w-5/12 flex flex-col items-center gap-5 p-5 bg-white rounded-lg shadow-lg my-[70px]">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        <input type="hidden" name="description" id="cart" value="<?= htmlspecialchars(json_encode($_SESSION['cart'])) ?>">
        <input type="hidden" name="coords" id="cords" value="">
        <input type="hidden" name="price" id="price" value="<?= htmlspecialchars($totalPrice) ?>">
        <input type="hidden" name="date" value="">
        <script>
            let currentDate = new Date();

            let formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' ');

            document.querySelector('input[name="date"]').value = formattedDate;
        </script>
        <h1 class="text-3xl font-bold mb-4">Detalles de envío</h1>
        <div class="w-full">
            <label for="full_name" class="text-gray-700">Nombre completo:</label>
            <input type="text" id="full_name" placeholder="Nombre completo" name="full_name" value="<?= $_SESSION['full_name'] ?>" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
        </div>
        <div class="w-full">
            <label for="email" class="text-gray-700">Correo electrónico:</label>
            <input type="email" id="email" placeholder="Correo electrónico" name="email" value="<?= $_SESSION['email'] ?>" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
        </div>
        <div class="w-full">
            <label for="phone_number" class="text-gray-700">Teléfono:</label>
            <input type="tel" id="phone_number" placeholder="Teléfono" name="phone_number" value="<?= $_SESSION['phone_number'] ?>" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
        </div>
        <div class="w-full">
            <label for="shipping_address" class="text-gray-700">Dirección de envío:</label>
            <input type="text" id="shipping_address" name="address" placeholder="Dirección de envío" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1" autocomplete="off">
            <div id="map" class="w-11/12 h-[400px] mt-5 mx-auto rounded-lg shadow-md"></div>
        </div>
        <div class="w-full">
            <label for="additional_notes" class="text-gray-700">Notas adicionales:</label>
            <textarea id="additional_notes" placeholder="Notas adicionales" name="message" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1 h-36 resize-none"></textarea>
        </div>
        <button id="submit-button" type="submit" class="bg-violet-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Continuar</button>
    </form>
    <script>
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
            autocomplete = new google.maps.places.Autocomplete(document.getElementById("shipping_address"));

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
                    document.getElementById("shipping_address").value = results[0].formatted_address;
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

    </script>
    <script src="/public/js/sale.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0&libraries=places&callback=initMap" async defer></script>
</body>
</html>