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

            <input type="number" class="hidden" name="user_id" id="user_id" value="<?= isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'] ?>">

            <div class="bg-white flex flex-col gap-4 p-5 rounded-lg shadow-lg w-full md:w-4/12 lg:w-auto max-w-[320px] px-8 mx-auto">
                <h1 class="text-lg uppercase tracking-tight font-bold">Imagen:</h1>
                <div class="mx-auto size-full p-2">
                    <img src="<?= $user->image ?>" alt="Imagen de perfil" class="object-cover rounded-lg shadow-lg">
                </div>
                <input type="file" id="image" name="image" class="hidden w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
                <button id="btn-edit" class="text-violet-800 border-2 border-violet-800 py-2 px-4 rounded-md mt-auto w-max font-bold cursor-pointer">Editar</button>
                <a class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold cursor-pointer" id="btn-logout">Cerrar sesión</a>
            </div>
            <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-4 w-full md:w-6/12 lg:w-9/12">   
                <h1 class="text-lg uppercase tracking-tight font-bold">Datos de <?= $user -> username ?>:</h1>   
                <div class="flex flex-col gap-1">
                    <label for="full_name" class="text-md font-medium text-gray-700">Nombre Completo:</label>
                    <input type="text" id="full_name" name="full_name" value="<?= $user->full_name; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div> 

                <div class="flex flex-col gap-1">
                    <label for="username" class="text-md font-medium text-gray-700">Nombre de Usuario:</label>
                    <input type="text" id="username" name="username" value="<?= $user->username; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="email" class="text-md font-medium text-gray-700">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" value="<?= $user->email; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="address" class="text-md font-medium text-gray-700">Dirección:</label>
                    <input type="text" id="address" name="address" value="<?= $user->address; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="phone_number" class="text-md font-medium text-gray-700">Número de Teléfono:</label>
                    <input type="number" id="phone_number" name="phone_number" value="<?= $user->phone_number; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="description" class="text-md font-medium text-gray-700">Descripción:</label>
                    <textarea type="text" id="description" name="description" class="h-24 w-full border rounded-lg py-1 px-1 resize-none" disabled> <?= $user -> description ?> </textarea>
                </div>

                <label for="account_type" class="">Tipo de Cuenta: <strong> <?= $user -> role_id == 3 ? 'Adminstrador' : ($user -> role_id  == 2 ? 'Vendedor' : 'Usuario'); ?> </strong></label>
                
                <span class="w-full flex justify-between items-center">
                    <div>
                        <button type="submit" id="btn-submit" name="submit" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold hidden">Actualizar Perfil</button>
                    </div>
                    
                    <div class="flex justify-end gap-5">
                        <?= $_SESSION['role_id'] == 3 ? '<a href="/page/dashboard_users" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold"> Administrador </a>' : '' ?>
                    </div>
                </span>
            </div>
        </form>
        
        <?php if($user -> role_id == 2): ?>
        <div class="w-full flex flex-col shadow-lg rounded-lg">
            <span class="w-full flex flex-col sm:flex-row gap-2 justify-between bg-slate-800 text-white p-3 rounded-t-lg">
                <h1 class="text-xl tracking-tight font-bold ">Productos de <?= $user -> username ?></h1>
                <?php if ($_SESSION['role_id'] == 2) : ?>
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
                        <?php foreach ($products['data'] as $product): ?>
                        <tr>
                            <td class="p-2"><?= $product['id']; ?></td>
                            <td class="p-2 hidden lg:table-cell"><?= $product['name']; ?></td>
                            <td class="p-2"><?= number_format($product['price']); ?> COP</td>
                            <td class="p-2 hidden sm:table-cell"><?= $product['stock']; ?></td>
                            <td class="p-2"><?= ($product['category_id'] == 1) ? 'moda' : (($product['category_id'] == 2) ? 'comida' : (($product['category_id'] == 3) ? 'tecnología' : 'otros' )) ?>
                            </td>
                            <td class="p-2 flex flex-col gap-3 sm:flex-row justify-center"> 
                                <a href="/page/product_profile/?id=<?= $product['id'] ?>"><button class="p-[2px] sm:px-3 border-2 border-violet-800 text-violet-800 rounded-md font-bold duration-300 hover:bg-gray-200"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                <button class="p-[2px] sm:px-3 bg-violet-800 text-white rounded-md font-bold duration-300 hover:bg-violet-600 btn-delete" onclick="deleteElement(<?= $product['id'] ?>)"><i class="fa-solid fa-trash-can"></i></button> 
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div>
                <ul class="inline-flex -space-x-px text-sm">
                    <?php if ($products['page'] > 1): ?>
                        <li>
                            <a href="/page/user_profile/?id=<?= $user->user_id ?>&page=<?= $products['page'] - 1 ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg cursor-not-allowed opacity-50">Previous</span>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $products['pages']; $i++): ?>
                        <li>
                            <a href="/page/user_profile/?id=<?= $user->user_id ?>&page=<?= $i ?>" class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-500 duration-300 <?= $i == $products['page'] ? 'text-black bg-gray-300 font-semibold hover:bg-slate-700 hover:text-white' : 'text-gray-500 bg-gray-50 hover:bg-gray-300 hover:text-gray-700' ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($products['page'] < $products['pages']): ?>
                        <li>
                            <a href="/page/user_profile/?id=<?= $user->user_id ?>&page=<?= $products['page'] + 1 ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
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
                    <span class="flex justify-between items-center">
                        <span class="text-lg font-bold">Nuevo Objeto</span>
                        <button id="closeModalButton" class="text-gray-500 hover:text-gray-700"  onclick="toggleModal()">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                    <form id="new-product-form" class="flex flex-col gap-4">
                        <input type="hidden" id="user_id" name="user_id" value="<?= $user->user_id ?>">
                        <input type="hidden" id="image" name="image" value='/public/images/products/nf.jpg'>
                        <input type="hidden" id="calification" name="calification" value="0">

                        <div class="flex flex-col gap-1">
                            <label for="name" class="text-md font-medium text-gray-700">Nombre:</label>
                            <input type="text" id="name" name="name" class="w-full border rounded-lg py-1 px-3" required>
                        </div> 

                        <div class="flex flex-col gap-1">
                            <label for="description" class="text-md font-medium text-gray-700">Descripción:</label>
                            <textarea id="description" name="description" class="w-full h-24 resize-none border rounded-lg py-1 px-3" required></textarea>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="price" class="text-md font-medium text-gray-700">Precio:</label>
                            <input type="text" id="price" name="price" class="w-full border rounded-lg py-1 px-3" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="stock" class="text-md font-medium text-gray-700">Stock:</label>
                            <input type="text" id="stock" name="stock" class="w-full border rounded-lg py-1 px-3" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="category" class="text-md font-medium text-gray-700">Categoría:</label>
                            <select name="category" id="category" class="w-full border rounded-lg py-1 px-3" required>
                                <option value="1">Moda</option>
                                <option value="2">Comida</option>
                                <option value="3">Tecnología</option>
                                <option value="4">Otros</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="state" class="text-md font-medium text-gray-700">Estado:</label>
                            <select name="state" id="state" class="w-full border rounded-lg py-1 px-3" required>
                                <option value="public">Public</option>
                                <option value="private">Private</option>
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
                    window.location = '/page/user_profile/?id=<?= $user -> user_id; ?>';
                } else {
                    alert(Data.message)
                }

            });
        }        
    </script>
    <script src="/public/js/user_profile.js"></script>
</body>
</html>