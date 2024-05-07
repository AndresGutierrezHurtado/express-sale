<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Producto | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-50">
    <?php require_once(__DIR__ . "/../layout/header.php") ?>
    <main class="w-full flex justify-center items-center px-5">
    <form id="product_profile_form" class="w-full flex flex-col md:flex-row justify-center items-start gap-5 my-12" enctype="multipart/form-data">
        <input type="hidden" id="id" name="product_id" value="<?= $_GET['id'] ?>">
        
        <div class="bg-white flex flex-col gap-4 p-5 rounded-lg shadow-lg w-full md:w-4/12 lg:w-3/12 xl:w-2/12">
            <h1 class="text-lg uppercase tracking-tight font-bold">Imagen:</h1>
            <div class="mx-auto size-full p-2">
                <img src="<?= $product['product_image'] ?>" alt="Imagen de perfil" class="object-cover rounded-lg shadow-lg">
            </div>
            <input type="file" id="image" name="product_image" class="hidden w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
            
            <button id="btn-edit" class="text-violet-800 border-2 border-violet-800 py-2 px-4 rounded-md mt-auto w-max font-bold cursor-pointer mb-3">Editar</button>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-4 w-full md:w-6/12 xl:w-5/12">   
            <h1 class="text-lg uppercase tracking-tight font-bold">Datos de <?= $product['product_name'] ?>:</h1>   
            <div class="flex flex-col gap-1">
                <label for="name" class="text-md font-medium text-gray-700">Nombre:</label>
                <input type="text" id="name" name="product_name" value="<?= $product['product_name']; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
            </div> 

            <div class="flex flex-col gap-1">
                <label for="description" class="text-md font-medium text-gray-700">Descripción:</label>
                <textarea id="description" name="product_description" class="w-full h-24 resize-none border rounded-lg py-1 px-3" disabled><?= $product['product_description']; ?></textarea>
            </div>

            <div class="flex flex-col gap-1">
                <label for="price" class="text-md font-medium text-gray-700">Precio:</label>
                <input type="text" id="price" name="product_price" value="<?= $product['product_price']; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
            </div>

            <div class="flex flex-col gap-1">
                <label for="stock" class="text-md font-medium text-gray-700">Stock:</label>
                <input type="text" id="stock" name="product_stock" value="<?= $product['product_stock']; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
            </div>

            <div class="flex flex-col gap-1">
                <label for="category" class="text-md font-medium text-gray-700">Categoría:</label>
                <select name="product_category_id" id="category_id" class="w-full border rounded-lg py-1 px-3" disabled>
                    <option value="1" <?= $product['product_category_id'] == '1' ? 'selected' : '' ?>>Moda</option>
                    <option value="2" <?= $product['product_category_id'] == '2' ? 'selected' : '' ?>>Comida</option>
                    <option value="3" <?= $product['product_category_id'] == '3' ? 'selected' : '' ?>>Tecnología</option>
                    <option value="4" <?= $product['product_category_id'] == '4' ? 'selected' : '' ?>>Otros</option>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label for="state" class="text-md font-medium text-gray-700">Estado:</label>
                <select name="product_state" id="state" class="w-full border rounded-lg py-1 px-3" disabled>
                    <option value="public" <?= $product['product_state'] == 'public' ? 'selected' : '' ?>>Public</option>
                    <option value="private" <?= $product['product_state'] == 'private' ? 'selected' : '' ?>>Private</option>
                </select>
            </div>

            <span class="w-full flex justify-between items-center">
                <div>
                    <button type="submit" id="btn-submit" name="submit" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold hidden">Actualizar Perfil</button>
                </div>
                
                <div class="flex gap-5">
                    <?= $_SESSION['user_role_id'] == 3 ? '<a href="/page/dashboard_products" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold"> Administrador </a>' : '' ?>
                </div>
            </span>
        </div>
    </form>

    </main>
    <script src="/public/js/product_profile.js"></script>
</body>
</html>