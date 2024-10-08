<main class="w-full min-h-screen flex items-center justify-center bg-violet-500">
    <div class="w-full max-w-[600px] mx-auto">
        <div class="w-full p-5 bg-white rounded-lg shadow-lg space-y-5">
            <div class="space-y-1">
                <h1 class="text-2xl font-bold tracking-tight">Restablece tu contraseña</h1>
                <p>Ingresa tu nueva contraseña</p>
            </div>
            <form action="/user/reset_password" method="post" data-redirect="/page/login" class="fetch-form space-y-3">
                <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $result['usuario_id'] ?>">

                <div class="space-y-1">
                    <label for="usuario_contra" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="usuario_contra" id="usuario_contra"
                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-violet-600 focus:outline-none sm:text-sm" required>
                </div>

                <div class="space-y-1">
                    <label for="usuario_contra_confirmacion" class="block text-sm font-medium text-gray-700">Confirma contraseña</label>
                    <input type="password" id="usuario_contra_confirmacion"
                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-violet-600 focus:outline-none sm:text-sm" required>
                </div>

                <button type="submit" onclick="validarForm(event)" class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[17px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                    </span>
                    Cambiar contraseña
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    function validarForm(e) {
        e.preventDefault();
        // Verificar que las contraseñas coincidan
        if (document.getElementById('usuario_contra').value !== document.getElementById('usuario_contra_confirmacion').value) {
            Swal.fire({
                icon: "error",
                title: "Hubo un error",
                text: "Las contraseñas NO coinciden",
            });
        } else {
            e.target
                .closest("form")
                .dispatchEvent(new Event("submit", {
                    cancelable: true
                }));
        }
    }
</script>