<main class="w-full min-h-screen bg-slate-800">
    <!-- Parte superior -->
    <section class="w-full mx-auto">
        <div class="container mx-auto px-2 sm:px-5 flex flex-col gap-4 py-2 text-white">
            <span class="w-full max-w-[100vw] flex flex-col-reverse sm:flex-row gap-2 justify-between items-center">
                <div class="flex gap-4">
                    <!-- Opciones de ordenamiento -->
                    <div class="dropdown dropdown-hover">
                        <div tabindex="0" role="button" class="btn text-lg rounded-full bg-slate-900 size-[36px] text-white flex-none min-h-[0px]" data-theme="dark">
                            <i class="fa-solid fa-arrow-down-wide-short text-[19px]"></i>
                        </div>
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow text-black rounded-lg">
                            <h1 class="px-4 py-1.5 font-bold text-lg">Ordenar por:</h1>
                            <li><a href="/page/dashboard_users/<?= $this->buildQueryString(['sort' => 'usuario_id']) ?>">Id</a></li>
                            <li><a href="/page/dashboard_users/<?= $this->buildQueryString(['sort' => 'usuario_nombre']) ?>">Nombre</a></li>
                            <li><a href="/page/dashboard_users/<?= $this->buildQueryString(['sort' => 'usuario_alias']) ?>">Usuario</a></li>
                            <li><a href="/page/dashboard_users/<?= $this->buildQueryString(['sort' => 'usuario_correo']) ?>">Correo</a></li>
                            <li><a href="/page/dashboard_users/<?= $this->buildQueryString(['sort' => 'rol_nombre']) ?>">Rol</a></li>
                        </ul>
                    </div>

                    <!-- Formulario de búsqueda -->
                    <form action="/page/dashboard_users/" method="GET" class="flex gap-2">
                        <?php if (isset($_GET['search']) && !empty($_GET['search'])) : ?>
                            <a href="/page/dashboard_users/" class="fa-solid fa-arrows-rotate bg-slate-600 rounded-full size-[35px] flex items-center justify-center"></a>
                        <?php endif; ?>
                        <input type="text" name="search" class="bg-slate-600 rounded-full w-full max-w-[200px] px-5" placeholder="Buscar..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                        <button type="submit" class="bg-slate-600 rounded-full size-[35px]"><i class="fa-solid fa-magnifying-glass text-[15px]"></i></button>
                    </form>
                </div>

                <!-- Botón de perfil -->
                <div class="tooltip tooltip-bottom my-3" data-tip="Perfil de usuario">
                    <a href="/page/profile" class="size-[60px] overflow-hidden rounded-full tooltip">
                        <img src="<?= $user_session['usuario_imagen_url'] ?>" alt="profile" class="object-cover w-full h-full">
                    </a>
                </div>
            </span>
            <!-- Logo y titulos -->
            <span class="flex flex-col text-center items-center">
                <a href="/" class="size-[150px]">
                    <img src="/public/images/logo.png" alt="express-sale">
                </a>
                <h2 class="text-3xl tracking-tight font-bold uppercase">Panel de administrador</h2>
                <p class="opacity-75 font-semibold">Usuarios / productos</p>
            </span>
        </div>
    </section>
    <section class="w-full bg-gray-100 mt-5 px-3">
        <div class="container mx-auto px-0 sm:px-5 flex flex-col py-16">
            <!-- Parte superior de la tabla -->
            <span class="flex justify-between items-center p-3 bg-slate-800 text-white rounded-t-lg">
                <h2 class=" font-bold text-xl tracking-tight">Adminstrar usuarios</h2>

                <div class="tooltip cursor-pointer" data-tip="Cambiar de tabla">
                    <select class="bg-transparent focus:border-0 p-1 px-3 cursor-pointer" onchange="location = this.value;">
                        <option value="/page/dashboard_users" selected class="text-black">Usuarios</option>
                        <option value="/page/dashboard_products" class="text-black">Productos</option>
                    </select>
                </div>
            </span>

            <!-- Tabla de usuarios -->
            <div class="w-full">
                <div class="w-full overflow-x-auto">
                    <table class="table-auto border-collapse border border-gray-900 text-[13px] sm:text-[16px] text-center w-full">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">ID</th>
                                <th class="p-2 min-w-[200px]">Nombre</th>
                                <th class="p-2">Usuario</th>
                                <th class="p-2">Correo</th>
                                <th class="p-2">Rol</th>
                                <th class="p-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users['data'] as $user): ?>
                                <tr>
                                    <td class="p-2"><?= $user['usuario_id']; ?></td>
                                    <td class="p-2"><?= $user['usuario_nombre'] . " " . $user['usuario_apellido']; ?></td>
                                    <td class="p-2"><?= $user['usuario_alias']; ?></td>
                                    <td class="p-2"><?= $user['usuario_correo']; ?></td>
                                    <td class="p-2"><?= $user['rol_nombre'] ?></td>
                                    <td class="p-2 flex flex-col gap-3 sm:flex-row justify-center">
                                        <a href="/page/profile/?id=<?= $user['usuario_id'] ?>">
                                            <button class="p-[2px] sm:px-3 border-2 border-violet-800 text-violet-800 rounded-md font-bold duration-300 hover:bg-gray-200">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </a>
                                        <button id="btn-delete" onclick="if (confirm('¿Deseas eliminar este usuario?')) deleteElement(<?= $user['usuario_id'] ?>)"
                                            class="p-[2px] sm:px-3 bg-violet-800 text-white rounded-md font-bold duration-300 hover:bg-violet-600">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            <span class="pb-1 pt-4 flex flex-col md:flex-row gap-2 justify-between items-center">
                <p>
                    Viendo
                    <strong><?= ($page * $users['limit']) - $users['limit'] + 1 . " - " . count($users['data']) + ($page * $users['limit']) - $users['limit'] ?></strong> de
                    <strong><?= $users['rows'] ?></strong> resultados
                </p>

                <div class="flex gap-3">
                    <?php if ($page > 1): ?>
                        <a href="/page/dashboard_users/<?= $this->buildQueryString(['page' => $page - 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> anterior </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> anterior </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $users['pages']; $i++): ?>
                        <a href="/page/dashboard_users/<?= $this->buildQueryString(['page' => $i]) ?>" class="font-semibold bg-gray-200 size-[30px] flex items-center justify-center rounded-sm duration-300 <?= $i == $page ? 'bg-gray-400 font-bold' : ' hover:bg-gray-300' ?>"> <?= $i ?> </a>
                    <?php endfor; ?>

                    <?php if ($page < $users['pages']): ?>
                        <a href="/page/dashboard_users/<?= $this->buildQueryString(['page' => $page + 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> siguiente </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> siguiente </a>
                    <?php endif; ?>
                </div>
            </span>

        </div>
    </section>
    <!-- Footer -->
    <footer class="text-white text-md sm:text-xl tracking-tight text-center py-5">
        <p>&copy; Express Sale, 2024.</p>
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
                body: JSON.stringify({
                    'id': idUsuario
                }),
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