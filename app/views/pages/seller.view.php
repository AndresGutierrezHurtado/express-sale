<?php
function buildQueryString( $add = [], $remove = []) {
    $params = $_GET;
    $queryString = '?';
    foreach ($params as $key => $param) {
        if (!in_array($key, $remove) && !array_key_exists($key, $add)) {
            $queryString.= $key . '=' . $param . '&';
        }
    }
    foreach ($add as $key => $param) {
        $queryString.= $key . '=' . $param . '&';
    }
    $queryString = rtrim($queryString, '&');
    return $queryString;
}
?>
<main class="w-full max-w-[1200px] mx-auto py-10 flex flex-col md:flex-row justify-between gap-10">
    <!-- Vendedor contenedor -->
    <div class="w-full max-w-[450px] space-y-5">
        <div class="w-full bg-white p-6 rounded-lg shadow-md h-fit flex flex-col gap-5">

            <h3 class="text-2xl font-bold tracking-tight">Información del vendedor:</h3>

            <div class="flex flex-col sm:flex-row items-center gap-4">
                <div class="w-24 h-24 rounded-full overflow-hidden">
                    <img src="<?= $seller['usuario_imagen_url'] ?>" alt="Foto de <?= $seller['usuario_nombre'] ?>" class="object-cover w-full h-full">
                </div>
                <div class="w-full ">
                    <h2 class="text-xl font-bold"><?= $seller['usuario_nombre'] . " " . $seller['usuario_apellido'] ?></h2>
                    <p class="text-sm text-gray-600">
                        Ubicación: 
                        <?= $seller['usuario_direccion'] ?? 'Sin ubicación' ?>
                    </p>
                    <p class="text-sm text-gray-600">
                        Número: 
                        <?= $seller['usuario_numero'] ?? 'sin numero' ?>
                    </p>
                    <p class="text-sm text-gray-600"> <?= $seller['trabajador_numero_trabajos'] ?> productos vendidos </p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-semibold">Calificaciones:</h3>
                <div class="flex gap-5 w-full">
                    <div class="flex flex-col justify-center items-center">
                        <h1 class="text-[40px] font-semibold"><?= $seller['calificacion_promedio'] ?></h1>
                        <span class="flex items-center text-[15px] text-violet-500">
                            <?php
                                $calificacion = $seller['calificacion_promedio'];
                                $calificacionEntera = floor($calificacion);
                                $fraccion = $calificacion - $calificacionEntera;

                                for ($i = 0; $i < $calificacionEntera; $i++) {
                                    echo '<i class="fa-solid fa-star"></i>';
                                }
                                
                                if ($fraccion >= 0.5) {
                                    echo '<i class="fa-solid fa-star-half-stroke"></i>';
                                    $calificacionEntera++;
                                }

                                for ($i = $calificacionEntera; $i < 5; $i++) {
                                    echo '<i class="fa-regular fa-star"></i>';
                                }
                            ?>
                        </span>
                        <p class="mt-1 text-black/[0.6] "> <i class="fa-solid fa-user text-[13px]"></i> <?= $seller['numero_calificaciones'] ?> </p> 
                    </div>
                    <div class="w-full flex flex-col gap-0">
                        <span class="flex items-center gap-2">
                            <p>5</p> 
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $seller['numero_calificaciones'] < 1 ? '0' : ($seller['calificaciones_5'] / $seller['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                        <span class="flex items-center gap-2">
                            <p>4</p>
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $seller['numero_calificaciones'] < 1 ? '0' : ($seller['calificaciones_4'] / $seller['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                        <span class="flex items-center gap-2">
                            <p>3</p>
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $seller['numero_calificaciones'] < 1 ? '0' : ($seller['calificaciones_3'] / $seller['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                        <span class="flex items-center gap-2">
                            <p>2</p>
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $seller['numero_calificaciones'] < 1 ? '0' : ($seller['calificaciones_2'] / $seller['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                        <span class="flex items-center gap-2">
                            <p>1</p>
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $seller['numero_calificaciones'] < 1 ? '0' : ($seller['calificaciones_1'] / $seller['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="flex gap-5 justify-between">
                    <button onclick="<?= isset($_SESSION['usuario_id']) ? "toggleModal('vendedor')" : "login()" ?>"
                    class="px-5 py-1 w-fit bg-violet-600 text-white font-bold rounded-lg duration-300 hover:bg-violet-400" > Calificar </button>
                    
                    <button onclick="toggleComments()" class="text-violet-600 font-bold decoration-violet-600 hover:underline" id="btn-show-comments"> Ver comentarios </button>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Descripción:</h3>
                <p><?= $seller['trabajador_descripcion'] ?></p>
            </div>
        </div>

        <!-- Caja de comentarios -->
        <div class="w-full p-5 bg-white rounded-lg shadow-lg hidden" id="comment-box">
            <h3 class="text-2xl font-bold tracking-tight">Comentarios:</h3>
            <div class="w-full divide-y divide-y-gray-300">

                <?php if (count($califications) < 1): ?> 
                    <p class="text-lg mt-5 font-semibold text-gray-800/70">No hay calificaciones...</p>
                <?php endif; ?>
                
                <?php foreach ($califications as $calification): ?>

                    <article class="w-full space-y-2 py-4">
                        <span class="w-full flex items-center justify-between">
                            <!-- Información del usuario -->
                            <div>
                                <div class="flex gap-2 items-center">
                                    <div class="w-16 h-16 rounded-full">
                                        <img src="<?= $calification['usuario_imagen_url'] ?>" alt="Foto de <?= $calification['usuario_alias'] ?>" class="object-cover w-full h-full">
                                    </div>
                                    <p class="font-semibold tracking-tight"><?= $calification['usuario_alias'] ?></p> -
                                    <p class="text-[14px] text-gray-500/80 font-semibold">  <?= explode(' ', $calification['calificacion_fecha'])[0] ?></p>
                                </div>

                                <!-- Calificación -->
                                <span class="inline-flex">
                                    <?php
                                        $calificacion = $calification['calificacion'];
                                        $calificacionEntera = floor($calificacion);
                                        $fraccion = $calificacion - $calificacionEntera;

                                        for ($i = 0; $i < $calificacionEntera; $i++) {
                                            echo '<i class="fa-solid fa-star text-violet-600"></i>';
                                        }
                                        
                                        for ($i = $calificacionEntera; $i < 5; $i++) {
                                            echo '<i class="fa-solid fa-star text-gray-300"></i>';
                                        }
                                    ?>
                                </span>
                            </div>

                            <!-- Botón desplegable de calificación -->
                            <div class="relative">
                                <button onclick="<?= isset($_SESSION['usuario_id']) ? "toggleOptions('dropdown-" . $calification['calificacion_id'] . "')" : 'login()' ?>">
                                    <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                                </button>
                                <ul class="absolute top-[-25px] right-0 translate-x-1/2 translate-y-1/2 bg-white p-2 rounded-lg shadow w-[200px] text-center z-10 hidden" id="dropdown-<?= $calification['calificacion_id'] ?>">
                                    <?php if ($calification['usuario_id'] == $_SESSION['usuario_id'] || $_SESSION['rol_id'] == 4):?>
                                        <li class="px-3 py-1 hover:bg-gray-100 cursor-pointer" onclick="toggleModal('vendedor<?= $calification['calificacion_id'] ?>')"> <i class="fa-solid fa-pen text-sm mr-1"></i> Editar</li>
                                        <form action="/calification/delete" method="post" onsubmit="return confirm('¿Seguro que quieres eliminar este comentario?, esta acción es irreversible.')" class="w-full">
                                            <input type="hidden" name="calificacion_id" value="<?= $calification['calificacion_id'] ?>">
                                            <button type="submit" class="px-3 py-1 hover:bg-gray-100 cursor-pointer text-red-500 w-full"> <i class="fa-solid fa-trash text-sm mr-1"></i> Eliminar</button>
                                        </form>
                                    <?php endif; ?>
                                    <li class="px-3 py-1 hover:bg-gray-100 cursor-pointer text-red-500" onclick="setTimeout(() => {alert('Elemento reportado.'); window.location.href= window.location.href;}, 1000)"> <i class="fa-solid fa-flag text-sm mr-1"></i> Reportar</li>
                                </ul>
                            </div>
                        </span>

                        <p> <?= $calification['calificacion_comentario'] ?></p>
                        <?php if($calification['calificacion_imagen_url']):?>
                            <div class="w-full h-[230px] mx-auto">
                                <img src="<?= $calification['calificacion_imagen_url']?>" alt="Imagen de comentario" class="object-contain h-full w-full">
                            </div>
                        <?php endif;?>


                    </article>

                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Productos contenedor -->
    <div class="w-full p-5 bg-white rounded-lg space-y-5 h-fit">
        <h3 class="text-2xl font-bold tracking-tight">Productos:</h3>
        <div class="w-full divide-y divide-gray-300">
            <?php foreach ($products['data'] as $product): ?>

                <article class="w-full bg-white p-5 flex flex-col sm:flex-row gap-4 my-2">
                    <!-- Imagen -->
                    <a href="/page/product/?product=<?= $product['producto_id'] ?>" class="block w-full max-w-[230px] h-[240px] mx-auto">
                        <div class="w-full max-w-[230px] h-[240px] mx-auto">
                        <img src="<?= $product['producto_imagen_url'] ?>" alt="Imagen de <?= $product['producto_nombre'] ?>" class="object-contain h-full w-full">
                        </div>
                    </a>

                    <!-- Contenido -->
                    <div class="flex flex-col justify-between space-y-5 sm:space-y-3 grow">
                        <!-- Información del producto -->
                        <div class="space-y-3">
                            <div class="flex justify-between items-center w-full">
                                <div>
                                    <h3 class="font-semibold text-2xl"><?= $product['producto_nombre'] ?></h3>
                                    <a href="/page/sellers/?seller=<?= $product['usuario_id'] ?>" class="text-gray-600/60 text-sm font-semibold cursor-pointer hover:underline hover:text-violet-600">
                                        Publicado por <?= $product['usuario_alias'] ?>
                                    </a>
                                </div>
                                <p class="text-gray-600/60 text-sm font-semibold hidden sm:block"><?= explode(' ', $product['producto_fecha'])[0] ; ?></p>
                            </div>
                            <p><?= $product['producto_descripcion'] ?></p>
                        </div>

                        <!-- Precio y calificacion -->
                        <span class="w-full flex flex-col sm:flex-row items-center justify-between">
                            <h4 class="text-lg font-bold"><?= number_format($product['producto_precio']) ?> COP</h4>
                            <div class="flex gap-3 items-center justify-end">
                                <!-- Calificación -->
                                <div>
                                    <span class="inline-flex">
                                        <?php
                                            $calificacion = $product['calificacion_promedio'];
                                            $calificacionEntera = floor($calificacion);
                                            $fraccion = $calificacion - $calificacionEntera;

                                            for ($i = 0; $i < $calificacionEntera; $i++) {
                                                echo '<i class="fa-solid fa-star text-violet-600"></i>';
                                            }
                                            
                                            if ($fraccion >= 0.5) {
                                                echo '
                                                <div class="relative w-[18px] h-[16px]">
                                                    <i class="fa-solid fa-star-half text-violet-600 absolute left-0"></i>
                                                    <i class="fa-solid fa-star-half text-gray-300 transform scale-x-[-1] absolute right-0"></i>
                                                </div>
                                                ';
                                                $calificacionEntera++;
                                            }

                                            for ($i = $calificacionEntera; $i < 5; $i++) {
                                                echo '<i class="fa-solid fa-star text-gray-300"></i>';
                                            }
                                        ?>
                                    </span>
                                    <div class="flex w-full justify-between text-sm text-gray-600/90 font-semibold">
                                        <p><?= $product['calificacion_promedio'] ?></p>
                                        <p>
                                            <?= $product['numero_calificaciones'] ?>
                                            <i class="fa-solid fa-user"></i>
                                        </p>
                                    </div>
                                </div>
                                <!-- Calificar producto -->
                                <button 
                                class="size-[30px] bg-violet-600 text-white rounded-md duration-300 hover:bg-violet-800 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"  onclick="<?= isset($_SESSION['usuario_id']) ? "toggleModal(" . $product['producto_id'] . ")" : "login()" ?>">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </span>
                        
                        <!-- Agregar al carrito -->
                        <button type="submit" data-producto-id="<?= $product['producto_id'] ?>"
                        class="btn-add-cart group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-cart-plus text-[17px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                            </span>
                            Agregar al carrito
                        </button>
                    </div>
                </article>

            <?php endforeach; ?>
        </div>

        <!-- Paginacion -->
        <div class="w-full bg-white p-3 flex gap-3 justify-center">
            
            <?php if($page > 1): ?>
                <a href="/page/sellers/<?= buildQueryString(['page' => $page - 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> anterior </a>
            <?php else: ?>
                <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> anterior </a>
            <?php endif; ?>

            <?php for($i = 1; $i <= $products['pages']; $i++): ?>
                <a href="/page/sellers/<?= buildQueryString(['page' => $i]) ?>" class="font-semibold bg-gray-200 size-[30px] flex items-center justify-center rounded-sm duration-300 <?= $i == $page ? 'bg-gray-400 font-bold' : ' hover:bg-gray-300' ?>"> <?= $i ?> </a>
            <?php endfor; ?>
            
            <?php if($page < $products['pages']): ?>
                <a href="/page/sellers/<?= buildQueryString(['page' => $page + 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> siguiente </a>
            <?php else: ?>
                <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> siguiente </a>
            <?php endif; ?>

        </div>
    </div>
</main>

<!-- Modal vendedor -->
<div class="fixed inset-0 z-50 hidden modal" id="modalvendedor">
    <!-- Fondo oscuro -->
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleModal('vendedor')"></div>
    <!-- Espacio modal -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-full max-w-[500px]">
        <div class="w-full bg-white p-5 rounded-md space-y-5">
            <div>                
                <span class="w-full flex justify-between items-center">
                    <h1 class="text-xl font-bold tracking-tight">Califica el vendedor</h1>
                    <button class="duration-300 hover:text-gray-700" onclick="toggleModal('vendedor')">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </span>
                <p>Ten en cuenta la calidad de sus productos ofrecidos y la rapidez de entrega.</p>
            </div>
            <form id="rating-form" class="space-y-5" action="/calification/rate" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="vendedor_id" value="<?= $seller['usuario_id'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                <input type="hidden" name="tipo_objeto" value="usuario">
                <input type="hidden" name="calificacion">

                <div class="w-full space-y-2">
                    <label for="calificacion_comentario" class="text-sm font-semibold text-gray-700">Mensaje</label>
                    <textarea id="calificacion_comentario" name="calificacion_comentario" required
                    class="w-full h-32 p-2 border resize-none rounded-lg focus:border-violet-600 focus:outline-none" placeholder="Mensaje..."></textarea>
                </div>
                <div class="space-y-2">
                    <label for="calificacion_imagen_url" class="text-sm font-semibold text-gray-700">Imagen</label> <br>
                    <input type="file" name="calificacion_imagen" id="calificacion_imagen"
                    class="file:bg-violet-600/80 file:text-white file:px-4 file:py-1 file:cursor-pointer file:border-0 file:rounded-md file:font-semibold file:text-sm file:hover:bg-violet-700 file:duration-300">
                </div>
                <div id="stars" class="flex items-center justify-center gap-2 text-[25px]">
                    <span class="star starProducto" data-value="1"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="2"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="3"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="4"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="5"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                </div>
                <button id="calificar-btn" class="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
            </form>

        </div>
    </div>
</div>

<!-- Modal vendedor calificaciones -->
<?php foreach($califications as $calification) :?>
<div class="fixed inset-0 z-50 hidden modal" id="modalvendedor<?= $calification['calificacion_id'] ?>">
    <!-- Fondo oscuro -->
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleModal('vendedor<?= $calification['calificacion_id'] ?>')"></div>
    <!-- Espacio modal -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-full max-w-[500px]">
        <div class="w-full bg-white p-5 rounded-md space-y-5">
            <div>                
                <span class="w-full flex justify-between items-center">
                    <h1 class="text-xl font-bold tracking-tight">Califica el vendedor</h1>
                    <button class="duration-300 hover:text-gray-700" onclick="toggleModal('vendedor<?= $calification['calificacion_id'] ?>')">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </span>
                <p>Ten en cuenta la calidad de sus productos ofrecidos y la rapidez de entrega.</p>
            </div>
            <form id="rating-form" class="space-y-5" action="/calification/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="calificacion_id" value="<?= $calification['calificacion_id'] ?>">
                <input type="hidden" name="vendedor_id" value="<?= $seller['usuario_id'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                <input type="hidden" name="tipo_objeto" value="usuario">
                <input type="hidden" name="calificacion">

                <div class="w-full space-y-2">
                    <label for="calificacion_comentario" class="text-sm font-semibold text-gray-700">Mensaje</label>
                    <textarea id="calificacion_comentario" name="calificacion_comentario" required
                    class="w-full h-32 p-2 border resize-none rounded-lg focus:border-violet-600 focus:outline-none" placeholder="Mensaje..."><?= $calification['calificacion_comentario'] ?></textarea>
                </div>
                <div class="space-y-2">
                    <label for="calificacion_imagen_url" class="text-sm font-semibold text-gray-700">Imagen</label> <br>
                    <input type="file" name="calificacion_imagen" id="calificacion_imagen"
                    class="file:bg-violet-600/80 file:text-white file:px-4 file:py-1 file:cursor-pointer file:border-0 file:rounded-md file:font-semibold file:text-sm file:hover:bg-violet-700 file:duration-300">
                </div>
                <div id="stars" class="flex items-center justify-center gap-2 text-[25px]">
                    <span class="star starProducto" data-value="1"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="2"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="3"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="4"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="5"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                </div>
                <button id="calificar-btn" class="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
            </form>

        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modales -->
<?php foreach($products['data'] as $product): ?>
<div class="fixed inset-0 z-50 hidden modal" id="modal<?= $product['producto_id'] ?>">
    <!-- Fondo oscuro -->
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleModal(<?= $product['producto_id'] ?>)"></div>
    <!-- Espacio modal -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-full max-w-[500px]">
        <div class="w-full bg-white p-5 rounded-md space-y-5">
            <div>                
                <span class="w-full flex justify-between items-center">
                    <h1 class="text-xl font-bold tracking-tight">Califica el producto</h1>
                    <button class="duration-300 hover:text-gray-700" onclick="toggleModal(<?= $product['producto_id'] ?>)">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </span>
                <p>Ten en cuenta la calidad del producto y tiempo de envío.</p>
            </div>
            <form id="rating-form" class="space-y-5" action="/calification/rate" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= $product['producto_id'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                <input type="hidden" name="tipo_objeto" value="producto">
                <input type="hidden" name="calificacion">

                <div class="w-full space-y-2">
                    <label for="calificacion_comentario" class="text-sm font-semibold text-gray-700">Mensaje</label>
                    <textarea id="calificacion_comentario" name="calificacion_comentario" required
                    class="w-full h-32 p-2 border resize-none rounded-lg focus:border-violet-600 focus:outline-none" placeholder="Mensaje..."></textarea>
                </div>
                <div class="space-y-2">
                    <label for="calificacion_imagen_url" class="text-sm font-semibold text-gray-700">Imagen</label> <br>
                    <input type="file" name="calificacion_imagen" id="calificacion_imagen"
                    class="file:bg-violet-600/80 file:text-white file:px-4 file:py-1 file:cursor-pointer file:border-0 file:rounded-md file:font-semibold file:text-sm file:hover:bg-violet-700 file:duration-300">
                </div>
                <div id="stars" class="flex items-center justify-center gap-2 text-[25px]">
                    <span class="star starProducto" data-value="1"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="2"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="3"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="4"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    <span class="star starProducto" data-value="5"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                </div>
                <button id="calificar-btn" class="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
            </form>

        </div>
    </div>
</div>
<?php endforeach; ?>


<script src="/public/js/cart.js"></script>
<script src="/public/js/califications.js"></script>
<script>
    let visible = false;
    
    function login () {
        if (confirm('Para calificar un producto debes iniciar sesión.')) {
            window.location.href = '/page/login';
        }
    }

    function toggleOptions(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    function toggleComments() {
        document.getElementById('comment-box').classList.toggle('hidden');
        visible = !visible;
        document.getElementById('btn-show-comments').innerHTML = visible ? 'Ocultar comentarios' : 'Ver comentarios' ;
    }
</script>
    