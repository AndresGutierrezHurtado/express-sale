<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?= $user -> username ?> | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php require_once(__DIR__ . "/../layout/header.php")?>
    <main class="container mx-auto p-4 flex justify-center gap-10 py-12">
        <div class="w-full max-w-[400px] bg-white p-6 rounded-lg shadow-md h-fit flex flex-col gap-5">
            <h3 class="text-2xl font-bold tracking-tight">Información del vendedor:</h3>
            <div class="flex items-center space-x-4">
                <img src="<?= $user -> image; ?>" alt="Perfil" class="h-24 w-24 rounded-full">
                <div>
                    <h2 class="text-xl font-bold"><?= $user -> username; ?></h2>
                    <p class="text-sm text-gray-600">Ubicación: <?= $user -> address; ?></p>
                    <p class="text-sm text-gray-600">Número: <?= $user -> phone_number; ?></p>
                    <p class="text-sm text-gray-600"> * Ventas</p>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-lg font-semibold">calificacion:</h3>
                <span>
                    <i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-lg font-semibold">Descripción:</h3>
                <p>Descripción</p>
            </div>
        </div>
        <div class="bg-white p-10 py-5 rounded-lg flex flex-col gap-5">
            <h3 class="text-2xl font-bold tracking-tight">Productos:</h3>
            <div class="w-full max-w-[650px] flex flex-col gap-2">
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
                                </div>                             
                                <p><?= $product['description']; ?></p>
                            </div>
                            <div class="w-full flex justify-between">
                                <h3 class="font-medium text-xl"><?= number_format($product['price']); ?> COP</h3>
                                <span class="flex gap-3">
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
                                    <p class="opacity-[0.4]">(101)</p>
                                </span>
                            </div>
                        </div>
                        <span class="w-2/12 flex items-center justify-center">
                            <button class="rounded-full size-[60px] border-2 border-black btn-add-cart"  data-id="<?= $product['id'] ?>" data-name="<?= $product['name'] ?>" data-price="<?= $product['price'] ?>" data-image="<?= $product['image'] ?>"><i class="fa-solid fa-cart-plus text-2xl"></i></button>
                        </span>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-center py-6">
                <ul class="inline-flex -space-x-px text-lg">
                    <?php if ($products['page'] > 1): ?>
                    <li>
                        <a href="/page/public_profile/?vendedor=<?=$user -> user_id?>&page=<?= $products['page'] - 1 ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Anterior</a>
                    </li>
                    <?php else: ?>
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg cursor-not-allowed opacity-50">Anterior</span>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $products['pages']; $i++): ?>
                    <li>
                        <a href="/page/public_profile/?vendedor=<?=$user -> user_id?>&page=<?= $i ?>" class=" flex items-center justify-center px-3 h-8 leading-tight border border-gray-500 duration-300 <?= $i == $products['page'] ? 'text-black bg-gray-300 font-semibold hover:bg-slate-700 hover:text-white' : 'text-gray-500 bg-gray-50 hover:bg-gray-300 hover:text-gray-700' ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($products['page'] < $products['pages']): ?>
                    <li>
                        <a href="/page/public_profile/?vendedor=<?=$user -> user_id?>&page=<?= $products['page'] + 1 ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Siguiente</a>
                    </li>
                    <?php else: ?>
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg cursor-not-allowed opacity-50">Siguiente</span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </main>
    <?php require_once(__DIR__ . "/../layout/footer.php") ?>
</body>
</html>