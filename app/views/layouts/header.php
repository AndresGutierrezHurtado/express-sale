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
            <form id="search-form" class="hidden lg:flex gap-2 items-center justify-center grow max-w-[550px]" action="/page/products/" method="GET">
                <?php if (isset($_GET['search']) && !empty($_GET['search'])) : ?>
                    <a href="/page/products/"
                        class="btn btn-ghost btn-sm border border-gray-400/70">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </a>
                <?php endif; ?>
                <label class="input input-sm input-bordered w-full max-w-[400px] min-h-none h-auto py-0.5 px-3 flex items-center gap-2 focus-within:outline-offset-0 focus-within:outline-1 focus-within:outline-violet-600">
                    <input name="search" class="grow" placeholder="Buscar producto..." value="<?= isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : '' ?>" />
                    <button type="submit" class="btn btn-sm btn-ghost btn-circle">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16"
                            fill="currentColor"
                            class="h-4 w-4 opacity-70">
                            <path
                                fill-rule="evenodd"
                                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </label>
            </form>

            <!-- Account buttons -->
            <div class="flex gap-4">
                <?php if (isset($_SESSION['usuario']['usuario_alias'])): ?>
                    <a href="/page/profile" class="flex gap-2 items-center">
                        <i class="fa-regular fa-circle-user text-[25px]"></i>
                        Mi cuenta
                    </a>
                    <a href="/page/cart" class="flex gap-2 items-center">
                        <i class="fa-solid fa-cart-shopping text-[15px]"></i>
                        Carrito
                    </a>
                <?php else: ?>
                    <a href="/page/login" class="flex gap-2 items-center tooltip tooltip-bottom" data-tip="Auntentícate">
                        <i class="fa-solid fa-right-to-bracket text-[18px]"></i>
                        Registro
                    </a>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario']['rol_id']) && $_SESSION['usuario']['rol_id'] == 2): ?>
                    <a href="/page/stats/" class="flex gap-2 items-center">
                        <i class="fa-solid fa-truck-ramp-box text-[15px]"></i>
                        Vendedor
                    </a>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario']['rol_id']) && $_SESSION['usuario']['rol_id'] == 3): ?>
                    <a href="/page/stats/" class="flex gap-2 items-center">
                        <i class="fa-solid fa-truck text-[15px]"></i>
                        Domiciliario
                    </a>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario']['rol_id']) && $_SESSION['usuario']['rol_id'] == 4): ?>
                    <a href="/page/dashboard_users" class="flex gap-2 items-center">
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
            <ul class="menu bg-white min-h-[100dvh] w-80 max-w-full p-4 ">
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
                        <form action="/user/logout" method="post" class="fetch-form" data-redirect="/">
                            <button type="submit"
                                class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fa-solid fa-right-from-bracket text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                                </span>
                                Cerrar sesión
                            </button>
                        </form>
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