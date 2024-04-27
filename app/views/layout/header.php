<!-- Header -->
<header class="w-full bg-white flex justify-center sticky top-0 z-50 shadow-lg">
    <nav class="container px-5 flex flex-col gap-5 py-3 sm:gap-2">
        <!-- Header top section --> 
        <span class="flex flex-col sm:flex-row items-center gap-4 justify-between w-full">
            <a href="/" class="flex items-center gap-3">
                <img src="/public/images/logo.png" alt="Logo navbar" class="max-h-[45px]">
                <h2 class="font-sans text-xl">Express Sale</h2>
            </a>
            <form class="hidden md:block w-5/12" action="/page/products/" method="GET" >
                <div class="flex justify-center">
                    <?php if (isset($_GET['search']) && !empty($_GET['search'])) : ?>
                        <a href="/page/products/" class="fa-solid fa-arrows-rotate border border-gray-800 mr-2 rounded-full size-[35px] flex items-center justify-center"></a>
                    <?php endif; ?>
                    <input type="text" name="search" placeholder="Buscar producto..." class="border rounded-l-xl border-gray-800 max-w-[500px] w-full p-1 px-3"> 
                    <button class="border rounded-r-xl border-gray-800 bg-gray-800 text-white rounded-r-md p-1 px-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <div class="flex gap-4">
                <?php if (isset($_SESSION['username'])): ?> 
                    <a href="/page/user_profile" class="flex gap-3 items-center"> <i class="fa-regular fa-circle-user text-[25px]"></i> Mi cuenta </a> 
                    <a href="/page/user_cart" class="flex gap-3 items-center"> <i class="fa-solid fa-cart-shopping text-[15px]"></i> Carrito </a>                 
                <?php else: ?>
                    <a href="/page/login" class="flex gap-3 items-center"> <i class="fa-solid fa-right-to-bracket text-[22px]"></i> Registro </a> 
                <?php endif; ?>
            </div>
        </span>
        <!-- Header bottom section  -->
        <ul class="w-full sm:w-fit mx-auto">
            <li class="flex flex-col sm:flex-row w-full text-center gap-1 sm:gap-4 text-[18px] mx-auto">
                <a href="/" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Inicio</a> <div class="hidden sm:block">|</div> <hr class="block sm:hidden">
                <a href="/page/products" class="hover:scale-[1.05] hover:text-violet-800 duration-300">Productos</a><div class="hidden sm:block">|</div> <hr class="block sm:hidden">
                <a href="/" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Sobre Nosotros</a>                
            </li>
        </ul>
    </nav>
</header>