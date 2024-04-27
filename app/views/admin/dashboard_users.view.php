<?php 
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administrador | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-800">
    <main class="w-full min-h-screen">
        <section class="w-full text-white">
            <div class="container mx-auto px-2 sm:px-5 flex flex-col gap-4 py-2">                
                <span class="w-full flex flex justify-between items-center">
                    <div class="flex gap-4">
                        <div class="relative">
                            <button class="text-lg rounded-full bg-slate-900 size-[35px]" onclick="toggleSortList()"><i class="fa-solid fa-arrow-down-wide-short"></i></button>
                            <div class="absolute top-[120%] left-1/2 transform -translate-x-1/2 bg-white flex flex-col rounded-md min-w-[150px] overflow-hidden duration-200 opacity-0" id="list-sort">
                                <h1 class="text-black text-md uppercase font-bold tracking-tight upercase p-1 px-3">Ordernar por:</h1>
                                <a href="/page/dashboard_users/?sort=user_id<?= buildQueryString(['search'])?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Id</a>
                                <a href="/page/dashboard_users/?sort=full_name<?= buildQueryString(['search'])?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Nombre</a>
                                <a href="/page/dashboard_users/?sort=username<?= buildQueryString(['search'])?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Usuario</a>
                                <a href="/page/dashboard_users/?sort=email<?= buildQueryString(['search'])?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Correo</a>
                                <a href="/page/dashboard_users/?sort=role_id<?= buildQueryString(['search'])?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Rol</a>
                            </div>
                        </div>
                        <form action="/page/dashboard_users/" method="GET" class="flex gap-2">
                            <?php if (isset($_GET['search']) && !empty($_GET['search'])) : ?>
                                <a href="/page/dashboard_users/" class="fa-solid fa-arrows-rotate bg-slate-600 rounded-full size-[35px] flex items-center justify-center"></a>
                            <?php endif; ?>
                            <input type="text" name="search" class="bg-slate-600 rounded-full max-w-[150px] sm:min-w-[200px] lg:min-w-[300px] px-5" placeholder="Buscar..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                            <button type="submit" class="bg-slate-600 rounded-full size-[35px]"><i class="fa-solid fa-magnifying-glass text-[15px]"></i></button>
                        </form>
                    </div>
                    <a href="/page/user_profile" class="w-[80px] rounded-full flex justify-center items-center overflow-hidden">
                        <img src="<?= $user_sesion -> image ?>" alt="profile" class="">
                    </a>
                </span>
                <span class="flex flex-col text-center items-center">
                    <a href="/" class="size-[150px]">
                        <img src="/public/images/logo.png" alt="express-sale" >
                    </a>
                    <h2 class="text-2xl tracking-tight font-bold uppercase">Panel de administrador</h2>
                    <p class="opacity-75">Usuarios / productos</p>
                </span>
            </div>
        </section >
        <section class="w-full bg-gray-100 mt-5">
            <div class="container mx-auto px-0 sm:px-5 flex flex-col py-16">
                <span class="flex justify-between items-center p-3 bg-slate-800 text-white rounded-t-lg">
                    <h2 class=" font-bold text-xl tracking-tight">Adminstrar usuarios</h2>
                    <select class="bg-transparent focus:border-0 p-1 px-3" onchange="location = this.value;">
                        <option value="/page/dashboard_users" selected class="text-black">Usuarios</option>
                        <option value="/page/dashboard_products" class="text-black">Productos</option>
                    </select>
                </span>
                <table class="table-auto border-collapse border border-gray-900 text-[13px] sm:text-[16px] text-center max-w-full" >
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">ID</th>
                            <th class="p-2 hidden lg:table-cell">Nombre</th>
                            <th class="p-2">Usuario</th>
                            <th class="p-2 hidden sm:table-cell">Correo</th>
                            <th class="p-2">Rol</th>
                            <th class="p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users['data'] as $user): ?>
                        <tr>
                            <td class="p-2"><?= $user['user_id']; ?></td>
                            <td class="p-2 hidden lg:table-cell"><?= $user['full_name']; ?></td>
                            <td class="p-2"><?= $user['username']; ?></td>
                            <td class="p-2 hidden sm:table-cell"><?= $user['email']; ?></td>
                            <td class="p-2"><?= $user['role_id'] == 3 ? 'Adminstrador' : ($user['role_id'] == 2 ? 'Vendedor' : 'Usuario'); ?></td>
                            <td class="p-2 flex flex-col gap-3 sm:flex-row justify-center"> 
                                <a href="/page/user_profile/?id=<?= $user['user_id'] ?>"> <button class="p-[2px] sm:px-3 border-2 border-violet-800 text-violet-800 rounded-md font-bold duration-300 hover:bg-gray-200"><i class="fa-solid fa-pen-to-square"></i></button> </a>
                                <button class="p-[2px] sm:px-3 bg-violet-800 text-white rounded-md font-bold duration-300 hover:bg-violet-600" id="btn-delete" onclick="deleteElement(<?= $user['user_id'] ?>)"><i class="fa-solid fa-trash-can"></i></button> 
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <span class="pb-1 pt-4 border-b flex flex-col md:flex-row justify-between items-center">
                    <p>Viendo <strong><?= count($users['data']) ?></strong> de <strong><?= $users['rows'] ?></strong> </p>
                    <div>
                        <ul class="inline-flex -space-x-px text-sm">
                            <?php if ($users['page'] > 1): ?>
                            <li>
                                <a href="/page/dashboard_users/?page=<?= $users['page'] - 1 ?><?= isset($_GET['sort']) ? "&sort=".$_GET['sort'] : '' ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                            </li>
                            <?php else: ?>
                            <li>
                                <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-s-lg cursor-not-allowed opacity-50">Previous</span>
                            </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $users['pages']; $i++): ?>
                            <li>
                                <a href="/page/dashboard_users/?page=<?= $i ?><?= isset($_GET['sort']) ? "&sort=".$_GET['sort'] : '' ?>" class=" flex items-center justify-center px-3 h-8 leading-tight border border-gray-500 duration-300 <?= $i == $users['page'] ? 'text-black bg-gray-300 font-semibold hover:bg-slate-700 hover:text-white' : 'text-gray-500 bg-gray-50 hover:bg-gray-300 hover:text-gray-700' ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if ($users['page'] < $users['pages']): ?>
                            <li>
                                <a href="/page/dashboard_users/?page=<?= $users['page'] + 1 ?><?= isset($_GET['sort']) ? "&sort=".$_GET['sort'] : '' ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                            </li>
                            <?php else: ?>
                            <li>
                                <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-50 border border-gray-500 rounded-e-lg cursor-not-allowed opacity-50">Next</span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </span>
            </div>
        </section>
        <footer class="text-white text-md sm:text-xl tracking-tight text-center py-5">
            <p>&copy; diseño de Express Sale. Todos los derechos reservados.</p>
        </footer>
    </main>
    <script>
        function toggleSortList() {
            document.getElementById('list-sort').classList.toggle('opacity-0');
            document.getElementById('list-sort').classList.toggle('opacity-100');
        }

        function deleteElement(idUsuario) {
            fetch('/user/delete', {
            method: 'POST',
            body: JSON.stringify({'id' : idUsuario}),
            })
            .then(Response => Response.json())
            .then(Data => {
                console.log(Data);
                if (Data.success) {
                    alert(Data.message)
                    window.location = '/page/dashboard_users';
                } else {
                    alert(Data.message)
                }

            });
        }
    </script>    
</body>
</html>