<?php
function findUserById($users, $id) {
    foreach ($users as $user) {
        if ($user["user_id"] === $id) {
            return $user['username'];
        }
    }
    return null;
}

function buildQueryString($params) {
    $queryString = '';
    foreach ($params as $param) {
        if (isset($_GET[$param]) && !empty($_GET[$param])) {
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
                    <h2 class="text-2xl font-bold tracking-tight">Productos</h2>
                    <p><?= $products['rows'] ?> resultados</p>
                </div>
                <div class="flex">
                    <p>ordenar por</p>
                    <select class="h-fit bg-transparent" id="sort-select" onchange="window.location = this.value">
                        <option value="/page/products/?sort=calification<?= buildQueryString(['search', 'max', 'min', 'filter', 'value']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'calification' ? 'selected' : ''?>>Destacado</option>
                        <option value="/page/products/?sort=date<?= buildQueryString(['search', 'max', 'min', 'filter', 'value']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'selected' : ''?>>Reciente</option>
                        <option value="/page/products/?sort=price<?= buildQueryString(['search', 'max', 'min', 'filter', 'value']) ?>" <?= isset($_GET['sort']) && $_GET['sort'] == 'price' ? 'selected' : ''?>>Precio ascendente</option>
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
                            <option value="/page/products/?filter=category_id&value=1<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>" <?= isset($_GET['filter']) && isset($_GET['value']) && $_GET['filter'] == 'category_id' && $_GET['value'] == '1' ? 'selected' : ''?>>Ropa y calzado</option>
                            <option value="/page/products/?filter=category_id&value=2<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>" <?= isset($_GET['filter']) && isset($_GET['value']) && $_GET['filter'] == 'category_id' && $_GET['value'] == '2' ? 'selected' : ''?>>comida</option>
                            <option value="/page/products/?filter=category_id&value=3<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>" <?= isset($_GET['filter']) && isset($_GET['value']) && $_GET['filter'] == 'category_id' && $_GET['value'] == '3' ? 'selected' : ''?>>Tecnología</option>
                            <option value="/page/products/?filter=category_id&value=4<?= buildQueryString(['search', 'max', 'min', 'sort']) ?>" <?= isset($_GET['filter']) && isset($_GET['value']) && $_GET['filter'] == 'category_id' && $_GET['value'] == '4' ? 'selected' : ''?>>Otras</option>
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
                        <form action="/page/products/<?= buildQueryString(['search', 'filter', 'value', 'sort']) ?>" method="GET" class="flex flex-col gap-3 w-full my-2">
                            <div class="flex gap-3">
                                <input type="number" name="min" class="border p-1 px-2 w-1/2 input-price-filter" required placeholder="Desde...">
                                <input type="number" name="max" class="border p-1 px-2 w-1/2 input-price-filter" required placeholder="Hasta">
                            </div>
                            <div class="flex w-full gap-3">
                                <?= isset($_GET['max']) && isset($_GET['max']) ? ' <a href="/page/products/search='. buildQueryString(['search', 'filter', 'value', 'sort']) .'" class="bg-violet-800 rounded-lg text-white font-bold p-1 px-3 duration-300 hover:bg-violet-600 text-center flex justify-center items-center"> <i class="fa-solid fa-arrows-rotate"></i> </a> ' : '' ?>
                                <button class="bg-violet-800 rounded-lg text-white font-bold hidden p-1 px-3 duration-300 hover:bg-violet-600 w-full" id="btn-price-filter-submit"> Cambiar </button>
                            </div>
                        </form>
                    </div>
                    <!-- Agrega más filtros según sea necesario -->
                </aside>
                <div class="w-full md:w-7/12 lg:w-8/12 flex flex-col gap-2">
                    <?php foreach ($products['data'] as $product): ?>
                        <?php if($product['state'] == 'private') { continue;} ?>
                        <article class="flex flex-col md:flex-row justify-between gap-4 bg-white p-4 rounded-lg shadow-lg border min-h-[250px]">
                            <div class="w-full md:w-3/12 max-h-[230px] flex items-center justify-center">
                                <img src="<?= $product['image'] ?>" alt="<?= $product['name']; ?>" class="max-w-full max-h-full">
                            </div>
                            <div class="w-full md:w-7/12 flex flex-col justify-between gap-5">
                                <div class="flex flex-col gap-4">   
                                    <div>
                                        <h2 class="text-[25px] tracking-tight"><?= $product['name']; ?></h2>
                                        <p class="text-black/[0.5] text-md">Por <?= findUserById($users, $product['user_id']) ?></p>
                                    </div>                             
                                    <p><?= $product['description']; ?></p>
                                </div>
                                <div class="w-full flex justify-between">
                                    <h3 class="font-medium text-xl"><?= number_format($product['price']); ?> COP</h3>
                                    <span class="flex gap-3">
                                        <span>
                                            <?php
                                                for ($i = 0; $i < (int)$product['calification']; $i++) {
                                                    echo '<i class="fa-solid fa-star"></i>';
                                                }
                                                for ($i = (int)$product['calification']; $i < 5; $i++) {
                                                    echo "<i class=\"fa-regular fa-star\"></i>";
                                                }
                                                ?>
                                        </span>
                                        <p class="opacity-[0.4]">(101)</p>
                                    </span>
                                </div>
                            </div>
                            <span class="w-2/12 flex items-center justify-center">
                                <button class="rounded-full size-[60px] border-2 border-black"><i class="fa-solid fa-cart-plus text-2xl"></i></button>
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
    <?php require_once(__DIR__ . "/../layout/footer.php") ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sortSelect = document.getElementById('sort-select');
            const inputs = document.querySelectorAll('.input-price-filter');
            const radios = document.querySelectorAll('input[type="radio"]');

            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.checked) {
                        window.location.href = radio.value;
                    }
                });
            });

            inputs.forEach(input => {
                input.addEventListener('change', () => {
                    if (input.value == '') {
                        document.getElementById('btn-price-filter-submit').classList.add('hidden');
                    } else {
                        document.getElementById('btn-price-filter-submit').classList.remove('hidden');
                    }
                });
            });

            inputs.forEach(input => {
                if (input.value == '') {
                    document.getElementById('btn-price-filter-submit').classList.add('hidden');
                } else {
                    document.getElementById('btn-price-filter-submit').classList.remove('hidden');
                }
            });
        });
    </script>
</body>
</html>