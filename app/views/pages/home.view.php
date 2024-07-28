
<main>
    <!-- Introduction Section -->
    <section class="w-full px-3 bg-violet-800">
        <div class="w-full max-w-[1200px] min-h-[500px] mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="grow flex flex-col gap-4 justify-center items-center">
                <p class="text-white text-2xl text-center">¡Bienvenidos a Express Sale, <br> acá podrás comprar diferentes productos de tiendas locales!</p>
                <a href="#categories" class="p-1 px-6 border border-white rounded-md text-white font-bold w-fit mx-auto duration-300 hover:bg-white/[0.15]">Ver más</a>   
            </div>
            <div class="grow">
                <img src="https://cdni.iconscout.com/illustration/free/thumb/free-online-shopping-4277122-3561282.png?f=webp" alt="intro photo" class="max-w-full">
            </div>
        </div>
    </section>

    <section class="w-full px-3" id="categories">
        <div class="w-full max-w-[1200px] mx-auto py-10 space-y-7">
            <h3 class="text-4xl font-bold uppercase tracking-tight text-center">Categorías</h1>
            <div class="grid-cols-[repeat(auto-fill,_minmax(250px,_300px))] ">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-12">

                <!-- Categoria vestuario -->
                <article class="max-w-[300px] mx-auto p-5 space-y-1 bg-white rounded-2xl shadow-lg duration-300 hover:scale-[1.03] hover:shadow-xl">
                    <div class="w-full h-[230px] overflow-hidden">
                        <img src="/public/images/calzado.jpg" alt="calzado" class="object-fit h-full w-full">                        
                    </div>
                    <h1 class="text-xl capitalize font-bold">Vestuario</h1>
                    <p> las mejores tiendas locales de ropa y calzado. </p>
                    <a href="/page/products/?categoria=1" class="w-full ">
                        <button class="w-full p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600 mt-[15px]">Ver más</button>
                    </a>
                </article>
                
                <!-- Categoria comida -->
                <article class="max-w-[300px] mx-auto p-5 space-y-1 bg-white rounded-2xl shadow-lg duration-300 hover:scale-[1.03] hover:shadow-xl">
                    <div class="w-full h-[230px] overflow-hidden">
                        <img src="/public/images/comida.jpg" alt="calzado" class="object-fit h-full w-full">                        
                    </div>
                    <h1 class="text-xl capitalize font-bold">Comida</h1>
                    <p> Busca las mejores restaurantes y tiendas de comida locales. </p>
                    <a href="/page/products/?categoria=2" class="w-full ">
                        <button class="w-full p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600 mt-[15px]">Ver más</button>
                    </a>
                </article>
                
                <!-- Categoria tecnología -->
                <article class="max-w-[300px] mx-auto p-5 space-y-1 bg-white rounded-2xl shadow-lg duration-300 hover:scale-[1.03] hover:shadow-xl">
                    <div class="w-full h-[230px] overflow-hidden">
                        <img src="/public/images/tecnologia.jpg" alt="calzado" class="object-fit h-full w-full">                        
                    </div>
                    <h1 class="text-xl capitalize font-bold">Tecnología</h1>
                    <p> Busca los mejores productos de tecnología de las tiendas locales. </p>
                    <a href="/page/products/?categoria=3" class="w-full ">
                        <button class="w-full p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600 mt-[15px]">Ver más</button>
                    </a>
                </article>
                
                <!-- Categoria otros -->
                <article class="max-w-[300px] mx-auto p-5 space-y-1 bg-white rounded-2xl shadow-lg duration-300 hover:scale-[1.03] hover:shadow-xl">
                    <div class="w-full h-[230px] overflow-hidden">
                        <img src="/public/images/otros.jpg" alt="calzado" class="object-fit h-full w-full">                        
                    </div>
                    <h1 class="text-xl capitalize font-bold">Otros</h1>
                    <p> Busca las mejores tiendas locales de ropa y calzado. </p>
                    <a href="/page/products/?categoria=4" class="w-full ">
                        <button class="w-full p-1 px-3 rounded-lg bg-violet-800 text-white font-bold duration-300 hover:bg-violet-600 mt-[15px]">Ver más</button>
                    </a>
                </article>
                
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <div class="wavy-separator" id="about">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="bg-white">
            <path d="M0,0V46.29c47.93,27.21,138.91,41,238,41,107.24,0,204.38-16.6,265-36,70.43-22.53,145.5-46.51,238-25,63.84,14.85,137,53.25,234,53.25,119.33,0,187.67-45.83,238-71.29V0Z" opacity=".1" class="shape-fill"></path>
        </svg>
    </div>

    <section class="w-full px-3 bg-white py-10">
        <div class="w-full max-w-[1200px] mx-auto flex flex-col md:flex-row items-center gap-4">
            <div class="w-full md:w-1/2 h-fit space-y-2">
                <h3 class="text-4xl font-bold uppercase tracking-tight">Sobre Nostros</h3>
                <p>
                    Express Sale es una empresa en el mercado de ventas online, dedicada a ofrecer los mejores productos de tiendas locales a los 
                    mejores precios. Nuestra misión es apoyar el crecimiento de los negocios locales proporcionando una plataforma accesible y 
                    eficiente para su promoción y distribución de productos.
                </p>
            </div>
            <div class="w-full md:w-1/2 h-fit">
                <img src="https://static.vecteezy.com/system/resources/previews/007/932/867/non_2x/about-us-button-about-us-text-template-for-website-about-us-icon-flat-style-vector.jpg" alt="Foto Sobre nostros">
            </div>
        </div>
    </section>
</main>