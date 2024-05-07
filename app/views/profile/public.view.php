<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?= $user['user_username'] ?> | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php require_once(__DIR__ . "/../layout/header.php")?>

    <main class="container mx-auto p-4 flex flex-col md:flex-row justify-center gap-10 py-12">
        <!-- Vendedor contenedor -->
        <div class="w-full max-w-[400px] bg-white p-6 rounded-lg shadow-md h-fit flex flex-col gap-5">
            <h3 class="text-2xl font-bold tracking-tight">Información del vendedor:</h3>
            <div class="flex flex-col sm:flex-row items-center space-x-4">
                <img src="<?= $user['user_image'] ?>" alt="Perfil" class="h-24 w-24 rounded-full">
                <div class="w-full ">
                    <h2 class="text-xl font-bold"><?= $user['user_full_name'] ?></h2>
                    <p class="text-sm text-gray-600">Ubicación: <?= $user['user_address'] ?></p>
                    <p class="text-sm text-gray-600">Número: <?= $user['user_phone_number'] ?></p>
                    <p class="text-sm text-gray-600"> <?= $user['user_sales_done'] ?> Ventas</p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-semibold">Calificación:</h3>
                <span class="flex items-center">
                    <?php
                        $calificacion = $user['user_rating'];
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
                    <p class="mx-3 text-black/[0.6]"> <?= $user['user_rating'] ?> (<?= $user['user_votes'] ?>) </p> 
                </span>
                <button class="bg-violet-600 text-white font-bold rounded-lg duration-300 hover:bg-violet-400 px-5 py-1 w-fit" onclick="<?= isset($_SESSION['user_id']) ?  "toggleModal('modalVendedor', ".$user['user_id'].", ".$user['user_rating'].", ".$user['user_votes'].")" : "login()" ?>">Votar</button>
            </div>
            <div class="">
                <h3 class="text-lg font-semibold">Descripción:</h3>
                <p><?= $user['user_description'] ?></p>
            </div>
        </div>

        <!-- Productos contenedor -->
        <div class="bg-white p-3 md:p-10 py-5 rounded-lg flex flex-col gap-5">
            <h3 class="text-2xl font-bold tracking-tight">Productos:</h3>
            <div class="w-full max-w-[650px] flex flex-col gap-2">
                <?php foreach ($products['data'] as $product): ?>
                    <?php if($product['product_state'] == 'private') { continue;} ?>
                    <article class="flex flex-col md:flex-row justify-between gap-4 bg-white p-4 rounded-lg shadow-lg border min-h-[250px]">
                        <div class="w-full md:w-3/12 max-h-[230px] flex items-center justify-center">
                            <img src="<?= $product['product_image'] ?>" alt="<?= $product['product_name']; ?>" class="max-w-full max-h-[230px]">
                        </div>
                        <div class="w-full md:w-7/12 flex flex-col justify-between gap-5">
                            <div class="flex flex-col gap-4">   
                                <div>
                                    <h2 class="text-[25px] tracking-tight"><?= $product['product_name']; ?></h2>
                                </div>                             
                                <p><?= $product['product_description']; ?></p>
                            </div>
                            <div class="w-full flex flex-col sm:flex-row justify-between">
                                <h3 class="font-medium text-xl"><?= number_format($product['product_price']); ?> COP</h3>
                                <span class="flex  gap-3"><span class="flex gap-3 items-center">
                                    <span>
                                        <?php
                                            $calificacion = $product['product_rating'];
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
                                    <p class="opacity-[0.4]"><?= $product['product_rating'] ?> (<?= $product['product_votes'] ?>)</p>
                                    <button class="text-violet-600 font-bold border-2 border-violet-600 duration-300 hover:bg-gray-100 size-[30px] rounded-full" onclick="<?= isset($_SESSION['user_id']) ?  "toggleModal('modalProducto', ".$product['product_id'].", ".$product['product_rating'].", ".$product['product_votes'].")" : "login()" ?>"><i class="fa-solid fa-plus"></i></button>
                                </span>
                            </div>
                        </div>
                        <span class="w-full sm:w-2/12 flex items-center justify-center">
                        <button class="rounded-full size-[60px] border-2 border-black btn-add-cart" data-product_id="<?= $product['product_id'] ?>" data-product_name="<?= $product['product_name'] ?>"data-user_id="<?= $product['user_id'] ?>"   data-product_price="<?= $product['product_price'] ?>" data-product_image="<?= $product['product_image'] ?>"  data-product_address="<?= $product['user_address'] ?>" <?= isset($_SESSION['user_id']) ? "data-session='true'" : "data-session='false'"?>><i class="fa-solid fa-cart-plus text-2xl"></i></button>
                        </span>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-center py-6">
                <ul class="inline-flex -space-x-px text-lg">
                    <?php if ($products['page'] > 1): ?>
                    <li>
                        <a href="/page/public_profile/?vendedor=<?=$user['user_id']?>&page=<?= $products['page'] - 1 ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Anterior</a>
                    </li>
                    <?php else: ?>
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg cursor-not-allowed opacity-50">Anterior</span>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $products['pages']; $i++): ?>
                    <li>
                        <a href="/page/public_profile/?vendedor=<?=$user['user_id']?>&page=<?= $i ?>" class=" flex items-center justify-center px-3 h-8 leading-tight border border-gray-500 duration-300 <?= $i == $products['page'] ? 'text-black bg-gray-300 font-semibold hover:bg-slate-700 hover:text-white' : 'text-gray-500 bg-gray-50 hover:bg-gray-300 hover:text-gray-700' ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($products['page'] < $products['pages']): ?>
                    <li>
                        <a href="/page/public_profile/?vendedor=<?=$user['user_id']?>&page=<?= $products['page'] + 1 ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Siguiente</a>
                    </li>
                    <?php else: ?>
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg cursor-not-allowed opacity-50">Siguiente</span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Modal para calificar al vendedor -->
        <div class="fixed inset-0 z-50 hidden" id="modalVendedor">
            <div id="modalBackgroundVendedor" class="fixed inset-0 bg-black bg-opacity-40" onclick="toggleModal('modalVendedor')"></div>
            <div id="myModalVendedor" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center ">
                <div class="w-full md:w-auto md:max-w-full md:min-w-[500px] bg-white p-5 rounded-md">
                    <span class="flex justify-between items-center">
                        <span class="text-lg font-bold">Califica al vendedor</span>
                        <button id="closeModalButtonVendedor" class="text-gray-500 hover:text-gray-700"  onclick="toggleModal('modalVendedor')">
                            <svg class="h-6 w-6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                    <p class="w-full max-w-[350px] text-center mx-auto py-4">Ten en cuenta el servicio que ha brindado el vendedor o la calidad de sus productos.</p>
                    <form id="rating-form-vendedor" class="flex flex-col gap-4">
                        <div id="starsVendedor" class="flex items-center justify-center gap-2 text-[20px]">
                            <span class="starVendedor" data-value="1"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="starVendedor" data-value="2"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="starVendedor" data-value="3"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="starVendedor" data-value="4"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="starVendedor" data-value="5"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                        </div>
                        <a class="hidden" id="btn-empty"></a>
                        <button type="submit" id="calificar-btn-vendedor" class="hidden bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Modal para calificar al producto -->
        <div class="fixed inset-0 z-50 hidden" id="modalProducto">
            <div id="modalBackgroundProducto" class="fixed inset-0 bg-black bg-opacity-40" onclick="toggleModal('modalProducto')"></div>
            <div id="myModalProducto" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center ">
                <div class="w-full md:w-auto md:max-w-full md:min-w-[500px] bg-white p-5 rounded-md">
                    <span class="flex justify-between items-center">
                        <span class="text-lg font-bold">Califica al producto</span>
                        <button id="closeModalButtonProducto" class="text-gray-500 hover:text-gray-700"  onclick="toggleModal('modalProducto')">
                            <svg class="h-6 w-6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                    <p class="w-full max-w-[350px] text-center mx-auto py-4">Califica este producto según tu experiencia con él.</p>
                    <form id="rating-form-producto" class="flex flex-col gap-4" method="post">
                        <div id="starsProducto" class="flex items-center justify-center gap-2 text-[20px]">
                            <span class="starProducto" data-value="1"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="starProducto" data-value="2"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="starProducto" data-value="3"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="starProducto" data-value="4"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="starProducto" data-value="5"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                        </div>
                        <a class="hidden" id="btn-empty"></a>
                        <button type="submit" id="calificar-btn-producto" class="hidden bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require_once(__DIR__ . "/../layout/footer.php") ?>
    <script src="/public/js/cart.js"></script>
    <script src="/public/js/rating.js"></script>
    <script>
        function toggleModal(modalId, id="", rating="", votes="") {
            document.getElementById(modalId).classList.toggle('hidden');
            let attribute = 'data-'+ (modalId == 'modalProducto' ? 'product_' : 'user_');
            document.querySelector(`#${modalId} button[type="submit"]`).setAttribute(`${attribute}id`, id);
            document.querySelector(`#${modalId} button[type="submit"]`).setAttribute(`${attribute}rating`, rating);
            document.querySelector(`#${modalId} button[type="submit"]`).setAttribute(`${attribute}votes`, votes);
        }
    </script>
</body>
</html>