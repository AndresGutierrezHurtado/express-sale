<main class="w-full bg-gray-200 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-[700px] mx-auto py-[100px] space-y-10">
        <div class="w-full bg-white p-10 rounded-lg shadow-lg relative space-y-5">
            <!-- centrar verticalmente -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full overflow-hidden border-[7px] border-white size-[150px]">
                <img src="<?= $user['usuario_imagen_url'] ?>" alt="Imagen de <?= $user['usuario_nombre'] ?>" class="object-cover w-full h-full">
            </div>
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight text-center mx-auto mt-12"><?= $user['usuario_nombre'] ?> <?= $user['usuario_apellido'] ?></h1>
                <p class="text-lg font-bold text-gray-600/60 tracking-wide"><?= $user['rol_nombre'] ?></p>
                <!-- Calificaciones -->
                <div class="flex items-center text-md mx-auto w-fit">
                    <i class="fa-solid fa-star text-yellow-500"></i>
                    <p class="ms-2 font-bold text-gray-900"><?= $user['calificacion_promedio'] ?></p>
                    <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                    <a class="font-medium text-gray-900  hover:underline cursor-pointer tooltip tooltip-bottom" data-tip="Mostrar/ocultar opiniones" onclick="toggleComments()"><?= $user['numero_calificaciones'] ?> opiniones</a>
                </div>
                <p class="font-semibold"><?= $user['trabajador_numero_trabajos'] ?> envío/s realizados</p>
                <p class="my-2"><?= $user['trabajador_descripcion'] ?></p>                
            </div>

            <hr>

            <div class="">
                <h1 class="text-2xl font-bold tracking-tight mb-2">Información de contacto: </h1>
                <p> <strong>Dirección:</strong> <?= $user['usuario_direccion'] ?> </p>
                <p> <strong>Correo electrónico:</strong> <?= $user['usuario_correo'] ?> </p>
                <p> <strong>Número telefónico:</strong> <?= $user['usuario_telefono'] ?> </p>
            </div>

            <hr>

            <!-- Agregar comentario -->
            <div class="space-y-3">
                <h4 class="text-lg font-semibold">Agrega tu comentario:</h4>

                <form action="/calification/rate" method="POST" enctype="multipart/form-data" class="space-y-3 fetch-form" <?= (!isset($_SESSION['usuario_id']) ? 'onsubmit="login(event)"' : '') ?>>
                    <input type="hidden" name="vendedor_id" value="<?= $user['usuario_id'] ?>">
                    <input type="hidden" name="usuario_id" value="<?= (!isset($_SESSION['usuario_id']) ? '' : $_SESSION['usuario_id']) ?>">
                    <input type="hidden" name="tipo_objeto" value="usuario">

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
        <div class="w-full bg-white p-10 rounded-lg shadow-lg relative space-y-5 hidden" id="comment-box">
            <h2 class="text-2xl font-bold tracking-tight">Comentarios</h2>

            <div class="space-y-3 divide-y divide-y-gray-300">
                <?php if(!isset($califications) || count($califications) < 1) :?>
                    <p class="text-lg text-gray-600">Aún no hay comentarios</p>
                <?php endif;?>

                <?php foreach( $califications as $calification):?>

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
</main>

<!-- Modales calificaciones -->
<?php foreach ($califications as $calification) : ?>

<dialog id="seller_modal_<?= $calification['calificacion_id'] ?>" class="modal">
    <div class="modal-box rounded-lg">
        <div class="modal-action m-0">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</button>
            </form>
        </div>
        <!-- Contenido modal -->
        <h3 class="text-xl font-bold">Calificar al domiciliario:</h3>
        <p>Ten en cuenta la rapidez y cuidado de entrega.</p>

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

<script>
    let visible = false;
    
    function toggleComments() {
        document.getElementById('comment-box').classList.toggle('hidden');
        visible = !visible;
        if (document.getElementById('btn-show-comments')) {
            document.getElementById('btn-show-comments').innerHTML = visible ? 'Ocultar comentarios' : 'Ver comentarios' ;
        }
    }
</script>
