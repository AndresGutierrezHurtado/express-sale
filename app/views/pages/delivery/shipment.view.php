<!-- Carga de la API de Google Maps -->
<script>
    function initMap() {
        // Coordenadas y opciones del mapa
        var map = new google.maps.Map(document.getElementById('shipment-map'), {
            zoom: 10,
            center: {
                lat: 0,
                lng: 0
            },
        });

        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer({
            map: map
        });

        // Obtener ubicación
        function getCurrentLocation(callback) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    callback(userLocation);
                }, function(error) {
                    let errorMessage = "";

                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = ("El usuario denegó la solicitud de geolocalización.");
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = ("La información de ubicación no está disponible.");
                            break;
                        case error.TIMEOUT:
                            errorMessage = ("La solicitud de ubicación ha caducado.");
                            break;
                        case error.UNKNOWN_ERROR:
                            errorMessage = ("Ha ocurrido un error desconocido.");
                            break;
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Hubo un error",
                        text: "Error obteniendo la ubicación. Código: " + error.code + ". Mensaje: " + errorMessage,
                        footer: 'Si quieres notificar el error ve al <a href="/page/home/#footer_form" class="text-violet-600 hover:underline font-medium" >formulario de contacto</a>',
                    });

                    callback({
                        // Bogotá
                        lat: 4.710988599999999,
                        lng: -74.07209219999999
                    });
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                console.error('Error: El navegador no admite la geolocalización.');
                callback(null);
            }
        }

        getCurrentLocation(function(userLocation) {
            if (userLocation) {
                // Centrar el mapa
                map.setCenter(userLocation);

                // Obtener la ubicación de los waypoints
                var waypoints = <?php echo json_encode($order['productos']); ?>;
                var destinations = waypoints.map(function(waypoint) {
                    return waypoint.usuario_direccion;
                });

                //  Calcular la distancia entre la ubicación del usuario y la ubicación de los waypoints
                var service = new google.maps.DistanceMatrixService();
                service.getDistanceMatrix({
                    origins: [userLocation],
                    destinations: destinations,
                    travelMode: 'DRIVING',
                }, function(response, status) {
                    if (status === 'OK') {
                        var distances = response.rows[0].elements.map(function(element) {
                            return element.distance.value;
                        });

                        waypoints.forEach(function(waypoint, index) {
                            waypoint.distance = distances[index];
                        });

                        // Ordenar los waypoints por distancia
                        waypoints.sort(function(a, b) {
                            return a.distance - b.distance;
                        });

                        // Calcular la ruta
                        var request = {
                            origin: userLocation,
                            destination: '<?= $order['envio_direccion'] ?>',
                            waypoints: waypoints.map(function(waypoint) {
                                return {
                                    location: waypoint.usuario_direccion,
                                    stopover: true
                                };
                            }),
                            travelMode: google.maps.TravelMode.DRIVING,
                        };

                        // Mostrar la ruta
                        directionsService.route(request, function(result, status) {
                            if (status === 'OK') {
                                directionsRenderer.setDirections(result);
                            } else {
                                console.error('Error al calcular la ruta: ' + status);
                            }
                        });
                    } else {
                        console.error('Error al calcular las distancias: ' + status);
                    }
                });
            }
        });
    }
</script>

<div class="container mx-auto py-8">
    <?php if ($order['pedido_estado'] == 'entregado' || $order['pedido_estado'] == 'recibido') : ?>
        <div class="flex flex-col gap-5 justify-center items-center">
            <h1 class="text-center font-bold text-3xl tracking-tight"> este envío ya fue realizado.</h1>
            <a href="/page/shipments"><button class="text-md flex gap-3 font-semibold items-center rounded-full border-2 border-red-500 px-4 p-1 text-red-500"> <i class="fa-solid fa-angle-left"></i> Volver</button></a>
        </div>
    <?php else : ?>
        <!-- Encabezado: información del destinatario -->
        <div class="bg-white p-4 shadow-md rounded-md mb-8">
            <h2 class="text-4xl font-bold mb-2">Envío para <?= $order['comprador_nombre'] ?></h2>
            <p class="text-gray-700"><strong>Dirección:</strong> <?= $order['envio_direccion'] ?></p>
            <p class="text-gray-700"><strong>Teléfono:</strong> <?= $order['comprador_telefono'] ?></p>
            <p class="text-gray-700"><strong>Mensaje:</strong> <?= $order['envio_mensaje'] ?></p>
        </div>

        <!-- Lista de productos a entregar -->
        <div class="bg-white p-4 shadow-md rounded-md mb-8 space-y-4">
            <h2 class="text-2xl font-bold mb-2">Productos a entregar</h2>
            <ul>
                <?php foreach ($order['productos'] as $producto): ?>
                    <li class="flex justify-between items-center py-2">
                        <div>
                            <p class="font-semibold"> (<?= $producto['producto_cantidad'] ?>) <?= $producto['producto_nombre'] ?> | <?= number_format($producto['producto_precio']) ?> COP por producto</p>
                            <p class="text-gray-600">Vendedor: <a href="/page/sellers/?seller=<?= $producto['usuario_id'] ?>"><?= $producto['usuario_alias'] ?></a> </p>
                        </div>
                        <p class="font-semibold"><?= $producto['usuario_direccion'] ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <hr>

            <h2 class="text-2xl font-bold mb-2">Destino</h2>
            <ul>
                <li class="flex justify-between items-center py-2">
                    <div>
                        <h2 class="font-semibold mb-2">Sitio de entrega de <?= $order['envio_direccion'] ?></h2>
                        <p class="text-gray-600">Teléfono: <?= $order['comprador_telefono'] ?></p>
                    </div>
                    <p class="font-semibold"><?= $order['envio_direccion'] ?></p>
                </li>
            </ul>
        </div>

        <!-- Mapa con la ruta a las tiendas -->
        <div class="bg-white p-4 shadow-md rounded-md mb-8">
            <h2 class="text-xl font-semibold mb-2">Ruta de entrega</h2>

            <!-- Mapa -->
            <div id="shipment-map" class="h-96"></div>

            <!-- Botón para abrir la ruta en Waze -->
            <div class="text-center mt-5 flex gap-4 justify-center items-center">
                <button id="openWazeBtn" class="font-semibold flex gap-2 items-center text-blue-500 px-5 p-2 rounded-full border-2 border-blue-500 hover:bg-gray-200 duration-300">
                    <i class="fas fa-map-marked-alt"></i> Abrir Ruta en Waze
                </button>
            </div>

            <!-- Botón para abrir la ruta en Google Maps -->
            <div class="text-center mt-2 flex ga-4 justify-center items-center">
                <button id="openRouteBtn" class="font-semibold flex gap-2 items-center text-blue-500 px-5 p-2 rounded-full border-2 border-blue-500 hover:bg-gray-200 duration-300">
                    <i class="fas fa-map-marked-alt"></i> Abrir Ruta en Google maps
                </button>
            </div>
        </div>

        <div class="text-center">
            <button id="submit-delivery-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" data-order_id="<?= $_GET['shipment'] ?>">
                <i class="fas fa-check-circle mr-2"></i> Marcar como terminado
            </button>
        </div>

    <?php endif; ?>
</div>

<script>
    // Abrir la ruta en google maps al presionar el boton de la ruta
    document.getElementById('openRouteBtn').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var routeURL = 'https://www.google.com/maps/dir/' + position.coords.latitude + ',' + position.coords.longitude + '/';
                var waypoints = <?= json_encode($order['productos']) ?>;

                // Agregar los waypoints a la URL de Google Maps
                waypoints.forEach(function(waypoint) {
                    if (waypoint.usuario_direccion) {
                        routeURL += encodeURIComponent(waypoint.usuario_direccion) + '/';
                    }
                });

                // Agregar la dirección final
                routeURL += encodeURIComponent('<?= $order['envio_direccion'] ?>');

                // Abrir la URL de Google Maps
                window.open(routeURL, '_blank');
            }, function(error) {
                console.error("Error obteniendo la ubicación: " + error.message);
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Hubo un error",
                text: "La geolocalización no es soportada por este navegador.",
                footer: 'Si quieres notificar el error ve al <a href="/page/home/#footer_form" class="text-violet-600 hover:underline font-medium" >formulario de contacto</a>',
            });
        }
    });

    // Abrir la ruta en Waze al presionar el botón de Waze
    document.getElementById('openWazeBtn').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var wazeURL = 'waze://?ll=' + position.coords.latitude + ',' + position.coords.longitude + '&navigate=yes';
                var waypoints = <?= json_encode($order['productos']) ?>;

                // Agregar los waypoints a la URL de Waze
                waypoints.forEach(function(waypoint) {
                    if (waypoint.usuario_direccion) {
                        wazeURL += '&via=' + encodeURIComponent(waypoint.usuario_direccion);
                    }
                });

                // Agregar la dirección final
                wazeURL += '&via=' + encodeURIComponent('<?= $order['envio_direccion'] ?>');

                // Abrir la URL de Waze
                window.open(wazeURL, '_blank');
            }, function(error) {
                console.error("Error obteniendo la ubicación: " + error.message);
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Hubo un error",
                text: "La geolocalización no es soportada por este navegador.",
                footer: 'Si quieres notificar el error ve al <a href="/page/home/#footer_form" class="text-violet-600 hover:underline font-medium" >formulario de contacto</a>',
            });
        }
    });


    // terminar ruta
    document.getElementById('submit-delivery-button').addEventListener('click', function() {
        const data = new FormData();

        data.append('pedido_id', '<?= $order['pedido_id'] ?>');
        data.append('pedido_estado', 'entregado');

        fetch('/order/update', {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateDelivery();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Hubo un error al terminar el envío " + data.error,
                        confirmButtonText: "Ok"
                    });
                }
            })
    });

    function updateDelivery() {
        const data = new FormData();

        data.append('usuario_id', '<?= $_SESSION['usuario_id'] ?>');
        data.append('trabajador_numero_trabajos', '<?= $trabajador['trabajador_numero_trabajos'] ?>');

        fetch('/user/update', {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: "succes",
                        title: "Envio terminado",
                        text: "El envio fue realizado correctamente, ahora espera a la confirmación del cliente para aumentar tu saldo.",
                        confirmButtonText: "Ok"
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Hubo un error al terminar el envío " + data.error,
                        confirmButtonText: "Ok"
                    });
                }
            })
    }
</script>