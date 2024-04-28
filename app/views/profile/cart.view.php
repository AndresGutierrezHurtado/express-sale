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
<body class="w-full min-h-screen flex flex-col bg-gray-100">

    <?php require_once(__DIR__ . "/../layout/header.php")?>

    <main class="w-full my-14 flex justify-center">
        <div class="flex gap-5 w-7/12">   
            <!-- Contenedor para el listado de productos -->
            <div class="w-7/12 h-fit bg-white py-5 p-4 shadow rounded flex flex-col gap-4">
                <h2 class="text-2xl font-bold tracking-tight">Carrito de compras: </h2>
                <hr>
                <?php foreach ($cart as $product) : ?>
                    <div class="flex items-start gap-4 py-2 p-4">
                        <div class="w-3/12">
                            <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>" class="max-w-full max-h-full">
                        </div>
                        <div class="w-9/12 px-4 flex flex-col justify-center gap-2 h-full">
                            <div class="flex gap-2">
                                <div class="w-full">
                                    <h3 class="text-[22px] font-semibold"><?= $product['name']; ?></h3>
                                    <span class="flex gap-3">
                                        <p>Cantidad: </p>
                                        <button class ="border border-gray-800 size-[30px] rounded-full flex items-center justify-center btn-increase" data-id="<?= $product['id'] ?>"><i class="fa-solid fa-arrow-up"></i></button>
                                        <input type="number" value="<?= $product['quantity']; ?>" placeholder="Cantidad" min="1" max="50" class="w-[50px] border border-gray-800 px-2 p-[2px] rounded-lg mb-4" disabled>
                                        <button class ="border border-gray-800 size-[30px] rounded-full flex items-center justify-center btn-decrease <?= $product['quantity'] == 1 ? 'cursor-no-drop' : '' ?>" <?= $product['quantity'] == 1 ? 'disabled' : '' ?>  data-id="<?= $product['id'] ?>"><i class="fa-solid fa-arrow-down"></i></button>
                                    </span>
                                </div>
                                <div class="h-full flex items-center">
                                    <button class="border border-pink-600 size-[40px] rounded-full duration-300 hover:bg-gray-200 btn-delete" data-id="<?= $product['id'] ?>"><i class="fa-solid fa-trash-can text-pink-600"></i></button>
                                </div>
                            </div>

                            <span class="flex justify-between">
                                <p class="text-gray-800 text-md font-semibold">Precio: <?=  number_format($product['price'], 2); ?> COP</p>
                                <p class="text-gray-600">Total: <?=  number_format($product['price'] * $product['quantity'], 2); ?> COP</p>
                            </span>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
                <?php if(count($cart) < 1): ?>
                    <div class="w-full">
                        <p class="font-bold">No se encontraron productos.</p>
                    </div>
                <?php else: ?>
                    <button id="btn-empty" class="border-2 border-violet-600 text-violet-600 font-bold rounded-md p-1 px-3 duration-300 hover:bg-gray-200">Vaciar carrito</button>
                <?php endif; ?>
            </div>         

            <!-- Contenedor para la información total de la venta -->
            <div class=" bg-white p-5 flex flex-col gap-2 shadow rounded mb-8 w-4/12 h-fit">
                <h2 class="text-2xl font-bold tracking-tight"> Total compra: </h2>
                <?php
                $totalVenta = 0;
                $totalCantidad = 0;
                foreach ($cart as $product) {
                    $precioTotalProducto = $product['price'] * $product['quantity'];
                    $totalVenta += $precioTotalProducto;
                    $totalCantidad += $product['quantity'];
                }
                ?>
                <span class="flex gap-2 justify-between">
                    <p>Sub-total: </p> 
                    <p> <?= number_format($totalVenta); ?> COP</p>
                </span>
                <span class="flex gap-2 justify-between">
                    <p>Precio envío: </p> 
                    <p> <?= number_format(7000); ?> COP</p>
                </span>
                <span class="flex gap-2 justify-between">
                    <p>IVA: </p> 
                    <p> <?= number_format($totalVenta * 0.19); ?> COP</p>
                </span>
                <span class="flex gap-2 justify-between font-bold mt-4">
                    <p>Total: </p> 
                    <p> <?= number_format($totalVenta + 7000 + ($totalVenta * 0.19)); ?> COP</p>
                </span>
                <button class="w-full p-x3 p-1 text-white font-bold bg-violet-600 rounded-md ">PAGAR</button>
            </div>
        </div>
    </main>
    <!-- falta agregar la lógica para eliminar, y actualizar items del carrito -->
<script src="/public/js/cart.js"></script>
</body>
</html>