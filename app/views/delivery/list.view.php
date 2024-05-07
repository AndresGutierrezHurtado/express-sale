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
            <div class="w-full bg-slate-700 px-3 p-1 rounded-t-lg">
                <h1 class="tracking-tight font-bold text-white">Lista de envíos pendientes</h1>
            </div>
            <div>
                <?php foreach($deliveries['data'] as $delivery): ?>
                    <article class="p-5 w-full bg-white">
                        <h1>Envio para <?= $delivery['full_name'] ?></h1>
                        <p>desde: </p>
                        <p>hasta: <?= $delivery['address_sale'] ?></p>
                        
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0&libraries=places&callback=initMap" async defer></script>
</body>
</html>