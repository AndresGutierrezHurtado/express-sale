<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-50">
    <?php require_once(__DIR__ . "/../layout/header.php") ?>
    <main class="w-full flex flex-col gap-10 py-12 justify-center items-center container mx-auto px-5">
        <form id="user_profile_form" class="w-full flex flex-col md:flex-row justify-between items-start gap-5" enctype="multipart/form-data">
            <input type="hidden" class="hidden" name="user_id" id="user_id" value="<?= isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'] ?>">

            <div class="bg-white flex flex-col gap-4 p-5 rounded-lg shadow-lg w-full w-full sm:w-[300px] mx-auto">
                <h1 class="text-lg uppercase tracking-tight font-bold">Imagen:</h1>
                <div class="w-full aspect-square [background-image:url('<?= $user['image_url'] ?>')] bg-cover bg-center rounded-lg shadow-lg"> </div>
                <input type="file" id="image" name="image" 
                class="hidden w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
                <button id="btn-edit" class="text-violet-800 border-2 border-violet-800 py-2 px-4 rounded-md mt-auto w-max font-bold cursor-pointer">Editar</button>
                <a class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold cursor-pointer" id="btn-logout">Cerrar sesión</a>
            </div>

            <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-4 w-full md:w-6/12 lg:w-9/12">
                <h1 class="text-lg uppercase tracking-tight font-bold">Datos de <?= $user['user_username'] ?>:</h1>
                <div class="flex flex-col gap-1">
                    <label for="full_name" class="text-md font-medium text-gray-700">Nombres:</label>
                    <input type="text" id="full_name" name="user_first_name" value="<?= $user['user_first_name']; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="full_name" class="text-md font-medium text-gray-700">Apellidos:</label>
                    <input type="text" id="full_name" name="user_last_name" value="<?= $user['user_last_name']; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="username" class="text-md font-medium text-gray-700">Nombre de Usuario:</label>
                    <input type="text" id="username" name="user_username" value="<?= $user['user_username']; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="email" class="text-md font-medium text-gray-700">Correo Electrónico:</label>
                    <input type="email" id="email" name="user_email" value="<?= $user['user_email']; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="address" class="text-md font-medium text-gray-700">Dirección:</label>
                    <input type="text" id="address_input" name="user_address" value="<?= $user['user_address']; ?>" class="w-full border rounded-lg py-1 px-3" disabled autocomplete="off">
                </div>

                <div class="flex flex-col gap-1">
                    <label for="phone_number" class="text-md font-medium text-gray-700">Número de Teléfono:</label>
                    <input type="number" id="phone_number" name="user_phone_number" value="<?= $user['user_phone_number']; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>

                <?php if ($user['user_role_id'] == 2 || $user['user_role_id'] == 3):?>
                    <div class="flex flex-col gap-1">
                        <label for="description" class="text-md font-medium text-gray-700">Descripción:</label>
                        <textarea type="text" id="description" name="worker_description" 
                        class="h-24 w-full border rounded-lg py-1 px-3 resize-none" disabled> <?= $user['worker_description'] ?> </textarea>
                    </div>
                <?php endif; ?>

                <label for="account_type">Tipo de Cuenta: <strong class="capitalize"> <?= $user['role_name']?> </strong></label>

                <span class="w-full flex justify-between items-center">
                    <div>
                        <button type="submit" id="btn-submit" name="submit" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold hidden">Actualizar Perfil</button>
                    </div>
                    <?php if ($_SESSION['user_role_id'] == 4):?>
                        <div class="flex justify-end gap-5">
                            <a href="/page/dashboard_users" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold"> Administrador </a>
                        </div>
                    <?php endif; ?>
                </span>
            </div>
        </form>

        
        <div class="w-full flex flex-col shadow-lg rounded-lg">
            <span class="w-full flex flex-col sm:flex-row gap-2 justify-between bg-slate-800 text-white p-3 rounded-t-lg">
                <h1 class="text-xl tracking-tight font-bold ">Compras de <?= $user['user_username'] ?></h1>
            </span>
            <div class="w-full bg-white flex flex-col gap-5 justify-center items-center p-5 rounded-b-lg">
                <table class="w-full table-auto border-collapse border border-gray-900 text-[13px] sm:text-[16px] text-center max-w-full" >
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">Compra</th>
                            <th class="p-2 hidden lg:table-cell">Productos</th>
                            <th class="p-2">Fecha</th>
                            <th class="p-2">Estado</th>
                            <th class="p-2">Precio</th>
                            <th class="p-2">Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="p-2"><?= $order['order_id']; ?></td>
                            <td class="p-2"><?php
                            foreach ($order['products'] as $product) {
                                echo $product['product_name'] . ' - '.$product['sold_product_quantity'].' ( producto/s.) <br>';
                            }
                            ?></td>
                            <td class="p-2"><?= $order['order_date'] ?></td>
                            <td class="p-2"> <?= $order['state_name'] ?> </td>
                            <td class="p-2"><?= number_format($order['order_amount']); ?> COP</td>
                            <td class="p-2"> 
                                <a href="/page/order_shift/?id=<?= $order['order_id'] ?>">
                                    <button class="p-[2px] sm:px-3 border-2 border-violet-800 text-violet-800 rounded-md font-bold duration-300 hover:bg-gray-200">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
                <?php if ($deliveries['rows'] < 1) : ?>
                    <p class="font-bold text-md">No se encontraron compras.</p>
                <?php endif;?>
            </div>
        </div>
        <?php if ( $user['user_role_id'] == 2 ) : ?> 
            <div class="w-full flex flex-col shadow-lg rounded-lg">
                <span class="w-full flex flex-col sm:flex-row gap-2 justify-between bg-slate-800 text-white p-3 rounded-t-lg">
                    <h1 class="text-xl tracking-tight font-bold ">Productos de <?= $user['user_username'] ?></h1>
                    <?php if ($_SESSION['user_role_id'] == 2) : ?>
                    <div class="flex gap-5">
                        <button class="bg-green-600 px-3 p-1 rounded-lg flex items-center gap-3" onclick="toggleModal()"> <i class="fa-solid fa-plus"></i> Añadir nuevo producto</button>
                    </div>
                    <?php endif; ?>
                </span>
                <div class="w-full bg-white flex flex-col gap-5 justify-center items-center p-5 rounded-b-lg">
                    <table class="w-full table-auto border-collapse border border-gray-900 text-[13px] sm:text-[16px] text-center max-w-full" >
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">ID</th>
                                <th class="p-2 hidden lg:table-cell">Nombre</th>
                                <th class="p-2">Precio</th>
                                <th class="p-2 hidden sm:table-cell">Stock</th>
                                <th class="p-2">Categoría</th>                            
                                <th class="p-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $products['data'] as $product ): ?>
                            <tr>
                                <td class="p-2"><?= $product['product_id']; ?></td>
                                <td class="p-2 hidden lg:table-cell"><?= $product['product_name']; ?></td>
                                <td class="p-2"><?= number_format($product['product_price']); ?> COP</td>
                                <td class="p-2 hidden sm:table-cell"><?= $product['product_stock']; ?></td>
                                <td class="p-2"><?= $product['category_name'] ?> </td>
                                <td class="p-2 flex flex-col gap-3 sm:flex-row justify-center"> 
                                    <a href="/page/product_profile/?id=<?= $product['product_id'] ?>"><button class="p-[2px] sm:px-3 border-2 border-violet-800 text-violet-800 rounded-md font-bold duration-300 hover:bg-gray-200"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                    <button class="p-[2px] sm:px-3 bg-violet-800 text-white rounded-md font-bold duration-300 hover:bg-violet-600 btn-delete" onclick="deleteElement(<?= $product['product_id'] ?>)"><i class="fa-solid fa-trash-can"></i></button> 
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div>
                    <ul class="inline-flex -space-x-px text-sm">
                        <?php if ($products['pages'] > 1): ?>
                            <li>
                                <a href="/page/user_profile/?id=<?= $user['user_id'] ?>&pageProducts=<?= $products['pageProducts'] - 1 ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                            </li>
                        <?php else: ?>
                            <li>
                                <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg cursor-not-allowed opacity-50">Previous</span>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $products['pages']; $i++): ?>
                            <li>
                                <a href="/page/user_profile/?id=<?= $user['user_id'] ?>&pageProducts=<?= $i ?>" class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-500 duration-300 <?= $i == $products['page'] ? 'text-black bg-gray-300 font-semibold hover:bg-slate-700 hover:text-white' : 'text-gray-500 bg-gray-50 hover:bg-gray-300 hover:text-gray-700' ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($products['page'] < $products['pages']): ?>
                            <li>
                                <a href="/page/user_profile/?id=<?= $user['user_id'] ?>&pageProducts=<?= $products['pageProducts'] + 1 ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                            </li>
                        <?php else: ?>
                            <li>
                                <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg cursor-not-allowed opacity-50">Next</span>
                            </li>
                        <?php endif; ?>
                    </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="fixed inset-0 hidden z-50" id="modal">
            <div id="modalBackground" class="fixed inset-0 bg-black bg-opacity-40" onclick="toggleModal()"></div>
            <div id="myModal" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-10/12 sm:w-8/12 md:w-6/12 lg:w-4/12 xl:w-2/12">
                <div class="w-full md:w-auto md:max-w-full md:min-w-[500px] bg-white p-5 rounded-md">
                    <span class="flex justify-between items-center mb-3">
                        <span class="text-lg font-bold">Nuevo producto:</span>
                        <button id="closeModalButton" class="text-gray-500 hover:text-gray-700"  onclick="toggleModal()">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                    <form id="new-product-form" class="flex flex-col gap-4">
                        <input type="hidden" id="product_user_id" name="product_user_id" value="<?= $user['user_id'] ?>">

                        <div class="flex flex-col gap-1">
                            <label for="product_name" class="text-md font-medium text-gray-700">Nombre:</label>
                            <input type="text" id="product_name" name="product_name" class="w-full border rounded-lg py-1 px-3" required>
                        </div> 

                        <div class="flex flex-col gap-1">
                            <label for="product_description" class="text-md font-medium text-gray-700">Descripción:</label>
                            <textarea id="product_description" name="product_description" class="w-full h-24 resize-none border rounded-lg py-1 px-3" required></textarea>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="product_price" class="text-md font-medium text-gray-700">Precio:</label>
                            <input type="text" id="product_price" name="product_price" class="w-full border rounded-lg py-1 px-3" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="product_stock" class="text-md font-medium text-gray-700">Stock:</label>
                            <input type="text" id="product_stock" name="product_stock" class="w-full border rounded-lg py-1 px-3" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="product_category_id" class="text-md font-medium text-gray-700">Categoría:</label>
                            <select name="product_category_id" id="product_category_id" class="w-full border rounded-lg py-1 px-3" required>
                                <option value="1">Moda</option>
                                <option value="2">Comida</option>
                                <option value="3">Tecnología</option>
                                <option value="4">Otros</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="product_state" class="text-md font-medium text-gray-700">Estado:</label>
                            <select name="product_state_id" id="product_state" class="w-full border rounded-lg py-1 px-3" required>
                                <option value="1">Público</option>
                                <option value="2" selected>Privado</option>
                            </select>
                        </div>

                        <button type="submit" id="btn-submit" name="submit" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold">Subir</button>
                    </form>

                </div>
            </div>
        </div>
    </main>
    <script>
        function toggleModal() {
            document.getElementById('modal').classList.toggle('hidden');
        }
        
        function deleteElement(idProducto) {
            fetch('/product/delete', {
            method: 'POST',
            body: JSON.stringify({'id' : idProducto}),
            })
            .then(Response => Response.json())
            .then(Data => {
                console.log(Data);
                if (Data.success) {
                    alert(Data.message)
                    window.location.reload();
                } else {
                    alert(Data.message)
                }
            });
        }        
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0&libraries=places&callback=initMap" async defer></script>
    <script>
        function initMap() {
            geocoder = new google.maps.Geocoder();
            autocomplete = new google.maps.places.Autocomplete(document.getElementById("address_input"));
        }
    </script>
    <script src="/public/js/user_profile.js"></script>
</body>
</html>