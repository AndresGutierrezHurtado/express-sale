<!-- Footer Section -->
<footer class="w-full bg-indigo-950 px-3">
    <div class="w-full max-w-[1200px] mx-auto py-10 flex flex-col md:flex-row justify-between items-center md:items-start gap-5 text-white ">

        <!-- Columna con datos de contácto -->
        <div class="flex flex-col gap-2 text-lg">
            <h2 class="font-bold text-2xl mb-3 uppercase tracking-tight"> Contacto </h2>
            <p class="flex gap-2 items-center"> <i class="fa-solid fa-phone text-xl"></i> (+57) 320 9202177 </p>
            <p class="flex gap-2 items-center"> <i class="fa-regular fa-envelope text-xl"></i> expresssale.exsl@gmail.com </p>
            <p class="flex gap-2 items-center"> <i class="fa-brands fa-instagram text-xl"></i> express_sale </p>
            <p class="flex gap-2 items-center"> <i class="fa-brands fa-facebook text-xl"></i> Express Sale </p>
        </div>

        <!-- Columna formulario de contácto -->
        <div class="grow flex flex-col gap-2 p-0 max-w-[520px]">
            <h2 class="font-bold text-2xl mb-3 uppercase tracking-tight text-center"> ¡Queremos escucharte! </h2>

            <div class="collapse collapse-ghost collapse-arrow">
                <input type="checkbox" />
                <div class="collapse-title text-xl font-medium">Haz clic para mostrar/ocultar</div>
                <div class="collapse-content">
                    <form action="/mail/contact_form/" method="POST" class="fetch-form space-y-1">

                        <div class="form-control flex flex-col md:flex-row gap-2">
                            <div class="grow">
                                <label class="label">
                                    <span class="label-text text-neutral-content font-bold after:content-['*'] after:ml-0.5 after:text-red-500">Nombres</span>
                                </label>
                                <input name="usuario_nombre" placeholder="Ingresa tus nombres" class="input input-bordered w-full text-neutral" required />
                            </div>
                            <div class="grow">
                                <label class="label">
                                    <span class="label-text text-neutral-content font-bold after:content-['*'] after:ml-0.5 after:text-red-500">Apellidos</span>
                                </label>
                                <input name="usuario_apellido" placeholder="Ingresa tus apellidos" class="input input-bordered w-full text-neutral" required />
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-neutral-content font-bold after:content-['*'] after:ml-0.5 after:text-red-500">Correo electrónico</span>
                            </label>
                            <input type="email" name="usuario_correo" placeholder="ejemplo@gmail.com" class="input input-bordered text-neutral" required />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-neutral-content font-bold after:content-['*'] after:ml-0.5 after:text-red-500">Asunto</span>
                            </label>
                            <input name="correo_asunto" placeholder="Ingresa el tema de tu consulta" class="input input-bordered text-neutral" required />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-neutral-content font-bold after:content-['*'] after:ml-0.5 after:text-red-500">Mensaje</span>
                            </label>
                            <textarea name="correo_mensaje" placeholder="Ingresa tu consulta/mensaje." required
                            class="textarea textarea-bordered text-neutral h-32 resize-none"></textarea>
                        </div>

                        <div class="form-control">
                            <button class="btn btn-outline text-lg mt-5" data-theme="dark">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna de logo de la página -->
        <div class="flex justify-center">
            <img src="/public/images/logo.png" alt="Nature Image" class="rounded-lg class h-auto h-fit max-h-72">
        </div>
    </div>
</footer>