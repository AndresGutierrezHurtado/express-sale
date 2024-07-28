
<!-- Fondo Morado -->
<div class="fixed inset-0 overflow-hidden">
    <div class="absolute bg-violet-800 h-[120%] md:h-[140vh] w-[100%] left-[-50%] rounded-full top-1/2 transform -translate-y-1/2"></div>
</div>

<!-- Login -->
<main class="flex items-center justify-center z-50 py-5 md:py-10">
    <div class="w-full max-w-[450px] bg-white px-4 py-7 sm:rounded-xl sm:px-10 sm:shadow-xl z-50 flex flex-col gap-5">
        <div>
            <!-- Logo y Titulo -->
            <a href="/" class="flex justify-center items-center mx-auto w-5/12">
                <img src="/public/images/logo.png" alt="logo.png" class="mx-auto">
            </a>
            <div class="text-center sm:mx-auto sm:w-full sm:max-w-md">                
                <h1 class="text-3xl font-extrabold text-gray-900">
                    Inicia Sesión
                </h1>
            </div>
        </div>

        <form id="login_form" method="post" class="space-y-6">
            <!-- Formulario -->
            <div>
                <label for="usuario_alias" class="block text-sm font-medium text-gray-700">Correo electrónico / Usuario</label>
                <div class="mt-1">
                    <input id="usuario_alias" name="usuario_alias" type="text" 
                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-violet-600 focus:outline-none sm:text-sm" required>
                </div>
            </div>
            <div>
                <label for="user_password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <div class="mt-1"> 
                    <input id="user_password" name="usuario_contraseña" type="password" autocomplete="current-password" 
                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-violet-600 focus:outline-none sm:text-sm" required>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-violet-600 disabled:opacity-50" disabled>
                    <label for="remember_me" class="ml-2 block text-sm text-gray-400">Recuérdame</label>
                </div>
                <div class="text-sm">
                    <a class="font-medium text-violet-400 hover:text-violet-500" href="/page/recover_account/">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </div>
            
            <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-lock text-[17px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                </span>
                Iniciar sesión
            </button>
        </form>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="bg-white px-2 text-gray-500 ">O continua con</span>
            </div>
        </div>

        <!-- Login con Google -->
        <a href="<?= $auth_url ?>" class="w-full bg-gray-50 border border-gray-300 py-1.5 px-4 rounded text-gray-500 font-semibold duration-300 hover:bg-gray-100 flex items-center justify-center" >
            <i class="fa-brands fa-google text-[20px] mr-2"></i>
            <span>Ingresa con Google</span>
        </a>

        <span class="w-full text-center">No tienes cuenta aún?
            <a class="font-semibold text-violet-400 duration-300 hover:text-violet-600" href="/page/register">Regístrate</a>
        </span>
    </div>
</main> 
<script src="/public/js/login.js"></script>