<?php 
function buildQueryString( $add = [], $remove = []) {
    $params = $_GET;
    $queryString = '?';
    foreach ($params as $key => $param) {
        if (!in_array($key, $remove) && !array_key_exists($key, $add)) {
            $queryString.= $key . '=' . $param . '&';
        }
    }
    foreach ($add as $key => $param) {
        $queryString.= $key . '=' . $param . '&';
    }
    return rtrim($queryString, '&');
}
?>
<main class="w-full min-h-screen bg-slate-800">
    <!-- Parte superior -->
    <section class="w-full mx-auto">
        <div class="container mx-auto px-2 sm:px-5 flex flex-col gap-4 py-2 text-white">                
            <span class="w-full flex flex justify-between items-center">
                <div class="flex gap-4">
                    <!-- Opciones de ordenamiento -->
                    <div class="relative">
                        <button class="text-lg rounded-full bg-slate-900 size-[35px]" onclick="toggleSortList()"><i class="fa-solid fa-arrow-down-wide-short"></i></button>
                        <div class="absolute top-[120%] left-1/2 transform -translate-x-1/2 bg-white flex flex-col rounded-md min-w-[150px] overflow-hidden duration-200 opacity-0" id="list-sort">
                            <h1 class="text-black text-md uppercase font-bold tracking-tight upercase p-1 px-3">Ordernar por:</h1>
                            <a href="/page/dashboard_users/<?= buildQueryString(['sort' => 'usuario_id']) ?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Id</a>
                            <a href="/page/dashboard_users/<?= buildQueryString(['sort' => 'usuario_nombre']) ?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Nombre</a>
                            <a href="/page/dashboard_users/<?= buildQueryString(['sort' => 'usuario_alias']) ?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Usuario</a>
                            <a href="/page/dashboard_users/<?= buildQueryString(['sort' => 'usuario_correo']) ?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Correo</a>
                            <a href="/page/dashboard_users/<?= buildQueryString(['sort' => 'rol_nombre']) ?>" class="text-black duraton-300 hover:bg-gray-200 p-1 px-3 cursor-pointer">Rol</a>
                        </div>
                    </div>

                    <!-- Formulario de búsqueda -->
                    <form action="/page/dashboard_users/" method="GET" class="flex gap-2">
                        <?php if (isset($_GET['search']) && !empty($_GET['search'])) : ?>
                            <a href="/page/dashboard_users/" class="fa-solid fa-arrows-rotate bg-slate-600 rounded-full size-[35px] flex items-center justify-center"></a>
                        <?php endif; ?>
                        <input type="text" name="search" class="bg-slate-600 rounded-full max-w-[150px] sm:min-w-[200px] lg:min-w-[300px] px-5" placeholder="Buscar..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                        <button type="submit" class="bg-slate-600 rounded-full size-[35px]"><i class="fa-solid fa-magnifying-glass text-[15px]"></i></button>
                    </form>
                </div>
                <!-- Botón de perfil -->
                <a href="/page/profile" class="size-[80px] overflow-hidden rounded-full">
                    <img src="<?= $user_session['usuario_imagen_url'] ?>" alt="profile" class="object-cover w-full h-full">
                </a>
            </span>
            <!-- Logo y titulos -->
            <span class="flex flex-col text-center items-center">
                <a href="/" class="size-[150px]">
                    <img src="/public/images/logo.png" alt="express-sale" >
                </a>
                <h2 class="text-3xl tracking-tight font-bold uppercase">Panel de administrador</h2>
                <p class="opacity-75 font-semibold">Usuarios / productos</p>
            </span>
        </div>
    </section >
    <section class="w-full bg-gray-100 mt-5">
        <div class="container mx-auto px-0 sm:px-5 flex flex-col py-16">
            <!-- Parte superior de la tabla -->
            <span class="flex justify-between items-center p-3 bg-slate-800 text-white rounded-t-lg">
                <h2 class=" font-bold text-xl tracking-tight">Adminstrar usuarios</h2>
                <select class="bg-transparent focus:border-0 p-1 px-3" onchange="location = this.value;">
                    <option value="/page/dashboard_users" selected class="text-black">Usuarios</option>
                    <option value="/page/dashboard_products" class="text-black">Productos</option>
                </select>
            </span>

            <!-- Tabla de usuarios -->
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
                        <td class="p-2"><?= $user['usuario_id']; ?></td>
                        <td class="p-2 hidden lg:table-cell"><?= $user['usuario_nombre'] . " " . $user['usuario_apellido']; ?></td>
                        <td class="p-2"><?= $user['usuario_alias']; ?></td>
                        <td class="p-2 hidden sm:table-cell"><?= $user['usuario_correo']; ?></td>
                        <td class="p-2"><?= $user['rol_nombre']?></td>
                        <td class="p-2 flex flex-col gap-3 sm:flex-row justify-center"> 
                            <a href="/page/profile/?id=<?= $user['usuario_id'] ?>"> 
                                <button class="p-[2px] sm:px-3 border-2 border-violet-800 text-violet-800 rounded-md font-bold duration-300 hover:bg-gray-200">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button> 
                            </a>
                            <button id="btn-delete" onclick="if (confirm('¿Deseas eliminar este usuario?')) deleteElement(<?= $user['usuario_id'] ?>)"
                            class="p-[2px] sm:px-3 bg-violet-800 text-white rounded-md font-bold duration-300 hover:bg-violet-600" >
                                <i class="fa-solid fa-trash-can"></i>
                            </button> 
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Paginación -->
            <span class="pb-1 pt-4 border-b flex flex-col md:flex-row justify-between items-center">
                <p>
                    Viendo 
                    <strong><?= ($page * $users['limit']) - $users['limit'] . " - " . count($users['data']) + ($page * $users['limit']) - $users['limit'] ?></strong> de 
                    <strong><?= $users['rows'] ?></strong> resultados
                </p>
                    
                <div class="flex gap-3">
                    <?php if($page > 1): ?>
                        <a href="/page/dashboard_users/<?= buildQueryString(['page' => $page - 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> anterior </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> anterior </a>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $users['pages']; $i++): ?>
                        <a href="/page/dashboard_users/<?= buildQueryString(['page' => $i]) ?>" class="font-semibold bg-gray-200 size-[30px] flex items-center justify-center rounded-sm duration-300 <?= $i == $page ? 'bg-gray-400 font-bold' : ' hover:bg-gray-300' ?>"> <?= $i ?> </a>
                    <?php endfor; ?>
                    
                    <?php if($page < $users['pages']): ?>
                        <a href="/page/dashboard_users/<?= buildQueryString(['page' => $page + 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> siguiente </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> siguiente </a>
                    <?php endif; ?>
                </div>

            </span>
        </div>
    </section>
    <!-- Footer -->
    <footer class="text-white text-md sm:text-xl tracking-tight text-center py-5">
        <p>&copy; Express Sale 2024.</p>
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
            alert(Data.message)
            if (Data.success) {
                alert(Data.message)
                window.location.reload();
            } 
        });
    }
</script>