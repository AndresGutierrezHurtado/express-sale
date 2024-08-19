<!-- Header -->
<header class="w-full bg-white flex justify-center sticky top-0 z-50 shadow-lg px-3">
    <nav class="w-full max-w-[1200px] flex flex-col gap-5 py-3 sm:gap-2">
        <!-- Header top section --> 
        <span class="flex flex-col sm:flex-row items-center gap-4 justify-between w-full">
            <div class="w-full sm:w-fit flex justify-between">
                <a href="/" class="flex items-center gap-3 font-sans text-xl">
                    <img src="/public/images/logo.png" alt="Logo Express Sale" class="max-h-[45px]"> Express Sale
                </a>
                <button class="px-3 sm:hidden" id="dropdown-menu-button"><i class="fa-solid fa-bars"></i></button>
            </div>

            <!-- Search form -->
            <form id="search-form" class="hidden md:flex gap-2 items-center grow max-w-[550px]" action="/page/products/" method="GET" >
                <?php if (isset($_GET['search']) && !empty($_GET['search'])) : ?>
                    <a href="/page/products/" 
                    class="border border-gray-400 size-[35px] rounded flex items-center justify-center text-gray-600 bg-gray-50 duration-300 hover:bg-gray-100 hover:text-gray-700 focus:ring-1 focus:ring-violet-600 focus:ring-offset-2 focus:outline-none">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </a>
                <?php endif; ?>
                <div class="relative grow">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
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
        <ul class="hidden md:flex gap-4 text-[18px] w-fit mx-auto">
            <li class="duration-300 hover:text-violet-800 hover:scale-105"><a href="/">Inicio</a></li>|
            <li class="duration-300 hover:text-violet-800 hover:scale-105"><a href="/page/products">Productos</a></li>|
            <li class="duration-300 hover:text-violet-800 hover:scale-105"><a href="/page/home/#about">Sobre Nosotros</a></li>
        </ul>

        <!-- Header mobile section -->
        <ul id="dropdown-ul" class="text-[18px] text-center hidden">
            <li class="p-2 rounded duration-300 hover:bg-gray-100"><a href="/">Inicio</a></li>
            <hr>
            <li class="p-2 rounded duration-300 hover:bg-gray-100"><a href="/page/products">Productos</a></li>
            <hr>
            <li class="p-2 rounded duration-300 hover:bg-gray-100"><a href="/page/home/#aboutUs">Sobre Nosotros</a></li>
        </ul>
    </nav>
</header>
<script>
document.getElementById('dropdown-menu-button').addEventListener('click', () => {
    document.getElementById('dropdown-ul').classList.toggle('hidden');
})
</script>