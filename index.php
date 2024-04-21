<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Express Sale</title>
    <link rel="shortcut icon" href="./public/img/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            example: '#da373d',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-200 min-h-screen">
    <!-- Header -->
    <header class="w-full bg-white flex justify-center sticky top-0">
        <!-- Header parte superior --> 
        <nav class="container container-md">
            <span class="flex items-center pt-2 justify-between w-full">
                <div class="flex items-center gap-3">
                    <img src="./public/img/logo.png" alt="Logo navbar" class="max-h-[45px]">
                    <h2 class="font-sans text-xl">Express Sale</h2>
                </div>
                <form>
                    <div class="flex">
                        <input type="text" name="busqueda" placeholder="Buscar producto..." class="border rounded-l-xl border-gray-800 min-w-[400px] p-1 px-3"> 
                        <button class="border rounded-r-xl border-gray-800 bg-gray-800 text-white rounded-r-md p-1 px-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                <a href="" class="text-lg">Express Sale Premium</a>
            </span>
        <!-- Header parte inferior -->
            <ul class="flex justify-center items-center pt-2 pb-4">
                <li class="flex gap-4 text-[18px]"> 
                    <a href="index.php" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Inicio</a>|
                    <a href="products.php" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Productos</a>|
                    <a href="login.php" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Registro</a> 
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="introduction" class="bg-violet-800 w-full h-[50vh] flex justify-center items-center">
            <div class="container container-md flex justify-center gap-10">
                <div class="flex flex-col justify-center gap-3">
                    <p class="text-white text-xl text-center">¡Bienvenidos a Express Sale, <br> acá podrás comprar diferentes productos de tiendas locales!</p>
                    <button class="p-1 px-3 border border-white rounded-md text-white font-bold w-fit mx-auto">Ver más</button>    
                </div>
                <img src="https://cdni.iconscout.com/illustration/free/thumb/free-online-shopping-4277122-3561282.png?f=webp" alt="intro photo" class="max-w-[550px]">
            </div>
        </section>

        <section class="w-full min-h-[70hv]" id="categories">
            <div class="flex flex-col gap-10 justify-center items-center py-5">                
                <h1 class="text-3xl font-bold uppercase tracking-tight">Categorías</h1>
                <div class="grid grid-cols-3 gap-16">
                    <article class="bg-white p-4 rounded-3xl shadow-lg min-w-[250px] max-w-[300px] flex flex-col gap-4 duration-300 hover:scale-[1.04] hover:shadow-xl">
                        <div class="w-full max-h-[230px] flex justify-center items-center">
                            <img src="./public/img/calzado.jpg" alt="" class="max-w-full max-h-full h-auto w-auto">                        
                        </div>
                        <h1 class="text-xl capitalize font-bold">Vestuario</h1>
                        <p>Busca las mejores tiendas locales de ropa y calzado.</p>
                        <button class="p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600">Ver más</button>
                    </article>
                    
                    <article class="bg-white p-4 rounded-3xl shadow-lg min-w-[250px] max-w-[300px] flex flex-col gap-4 duration-300 hover:scale-[1.04] hover:shadow-xl">
                        <div class="w-full max-h-[230px] flex justify-center items-center">
                            <img src="./public/img/comida.jpg" alt="" class="max-w-full max-h-full h-auto w-auto">                        
                        </div>
                        <h1 class="text-xl capitalize font-bold">Comida</h1>
                        <p>Busca las mejores restaurantes y tiendas de comida locales.</p>
                        <button class="p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600">Ver más</button>
                    </article>
                    <article class="bg-white p-4 rounded-3xl shadow-lg min-w-[250px] max-w-[300px] flex flex-col gap-4 duration-300 hover:scale-[1.04] hover:shadow-xl">
                        <div class="w-full max-h-[230px] flex justify-center items-center">
                            <img src="./public/img/otros.jpg" alt="" class="max-w-full max-h-full h-auto w-auto">                        
                        </div>
                        <h1 class="text-xl capitalize font-bold">Otros</h1>
                        <p>Busca las mejores tiendas locales de ropa y calzado.</p>
                        <button class="p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600">Ver más</button>
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
            <div class="container mx-auto flex flex-col md:flex-row justify-between items-center py-10 px-5">
                <div class="md:w-6/12">
                    <h1 class="text-3xl font-bold uppercase mb-4">Sobre Nosotros</h1>
                    <p class="text-gray-600 text-lg">
                        Express Sale es una empresa líder en el mercado de ventas online, dedicada a ofrecer los mejores productos de tiendas locales a los precios más competitivos. Nuestra misión es apoyar el crecimiento de los negocios locales proporcionando una plataforma accesible y eficiente para su promoción y distribución de productos.
                    </p>
                </div>
                <div class="md:w-4/12 flex justify-center mt-5 md:mt-0">
                    <img src="https://static.vecteezy.com/system/resources/previews/007/932/867/non_2x/about-us-button-about-us-text-template-for-website-about-us-icon-flat-style-vector.jpg" alt="About Us Image" class="max-w-full rounded-lg">
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        <footer class="w-full bg-indigo-950	text-white py-10">
            <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Contact & Social Media Column -->
                <div class="flex flex-col gap-2 text-lg">
                    <h2 class="font-bold text-2xl mb-3 uppercase tracking-tight"> Contacto </h2>
                    <p class="flex gap-2 items-center"> <i class="fa-solid fa-phone text-xl"></i> (+57) 320 9202177</p>
                    <p class="flex gap-2 items-center"> <i class="fa-regular fa-envelope text-xl"></i> support@expresssale.com</p>
                    <p class="flex gap-2 items-center"> <i class="fa-brands fa-instagram text-xl"></i> express-sale</p>
                    <p class="flex gap-2 items-center"> <i class="fa-brands fa-facebook text-xl"></i> Express Sale</p> 
                </div>
                <!-- Newsletter Form Column -->
                <div class="flex flex-col gap-2">
                    <h2 class="font-bold text-2xl mb-3 uppercase tracking-tight"> ¡Queremos escucharte! </h2>
                    <form action="#" method="POST">
                        <input type="email" name="email" placeholder="correo electronico" class="p-2 text-gray-800 w-full mb-2 rounded-md border-gray-300">
                        <div class="div-group flex  gap-2">
                            <input type="email" name="email" placeholder="Nombre" class="p-2 text-gray-800 w-1/2 mb-2 rounded-md border-gray-300">
                            <input type="email" name="email" placeholder="Asunto" class="p-2 text-gray-800 w-1/2 mb-2 rounded-md border-gray-300">
                        </div>
                        <textarea name="mensaje" class="h-28 w-full p-2 resize-none border rounded-md border-gray-300" placeholder="Escribe tu mensaje aquí..."></textarea>
                        <button type="submit" class="p-2 bg-blue-500 w-full hover:bg-blue-600 transition duration-200">Enviar</button>
                    </form>
                </div>
                <!-- Footer Image Column -->
                <div class="flex justify-center">
                    <img src="./public/img/logo.png" alt="Nature Image" class="rounded-lg class max-h-72">
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
