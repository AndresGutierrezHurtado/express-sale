<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra  | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen flex justify-center items-center bg-gray-100">
    <div class="w-5/12 mx-auto py-8">
        <div class="bg-white p-8 rounded-md shadow-md">
            <h1 class="text-2xl font-semibold mb-4">Detalles de la compra</h1>
            
            <div class="class flex flex-col gap-2 mb-5  ">
                <div>                    
                    <p><strong>Nombre:</strong> <?= $delivery['sale_full_name'] ?></p>
                    <p><strong>Email:</strong> <?= $delivery['sale_email'] ?></p>
                    <p><strong>Teléfono:</strong> <?= $delivery['sale_phone_number'] ?></p>
                    <p><strong>Dirección de entrega:</strong> <?= $delivery['sale_address'] ?></p>                
                </div>
                <a href="descargar_factura.php?sale_id=<?= $sale['sale_id'] ?>" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded inline-block w-fit">
                    <i class="fas fa-download mr-2"></i> Descargar Factura
                </a>
            </div>

            <!-- Información de la compra -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold mb-4">Productos</h2>
                <ul class="flex flex-col gap-10 py-5">
                    <?php foreach(json_decode($delivery['sale_description'], true) as $product): ?>
                        <li class="w-full">
                            <article class="flex justify-between items-center mb-4 rounded-lg shadow-lg p-5">
                                <div class="w-3/12 h-32">
                                    <img src="<?= $product['product_image'] ?>" alt="<?= $product['product_name'] ?>" class="h-full object-cover">
                                </div>
                                <div class="flex flex-col gap-10 w-5/12">
                                    <div>
                                        <h1 class="text-2xl font-semibold"><?= $product['product_name'] ?></h1>
                                        <p class="text-gray-600">Vendedor: Pendiente</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Precio: <?= number_format($product['product_price'], 2) ?> COP</p>
                                        <p class="text-gray-600">cantidad: <?= $product['product_quantity'] ?></p>
                                    </div>
                                </div>
                                <p class="text-lg font-semibold"><?= number_format($product['product_price'] * $product['product_quantity'], 2) ?> COP</p>
                            </article>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Información adicional -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold mb-4">Información adicional</h2>
                <p><strong>Fecha de compra:</strong> <?= $delivery['sale_date'] ?></p>
                <p><strong>Precio total:</strong> <?= number_format($delivery['sale_price'], 2) ?> COP</p>
                <p><strong>Estado:</strong> <?= ucfirst($delivery['sale_state']) ?></p>
            </div>

            <!-- Botón de regreso -->
            <a href="/page/user_profile" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-block">
                <i class="fas fa-arrow-left mr-2"></i> Volver a las ventas
            </a>
        </div>
    </div>
</body>
</html>