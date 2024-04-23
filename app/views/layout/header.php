<?php
session_start();
?>

<!-- Header -->
<header class="w-full bg-white flex justify-center sticky top-0 z-50 shadow-lg">
    <nav class="container px-5 flex flex-col gap-5 sm:gap-2">
        <!-- Header top section --> 
        <span class="flex flex-col sm:flex-row items-center pt-2 justify-between w-full">
            <a href="/" class="flex items-center gap-3">
                <img src="/public/images/logo.png" alt="Logo navbar" class="max-h-[45px]">
                <h2 class="font-sans text-xl">Express Sale</h2>
            </a>
            <form class="hidden md:block w-5/12">
                <div class="flex justify-center">
                    <input type="text" name="busqueda" placeholder="Buscar producto..." class="border rounded-l-xl border-gray-800 max-w-[500px] w-full p-1 px-3"> 
                    <button class="border rounded-r-xl border-gray-800 bg-gray-800 text-white rounded-r-md p-1 px-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <a href="" class="text-lg">Express Sale Premium</a>
        </span>
        <!-- Header bottom section  -->
        <ul class="flex justify-center items-center pb-4">
            <li class="flex gap-4 text-[18px]">
                <a href="/" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Inicio</a>|
                <a href="/page/products" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Productos</a>|
                <a href="/" class="hover:scale-[1.05] hover:text-violet-800	duration-300 hidden md:block">Sobre Nosotros</a> <div class="hidden md:block">|</div>
                <a href="<?= $_SESSION['username'] ? 'page/userProfile' : '/page/login' ?>" class="hover:scale-[1.05] hover:text-violet-800	duration-300"> <?= $_SESSION['username'] ? 'Mi cuenta' : 'Registro' ?> </a> 
            </li>
        </ul>
    </nav>
</header>