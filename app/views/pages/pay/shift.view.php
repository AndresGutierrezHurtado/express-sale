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
<body class="w-full min-h-screen flex justify-center items-center bg-gray-200">
    <div class="w-5/12 mx-auto py-8">
        <div class="bg-white p-8 rounded-md shadow-md space-y-4">
            <div class="flex flex-col items-center">
                <div class="size-[160px]">
                    <img src="/public/images/logo.png" alt="Logo express sale" class="max-h-full max-w-full">
                </div>
            </div>
            <div class="flex gap-10">                
                <div class="space-y-2">                    
                    <h1 class="text-3xl font-bold tracking-tight">Detalles de la compra</h1>
                    <div>
                        <p>
                            <strong>Nombre:</strong> 
                            <?= $delivery['order_first_name'] . " " . $delivery['order_last_name']  ?></p>
                        <p>
                            <strong>Email:</strong> 
                            <?= $delivery['order_email'] ?>
                        </p>
                        <p>
                            <strong>Teléfono:</strong> 
                            <?= $delivery['order_phone_number'] ?>
                        </p>
                        <p>
                            <strong>Dirección de entrega:</strong> 
                            <?= $delivery['order_address'] ?>
                        </p> 
                    </div>               
                </div>

                <!-- Información adicional -->
                <div class="space-y-4">
                    <h2 class="text-xl font-bold">Información adicional</h2>
                    <div>                        
                        <p>
                            <strong>Fecha de compra:</strong> 
                            <?= $delivery['order_date'] ?>
                        </p>
                        <p>
                            <strong>Domiciliario:</strong> 
                            <a href="" class="hover:text-purple-600 hover:underline">  
                                <?= $worker['user_username'] ?> 
                            </a>
                        </p>
                        <p>
                            <strong>Precio total:</strong> 
                            <?= number_format($delivery['order_amount'], 2) ?> COP
                        </p>
                        <p>
                            <strong>Estado:</strong> 
                            <?= ucfirst($delivery['state_name']) ?>
                        </p>
                    </div>
                </div>
            </div>

            <hr>
            <!-- Información de la compra -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Productos</h2>
                
                <div class="flex flex-col gap-10 py-5">
                    <?php foreach($products as $product): ?>
                        <article class="flex items-center justify-center p-5 border rounded-md gap-5">
                            <div class="w-[150px] flex-none">
                                <img src="<?= $product['image_url'] ?>" alt="<?= $product['product_name'] ?>" class="h-full w-full object-cover">
                            </div>
                            <div class="flex flex-col justify-between w-full min-w-[1fr] space-y-5">
                                <div>
                                    <h1 class="text-2xl font-semibold"><?= $product['product_name'] ?></h1>
                                    <p class="text-gray-600"> 
                                        <strong class="font-semibold">Vendedor:</strong> 
                                        Pendiente
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-600">
                                    <strong class="font-semibold">Precio:</strong> 
                                        <?= number_format($product['product_price'], 2) ?> COP
                                    </p>
                                    <p class="text-gray-600">
                                    <strong class="font-semibold">Cantidad:</strong> 
                                        <?= $product['sold_product_quantity'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center min-w-[100px] flex-none">
                                <p class="text-lg font-semibold"><?= number_format($product['product_price'] * $product['sold_product_quantity'], 2) ?> COP</p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
            <hr>
            <a href="/page/order_receipt_pdf/?id=<?= $delivery['order_id'] ?>" target="_blank" 
            class="w-full">
                <button class="w-full px-4 py-1.5 rounded-md bg-violet-600 duration-300 hover:bg-violet-700 shadow-lg text-white font-semibold mt-4">
                    <i class="fas fa-download mr-2"></i> 
                    Descargar Factura
                </button>
            </a>
            <a href="/page/user_profile/?id=<?= $delivery['order_id'] ?>" target="_blank" 
            class="w-full">
                <button 
                class="w-full px-4 py-1.5 rounded-md bg-gray-50 duration-300 hover:bg-gray-100 shadow-lg font-semibold mt-4 border border-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i> 
                    Volver
                </button>
            </a>
        </div>
    </div>
</body>
</html>