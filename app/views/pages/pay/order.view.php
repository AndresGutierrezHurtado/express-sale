<div class="w-full max-w-[700px] mx-auto py-8">
    <div class="bg-white p-8 rounded-lg shadow-lg flex flex-col gap-5">
        <div class="flex flex-col items-center">
            <div class="size-[160px]">
                <img src="/public/images/logo.png" alt="Logo express sale" class="object-contain w-full h-full">
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-10 md:gap-2 md:justify-between">
            <div class="space-y-2 w-full max-w-[315px]">
                <h1 class="text-3xl font-bold tracking-tight">Detalles de la compra</h1>
                <div>
                    <p>
                        <strong>Nombre:</strong> 
                        <?= $order['comprador_nombre'] ?></p>
                    <p>
                        <strong>Email:</strong> 
                        <?= $order['comprador_correo'] ?>
                    </p>
                    <p>
                        <strong>Teléfono:</strong> 
                        <?= $order['comprador_telefono'] ?>
                    </p>
                    <p>
                        <strong>Dirección de entrega:</strong> 
                        <?= $order['envio_direccion'] ?>
                    </p> 
                </div>
            </div>

            <!-- Información adicional -->
            <div class="space-y-4 w-full max-w-[280px]">
                <h1 class="text-2xl font-bold tracking-tight">Información adicional</h1>
                <div>
                    <p>
                        <strong>Fecha:</strong> 
                        <?= explode(" ", $order['pedido_fecha'])[0] ?>
                    </p>
                    <p>
                        <strong>Domiciliario:</strong> 
                        <a href="<?= isset($order['domiciliario_id']) ? '/page/deliveries/?delivery=' . $order['domiciliario_id'] : '' ?>" class="text-gray-600 text-sm font-semibold cursor-pointer hover:underline hover:text-violet-600">  
                            <?= isset($order['domiciliario_id']) ? $order['domiciliario_alias'] : 'pendiente' ?> 
                        </a>
                    </p>
                    <p>
                        <strong>Precio total:</strong> 
                        <?= number_format($order['pago_valor'], 2) ?> COP
                    </p>
                    <p>
                        <strong>Estado:</strong> 
                        <?= ucfirst($order['pedido_estado']) ?>
                    </p>
                    <?php if ($order['pedido_estado'] == 'entregado' || $order['pedido_estado'] == 'recibido') :?>
                        <p>
                            <strong>Fecha entrega:</strong> 
                            <?= explode(" ",$order['fecha_entrega'])[0] ?>
                        </p>
                        <p>
                            <strong>Hora entrega:</strong> 
                            <?= explode(" ",$order['fecha_entrega'])[1] ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr>
        <!-- Información de la compra -->
        <div>
            <h2 class="text-3xl font-bold mb-4">Productos</h2>
            
            <div class="space-y-5 py-5">
                <?php foreach($order['productos'] as $product): ?>
                    <article class="flex flex-col md:flex-row items-center justify-center p-5 border rounded-md gap-5">
                        <div class="w-[150px] flex-none">
                            <img src="<?= $product['producto_imagen_url'] ?>" alt="<?= $product['producto_nombre'] ?>" class="h-full w-full object-cover">
                        </div>
                        <div class="flex flex-col justify-between w-full min-w-[1fr] space-y-5">
                            <div>
                                <h1 class="text-2xl font-semibold"><?= $product['producto_nombre'] ?></h1>
                                <p class="text-gray-600"> 
                                    <strong class="font-semibold">Vendedor:</strong> 
                                    <a href="/page/sellers/?seller=<?= $product['usuario_id'] ?>" class="text-gray-600/80 text-sm font-semibold cursor-pointer hover:underline hover:text-violet-600">
                                        <?= $product['usuario_alias'] ?>
                                    </a>
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">
                                <strong class="font-semibold">Precio:</strong> 
                                    <?= number_format($product['producto_precio'], 2) ?> COP
                                </p>
                                <p class="text-gray-600">
                                <strong class="font-semibold">Cantidad:</strong> 
                                    <?= $product['producto_cantidad'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center min-w-[100px] flex-none">
                            <p class="text-lg font-semibold"><?= number_format($product['producto_precio'] * $product['producto_cantidad'], 2) ?> COP</p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <hr>

        <div class="flex flex-col gap-2">
            <!-- Botón para descargar y regresar -->
            <a href="/page/receipt/?receipt=<?= $order['pedido_id'] ?>" target="_blank" >
                <button
                class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-download text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                    </span>
                    Descargar factura
                </button>
            </a>
            <?php if($order['pedido_estado'] == 'entregado'): ?>
                <button id="check-button" onclick="if (confirm('¿Estás seguro que recibiste tu pedido?')) { checkOrder(<?= $order['pedido_id'] ?>) }"
                class="group relative flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-circle-check text-[18px] text-green-500 duration-300 group-hover:text-green-400"></i>
                    </span>
                    Marcar como recibido
                </button>
            <?php endif; ?>
            <a href="/page/profile/?id=<?= $order['usuario_id'] ?>">
                <button
                class="group relative flex w-full justify-center rounded-md border border-transparent bg-gray-100 px-4 py-2 text-sm font-medium text-black hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-arrow-left text-[17px] text-gray-300 duration-300 group-hover:text-gray-500"></i>
                    </span>
                    Volver
                </button>
            </a>
        </div>
    </div>
</div>

<script>
    function checkOrder (id) {
        const data = new FormData();
        data.append('pedido_id', id);
        data.append('pedido_estado', 'recibido');
        data.append('trabajador_numero_trabajos', <?= $order['trabajador_numero_trabajos'] + 1 ?>);

        fetch('/order/update', {
        method: 'POST',
        body: data,
        })
        .then(Response => Response.json())
        .then(Data => {
            console.log(Data);
            if (Data.success) {
                alert(Data.message)
                window.location.reload();
            } else {
                alert(Data.message)
            }
        });
    }
</script>