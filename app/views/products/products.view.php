<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-50">
    <?php require_once(__DIR__ . "/../layout/header.php")?>

    <section class="w-full h-auto">
        <div class="container mx-auto flex flex-col gap-10 justify-between items-center py-10 px-5">
            <span class="w-full flex justify-between">
                <div class="flex flex-col">
                    <h2 class="text-2xl font-bold tracking-tight">Productos</h2>
                    <p><?= count($products) ?> resultados</p>
                </div>
                <div class="flex">
                    <p>ordenar por</p>
                    <select class="h-fit bg-transparent">
                        <option value="destacados">Destacado</option>
                        <option value="destacados">reciente</option>
                    </select>
                </div>
            </span>
            <div class="w-full flex justify-between">                
            <aside class="w-3/12 h-fit bg-white flex flex-col gap-5 p-5 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold">Filtrar Productos</h2>
                <div class="flex flex-col gap-1">
                    <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select id="categoria" name="categoria" class="w-full p-1 px-2 border rounded-md">
                        <option value="">Todas</option>
                        <option value="ropa">Ropa y calzado</option>
                        <option value="comida">comida</option>
                        <option value="electronica">Tecnología</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="costo-envio" class="block text-sm font-medium text-gray-700">Costo de envío</label>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Gratis</p>
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="block text-sm font-medium text-gray-700">Precio</label>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Hasta $ 45.000</p>
                    </span>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>$65.000 a $100.000</p>
                    </span>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Más de $100.000</p>
                    </span>
                    <span class="flex gap-3 w-full">
                        <input type="number" class="border p-1 px-2 w-1/2" placeholder="Desde...">
                        <input type="number" class="border p-1 px-2 w-1/2" placeholder="Hasta">
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="block text-sm font-medium text-gray-700">Descuento</label>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Desde 5% OFF</p>
                    </span>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Desde 10% OFF</p>
                    </span>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Desde 15% OFF</p>
                    </span>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Desde 24% OFF</p>
                    </span>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Desde 30% OFF</p>
                    </span>
                    <span class="flex gap-3">
                        <input type="checkbox" id="costo-envio"> 
                        <p>Desde 40% OFF</p>
                    </span>
                </div>
                <!-- Agrega más filtros según sea necesario -->
            </aside>

                <div class="w-8/12 flex flex-col gap-2">
                    <?php foreach (array_slice($products, 0, 5) as $product): ?>
                        <article class="flex justify-between gap-4 bg-white p-4 rounded-lg shadow-lg border h-[250px]">
                            <div class="w-3/12">
                                <img src="https://www.racketcenter.com.co/wp-content/uploads/2022/10/playera-nikecourt-drifit-is-DH0857-010-1-1000x1000.jpg" alt="<?= $product['name']; ?>" class="max-w-full max-h-full">
                            </div>
                            <div class="w-7/12 flex flex-col justify-between">
                                <div>                                
                                    <h2 class="text-2xl"><?= $product['name']; ?></h2>
                                    <span class="flex w-full gap-3">
                                        <span>
                                            <?php
                                                for ($i = 0; $i < (int)$product['calification']; $i++) {
                                                    echo '<i class="fa-solid fa-star"></i>';
                                                }
                                                for ($i = (int)$product['calification']; $i < 5; $i++) {
                                                    echo "<i class=\"fa-regular fa-star\"></i>";
                                                }
                                            ?>
                                        </span>
                                        <p class="opacity-[0.4]">(101)</p>
                                    </span>
                                </div>
                                <p><?= $product['description']; ?></p>
                                <h3 class="font-medium text-xl"><?= number_format($product['price']); ?> COP</h3>
                            </div>
                            <span class="w-2/12 flex items-center justify-center">
                                <button class="rounded-full size-[60px] border-2 border-black"><i class="fa-solid fa-cart-plus text-2xl"></i></button>
                            </span>
                        </article>
                    <?php endforeach; ?>                 
                </div>
            </div>
        </div>
    </section>


    <?php require_once(__DIR__ . "/../layout/footer.php") ?>
</body>
</html>