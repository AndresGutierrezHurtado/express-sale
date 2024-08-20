<!-- Header -->
<header class="w-full bg-white flex justify-center sticky top-0 z-50 shadow-lg px-3">
    <nav class="w-full max-w-[1200px] flex flex-col gap-5 py-3 sm:gap-2 drawer drawer-end">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <!-- Header top section -->
        <span class="flex flex-col sm:flex-row items-center gap-4 justify-between w-full">
            <div class="w-full sm:w-fit flex justify-between">
                <a href="/" class="flex items-center gap-3 font-sans text-xl">
                    <img src="/public/images/logo.png" alt="Logo Express Sale" class="max-h-[45px]"> Express Sale
                </a>
                <div class="sm:hidden">
                    <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            class="inline-block h-6 w-6 stroke-current">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
            </div>

            <!-- Search form -->
            <form id="search-form" class="hidden lg:flex gap-2 items-center grow max-w-[550px]" action="/page/products/" method="GET">
                <?php if (isset($_GET['search']) && !empty($_GET['search'])) : ?>
                    <a href="/page/products/"
                        class="border border-gray-400 size-[35px] rounded flex items-center justify-center text-gray-600 bg-gray-50 duration-300 hover:bg-gray-100 hover:text-gray-700 focus:ring-1 focus:ring-violet-600 focus:ring-offset-2 focus:outline-none">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </a>
                <?php endif; ?>
                <div class="relative grow">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="search" placeholder="Buscar producto..." value="<?= isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : '' ?>"
                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-400 rounded-lg bg-gray-50 focus:ring-1 focus:ring-violet-600 focus:outline-none focus:border-violet-600" />
                    <button type="submit" class="text-black absolute top-1/2 right-5 -translate-y-1/2 font-medium text-sm hover:text-violet-600">Search</button>
                </div>
            </form>

            <!-- Account buttons -->
            <div class="flex gap-4">
                <?php if (isset($_SESSION['usuario_alias'])): ?>
                    <a href="/page/profile" class="flex gap-3 items-center">
                        <i class="fa-regular fa-circle-user text-[25px]"></i>
                        Mi cuenta
                    </a>
                    <a href="/page/cart" class="flex gap-3 items-center">
                        <i class="fa-solid fa-cart-shopping text-[15px]"></i>
                        Carrito
                    </a>
                <?php else: ?>
                    <a href="/page/login" class="flex gap-3 items-center tooltip tooltip-bottom" data-tip="Auntentícate">
                        <i class="fa-solid fa-right-to-bracket text-[18px]"></i>
                        Registro
                    </a>
                <?php endif; ?>

                <?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 3): ?>
                    <a href="/page/shipments" class="flex gap-3 items-center">
                        <i class="fa-solid fa-truck text-[15px]"></i>
                        Envíos
                    </a>
                <?php endif; ?>

                <?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 4): ?>
                    <a href="/page/dashboard_users" class="flex gap-3 items-center">
                        <i class="fa-solid fa-gear text-[15px]"></i>
                        Administrador
                    </a>
                <?php endif; ?>
            </div>
        </span>

        <!-- Header bottom section  -->
        <ul class="hidden sm:flex gap-4 text-[18px] w-fit mx-auto">
            <li class="duration-300 hover:text-violet-800 hover:scale-105"><a href="/">Inicio</a></li>|
            <li class="duration-300 hover:text-violet-800 hover:scale-105"><a href="/page/products">Productos</a></li>|
            <li class="duration-300 hover:text-violet-800 hover:scale-105"><a href="/page/home/#about">Sobre Nosotros</a></li>
        </ul>

        <!-- Header mobile section -->
        <div class="drawer-side sm:hidden">
            <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu bg-white min-h-screen w-80 max-w-full p-4 ">
                <!-- Inicio y cerrar -->
                <span class="flex justify-between">
                    <li>
                        <a href="/" class="h-full flex items-center">
                            <i class="fa-solid fa-home"></i>
                        </a>
                    </li>
                    <li>
                        <a>
                            <label for="my-drawer-3" aria-label="open sidebar font-bold">
                                <i class="fa-solid fa-x"></i>
                            </label>
                        </a>
                    </li>
                </span>

                <hr class="border-gray-500 my-3">

                <!-- Menu de navegación -->
                <div>
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/page/products">Productos</a></li>
                    <li><a href="/page/home/#aboutUs">Sobre Nosotros</a></li>
                </div>

                <div class="mt-auto flex flex-col gap-2">
                    <hr class="border-gray-500 my-3">
                    <?php if (isset($_SESSION['usuario_id'])) : ?>
                        <!-- Botón de cuenta y cerrar sesión -->
                        <a href="/page/profile"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-user-circle text-[18px] text-gray-300 duration-300 group-hover:text-gray-400"></i>
                            </span>
                            Mi cuenta
                        </a>
                        <a id="btn-logout-header"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-right-from-bracket text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                            </span>
                            Cerrar sesión
                        </a>
                    <?php else : ?>
                        <!-- Botón de iniciar sesión y registrarse -->
                        <a href="/page/register"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-user-plus text-[18px] text-gray-300 duration-300 group-hover:text-gray-400"></i>
                            </span>
                            Regístrate
                        </a>
                        <a href="/page/login"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-user-shield text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                            </span>
                            Inicia sesión
                        </a>
                    <?php endif ?>
                </div>

            </ul>
        </div>
    </nav>
</header>

<script>
    // Botón cerrar sesión
    if (document.getElementById('btn-logout-header')) {
        document.getElementById('btn-logout-header').addEventListener('click', () => {
            if (confirm('¿Estás seguro que quieres cerrar sesión?')) {
                fetch('/user/log_out')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.href = '/';
                        } else {
                            alert('hubo un problema.');
                        }
                    });
            }
        });
    }
</script>