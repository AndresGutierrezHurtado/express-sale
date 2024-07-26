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
    <title> Listado de compras pendientes | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-100">
    <?php require_once(__DIR__ . "/../layout/header.php"); ?>
    <main class="w-full flex justify-center ">
        <div class="w-full md:w-7/12 my-[70px]">            
            <div class="w-full bg-slate-700 px-7 p-5 rounded-lg mb-5">
                <h1 class="tracking-tight font-bold text-white text-3xl">Lista de envíos pendientes: </h1>
            </div>
            <div class="flex flex-col gap-2">
                <!-- Si no hay envíos para hacer -->
                <?php if (count($orders) < 1) : ?>
                    <h1 class="text-center text-2xl font-bold">No se encontraron envíos disponibles...</h1>
                <?php endif;?>
                <!-- cada articulo-->
                <?php foreach($orders as $order): ?>
                    <article class="p-5 w-full bg-white rounded-lg shadow-lg flex justify-between">
                        <div class="flex flex-col gap-1">                            
                            <h1 class="font-bold text-2xl">Envio para <?= $order['order_first_name'] ." ". $order['order_last_name'] ?></h1>
                            <div class="flex gap-2 my-2">
                                
                                <p class="font-bold">Ruta:</p>
                                <p class="text-[13px]"> <strong>Desde:</strong>
                                    <?php 
                                        // aca haz cada producto 
                                        $productos = $order['products'];
                                        $distancia_total = 0;
                                    
                                        for ($i = 0; $i < count($productos); $i++) {
                                            $origen = $productos[$i]['sold_product_address'];
                                            $destino = ($i == count($productos) - 1) ? $destino = $order['order_address'] : $destino = $productos[$i + 1]['sold_product_address'] ;
                                        
                                            $dataApi = obtenerDistancia($origen, $destino);
                                            $distancia_total += $dataApi['distance']['value'];
                                        }

                                        $totalProductos = count($productos);
                                        $contador = 0;
                                        
                                        foreach ($productos as $producto):

                                            echo $producto['sold_product_address'];
                                            if (++$contador < $totalProductos) {
                                                echo '<br> <strong>luego por:</strong> ';
                                            } else {
                                                echo '.';
                                            }
                                        endforeach; 
                                        ?>
                                    <br><strong>Hasta:</strong> <?= $order['order_address'] ?>
                                </p>
                            </div>
                            <p><strong>Distancia:</strong> <?= $distancia_total / 1000 ?> Km </p>
                            <p><strong>Pago:</strong> <?= $distancia_total > 10000 ? '10,000' : '7,000' ?> COP </p>
                            <p><strong>Fecha:</strong> <?= $order['order_date'] ?></p>
                        </div>
                        <a href="/page/delivery/?id=<?= $order['order_id']?>">
                            <button class="px-3 p-1 border-2 border-green-500 rounded-lg text-green-500 font-bold flex gap-3 items-center hover:bg-gray-100 duration-300"> <i class="fa-solid fa-circle-check "></i> Realizar Envío</button>
                        </a>                        
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
</html>