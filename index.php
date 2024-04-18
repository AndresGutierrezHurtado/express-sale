<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Express Sale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            clifford: '#da373d',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-200 min-h-screen">
    <header class="w-full bg-white flex justify-center sticky top-0">
        <nav class="container container-md">
            <span class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <img src="./public/img/logo.png" alt="Logo navbar" class="max-h-[60px]">
                    <h2 class="font-sans text-xl">Express Sale</h2>
                </div>
                <form>
                    <div class="flex">
                        <input type="text" name="busqueda" class="border rounded-l-md border-gray-400 min-w-[400px] p-1 px-3"> <button class="border rounded-r-md border-gray-600 bg-gray-600 text-white rounded-r-md p-1 px-3">B</button>
                    </div>
                </form>
                <a href="" class="text-lg">Express Sale Premium</a>
            </span>
            <ul class="flex justify-center items-center pt-2 pb-4">
                <li class="flex gap-4 text-lg"> 
                    <a href="index.php" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Inicio</a>|
                    <a href="products.php" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Productos</a>|
                    <a href="login.php" class="hover:scale-[1.05] hover:text-violet-800	duration-300">Registro</a> 
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="introduction" class="bg-violet-800 w-full min-h-[600px] h-[50vh] flex justify-center items-center">
            <div class="container container-md flex justify-center gap-10">
                <div class="flex flex-col justify-center gap-3">
                    <p class="text-white text-xl text-center">¡Bienvenidos a Express Sale, <br> acá podrás comprar diferentes productos de tiendas locales!</p>
                    <button class="p-1 px-3 border border-white rounded-md text-white font-bold w-fit mx-auto">Ver más</button>    
                </div>
                <img src="https://cdni.iconscout.com/illustration/free/thumb/free-online-shopping-4277122-3561282.png?f=webp" alt="intro photo" class="max-w-[550px]">
            </div>
        </section>

        <section id="categories">
            <h1>Categorías</h1>
            <div>
                <article>
                    <h1>Vestuario</h1>
                </article>
                <article>
                    <h1>Comida</h1>
                </article>
                <article>
                    <h1>Otros</h1>
                </article>
            </div>
        </section>

        <section id="aboutUs">

        </section>

        <footer>
            
        </footer>
    </main>
</body>
</html>
