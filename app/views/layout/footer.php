<!-- Footer Section -->
<footer class="w-full bg-indigo-950	text-white py-10">
    <div class="container px-5 mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-8">
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
            <form action="#" method="POST" class="flex flex-col gap-2">
                <input type="email" name="email" placeholder="correo electronico" class="p-2 text-gray-800 w-full rounded-sm border-gray-300">
                <div class="div-group flex flex-col lg:flex-row  gap-2">
                    <input type="email" name="email" placeholder="Nombre" class="p-2 text-gray-800 w-full lg:w-1/2 rounded-sm border-gray-300">
                    <input type="email" name="email" placeholder="Asunto" class="p-2 text-gray-800 w-full lg:w-1/2 rounded-sm border-gray-300">
                </div>
                <textarea name="mensaje" class="h-28 w-full p-2 resize-none border rounded-sm border-gray-300" placeholder="Escribe tu mensaje aquí..."></textarea>
                <button type="submit" class="p-2 w-full duration-300 bg-transparent border-2 border-white rounded-xl hover:bg-white/[0.1] text-lg tracking-tight uppercase font-bold">Enviar</button>
            </form>
        </div>
        <!-- Footer Image Column -->
        <div class="flex justify-center">
            <img src="/public/assets/images/logo.png" alt="Nature Image" class="rounded-lg class h-auto h-fit max-h-72">
        </div>
    </div>
</footer>