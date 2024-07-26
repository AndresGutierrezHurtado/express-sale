<main class="w-full">
    <div class="w-full max-w-[1200px] mx-auto flex gap-10 py-10">   
        <!-- Contenedor para el listado de productos -->
        <div class="w-full grow bg-white p-5 rounded-lg shadow-lg h-fit space-y-5">
            <h2 class="text-2xl font-bold tracking-tight">Carrito de compras: </h2>
            <hr>

            <!-- Listado de productos -->
            <div class="divide-y divide-y-gray-300">
                <?php if(count($products) < 1): ?>
                    <div class="w-full">
                        <p class="font-bold">No se encontraron productos.</p>
                    </div>
                <?php endif; ?>
                
                <?php foreach ($products as $product) : ?>

                    <article class="flex flex-col md:flex-row py-5">
                        <!-- Imagen -->
                        <div class="w-full max-w-[180px] h-[180px] mx-auto mx-3">
                            <img src="<?= $product['producto_imagen_url']; ?>" alt="<?= $product['producto_nombre']; ?>" class="object-contain h-full w-full">
                        </div>
                        
                        <div class="flex flex-col justify-between space-y-5 sm:space-y-3 grow">
                            <!-- Información del producto -->
                            <div class="flex flex-col md:flex-row gap-2">
                                <div class="w-full">
                                    <h3 class="text-[22px] font-semibold"><?= $product['producto_nombre']; ?></h3>
                                    <span class="flex gap-3">
                                        <p>Cantidad: </p>

                                        <button data-producto-id="<?= $product['producto_id'] ?>"
                                        class="border border-gray-800 size-[30px] rounded-full flex items-center justify-center btn-increase">
                                            <i class="fa-solid fa-arrow-up"></i>
                                        </button>

                                        <input type="number" value="<?= $product['producto_cantidad']; ?>" placeholder="Cantidad" min="1" max="50" disabled
                                        class="w-[50px] border border-gray-800 px-2 p-[2px] rounded-lg mb-4">

                                        <button data-producto-id="<?= $product['producto_id'] ?>"
                                        class ="border border-gray-800 size-[30px] rounded-full flex items-center justify-center btn-decrease <?= $product['producto_cantidad'] == 1 ? 'cursor-no-drop' : '' ?>" <?= $product['producto_cantidad'] == 1 ? 'disabled' : '' ?>>
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <!-- Precio total e individual -->
                            <span class="flex flex-col sm:flex-row justify-between">
                                <p class="text-gray-800 text-md font-semibold">Precio: <?=  number_format($product['producto_precio'], 2); ?> COP</p>
                                <p class="text-gray-600">Total: <?=  number_format($product['producto_precio'] * $product['producto_cantidad'], 2); ?> COP</p>
                            </span>

                            <!-- Quitar del carrito -->
                            <button type="submit" data-producto-id="<?= $product['producto_id'] ?>"
                            class="btn-delete group relative flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fa-solid fa-trash-can text-[17px] text-red-500 duration-300 group-hover:text-red-400"></i>
                                </span>
                                Quitar al carrito
                            </button>
                        </div>
                    </article>

                <?php endforeach; ?>
            </div>

            <?php if(count($products) > 1): ?>
                <hr>
                <button id="btn-empty" class="w-full border-2 border-violet-600 text-violet-600 font-bold rounded-md p-1.5 px-3 duration-300 hover:bg-gray-200">Vaciar carrito</button>
            <?php endif; ?>
        </div>         

        <!-- Contenedor para la información total de la venta -->
        <div class=" bg-white p-5 flex flex-col gap-2 shadow rounded mb-8 w-full md:w-4/12 h-fit">
            <h2 class="text-2xl font-bold tracking-tight"> Total compra: </h2>
            <?php
            $totalVenta = 0;
            $totalCantidad = 0;
            foreach ($products as $product) {
                $precioTotalProducto = $product['producto_precio'] * $product['producto_cantidad'];
                $totalVenta += $precioTotalProducto;
                $totalCantidad += $product['producto_cantidad'];
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
            <a href="/page/payprocess">
                <button class="w-full p-x3 p-1 text-white font-bold bg-violet-600 rounded-md">Continuar</button>    
            </a>
        </div>
    </div>
</main>

<script src="/public/js/cart.js"></script>