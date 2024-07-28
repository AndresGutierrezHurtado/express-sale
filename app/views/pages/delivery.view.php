<main class="w-full bg-gray-200 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-[700px] mx-auto py-12 space-y-10">
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
                    <a class="font-medium text-gray-900  hover:underline cursor-pointer" onclick="toggleComments()"><?= $user['numero_calificaciones'] ?> opiniones</a>
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
                <h4 class="text-2xl font-bold tracking-tight mb-2">Agrega tu calificacion:</h4>
                
                <form action="/calification/rate" method="POST" enctype="multipart/form-data" class="space-y-3 modal">
                    <div id="stars" class="flex items-center justify-center gap-2 text-[25px]">
                        <span class="star starProducto" data-value="1"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                        <span class="star starProducto" data-value="2"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                        <span class="star starProducto" data-value="3"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                        <span class="star starProducto" data-value="4"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                        <span class="star starProducto" data-value="5"><i class="fa-solid fa-star cursor-pointer text-gray-300 duration-300 hover:scale-110"> </i></span>
                    </div>
                    <div class="w-full rounded-[100px] bg-gray-200 px-4 py-2 flex items-center gap-4">
                        <input type="hidden" name="vendedor_id" value="<?= $user['usuario_id'] ?>">
                        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                        <input type="hidden" name="tipo_objeto" value="usuario">
                        <input type="hidden" name="calificacion">

                        <input type="text" placeholder="Escribe un comentario..." name="calificacion_comentario" required
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

            <div class="space-y-3">
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
</main>

<!-- Modales -->
<?php foreach($califications as $calification) :?>
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
                <input type="hidden" name="vendedor_id" value="<?= $user['usuario_id'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                <input type="hidden" name="tipo_objeto" value="usuario">
                <input type="hidden" name="calificacion">

                <div class="w-full space-y-2">
                    <label for="calificacion_comentario" class="text-sm font-semibold text-gray-700">Mensaje</label>
                    <textarea id="calificacion_comentario" name="calificacion_comentario" required
                    class="w-full h-32 p-2 border resize-none rounded-lg focus:border-violet-600 focus:outline-none" placeholder="Mensaje..."><?= $calification['calificacion_comentario'] ?></textarea>
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
<script src="/public/js/califications.js"></script>