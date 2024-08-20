<main class="w-full px-3">
    <div class="w-full max-w-[1200px] mx-auto py-12 space-y-5">
        <div class="w-full p-5 md:p-10 bg-white rounded-lg shadow-lg flex flex-col md:flex-row gap-10">
            <!-- Imagen -->
            <div class="w-full max-w-[500px] divide-y-2 divide-black border-2 border-black rounded overflow-hidden">
                <!-- Imagen principal -->
                <div class="w-full h-[250px] bg-slate-800">
                    <img id="main-media" src="<?= $product['producto_imagen_url'] ?>" alt="Imagen de <?= $product['producto_nombre'] ?>"
                        class="object-contain w-full h-full">
                </div>
                <!-- archivos multimedia -->
                <div class="w-full h-[150px] flex p-5 gap-5 overflow-x-auto">
                    <div class="w-[150px] h-full flex-shrink-0 cursor-pointer">
                        <img src="<?= $product['producto_imagen_url'] ?>" alt="Imagen de <?= $product['producto_nombre'] ?>"
                            class="thumbnail object-contain w-full h-full border-2 border-violet-600 rounded duration-300 hover:scale-[1.01] hover:shadow-md">
                    </div>

                    <?php foreach ($product['multimedia'] ?? [] as $index => $file): ?>
                        <div class="w-[150px] h-full flex items-center justify-center flex-shrink-0 cursor-pointer">
                            <?php if ($file['multimedia_tipo'] == 'imagen') : ?>
                                <img src="<?= $file['multimedia_url'] ?>" alt="archivo multimedia"
                                    class="thumbnail object-contain w-full h-full border border-gray-400 rounded duration-300 hover:scale-[1.01] hover:shadow-md">
                            <?php else: ?>
                                <video class="thumbnail object-contain w-full h-full border border-gray-400 rounded duration-300 hover:scale-[1.01] hover:shadow-md">
                                    <source src="<?= $file['multimedia_url'] ?>" type="video/mp4">
                                    Tu navegador no soporta video HTML5.
                                </video>
                            <?php endif; ?>
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
                    <div class="flex items-center text-md flex-none w-fit">
                        <i class="fa-solid fa-star text-yellow-500"></i>
                        <p class="ms-2 font-bold text-gray-900"><?= $product['calificacion_promedio'] ?></p>
                        <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                        <a class="font-medium text-gray-900  hover:underline cursor-pointer tooltip tooltip-bottom" data-tip="Mostrar/Ocultar comentarios" onclick="toggleComments()"><?= $product['numero_calificaciones'] ?> comentarios</a>
                    </div>
                </div>

                <p><?= $product['producto_descripcion'] ?></p>

                <div>
                    <h4 class="font-bold text-2xl tracking-tight"><?= number_format($product['producto_precio']) ?> COP</h4>
                    <p class="text-gray-600 font-semibold text-sm">Disponibles: <?= $product['producto_cantidad'] ?></p>
                </div>
                <div class="flex gap-2">
                    <!-- Agregar al carrito -->
                    <button type="submit" data-producto-id="<?= $product['producto_id'] ?>"
                        class="btn-add-cart group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa-solid fa-cart-plus text-violet-500 duration-300 group-hover:text-violet-400"></i>
                        </span>
                        Agregar al carrito
                    </button>
                    <?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 4 || isset($_SESSION['usuario_id']) && $product['usuario_id'] == $_SESSION['usuario_id']) : ?>
                        <a href="/page/product_profile/?producto=<?= $product['producto_id'] ?>" data-tip="Editar producto"
                        class="relative group flex items-center justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer tooltip">
                            <i class="fa-solid fa-user-gear text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sección comentarios -->
        <div class="w-full p-5 md:p-10 bg-white rounded-lg shadow-lg flex flex-col md:flex-row gap-10 hidden" id="comment-box">
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

                    <form action="/calification/rate" method="POST" enctype="multipart/form-data" class="space-y-3 fetch-form" <?= (!isset($_SESSION['usuario_id']) ? 'onsubmit="login(event)"' : '') ?>>
                        <input type="hidden" name="producto_id" value="<?= $product['producto_id'] ?>">
                        <input type="hidden" name="usuario_id" value="<?= (!isset($_SESSION['usuario_id']) ? '' : $_SESSION['usuario_id']) ?>">
                        <input type="hidden" name="tipo_objeto" value="producto">

                        <div class="rating flex justify-center gap-2 py-3">
                            <input type="radio" name="calificacion" value="1" class="mask mask-star-2 bg-violet-600" checked />
                            <input type="radio" name="calificacion" value="2" class="mask mask-star-2 bg-violet-600" />
                            <input type="radio" name="calificacion" value="3" class="mask mask-star-2 bg-violet-600" />
                            <input type="radio" name="calificacion" value="4" class="mask mask-star-2 bg-violet-600" />
                            <input type="radio" name="calificacion" value="5" class="mask mask-star-2 bg-violet-600" />
                        </div>

                        <div class="w-full rounded-[100px] bg-gray-200 px-4 py-2 flex items-center gap-4">
                            <label for="fileUpload" class="cursor-pointer relative rounded-full" onchange="document.getElementById('file_indicator').classList.remove('hidden'); this.classList.add('bg-gray-300', 'p-1.5');">
                                <input type="file" id="fileUpload" class="hidden" name="calificacion_imagen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd" d="M9 7a5 5 0 0 1 10 0v8a7 7 0 1 1-14 0V9a1 1 0 0 1 2 0v6a5 5 0 0 0 10 0V7a3 3 0 1 0-6 0v8a1 1 0 1 0 2 0V9a1 1 0 1 1 2 0v6a3 3 0 1 1-6 0z" clip-rule="evenodd"></path>
                                </svg>
                                <!-- Indicador de número de archivos -->
                                <span id="file_indicator" class="hidden absolute top-[3px] right-[3px] translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-4 h-4 ms-2 text-center text-xs font-bold text-blue-800 bg-blue-400 rounded-full"> 1 </span>
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
                <div class="space-y-3 divide-y divide-y-gray-300">
                    <?php if (!isset($product['calificaciones']) || count($product['calificaciones']) < 1) : ?>
                        <p class="text-lg text-gray-600">Aún no hay comentarios</p>
                    <?php endif; ?>

                    <?php foreach ($product['calificaciones'] as $calification): ?>

                        <article class="w-full space-y-2 py-4">
                            <span class="w-full flex items-center justify-between">
                                <!-- Información del usuario -->
                                <div class="w-full">
                                    <div class="flex justify-between w-full">
                                        <div class="flex gap-2 items-center">
                                            <div class="w-12 h-12 rounded-full overflow-hidden">
                                                <img src="<?= $calification['usuario_imagen_url'] ?>" alt="Foto de <?= $calification['usuario_alias'] ?>" class="object-cover w-full h-full">
                                            </div>
                                            <p class="font-semibold tracking-tight"><?= $calification['usuario_alias'] ?></p> -
                                            <p class="text-[14px] text-gray-500/80 font-semibold"> <?= explode(' ', $calification['calificacion_fecha'])[0] ?></p>
                                        </div>

                                        <!-- Botón desplegable de calificación -->
                                        <div class="relative">
                                            <div class="dropdown dropdown-hover">
                                                <div tabindex="0" role="button" class="btn btn-sm btn-ghost m-1">
                                                    <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                                                </div>
                                                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                                                    <!-- Opciones de eliminar, editar y reportar comentario -->
                                                    <?php if ($calification['usuario_id'] == $_SESSION['usuario_id'] || $_SESSION['rol_id'] == 4): ?>
                                                        <li onclick="seller_modal_<?= $calification['calificacion_id'] ?>.showModal()"><a class="text-center flex justify-center gap-2"> <i class="fa-solid fa-pen text-sm"></i>Editar</a></li>
                                                        <form class="fetch-form w-full text-red-500" action="/calification/delete" method="post">
                                                            <input type="hidden" name="calificacion_id" value="<?= $calification['calificacion_id'] ?>">
                                                            <button type="submit" class="w-full" onclick="return confirm('¿Seguro que quieres eliminar este comentario?, esta acción es irreversible.')">
                                                                <li>
                                                                    <a class="text-center flex justify-center gap-2">
                                                                        <i class="fa-solid fa-trash-can text-sm"></i>Eliminar
                                                                    </a>
                                                                </li>
                                                            </button>
                                                        </form>
                                                        <hr class="border-gray-300">
                                                    <?php endif; ?>
                                                    <li onclick="setTimeout(() => {alert('Elemento reportado.'); window.location.href= window.location.href;}, 1000)"><a class="text-center text-red-500 flex justify-center gap-2"> <i class="fa-solid fa-flag text-sm"></i>Reportar</a></li>
                                                </ul>
                                            </div>
                                        </div>
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
                            </span>

                            <p> <?= $calification['calificacion_comentario'] ?></p>
                            <?php if ($calification['calificacion_imagen_url']): ?>
                                <div class="w-full h-[230px] mx-auto">
                                    <img src="<?= $calification['calificacion_imagen_url'] ?>" alt="Imagen de comentario" class="object-contain h-full w-full">
                                </div>
                            <?php endif; ?>

                        </article>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modales -->
<?php foreach ($product['calificaciones'] as $calification) : ?>

    <dialog id="seller_modal_<?= $calification['calificacion_id'] ?>" class="modal">
        <div class="modal-box rounded-lg">
            <div class="modal-action m-0">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</button>
                </form>
            </div>
            <!-- Contenido modal -->
            <h3 class="text-xl font-bold">Calificar producto:</h3>
            <p>Ten en cuenta la calidad del producto y tiempo de envío.</p>

            <form action="/calification/update" method="post" enctype="multipart/form-data" class="fetch-form space-y-2">
                <input type="hidden" name="calificacion_id" value="<?= $calification['calificacion_id'] ?>">
                <input type="hidden" name="vendedor_id" value="<?= $seller['usuario_id'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                <input type="hidden" name="tipo_objeto" value="usuario">

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium text-gray-700">Mensaje:</span>
                    </div>
                    <textarea placeholder="Ingresa un comentario sobre el vendedor." id="calificacion_comentario" name="calificacion_comentario"
                        class="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded"><?= $calification['calificacion_comentario'] ?></textarea>
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium text-gray-700">Imagen:</span>
                    </div>
                    <input type="file" name="calificacion_imagen" id="calificacion_imagen"
                        class="w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
                </label>

                <div class="rating flex justify-center gap-2 py-3">
                    <input type="radio" name="calificacion" value="1" class="mask mask-star-2 bg-violet-600" <?= $calification['calificacion'] == 1 ? 'checked' : '' ?> />
                    <input type="radio" name="calificacion" value="2" class="mask mask-star-2 bg-violet-600" <?= $calification['calificacion'] == 2 ? 'checked' : '' ?> />
                    <input type="radio" name="calificacion" value="3" class="mask mask-star-2 bg-violet-600" <?= $calification['calificacion'] == 3 ? 'checked' : '' ?> />
                    <input type="radio" name="calificacion" value="4" class="mask mask-star-2 bg-violet-600" <?= $calification['calificacion'] == 4 ? 'checked' : '' ?> />
                    <input type="radio" name="calificacion" value="5" class="mask mask-star-2 bg-violet-600" <?= $calification['calificacion'] == 5 ? 'checked' : '' ?> />
                </div>
                <button id="calificar-btn" class="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-black/50">
            <button class="cursor-auto">close</button>
        </form>
    </dialog>

<?php endforeach; ?>

<script src="/public/js/cart.js"></script>
<script src="/public/js/califications.js"></script>
<script>
    // Selecciona todas las miniaturas
    document.querySelectorAll('.thumbnail').forEach(item => {
        item.addEventListener('click', function() {
            var mainMedia = document.getElementById('main-media');

            // Si es un video, cambiar el source
            if (item.tagName.toLowerCase() === 'video') {
                mainMedia.outerHTML = `<video id="main-media" class="object-contain w-full h-full" controls>
                                          <source src="${item.querySelector('source').src}" type="video/mp4">
                                          Tu navegador no soporta video HTML5.
                                       </video>`;
            } else {
                mainMedia.outerHTML = `<img id="main-media" src="${item.src}" alt="archivo multimedia"
                                        class="object-contain w-full h-full">`;
            }

            // remover el y agregar estilos
            document.querySelectorAll('.thumbnail').forEach(thumbnail => {
                if (thumbnail !== item) {
                    thumbnail.classList.remove('border-violet-600');
                    thumbnail.classList.remove('border-2');
                    thumbnail.classList.add('border');
                }
            });
            item.classList.add('border-2');
            item.classList.add('border-violet-600');

        });
    });

    let visible = false;

    function login(event = null) {
        event.preventDefault();
        if (confirm('Para calificar un producto debes iniciar sesión.')) {
            window.location.href = '/page/login';
            exit();
        }
    }

    function toggleComments() {
        document.getElementById('comment-box').classList.toggle('hidden');
        visible = !visible;
        if (document.getElementById('btn-show-comments')) {
            document.getElementById('btn-show-comments').innerHTML = visible ? 'Ocultar comentarios' : 'Ver comentarios';
        }
    }
</script>