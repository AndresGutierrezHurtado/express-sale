<?php
function obtenerDistancia($origen, $destino) {
    $data = json_decode(file_get_contents( "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".urlencode($origen)."&origins=".urlencode($destino)."&units=meters&key=" . API_MAPS ), true);

    $data['status'] == 'OK' ? $data = $data['rows'][0]['elements'][0] : $data = 0;
    return $data;
}
?>

<main class="w-full min-h-screen flex justify-center items-center bg-gray-100">
    <div class="w-full max-w-[1200px] my-12">
        <a href="/">
            <div class="h-[200px] w-[200px] rounded-full mx-auto">
                <img src="/public/images/logo.png" alt="Logo Express Sale">
            </div>
        </a>
        <div class="w-full bg-slate-700 px-7 p-5 rounded-lg mb-5">
            <h1 class="tracking-tight font-bold text-white text-3xl">Lista de envíos pendientes: </h1>
        </div>
        <div class="space-y-5">
            <!-- Si no hay envíos para hacer -->
            <?php if (count($orders) < 1) : ?>
                <h1 class="text-center text-2xl font-bold">No se encontraron envíos disponibles...</h1>
            <?php endif;?>
            <!-- cada articulo-->
            <?php foreach($orders as $order): ?>
                <article class="p-5 w-full bg-white rounded-lg shadow-lg flex justify-between">
                    <div class="flex flex-col gap-1">                            
                        <h1 class="font-bold text-2xl">Envio para <?= $order['comprador_nombre'] ?></h1>
                        <div class="flex gap-2 my-2">
                            
                            <p class="font-bold">Ruta:</p>
                            <p class="text-[13px]"> <strong>Desde:</strong>
                                <?php 
                                    $productos = $order['productos'];
                                    $totalProductos = count($productos);
                                    $distancia_total = 0;

                                    foreach($order['productos'] as $i => $producto) {
                                        $origen = $productos[$i]['usuario_direccion'];
                                        $destino = ($i == count($productos) - 1) ? $destino = $order['envio_direccion'] : $destino = $productos[$i]['usuario_direccion'] ;
                                    
                                        $distancia_total += obtenerDistancia($origen, $destino)['distance']['value'];
                                    }

                                    $contador = 0;
                                    
                                    foreach ($productos as $producto){
                                        echo $producto['usuario_direccion'];
                                        if (++$contador < $totalProductos): ?>
                                            <br> <strong>luego por:</strong>
                                        <?php endif;
                                    }
                                    ?>
                                <br><strong>Hasta:</strong> <?= $order['envio_direccion'] ?>
                            </p>
                        </div>
                        <p><strong>Distancia:</strong> <?= $distancia_total / 1000 ?> Km </p>
                        <p><strong>Pago:</strong> <?= number_format($distancia_total > 10000 ? 10000 : 7000) ?> COP </p>
                        <p><strong>Fecha:</strong> <?= $order['pedido_fecha'] ?></p>
                    </div>
                    <a href="/page/shipment/?shipment=<?= $order['pedido_id']?>">
                        <button class="px-3 p-1 border-2 border-green-500 rounded-lg text-green-500 font-bold flex gap-3 items-center hover:bg-gray-100 duration-300"> <i class="fa-solid fa-circle-check "></i> Realizar Envío</button>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>