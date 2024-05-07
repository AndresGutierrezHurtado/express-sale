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
<body class="w-full min-h-screen bg-gray-100">
    <?php require_once(__DIR__ . "/../layout/header.php"); ?>
    <main class="w-full flex justify-center ">
        <div class="w-full md:w-7/12 my-[70px]">            
            <div class="w-full bg-slate-700 px-7 p-5 rounded-lg mb-5">
                <h1 class="tracking-tight font-bold text-white text-3xl">Lista de envíos pendientes: </h1>
            </div>
            <div class="flex flex-col gap-2">
                <?php if ($deliveries['rows'] < 1) : ?>
                    <h1 class="text-center text-2xl font-bold">No se encontraron envíos disponibles...</h1>
                <?php endif;?>
                <?php foreach($deliveries['data'] as $delivery): ?>
                    <article class="p-5 w-full bg-white rounded-lg shadow-lg flex justify-between">
                        <div class="flex flex-col gap-1">                            
                            <h1 class="font-bold text-2xl">Envio para <?= $delivery['user_full_name'] ?></h1>
                            <p> <a class="font-bold"> Por:</a>
                                <?php 
                                    $productos = json_decode($delivery['sale_description'], true);
                                    $totalProductos = count($productos);
                                    $contador = 0;
                                    foreach ($productos as $producto):
                                        echo $producto['product_address'];
                                        if (++$contador < $totalProductos) {
                                            echo ', ';
                                        } else {
                                            echo '.';
                                        }
                                    endforeach;
                                ?>
                            </p>
                            <p><a class="font-bold"> Hasta:</a> <?= $delivery['sale_address'] ?></p>
                            <p><a class="font-bold"> Fecha:</a> <?= $delivery['sale_date'] ?></p>
                            <p><a class="font-bold"> Precio:</a> 7,000 COP</p>
                        </div>
                        <div>
                            <button class="px-3 p-1 border-2 border-green-500 rounded-lg text-green-500 font-bold flex gap-3 items-center hover:bg-gray-100 duration-300"> <i class="fa-solid fa-circle-check "></i> Realizar Envío</button>
                        </div>                        
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0&libraries=places&callback=initMap" async defer></script>
</body>
</html>