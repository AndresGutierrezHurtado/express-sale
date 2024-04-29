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
                    <p class="text-sm text-gray-600"> 0 Ventas</p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-semibold">Calificación:</h3>
                <span class="flex items-center">
                    <?php
                        $calificacion = $user -> rating;
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
                    <p class="mx-3 text-black/[0.6]"> <?= $user -> rating ?> (<?= $user -> votes ?>) </p> 
                </span>
                <button class="bg-violet-600 text-white font-bold rounded-lg duration-300 hover:bg-violet-400 px-5 py-1 w-fit" onclick="<?= isset($_SESSION['user_id']) ?  "toggleModal()" : "login()" ?>">Votar</button>
            </div>
            <div class="">
                <h3 class="text-lg font-semibold">Descripción:</h3>
                <p><?= $user -> description ?></p>
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
                                            $calificacion = $product['rating'];
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
                                    <p class="opacity-[0.4]"><?= $product['rating'] ?> (<?= $product['votes'] ?>)</p>
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
        
        <div class="fixed inset-0 z-50 hidden" id="modal">
            <div id="modalBackground" class="fixed inset-0 bg-black bg-opacity-40" onclick="toggleModal()"></div>
            <div id="myModal" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center ">
                <div class="w-full md:w-auto md:max-w-full md:min-w-[500px] bg-white p-5 rounded-md">
                    <span class="flex justify-between items-center">
                        <span class="text-lg font-bold">Califica al vendedor</span>
                        <button id="closeModalButton" class="text-gray-500 hover:text-gray-700"  onclick="toggleModal()">
                            <svg class="h-6 w-6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                    <p class="w-full max-w-[350px] text-center mx-auto py-4">Ten en cuenta el servicio que ha brindado el vendedor o la calidad de sus productos.</p>
                    <form id="rating-form" class="flex flex-col gap-4">
                        <div id="stars" class="flex items-center justify-center gap-2 text-[20px]">
                            <span class="star" data-value="1"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="star" data-value="2"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="star" data-value="3"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="star" data-value="4"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                            <span class="star" data-value="5"><i class="fa-regular fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"> </i></span>
                        </div>
                        <button id="calificar-btn" class="hidden bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">Calificar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require_once(__DIR__ . "/../layout/footer.php") ?>
    <script>        
        const stars = document.querySelectorAll('.star');
        const submitButton = document.getElementById('calificar-btn');

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

        document.getElementById('rating-form').addEventListener('submit' , (e) => {
            e.preventDefault();
            
            let seller = <?= $_GET['vendedor']?>;
            let votes = <?= $user -> votes?>;
            let currentRating = <?= $user -> rating ?>;

            let newRating = ((currentRating * votes) + parseInt(document.querySelector('.star.selected').dataset.value)) / (votes + 1);

            let formData = new FormData();
            
            formData.append('user_id', `${seller}`);
            formData.append('votes',  `${votes + 1}`);
            formData.append('rating', newRating);
            
            fetch('/user/update/', {
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

        function toggleModal() {
            document.getElementById('modal').classList.toggle('hidden');
        }

        function login () {
            alert('para votar tienes que iniciar sesión')
            window.location.href = "/page/login";
        }
    </script>
</body>
</html>