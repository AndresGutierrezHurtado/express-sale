<main class="w-full px-3">
    <div  class="w-full max-w-[1200px] mx-auto py-12 space-y-5">
        <div class="w-full p-5 md:p-10 bg-white rounded-lg shadow-lg flex flex-col md:flex-row gap-10">
            <!-- Imagen -->
            <div class="w-full max-w-[500px] divide-y-2 divide-black border-2 border-black rounded overflow-hidden">
                <div class="w-full h-[250px] bg-slate-800">
                    <img src="<?= $product['producto_imagen_url'] ?>" alt="Imagen de <?= $product['producto_nombre'] ?>"
                    class="object-contain w-full h-full">
                </div>
                <div class="w-full h-[150px] flex p-5 gap-5">
                    <!-- Multimedia -->
                    <div class="w-auto max-w-[200px] h-full">
                        <img src="<?= $product['producto_imagen_url'] ?>" alt="Imagen de <?= $product['producto_nombre'] ?>" 
                        class="object-contain w-full h-full border border-gray-400 rounded duration-300 hover:scale-[1.01] hover:shadow-md">
                    </div>

                    <?php foreach($product['multimedia'] ?? [] as $file):?>
                        <div class="w-auto max-w-[200px] h-full overflow-x-scroll flex items-center justify-center">
                            <?php if ($file['multimedia_tipo'] == 'imagen') :?>
                                <img src="<?= $file['multimedia_url'] ?>" alt="archivo multimedia"
                                class="object-contain w-full h-full border border-gray-400 rounded duration-300 hover:scale-[1.01] hover:shadow-md">
                            <?php else:?>
                                <video class="object-contain w-full h-full border border-gray-400 rounded duration-300 hover:scale-[1.01] hover:shadow-md">
                                    <source src="<?= $file['multimedia_url'] ?>" type="video/mp4">
                                    Tu navegador no soporta video HTML5.
                                </video>
                            <?php endif;?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="w-full space-y-5">
                <div class="w-full flex flex-col md:flex-row justify-between items-start">
                    <!-- Titulo y vendedor -->
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight"> <?= $product['producto_nombre'] ?> </h1>
                        <a href="/page/sellers/?seller=<?= $product['usuario_id'] ?>" class="text-gray-600/60 text-sm font-semibold cursor-pointer hover:underline hover:text-violet-600">
                            Publicado por <?= $product['usuario_alias'] ?>
                        </a>
                    </div>
                    
                    <!-- Calificaciones -->
                    <div class="flex items-center text-md">
                        <i class="fa-solid fa-star text-yellow-500"></i>
                        <p class="ms-2 font-bold text-gray-900"><?= $product['calificacion_promedio'] ?></p>
                        <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                        <a class="font-medium text-gray-900  hover:underline cursor-pointer" onclick="toggleComments()"><?= $product['numero_calificaciones'] ?> comentarios</a>
                    </div>
                </div>

                <p><?= $product['producto_descripcion'] ?></p>
                
                <div>
                    <h4 class="font-bold text-2xl tracking-tight"><?= number_format($product['producto_precio']) ?> COP</h4>
                    <p class="text-gray-600 font-semibold text-sm">Disponibles: <?= $product['producto_cantidad'] ?></p>
                </div>
                <!-- Agregar al carrito -->
                <button type="submit" data-producto-id="<?= $product['producto_id'] ?>"
                class="btn-add-cart group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-cart-plus text-[17px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                    </span>
                    Agregar al carrito
                </button>
            </div>
        </div>

        <!-- Sección comentarios -->
        <div class="w-full p-5 md:p-10 bg-white rounded-lg shadow-lg flex gap-10 hidden" id="comment-box">
            <div class="space-y-5 w-full md:w-1/2">
                <h2 class="text-3xl font-bold tracking-tight">Estadísticas</h2>
                <div class="flex gap-10 w-full justify-center">
                    <!-- Calificacion promedio -->
                    <div class="flex flex-col justify-center items-center">
                        <h1 class="text-[50px] font-bold"><?= $product['calificacion_promedio'] ?></h1>
                        <span class="flex items-center text-[15px] text-violet-500">
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
                        <p class="mt-1 text-black/[0.6] "> <i class="fa-solid fa-user text-[13px]"></i> <?= $product['numero_calificaciones'] ?> </p> 
                    </div>
                    <!-- Barras de calificaciones -->
                    <div class="w-full flex flex-col gap-0 max-w-[350px]">
                        <span class="flex items-center gap-2">
                            <p>5</p> 
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $product['numero_calificaciones'] < 1 ? '0' : ($product['calificaciones_5'] / $product['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                        <span class="flex items-center gap-2">
                            <p>4</p>
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $product['numero_calificaciones'] < 1 ? '0' : ($product['calificaciones_4'] / $product['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                        <span class="flex items-center gap-2">
                            <p>3</p>
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $product['numero_calificaciones'] < 1 ? '0' : ($product['calificaciones_3'] / $product['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                        <span class="flex items-center gap-2">
                            <p>2</p>
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $product['numero_calificaciones'] < 1 ? '0' : ($product['calificaciones_2'] / $product['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                        <span class="flex items-center gap-2">
                            <p>1</p>
                            <div class="w-full bg-gray-200 h-[6px] rounded-xl overflow-hidden">
                                <div class="bg-violet-500 h-full" style="width: <?= $product['numero_calificaciones'] < 1 ? '0' : ($product['calificaciones_1'] / $product['numero_calificaciones']) * 100 ?>%"></div>
                            </div>
                        </span>
                    </div>
                </div>

                <!-- Agregar comentario -->
                <div class="space-y-3">
                    <h4 class="text-lg font-semibold">Agrega tu comentario:</h4>
                    
                    <form action="/calification/rate" method="POST" enctype="multipart/form-data" class="space-y-3 modal">
                        <div id="stars" class="flex items-center justify-center gap-2 text-[25px]">
                            <span class="star starProducto" data-value="1"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                            <span class="star starProducto" data-value="2"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                            <span class="star starProducto" data-value="3"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                            <span class="star starProducto" data-value="4"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                            <span class="star starProducto" data-value="5"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                        </div>
                        <div class="w-full rounded-[100px] bg-gray-200 px-4 py-2 flex items-center gap-4">
                            <input type="hidden" name="product_id" value="<?= $product['producto_id'] ?>">
                            <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                            <input type="hidden" name="tipo_objeto" value="producto">
                            <input type="hidden" name="calificacion" value="producto">
    
                            <label for="fileUpload" class="cursor-pointer">
                                <input type="file" id="fileUpload" class="hidden" name="calificacion_imagen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd" d="M9 7a5 5 0 0 1 10 0v8a7 7 0 1 1-14 0V9a1 1 0 0 1 2 0v6a5 5 0 0 0 10 0V7a3 3 0 1 0-6 0v8a1 1 0 1 0 2 0V9a1 1 0 1 1 2 0v6a3 3 0 1 1-6 0z" clip-rule="evenodd"></path>
                                </svg>
                            </label>
                            <input type="text" placeholder="Escribe un comentario..." name="calificacion_comentario"
                            class="w-full border-0 bg-transparent focus:outline-none placeholder:text-gray-400 text-lg">
                            <button class="bg-violet-600 py-1 px-3 rounded-lg text-violet-400 hover:bg-violet-700 hover:text-violet-300 duration-300">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- sección de comentarios -->
            <div class="space-y-5 w-full md:w-1/2">
                <h2 class="text-3xl font-bold tracking-tight">Comentarios</h2>
                <!-- Caja de comentarios -->
                <div class="space-y-3">
                    <?php if(!isset($product['calificaciones']) || count($product['calificaciones']) < 1) :?>
                        <p class="text-lg text-gray-600">Aún no hay comentarios</p>
                    <?php endif;?>

                    <?php foreach( $product['calificaciones'] as $calification):?>

                        <article class="w-full space-y-2">
                            <span class="w-full flex items-center justify-between">
                                <!-- Información del usuario -->
                                <div>
                                    <div class="flex gap-2 items-center">
                                        <div class="w-12 h-12 rounded-full overflow-hidden ">
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
                                            <li class="px-3 py-1 hover:bg-gray-100 cursor-pointer" onclick="toggleModal('Producto<?= $calification['calificacion_id'] ?>')"> <i class="fa-solid fa-pen text-sm mr-1"></i> Editar</li>
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
                                <div class="w-auto max-w-[200px] h-[200px] mx-auto">
                                    <img src="<?= $calification['calificacion_imagen_url']?>" alt="Imagen de comentario" class="object-contain h-full w-full">
                                </div>
                            <?php endif;?>
                        </article>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modales -->
<?php foreach($product['calificaciones'] as $calification) :?>
<div class="fixed inset-0 z-50 hidden modal" id="modalProducto<?= $calification['calificacion_id'] ?>">
    <!-- Fondo oscuro -->
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleModal('Producto<?= $calification['calificacion_id'] ?>')"></div>
    <!-- Espacio modal -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-full max-w-[500px]">
        <div class="w-full bg-white p-5 rounded-md space-y-5">
            <div>                
                <span class="w-full flex justify-between items-center">
                    <h1 class="text-xl font-bold tracking-tight">Califica el vendedor</h1>
                    <button class="duration-300 hover:text-gray-700" onclick="toggleModal('Producto<?= $calification['calificacion_id'] ?>')">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </span>
                <p>Ten en cuenta la calidad de sus productos ofrecidos y la rapidez de entrega.</p>
            </div>
            <form id="rating-form" class="space-y-5" action="/calification/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="calificacion_id" value="<?= $calification['calificacion_id'] ?>">
                <input type="hidden" name="producto_id" value="<?= $product['producto_id'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                <input type="hidden" name="tipo_objeto" value="producto">
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
        if (document.getElementById('btn-show-comments')) {
            document.getElementById('btn-show-comments').innerHTML = visible ? 'Ocultar comentarios' : 'Ver comentarios' ;
        }
    }
</script>

