<?php

function obtenerDistancia($origen, $destino) {
    $api_key = 'AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0';

    $url ="https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".urlencode($origen)."&origins=".urlencode($destino)."&units=meters&key=" . $api_key;

    $response = file_get_contents($url);

    $data = json_decode($response, true);

    if ($data['status'] == 'OK') {
        return $data['rows'][0]['elements'][0]; // Devuelve el valor numérico de la distancia en metros
    } else {
        return 0;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Envío | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-100">
<div class="container mx-auto py-8">
    <?php if ($order['state_name'] == 'finalizado') : ?>
        <div class="flex flex-col gap-5 justify-center items-center">
            <h1 class="text-center font-bold text-3xl tracking-tight"> este envío ya fue realizado.</h1>
            <a href="/page/delivery_list"><button class="text-md flex gap-3 font-semibold items-center rounded-full border-2 border-red-500 px-4 p-1 text-red-500"> <i class ="fa-solid fa-angle-left"></i> Volver</button></a>
        </div>
    <?php else : ?>
        <!-- Encabezado: información del destinatario -->
        <div class="bg-white p-4 shadow-md rounded-md mb-8">
            <h2 class="text-xl font-semibold mb-2">Envío para <?= $order['order_first_name'] . " " . $order['order_last_name'] ?></h2>
            <p class="text-gray-600">Dirección: <?= $order['order_address'] ?></p>
            <p class="text-gray-600">Teléfono: <?= $order['order_phone_number'] ?></p>
        </div>

        <!-- Lista de productos a entregar -->
        <div class="bg-white p-4 shadow-md rounded-md mb-8">
            <h2 class="text-xl font-semibold mb-2">Productos a entregar</h2>
            <ul>
                <?php foreach($products as $producto): ?>
                    <li class="flex justify-between items-center py-2">
                        <div>
                            <p class="font-semibold"><?= $producto['product_name'] ?> (<?= $producto['sold_product_quantity'] ?>) | <?= number_format($producto['sold_product_price'])?> COP por producto</p>
                            <p class="text-gray-600">Vendedor: pendiente </p>
                        </div>
                        <p class="font-semibold"><?= $producto['sold_product_address'] ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h2 class="text-xl font-semibold mb-2">Destino</h2>
            <ul>
                <li class="flex justify-between items-center py-2">
                    <div>
                        <h2 class="font-semibold mb-2">Sitio de entrega de <?= $order['order_first_name'] ?></h2>
                        <p class="text-gray-600">Teléfono: <?= $order['order_phone_number'] ?></p>
                    </div>
                    <p class="font-semibold"><?= $order['order_address'] ?></p>
                </li>
            </ul>  
        </div>

        <!-- Mapa con la ruta a las tiendas -->
        <div class="bg-white p-4 shadow-md rounded-md mb-8">
            <h2 class="text-xl font-semibold mb-2">Ruta de entrega</h2>
            <div id="map" class="h-96"></div>
            <!-- Botón para abrir la ruta en Google Maps -->
            <div class="text-center mt-4 flex ga-4 justify-center items-center">
                <button id="openRouteBtn" class="font-semibold flex gap-2 items-center text-blue-500 px-5 p-2 rounded-full border-2 border-blue-500 hover:bg-gray-200 duration-300">
                <i class="fas fa-map-marked-alt"></i> Abrir Ruta en Google maps
                </button>
            </div>

        </div>

        <div class="text-center">
            <button id="submit-delivery-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" data-order_id="<?= $_GET['id']?>">
                <i class="fas fa-check-circle mr-2"></i> Marcar como terminado
            </button>
        </div>
    </div>

    <?php endif;?>
    <!-- Carga de la API de Google Maps -->
    <script>
        function initMap() {
            // Coordenadas y opciones del mapa
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: {lat: 0, lng: 0},
            });
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
            });
            
            // obtener la ubicación
            function getCurrentLocation(callback) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        callback(userLocation);
                    }, function() {
                        console.log('Error: No se pudo obtener la ubicación del usuario.');
                        callback(null);
                    });
                } else {
                    // Si el navegador no admite la geolocalización
                    console.log('Error: El navegador no admite la geolocalización.');
                    callback(null);
                }
            }
            
            getCurrentLocation(function(userLocation) {
                if (userLocation) {
                    // centrar el mapa en la ubicación del usuario
                    map.setCenter(userLocation);
                    
                    var waypoints = <?php echo json_encode($products); ?>;
                    var destinations = waypoints.map(function(waypoint) {
                        return waypoint.sold_product_address;
                    });
                    
                    // Calcular la distancia entre el usuario y los destinos
                    var service = new google.maps.DistanceMatrixService();
                    service.getDistanceMatrix({
                        origins: [userLocation],
                        destinations: destinations,
                        travelMode: 'DRIVING',
                    }, function(response, status) {
                        if (status == 'OK') {
                            var distances = response.rows[0].elements.map(function(element) {
                                return element.distance.value; // Distancia en metros
                            });
                            
                            // Asignar distancias a los waypoints
                            waypoints.forEach(function(waypoint, index) {
                                waypoint.distance = distances[index];
                            });
                            
                            // Ordenar los waypoints por distancia
                            waypoints.sort(function(a, b) {
                                return a.distance - b.distance;
                            });
                            
                            var request = {
                                origin: userLocation,
                                destination: '<?= $order['order_address'] ?>',
                                waypoints: waypoints.map(function(waypoint) {
                                    return {
                                        location: waypoint.sold_product_address,
                                        stopover: true
                                    };
                                }),
                                travelMode: google.maps.TravelMode.DRIVING,
                            };
                            // Calcular y mostrar la ruta
                            directionsService.route(request, function(result, status) {
                                if (status == 'OK') {
                                    directionsRenderer.setDirections(result);
                                } else {
                                    window.alert('Error al calcular la ruta: ' + status);
                                }
                            });
                        } else {
                            window.alert('Error al calcular las distancias: ' + status);
                        }
                    });
                }
            });
        }

        // reenviar a google maps con la ruta
        document.getElementById('openRouteBtn').addEventListener('click', function() {            
            var routeURL = 'https://www.google.com/maps/dir/';
            var waypoints = <?= json_encode($products); ?>;

            waypoints.forEach(function(waypoint) {
                routeURL += waypoint.sold_product_address + '/';
            });

            routeURL += '<?= $order['order_address'] ?>';
            
            window.open(routeURL, '_blank');
        });

        // terminar ruta
        document.getElementById('submit-delivery-button').addEventListener('click', function() {
            const data = new FormData();

            data.append('order_id', this.dataset.order_id);
            data.append('order_state_id', '5');

            fetch('/order/update', {
                method: 'POST',
                body: data 
            })
            .then(response => response.json())
            .then(data => { 
                alert('Envío terminado: \n +7000 COP');

                window.location.href="/page/delivery_list"
                updateDelivery();
            })
        });

        function updateDelivery() {
            <?php $_SESSION['user_delivery']['state'] = 'free'; ?>
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0&callback=initMap" async defer></script>
</body>
</html>