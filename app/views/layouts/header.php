<!-- Header -->
<header class="w-full bg-white flex justify-center sticky top-0 z-50 shadow-lg px-3">
    <nav class="w-full max-w-[1200px] flex flex-col gap-5 py-3 sm:gap-2">
        <!-- Header top section --> 
        <span class="flex flex-col sm:flex-row items-center gap-4 justify-between w-full">
            <div class="w-full sm:w-fit flex justify-between">
                <a href="/" class="flex items-center gap-3 font-sans text-xl">
                    <img src="/public/images/logo.png" alt="Logo navbar" class="max-h-[45px]"> Express Sale
                </a>
                <button class="px-3 sm:hidden" id="dropdown-menu-button"><i class="fa-solid fa-bars"></i></button>
            </div>

            <!-- Search form -->
            <form class="hidden md:block grow" action="/page/products/" method="GET" >
                <div class="flex justify-center">
                    <?php if (isset($_GET['search']) && !empty($_GET['search'])) : ?>
                        <a href="/page/products/" class="fa-solid fa-arrows-rotate border border-gray-800 mr-2 rounded-full size-[35px] flex items-center justify-center"></a>
                    <?php endif; ?>
                    <input type="text" name="search" placeholder="Buscar producto..." class="border rounded-l-xl border-gray-800 max-w-[500px] w-full p-1 px-3" value="<?= isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : '' ?>"> 
                    <button class="border rounded-r-xl border-gray-800 bg-gray-800 text-white rounded-r-md p-1 px-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>

            <!-- Account buttons -->
            <div class="flex gap-4">
                <?php if (isset($_SESSION['usuario_alias'])): ?> 
                    <a href="/page/user_profile" class="flex gap-3 items-center"> 
                        <i class="fa-regular fa-circle-user text-[25px]"></i> 
                        Mi cuenta 
                    </a> 
                    <a href="/page/cart" class="flex gap-3 items-center"> 
                        <i class="fa-solid fa-cart-shopping text-[15px]"></i> 
                        Carrito 
                    </a>                 
                <?php else: ?>
                    <a href="/page/login" class="flex gap-3 items-center"> 
                        <i class="fa-solid fa-right-to-bracket text-[18px]"></i> 
                        Registro 
                    </a> 
                <?php endif; ?>
                
                <?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 3): ?> 
                    <a href="/page/delivery_list" class="flex gap-3 items-center"> 
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