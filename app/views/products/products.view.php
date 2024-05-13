<?php

function buildQueryString($params) {
    $queryString = '';
    foreach ($params as $param) {
        if (isset($_GET[$param])) {
            $queryString .= '&' . $param . '=' . $_GET[$param];
        }
    }
    return $queryString;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-50">
    <?php require_once(__DIR__ . "/../layout/header.php")?>

    <section class="w-full h-auto">
        <div class="container mx-auto flex flex-col gap-10 justify-between items-center py-10 px-5">
            <span class="w-full flex flex-col sm:flex-row gap-4 justify-between">
                <div class="flex flex-col text-center sm:text-start">
                    <h2 class="text-2xl font-bold tracking-tight"><?= isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : (isset($_GET['value']) ? ($_GET['value'] == 1 ? 'Ropa y calzado' : ($_GET['value'] == 2 ? 'Comida' : ($_GET['value'] == 3 ? 'Tecnología' : ($_GET['value'] == 4 ? 'Otros' : 'Productos')))) : 'Productos'); ?></h2>
                    <p><?= $products['rows'] ?> resultados</p>
                </div>
                <div class="flex items-center gap-2">
                    <p>ordenar por</p>
                    <select class="h-fit bg-transparent" id="sort-select" onchange="window.location = this.value">
                        <option value="/page/products/?sort=avg_calification<?= buildQueryString(['search', 'max', 'min', 'filter', 'value']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'product_rating' ? 'selected' : ''?>>Destacado</option>
                        <option value="/page/products/?sort=product_date<?= buildQueryString(['search', 'max', 'min', 'filter', 'value']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'product_date' ? 'selected' : ''?>>Reciente</option>
                        <option value="/page/products/?sort=product_price<?= buildQueryString(['search', 'max', 'min', 'filter', 'value']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'product_price' ? 'selected' : ''?>>Precio ascendente</option>
                    </select>
                </div>
            </span>
            <div class="w-full flex flex-col md:flex-row gap-5 justify-between">                
                <aside class="w-full md:w-4/12 lg:w-3/12 h-fit bg-white flex flex-col gap-5 p-5 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold">Filtrar Productos</h2>
                    <div class="flex flex-col gap-1">
                        <label for="categoria" class="block text-sm font-medium text-gray-700">Categorías</label>
                        <select id="categoria" name="categoria" class="w-full p-1 px-2 border rounded-md" onchange="window.location = this.value">
                            <option value="/page/products/?none=none<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>">Todas</option>
                            <option value="/page/products/?filter=product_category_id&value=1<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>" <?= isset($_GET['filter']) && isset($_GET['value']) && $_GET['filter'] == 'product_category_id' && $_GET['value'] == '1' ? 'selected' : ''?>>Ropa y calzado</option>
                            <option value="/page/products/?filter=product_category_id&value=2<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>" <?= isset($_GET['filter']) && isset($_GET['value']) && $_GET['filter'] == 'product_category_id' && $_GET['value'] == '2' ? 'selected' : ''?>>comida</option>
                            <option value="/page/products/?filter=product_category_id&value=3<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>" <?= isset($_GET['filter']) && isset($_GET['value']) && $_GET['filter'] == 'product_category_id' && $_GET['value'] == '3' ? 'selected' : ''?>>Tecnología</option>
                            <option value="/page/products/?filter=product_category_id&value=4<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>" <?= isset($_GET['filter']) && isset($_GET['value']) && $_GET['filter'] == 'product_category_id' && $_GET['value'] == '4' ? 'selected' : ''?>>Otras</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="block text-sm font-medium text-gray-700">Precio</label>
                        <span class="flex gap-3">
                            <input type="radio" id="filtro-precios-cualquiera" name="precio" value="/page/products/?none=none<?= buildQueryString(['search', 'filter', 'value', 'sort']) ?>" <?= isset($_GET['min']) || isset($_GET['max']) ? '' : 'checked' ?>>
                            <label for="filtro-precios-cualquiera">Cualquiera</label>
                        </span>
                        <span class="flex gap-3">
                            <input type="radio" id="filtro-precios-hasta-45k" name="precio"  value="/page/products/?min=0&max=45000<?= buildQueryString(['search', 'filter', 'value', 'sort']) ?>" <?= isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] == 0  && $_GET['max'] == 45000 ? 'checked' : '' ?>>
                            <label for="filtro-precios-hasta-45k">Hasta $ 45.000</label>
                        </span>
                        <span class="flex gap-3">
                            <input type="radio" id="filtro-precios-65k-100k" name="precio" value="/page/products/?min=65000&max=100000<?= buildQueryString(['search', 'filter', 'value', 'sort']) ?>" <?= isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] == 65000  && $_GET['max'] == 100000 ? 'checked' : '' ?>>
                            <label for="filtro-precios-65k-100k">$65.000 a $100.000</label>
                        </span>
                        <span class="flex gap-3">
                            <input type="radio" id="filtro-precios-mas-100k" name="precio" value="/page/products/?min=100000&max=1000000000<?= buildQueryString(['search', 'filter', 'value', 'sort']) ?>" <?= isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] == 100000  && $_GET['max'] == 1000000000 ? 'checked' : '' ?>>
                            <label for="filtro-precios-mas-100k">Más de $100.000</label>
                        </span>
                        <form action="/page/products/" method="GET" class="flex flex-col gap-3 w-full my-2">
                            <div class="flex gap-3">
                                <input type="number" name="min" class="border p-1 px-2 w-1/2 input-price-filter" required placeholder="Desde...">
                                <input type="number" name="max" class="border p-1 px-2 w-1/2 input-price-filter" required placeholder="Hasta">
                            </div>
                            <div class="flex w-full gap-3">
                                <?= isset($_GET['max']) && isset($_GET['max']) ? ' <a href="/page/products/" class="bg-violet-800 rounded-lg text-white font-bold p-1 px-3 duration-300 hover:bg-violet-600 text-center flex justify-center items-center"> <i class="fa-solid fa-arrows-rotate"></i> </a> ' : '' ?>
                                <button class="bg-violet-800 rounded-lg text-white font-bold hidden p-1 px-3 duration-300 hover:bg-violet-600 w-full" id="btn-price-filter-submit"> Cambiar </button>
                            </div>
                        </form>
                    </div>
                    <!-- Agrega más filtros según sea necesario -->
                </aside>
                <div class="w-full md:w-7/12 lg:w-8/12 flex flex-col gap-2">
                    <?php if( count($products['data']) < 1) : ?>
                        <h2 class="text-2lx font-bold py-10 text-center">No se encontraron Productos.</h2>
                    <?php endif; ?>
                    <?php foreach ($products['data'] as $product): ?>
                        <?php if($product['state_name'] == 'private') { continue;} ?>
                        <article class="flex flex-col md:flex-row justify-between gap-4 bg-white p-4 rounded-lg shadow-lg border min-h-[250px]">
                            <div class="w-full md:w-3/12 max-h-[230px] flex items-center justify-center">
                                <img src="<?= $product['image_url'] ?>" alt="<?= $product['product_name']; ?>" class="max-w-full max-h-[230px]">
                            </div>
                            <div class="w-full md:w-7/12 flex flex-col justify-between gap-5">
                                <div class="flex flex-col gap-4">   
                                    <div>
                                        <h2 class="text-[25px] tracking-tight"><?= $product['product_name']; ?></h2>
                                        <a href="/page/public_profile/?usuario=<?= $product['product_user_id'] ?>" 
                                        class="text-black/[0.5] text-md hover:text-purple-600 hover:underline">Por <?= $product['user_username'] ?></a>
                                    </div>                             
                                    <p><?= $product['product_description']; ?></p>
                                </div>
                                <div class="w-full flex flex-col sm:flex-row justify-between">
                                    <h3 class="font-medium text-xl"><?= number_format($product['product_price']); ?> COP</h3>
                                    <span class="flex gap-3 items-center">
                                        <span>
                                            <?php
                                                $calificacion = $product['calification'];
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
                                        <p class="opacity-[0.4]"><?= $product['avg_calification'] ?> (<?= $product['califications_count'] ?>)</p>
                                        <button onclick="<?= isset($_SESSION['user_id']) ?  "toggleModal(".$product['product_id'].")" : "login()" ?>"
                                        class="text-violet-600 font-bold border-2 border-violet-600 duration-300 hover:bg-gray-100 size-[30px] rounded-full">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <span class="w-full sm:w-2/12 flex items-center justify-center">
                                <button data-product_id="<?= $product['product_id'] ?>" data-product_name="<?= $product['product_name'] ?>" data-product_price="<?= $product['product_price'] ?>"
                                 data-image_url="<?= $product['image_url'] ?>" data-product_user_id="<?= $product['product_user_id'] ?>" data-user_address="<?= $product['user_address'] ?>"
                                <?= isset($_SESSION['user_id']) ? "data-session='true'" : "data-session='false'"?>
                                class="rounded-full size-[60px] border-2 border-black btn-add-cart duration-300 hover:bg-gray-200">
                                    <i class="fa-solid fa-cart-plus text-2xl"></i>
                                </button>
                            </span>
                        </article>
                    <?php endforeach; ?>
                    <div class="flex justify-center py-6">
                        <ul class="inline-flex -space-x-px text-lg">
                            <?php if ($products['page'] > 1): ?>
                            <li>
                                <a href="/page/products/?page=<?= $products['page'] - 1 ?><?= buildQueryString(['search', 'filter', 'value', 'sort', 'min', 'max']) ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Anterior</a>
                            </li>
                            <?php else: ?>
                            <li>
                                <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg cursor-not-allowed opacity-50">Anterior</span>
                            </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $products['pages']; $i++): ?>
                            <li>
                                <a href="/page/products/?page=<?= $i ?><?= buildQueryString(['search', 'filter', 'value', 'sort', 'min', 'max']) ?>" class=" flex items-center justify-center px-3 h-8 leading-tight border border-gray-500 duration-300 <?= $i == $products['page'] ? 'text-black bg-gray-300 font-semibold hover:bg-slate-700 hover:text-white' : 'text-gray-500 bg-gray-50 hover:bg-gray-300 hover:text-gray-700' ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if ($products['page'] < $products['pages']): ?>
                            <li>
                                <a href="/page/products/?page=<?= $products['page'] + 1 ?><?= buildQueryString(['search', 'filter', 'value', 'sort', 'min', 'max']) ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Siguiente</a>
                            </li>
                            <?php else: ?>
                            <li>
                                <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg cursor-not-allowed opacity-50">Siguiente</span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Modal Calificación -->
    <div class="fixed inset-0 z-50 hidden" id="modal">
        <div class="fixed inset-0 bg-black bg-opacity-40" onclick="toggleModal()"></div>
        <div id="myModal" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center ">
            <div class="w-full md:w-auto md:max-w-full md:min-w-[500px] bg-white p-5 rounded-md">
                <span class="flex justify-between items-center">
                    <span class="text-lg font-bold">Califica el producto</span>
                    <button id="closeModalButton" class="text-gray-500 hover:text-gray-700"  onclick="toggleModal()">
                        <svg class="h-6 w-6" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
                <p class="w-full py-4">Ten en cuenta la calidad del producto y tiempo de envío.</p>
                <form id="rating-form" class="flex flex-col gap-4">
                    <textarea id="calification_comment" required
                    class="px-3 p-1 h-32 border resize-none rounded-lg focus:border-violet-600 focus:outline-none" placeholder="Mensaje..."></textarea>
                    <div id="stars" class="flex items-center justify-center gap-2 text-[20px]">
                        <span class="star" data-value="1"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                        <span class="star" data-value="2"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                        <span class="star" data-value="3"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                        <span class="star" data-value="4"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                        <span class="star" data-value="5"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                    </div>
                    <a class="hidden" id="btn-empty"></a>
                    <button id="calificar-btn" class="hidden bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
                </form>
            </div>
        </div>
    </div>
    <?php require_once(__DIR__ . "/../layout/footer.php") ?>
    <script src="/public/js/cart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sortSelect = document.getElementById('sort-select');
            const inputs = document.querySelectorAll('.input-price-filter');
            const radios = document.querySelectorAll('input[type="radio"]');       
            const stars = document.querySelectorAll('.star');
            const submitButton = document.getElementById('calificar-btn');

            // logica para seleccionar y des-seleccionar estrellas y aparecer o desaparecer botón de subir
            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const value = parseInt(star.dataset.value);

                    if (star.classList.contains('selected')) {
                        stars.forEach(s => {
                            s.innerHTML = '<i class="far fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"></i>';
                            s.classList.remove('selected');
                            submitButton.classList.remove('hidden');
                        });
                    } else {
                        stars.forEach((s, index) => {
                            if (index < value) {
                                s.innerHTML = '<i class="fas fa-star cursor-pointer text-amber-400 duration-300 hover:scale-[1.15]"></i>';
                                s.classList.remove('selected');
                            } else {
                                s.innerHTML = '<i class="far fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"></i>';
                                s.classList.remove('selected');
                            }
                        });
                        star.classList.add('selected');
                    }

                    const anySelected = Array.from(stars).some(s => s.classList.contains('selected'));
                    submitButton.classList.toggle('hidden', !anySelected);
                });
            });

            // logica para guardar la calificacion
            document.getElementById('rating-form').addEventListener('submit' , (e) => {
                e.preventDefault();

                let formData = new FormData();
                
                formData.append('calification_object_type', 'producto');
                formData.append('calification_comment', document.getElementById('calification_comment').value);
                formData.append('calification', parseInt(document.querySelector('.star.selected').dataset.value));
                formData.append('calificator_user_id', <?= $_SESSION['user_id'] ?>);
                formData.append('calificated_object_id', document.getElementById('calificar-btn').dataset.calificated_object_id );
                
                fetch('/calification/rate', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        window.location.reload();
                    }
                })
            });

            // logica para rango de precios
            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.checked) {
                        window.location.href = radio.value;
                    }
                });
            });

            // logica para el select de order
            inputs.forEach(input => {
                input.addEventListener('change', () => {
                    if (input.value == '') {
                        document.getElementById('btn-price-filter-submit').classList.add('hidden');
                    } else {
                        document.getElementById('btn-price-filter-submit').classList.remove('hidden');
                    }
                });
            });

            // logica para aparecer el boton de subir rango de precio personalizado
            inputs.forEach(input => {
                if (input.value == '') {
                    document.getElementById('btn-price-filter-submit').classList.add('hidden');
                } else {
                    document.getElementById('btn-price-filter-submit').classList.remove('hidden');
                }
            });
        });

            // logica para mostrar o desaparecer el modal de calificación
            function toggleModal( id = '' ) {
                document.getElementById('modal').classList.toggle('hidden');
                document.getElementById('calificar-btn').setAttribute('data-calificated_object_id', id);
            }

            // alerta de debes iniciar sesión
            function login () {
                if (confirm('para realizar esta acción tienes que iniciar sesión')){
                    window.location.href = '/page/login'
                }
            }
    </script>
</body>
</html>