<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Express Sale</title>
    <link rel="shortcut icon" href="./public/img/logo.png" type="image/png">
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
    <header class="w-full bg-white flex justify-center sticky top-0">
        <nav class="container container-md">
            <span class="flex items-center pt-2 justify-between w-full">
                <div class="flex items-center gap-3">
                    <img src="./public/img/logo.png" alt="Logo navbar" class="max-h-[60px]">
                    <h2 class="font-sans text-xl">Express Sale</h2>
                </div>
                <form>
                    <div class="flex">
                        <input type="text" name="busqueda" placeholder="Buscar producto..." class="border rounded-l-xl border-gray-600 min-w-[400px] p-1 px-3"> 
                        <button class="border rounded-r-xl border-gray-600 bg-gray-600 text-white rounded-r-md p-1 px-3">B</button>
                    </div>
                </form>
                <a href="" class="text-lg">Express Sale Premium</a>
            </span>
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

        <section class="w-full min-h-[70hv]"  id="aboutUs">
            
        </section>

        <footer class="w-full min-h-[70hv]" >
            
        </footer>
    </main>
</body>
</html>
