<main class="w-full min-h-screen flex items-center justify-center bg-violet-500">
    <div class="w-full max-w-[600px] mx-auto">
        <div class="w-full p-5 bg-white rounded-lg shadow-lg space-y-5">
            <div class="space-y-1">
                <h1 class="text-2xl font-bold tracking-tight">Restablece tu contraseña</h1>
                <p>Ingresa tu nueva contraseña</p>
            </div>
            <form action="/user/reset_password" method="post" class="space-y-3" id="resetPasswordForm">
                <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $result['usuario_id'] ?>">
                <div class="space-y-1">
                    <label for="usuario_contraseña" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="usuario_contraseña" name="usuario_contraseña" type="text" 
                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-violet-600 focus:outline-none sm:text-sm" required>
                </div>
                <div class="space-y-1">
                    <label for="usuario_contraseña_confirmacion" class="block text-sm font-medium text-gray-700">Confirma contraseña</label>
                    <input id="usuario_contraseña_confirmacion" type="text" 
                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-violet-600 focus:outline-none sm:text-sm" required>
                </div>
                
                <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
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
document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let data = new FormData(this);

    // Verificar que las contraseñas coincidan
    if (document.getElementById('usuario_contraseña').value !== document.getElementById('usuario_contraseña_confirmacion').value) {
        alert ('Las contraseñas no coinciden.');
        return;
    }

    // Enviar el formulario con fetch
    fetch('/user/reset_password', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location = '/page/login';
        } else {
            alert(data.message);
        }
    })
});
</script>