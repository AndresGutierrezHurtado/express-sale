<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen">   
    <?php require_once (__DIR__ . "/../layout/header.php"); ?> 
    <main>
        <!-- Introduction Section -->
        <section id="introduction" class="bg-violet-800 w-full min-h-[50vh] py-10 md:py-5 flex justify-center items-center">
            <div class="container px-5 flex flex-col md:flex-row justify-center gap-10">
                <div class="w-full md:w-6/12 flex flex-col justify-center gap-3">
                    <p class="text-white text-xl text-center">¡Bienvenidos a Express Sale, <br> acá podrás comprar diferentes productos de tiendas locales!</p>
                    <button class="p-1 px-3 border border-white rounded-md text-white font-bold w-fit mx-auto duration-300 hover:bg-white/[0.15]">Ver más</button>    
                </div>
                <div class="w-full md:w-5/12">
                    <img src="https://cdni.iconscout.com/illustration/free/thumb/free-online-shopping-4277122-3561282.png?f=webp" alt="intro photo" class="max-w-full">
                </div>

            </div>
        </section>

        <!-- Categories Section -->
        <section class="w-full min-h-[70hv]" id="categories">
            <div class="flex flex-col gap-10 justify-center items-center py-[70px] px-5">                
                <h1 class="text-3xl font-bold uppercase tracking-tight">Categorías</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-12">
                    <article class="bg-white p-4 rounded-3xl shadow-lg min-w-[250px] max-w-[300px] flex flex-col gap-4 duration-300 hover:scale-[1.04] hover:shadow-xl">
                        <div class="w-full max-h-[230px] flex justify-center items-center">
                            <img src="/public/images/calzado.jpg" alt="calzado" class="max-w-full max-h-full h-auto w-auto">                        
                        </div>
                        <h1 class="text-xl capitalize font-bold">Vestuario</h1>
                        <p>Busca las mejores tiendas locales de ropa y calzado.</p>
                        <a href="/page/products" class="w-full">
                            <button class="w-full p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600">Ver más</button>
                        </a>
                    </article>
                    
                    <article class="bg-white p-4 rounded-3xl shadow-lg min-w-[250px] max-w-[300px] flex flex-col gap-4 duration-300 hover:scale-[1.04] hover:shadow-xl">
                        <div class="w-full max-h-[230px] flex justify-center items-center">
                            <img src="/public/images/comida.jpg" alt="Comida" class="max-w-full max-h-full h-auto w-auto">                        
                        </div>
                        <h1 class="text-xl capitalize font-bold">Comida</h1>
                        <p>Busca las mejores restaurantes y tiendas de comida locales.</p>
                        <a href="/page/products" class="w-full">
                            <button class="w-full p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600">Ver más</button>
                        </a>
                    </article>

                    <article class="bg-white p-4 rounded-3xl shadow-lg min-w-[250px] max-w-[300px] flex flex-col gap-4 duration-300 hover:scale-[1.04] hover:shadow-xl">
                        <div class="w-full max-h-[230px] flex justify-center items-center">
                            <img src="/public/images/tencnologia.jpg" 
                            alt="otros" class="max-w-full max-h-full h-auto w-auto">                        
                        </div>
                        <h1 class="text-xl capitalize font-bold">Tecnología</h1>
                        <p>Busca los mejores productos de tecnología de las tiendas locales.</p>
                        <a href="/page/products" class="w-full">
                            <button class="w-full p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600">Ver más</button>
                        </a>
                    </article>

                    <article class="bg-white p-4 rounded-3xl shadow-lg min-w-[250px] max-w-[300px] flex flex-col gap-4 duration-300 hover:scale-[1.04] hover:shadow-xl">
                        <div class="w-full max-h-[230px] flex justify-center items-center">
                            <img src="/public/images/otros.jpg" alt="otros" class="max-w-full max-h-full h-auto w-auto">                        
                        </div>
                        <h1 class="text-xl capitalize font-bold">Otros</h1>
                        <p>Busca las mejores tiendas locales de ropa y calzado.</p>
                        <a href="/page/products" class="w-full">
                            <button class="w-full p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600">Ver más</button>
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <!-- About Us Section -->
        <div class="wavy-separator">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="bg-white">
                <path d="M0,0V46.29c47.93,27.21,138.91,41,238,41,107.24,0,204.38-16.6,265-36,70.43-22.53,145.5-46.51,238-25,63.84,14.85,137,53.25,234,53.25,119.33,0,187.67-45.83,238-71.29V0Z" opacity=".1" class="shape-fill"></path>
            </svg>
        </div>
        <section class="w-full min-h-[70hv] bg-white" id="aboutUs">
            <div class="container mx-auto flex flex-col md:flex-row justify-between items-center py-10 md:py-5 px-5">
                <div class="md:w-6/12">
                    <h1 class="text-3xl font-bold uppercase mb-4">Sobre Nosotros</h1>
                    <p class="text-gray-600 text-lg">
                        Express Sale es una empresa en el mercado de ventas online, dedicada a ofrecer los mejores productos de tiendas 
                        locales a los mejores precios. Nuestra misión es apoyar el crecimiento de los negocios locales proporcionando 
                        una plataforma accesible y eficiente para su promoción y distribución de productos.
                    </p>
                </div>
                <div class="md:w-4/12 flex justify-center mt-5 md:mt-0">
                    <img src="https://static.vecteezy.com/system/resources/previews/007/932/867/non_2x/about-us-button-about-us-text-template-for-website-about-us-icon-flat-style-vector.jpg" alt="About Us Image" class="max-w-full rounded-lg">
                </div>
            </div>
        </section>
    </main>
    <?php require_once (__DIR__ . "/../layout/footer.php"); ?> 
</body>
</html>
