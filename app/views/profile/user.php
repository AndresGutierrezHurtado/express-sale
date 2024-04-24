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
    <main class="w-full flex justify-center items-center px-5">
        <form id="user_profile" class="w-full flex flex-col md:flex-row justify-center items-start gap-5 my-12" enctype="multipart/form-data">

            <input type="number" class="hidden" id="user_id" value="<?= isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'] ?>">

            <div class="bg-white flex flex-col gap-4 p-5 rounded-lg shadow-lg w-full md:w-4/12 lg:w-3/12 xl:w-2/12">
                <h1 class="text-lg uppercase tracking-tight font-bold">Imagen:</h1>
                <div class="mx-auto size-full p-2">
                    <img src="<?= $user->image ?>" alt="Imagen de perfil" class="object-cover rounded-lg shadow-lg">
                </div>
                <input type="file" id="image" name="image" class="hidden w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
                
                <button id="btn-edit" class="text-violet-800 border-2 border-violet-800 py-2 px-4 rounded-md mt-auto w-max font-bold cursor-pointer">Editar</button>
                <a class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold cursor-pointer" id="btn-logout">Cerrar sesión</a>
            </div>
            <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-4 w-full md:w-6/12 xl:w-5/12">   
                <h1 class="text-lg uppercase tracking-tight font-bold">Datos de <?= $user -> username ?>:</h1>   
                <div class="flex flex-col gap-1">
                    <label for="full_name" class="text-md font-medium text-gray-700">Nombre Completo:</label>
                    <input type="text" id="full_name" value="<?= $user->full_name; ?>" class="w-full border rounded-lg py-1 px-3" disabled>
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

                <label for="account_type" class="">Tipo de Cuenta: <strong><?= ($user->account_type == 1) ? 'Normal' : 'Premium' ?></strong></label>
                
                <span class="w-full flex justify-between items-center">
                    <div>
                        <button type="submit" id="btn-submit" name="submit" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold hidden">Actualizar Perfil</button>
                    </div>
                    
                    <div class="flex gap-5">
                        <?= $_SESSION['role_id'] == 2 ? '<a href="/page/dashboard_users" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold"> Administrador </a>' : '<a href="" class="border-2 p-1 px-3 border-violet-800  rounded-lg text-violet-800 font-bold cursor-pointer duration-300 hover:bg-gray-200"> Mis productos</a>' ?>
                    </div>
                </span>
            </div>
        </form>
    </main>
    <script src="/public/js/profile.js"></script>
</body>
</html>