<main class="w-full px-5">
    <div class="max-w-[1200px] mx-auto py-16 space-y-5">
        <!-- Sección superior de ordenadores y resultados -->
        <span class="w-full flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-4xl font-bold tracking-tight">
                    <?= isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : (isset($_GET['value']) ? ($_GET['value'] == 1 ? 'Ropa y calzado' : ($_GET['value'] == 2 ? 'Comida' : ($_GET['value'] == 3 ? 'Tecnología' : ($_GET['value'] == 4 ? 'Otros' : 'Productos')))) : 'Productos'); ?>
                </h2>
                <p class="font-semibold text-gray-500"><?= $products['rows'] ?> Resultados</p>
            </div>

            <div class="flex gap-1">
                <p>ordenar por</p>
                <select class="h-fit bg-transparent text-start" id="sort-select" onchange="window.location = this.value">
                    <option value="/page/products/<?= buildQueryString([], ['sort']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'calificacion_promedio' ? 'selected' : ''?>> destacado </option>
                    <option value="/page/products/<?= buildQueryString(['sort' => 'producto_fecha']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'producto_fecha' ? 'selected' : ''?>> reciente </option>
                    <option value="/page/products/<?= buildQueryString(['sort' => 'producto_precio']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'producto_precio' ? 'selected' : ''?>> Precio </option>
                </select>
            </div>
        </span>

        <section class="w-full flex flex-col lg:flex-row items-center lg:items-start justify-center gap-16">
            <!-- Filtros-->
            <aside class="w-full max-w-[400px] p-5 bg-white rounded-lg shadow-lg space-y-4 h-fit">
                <h4 class="text-xl font-bold tracking-tight">Filtrar productos</h4>
                <!-- Filtrar por categorias -->
                <div class="flex flex-col gap-1">
                    <label for="categoria" class="block text-sm font-medium text-gray-700">Categorías</label>
                    <select id="categoria" name="categoria" class="w-full p-1 px-2 border rounded-md" onchange="window.location = this.value">
                        <option value="/page/products/<?= buildQueryString([], ['categoria']) ?>">Todas</option>
                        <option value="/page/products/<?= buildQueryString(['categoria' => '1']) ?>" <?= isset($_GET['categoria']) && $_GET['categoria'] == 1 ? 'selected' : ''?>>Ropa y calzado</option>
                        <option value="/page/products/<?= buildQueryString(['categoria' => '2']) ?>" <?= isset($_GET['categoria']) && $_GET['categoria'] == 2 ? 'selected' : ''?>>comida</option>
                        <option value="/page/products/<?= buildQueryString(['categoria' => '3']) ?>" <?= isset($_GET['categoria']) && $_GET['categoria'] == 3 ? 'selected' : ''?>>Tecnología</option>
                        <option value="/page/products/<?= buildQueryString(['categoria' => '4']) ?>" <?= isset($_GET['categoria']) && $_GET['categoria'] == 4 ? 'selected' : ''?>>Otras</option>
                    </select>
                </div>

                <!-- Filtrar por precio -->
                <div class="flex flex-col gap-1">
                    <label class="block text-sm font-medium text-gray-700">Precio</label>
                    <span class="flex gap-3">
                        <input type="radio" id="filtro-precios-cualquiera" name="precio" value="/page/products/<?= buildQueryString([], ['min', 'max']) ?>" <?= !isset($_GET['min']) && !isset($_GET['max']) ? 'checked' : '' ?>>
                        <label for="filtro-precios-cualquiera">Cualquiera</label>
                    </span>
                    <span class="flex gap-3">
                        <input type="radio" id="filtro-precios-hasta-45k" name="precio"  value="/page/products/<?= buildQueryString(['min' => '0', 'max' => '45000']) ?>" <?= isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] == 0  && $_GET['max'] == 45000 ? 'checked' : '' ?>>
                        <label for="filtro-precios-hasta-45k">Hasta $ 45.000</label>
                    </span>
                    <span class="flex gap-3">
                        <input type="radio" id="filtro-precios-65k-100k" name="precio" value="/page/products/<?= buildQueryString(['min' => '65000', 'max' => '100000']) ?>" <?= isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] == 65000  && $_GET['max'] == 100000 ? 'checked' : '' ?>>
                        <label for="filtro-precios-65k-100k">$65.000 a $100.000</label>
                    </span>
                    <span class="flex gap-3">
                        <input type="radio" id="filtro-precios-mas-100k" name="precio" value="/page/products/<?= buildQueryString(['min' => '100000', 'max' => '1000000000']) ?>" <?= isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] == 100000  && $_GET['max'] == 1000000000 ? 'checked' : '' ?>>
                        <label for="filtro-precios-mas-100k">Más de $100.000</label>
                    </span>
                    <form action="/page/products/" method="GET" class="flex flex-col gap-3 w-full my-2">
                        <?php foreach ($_GET as $key => $value) : ?>
                            <input type="hidden" name="<?= $key ?>" value="<?= $value ?>">
                        <?php endforeach; ?>
                        <div class="flex gap-3">
                            <input type="number" name="min" class="border p-1 px-2 w-1/2 input-price-filter" required placeholder="Desde...">
                            <input type="number" name="max" class="border p-1 px-2 w-1/2 input-price-filter" required placeholder="Hasta">
                        </div>
                        <div class="flex w-full gap-3">
                            <!-- Botón de refrescar y submit -->
                            <?php if( isset($_GET['max']) || isset($_GET['max']) ) : ?>
                                <a href="/page/products/<?= buildQueryString([], ['min', 'max']) ?>"> 
                                    <div class="bg-violet-800 rounded-lg text-white font-bold p-1 px-3 duration-300 hover:bg-violet-600 w-full">
                                        <i class="fa-solid fa-arrows-rotate"></i> 
                                    </div>
                                </a>
                            <?php endif; ?>
                            <button class="bg-violet-800 rounded-lg text-white font-bold hidden p-1 px-3 duration-300 hover:bg-violet-600 w-full" id="btn-price-filter-submit"> Cambiar </button>
                        </div>
                    </form>
                </div>
            </aside>
            
            <!-- Listado de productos -->
            <div class="w-full space-y-5">

                <?php foreach($products['data'] as $product): ?>

                    <article class="w-full bg-white p-5 rounded-lg shadow-lg flex flex-col sm:flex-row gap-4">
                        <!-- Imagen -->
                        <div class="w-full max-w-[230px] h-[240px] mx-auto">
                            <img src="<?= $product['producto_imagen_url'] ?>" alt="Imagen de <?= $product['producto_nombre'] ?>" class="object-contain h-full w-full">
                        </div>

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

                <!-- Paginación -->
                <div class="w-full bg-white p-3 rounded-lg shadow-lg flex gap-3 justify-center">
                    
                    <?php if($page > 1): ?>
                        <a href="/page/products/<?= buildQueryString(['page' => $page - 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> anterior </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> anterior </a>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $products['pages']; $i++): ?>
                        <a href="/page/products/<?= buildQueryString(['page' => $i]) ?>" class="font-semibold bg-gray-200 size-[30px] flex items-center justify-center rounded-sm duration-300 <?= $i == $page ? 'bg-gray-400 font-bold' : ' hover:bg-gray-300' ?>"> <?= $i ?> </a>
                    <?php endfor; ?>
                    
                    <?php if($page < $products['pages']): ?>
                        <a href="/page/products/<?= buildQueryString(['page' => $page + 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> siguiente </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> siguiente </a>
                    <?php endif; ?>

                </div>

            </div>
        </section>
    </div>
</main>

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

<script src="/public/js/productCalification.js"></script>
<script src="/public/js/cart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // logica para rango de precios
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.checked) {
                window.location.href = radio.value;
            }
        });
    });
    
    document.querySelectorAll('.input-price-filter').forEach(input => {
        input.addEventListener('change', () => {
            if (input.value == '') {
                document.getElementById('btn-price-filter-submit').classList.add('hidden');
            } else {
                document.getElementById('btn-price-filter-submit').classList.remove('hidden');
            }
        });
    });

});

function login () {
    if (confirm("Tienes que iniciar sesión para calificar un producto. ¿Deseas iniciar sesión?")) {
        window.location.href = '/page/login/';
    }
}
</script>