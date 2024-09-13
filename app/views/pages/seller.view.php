<main class="w-full max-w-[1200px] mx-auto py-10 flex flex-col md:flex-row justify-between gap-10">
    <!-- Vendedor contenedor -->
    <div class="w-full max-w-[450px] space-y-5">
        <div class="w-full bg-white p-6 rounded-lg shadow-md h-fit flex flex-col gap-5">

            <h3 class="text-2xl font-bold tracking-tight">Información del vendedor:</h3>

            <div class="flex flex-col sm:flex-row items-center gap-4">
                <div class="w-24 h-24 rounded-full overflow-hidden flex-none">
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
                    <button onclick="<?= isset($_SESSION['usuario_id']) ? "seller_modal.showModal()" : "login()" ?>"
                        class="px-5 py-1 w-fit bg-violet-600 text-white font-bold rounded-lg duration-300 hover:bg-violet-400"> Calificar </button>

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
                                                <?php if ($calification['usuario_id'] == $_SESSION['usuario_id'] || $_SESSION['usuario']['rol_id'] == 4): ?>
                                                    <li onclick="seller_modal_<?= $calification['calificacion_id'] ?>.showModal()"><a class="text-center flex justify-center gap-2"> <i class="fa-solid fa-pen text-sm"></i>Editar</a></li>
                                                    <form class="fetch-form w-full text-red-500" action="/calification/delete" method="post">
                                                        <input type="hidden" name="calificacion_id" value="<?= $calification['calificacion_id'] ?>">
                                                        <button type="submit" class="w-full" onclick="confirmAlert(event, '¿Seguro que quieres eliminar este comentario?, esta acción es irreversible.')">
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

    <!-- Productos contenedor -->
    <div class="w-full p-5 bg-white rounded-lg space-y-5 h-fit">
        <h3 class="text-2xl font-bold tracking-tight">Productos:</h3>
        <div class="w-full divide-y divide-gray-300">
            <?php foreach ($products['data'] as $product): ?>

                <?php if ($product['producto_estado'] == 'privado') continue; ?>

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
                                <p class="text-gray-600/60 text-sm font-semibold hidden sm:block"><?= explode(' ', $product['producto_fecha'])[0]; ?></p>
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
                                <button onclick="<?= isset($_SESSION['usuario_id']) ? "product_modal_" . $product['producto_id'] . ".showModal()" : "login()" ?>" data-tip="Agrega una calificación al producto"
                                    class="size-[30px] bg-violet-600 text-white rounded-md duration-300 hover:bg-violet-800 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 tooltip">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </span>

                        <!-- Agregar al carrito -->
                        <form action="/cart/update" method="post" class="fetch-form w-full">
                            <input type="hidden" name="producto_id" value="<?= $product['producto_id'] ?>">

                            <button <?= isset($_SESSION['usuario_id']) ? "type='submit'" : "type='button' onclick='login()'" ?>
                                class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fa-solid fa-cart-plus text-[17px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                                </span>
                                Agregar al carrito
                            </button>
                        </form>
                    </div>
                </article>

            <?php endforeach; ?>
        </div>

        <!-- Paginacion -->
        <div class="w-full bg-white p-3 flex gap-3 justify-center">

            <?php if ($page > 1): ?>
                <a href="/page/sellers/<?= $this->buildQueryString(['page' => $page - 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> anterior </a>
            <?php else: ?>
                <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> anterior </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $products['pages']; $i++): ?>
                <a href="/page/sellers/<?= $this->buildQueryString(['page' => $i]) ?>" class="font-semibold bg-gray-200 size-[30px] flex items-center justify-center rounded-sm duration-300 <?= $i == $page ? 'bg-gray-400 font-bold' : ' hover:bg-gray-300' ?>"> <?= $i ?> </a>
            <?php endfor; ?>

            <?php if ($page < $products['pages']): ?>
                <a href="/page/sellers/<?= $this->buildQueryString(['page' => $page + 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> siguiente </a>
            <?php else: ?>
                <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> siguiente </a>
            <?php endif; ?>

        </div>
    </div>
</main>

<!-- Modal vendedor -->
<dialog id="seller_modal" class="modal">
    <div class="modal-box rounded-lg">
        <div class="modal-action m-0">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</button>
            </form>
        </div>
        <!-- Contenido modal -->
        <h3 class="text-xl font-bold">Calificar al vendedor:</h3>
        <p>Ten en cuenta la calidad de sus productos ofrecidos y la rapidez de entrega.</p>

        <form action="/calification/rate" method="post" enctype="multipart/form-data" class="fetch-form space-y-2">
            <input type="hidden" name="vendedor_id" value="<?= $seller['usuario_id'] ?>">
            <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
            <input type="hidden" name="tipo_objeto" value="usuario">

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Mensaje:</span>
                </div>
                <textarea placeholder="Ingresa un comentario sobre el vendedor." id="calificacion_comentario" name="calificacion_comentario"
                    class="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded"></textarea>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Imagen:</span>
                </div>
                <input type="file" name="calificacion_imagen" id="calificacion_imagen"
                    class="w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
            </label>

            <div class="rating flex justify-center gap-2 py-3">
                <input type="radio" name="calificacion" value="1" class="mask mask-star-2 bg-violet-600" checked />
                <input type="radio" name="calificacion" value="2" class="mask mask-star-2 bg-violet-600" />
                <input type="radio" name="calificacion" value="3" class="mask mask-star-2 bg-violet-600" />
                <input type="radio" name="calificacion" value="4" class="mask mask-star-2 bg-violet-600" />
                <input type="radio" name="calificacion" value="5" class="mask mask-star-2 bg-violet-600" />
            </div>
            <button id="calificar-btn" class="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop bg-black/50">
        <button class="cursor-auto">close</button>
    </form>
</dialog>

<!-- Modal vendedor calificaciones -->
<?php foreach ($califications as $calification) : ?>

    <dialog id="seller_modal_<?= $calification['calificacion_id'] ?>" class="modal">
        <div class="modal-box rounded-lg">
            <div class="modal-action m-0">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</button>
                </form>
            </div>
            <!-- Contenido modal -->
            <h3 class="text-xl font-bold">Calificar al vendedor:</h3>
            <p>Ten en cuenta la calidad de sus productos ofrecidos y la rapidez de entrega.</p>

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

<!-- Modales productos -->
<?php foreach ($products['data'] as $product): ?>
    <dialog id="product_modal_<?= $product['producto_id'] ?>" class="modal">
        <div class="modal-box rounded-lg">
            <div class="modal-action m-0">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</button>
                </form>
            </div>
            <!-- Contenido modal -->
            <h3 class="text-xl font-bold">Calificar producto:</h3>
            <p>Ten en cuenta la calidad del producto y tiempo de envío.</p>

            <form action="/calification/rate" method="post" enctype="multipart/form-data" class="fetch-form space-y-5">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                <input type="hidden" name="producto_id" value="<?= $product['producto_id'] ?>">
                <input type="hidden" name="tipo_objeto" value="producto">

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium text-gray-700">Mensaje:</span>
                    </div>
                    <textarea placeholder="Ingresa un comentario sobre el producto," id="calificacion_comentario" name="calificacion_comentario"
                        class="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded"></textarea>
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium text-gray-700">Imagen:</span>
                    </div>
                    <input type="file" name="calificacion_imagen" id="calificacion_imagen"
                        class="w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
                </label>

                <div class="rating flex justify-center gap-2">
                    <input type="radio" name="calificacion" value="1" class="mask mask-star-2 bg-violet-600" checked />
                    <input type="radio" name="calificacion" value="2" class="mask mask-star-2 bg-violet-600" />
                    <input type="radio" name="calificacion" value="3" class="mask mask-star-2 bg-violet-600" />
                    <input type="radio" name="calificacion" value="4" class="mask mask-star-2 bg-violet-600" />
                    <input type="radio" name="calificacion" value="5" class="mask mask-star-2 bg-violet-600" />
                </div>
                <button id="calificar-btn" class="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-black/50">
            <button class="cursor-auto">close</button>
        </form>
    </dialog>
<?php endforeach; ?>

<script>
    let visible = false;

    function toggleComments() {
        document.getElementById('comment-box').classList.toggle('hidden');
        visible = !visible;
        document.getElementById('btn-show-comments').innerHTML = visible ? 'Ocultar comentarios' : 'Ver comentarios';
    }
</script>