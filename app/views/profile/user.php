<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full bg-gray-50">
    <?php require_once(__DIR__ . "/../layout/header.php") ?>
    <main class="w-full min-h-screen flex justify-center items-center">
    <form class="w-full flex justify-center items-start gap-5">
        <div class="bg-white p-5 rounded-lg shadow-lg w-2/12">
            <label for="image" class="block mb-2">Imagen:</label>
            <div class="flex items-center justify-center">
                <img src="<?= $user->image ?>" alt="Imagen de perfil" class="max-w-full max-h-full ">
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-4 w-5/12">      
            <div>
                <label for="full_name" class="block mb-2">Nombre Completo:</label>
                <input type="text" id="full_name" value="<?= $user->full_name; ?>" class="w-full border rounded-lg py-1 px-3">
            </div> 

            <div>
                <label for="username" class="block mb-2">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" value="<?= $user->username; ?>" class="w-full border rounded-lg py-1 px-3">
            </div>

            <div>
                <label for="email" class="block mb-2">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?= $user->email; ?>" class="w-full border rounded-lg py-1 px-3">
            </div>

            <div>
                <label for="address" class="block mb-2">Dirección:</label>
                <input type="text" id="address" name="address" value="<?= $user->address; ?>" class="w-full border rounded-lg py-1 px-3">
            </div>

            <div>
                <label for="phone_number" class="block mb-2">Número de Teléfono:</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?= $user->phone_number; ?>" class="w-full border rounded-lg py-1 px-3">
            </div>

            <label for="account_type" class="block mb-2">Tipo de Cuenta: <strong><?= ($user->account_type == 1) ? 'Normal' : 'Premium' ?></strong></label>
            
            <input type="submit" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max" value="Actualizar Perfil">
        </div>
    </form>

    </main>
</body>
</html>