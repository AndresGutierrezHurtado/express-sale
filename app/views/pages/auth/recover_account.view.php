<main class="w-full min-h-screen flex justify-center items-center bg-violet-700">

    <div class="w-full max-w-[600px] p-3 md:p-8 bg-white rounded-lg border space-y-4 shadow-xl">
        <a href="/" class="">
            <img src="/public/images/logo.png" alt="recover_account" class="max-w-full h-[170px] mx-auto">
        </a>
        <div class="space-y-2">
            <h3 class="text-3xl font-bold tracking-tight">¿Tienes problemas iniciando sesión?</h3>
            <p> Ingresa el correo vinculado a tu cuenta y te enviaremos un correo con las credenciales para iniciar sesión. </p>
        </div>
        <form onsubmit="recover_account(event)" id="form-recover-account"class="w-full flex flex-col gap-4">
            <div class="space-y-2">
                <label for="usuario_correo" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" id="usuario_correo" name="usuario_correo"
                    class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-violet-600 focus:outline-none sm:text-sm" required>
            </div>

            <div class="flex w-full gap-4">
                <a href="/page/login" class="p-1 px-3 bg-white border-2 border-violet-600 text-violet-600 font-bold rounded-lg">Cancelar</a>

                <button type="submit" 
                class="relative flex justify-center rounded-md border border-transparent bg-violet-600 px-16 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-paper-plane text-[17px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                    </span>
                    Enviar correo
                </button>
            </div>
        </form>
    </div>

</main>

<script>
    function recover_account(e) {
        e.preventDefault();

        let data = new FormData(document.getElementById('form-recover-account'));
        
        fetch('/mail/recover_account', {
            method: 'POST',
            body: data
        })
        .then(Response => Response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location = '/page/login';
            }
        });
    }
</script>