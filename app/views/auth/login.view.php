<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-50 flex items-center justify-center relative overflow-hidden">
    <div class="absolute bg-violet-800 h-[140vh] w-[100%] left-[-50%] rounded-full top-1/2 transform -translate-y-1/2"></div>
    <main class="flex items-center justify-center">
        <div class="mx-auto max-w-md z-50 py-5">
            <div class="bg-white px-4 pb-4 pt-8 sm:rounded-xl sm:px-10 sm:pb-6 sm:shadow-xl z-50">
                <a href="/" class="flex justify-center items-center mx-auto w-5/12 pb-5">
                        <img src="/public/images/logo.png" alt="logo.png" class="mx-auto">
                </a>
                <div class="text-center sm:mx-auto sm:w-full sm:max-w-md pb-5">                
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Inicia Sesión
                    </h1>
                </div>
                <form class="space-y-6" id="login_form">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Correo electrónico / Usuario</label>
                        <div class="mt-1">
                            <input id="username" type="text" autocomplete="current-username" class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="mt-1"> 
                            <input id="password" type="password" autocomplete="current-password" class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 disabled:cursor-wait disabled:opacity-50">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">Recuerdame</label>
                        </div>
                        <div class="text-sm">
                            <a class="font-medium text-indigo-400 hover:text-indigo-500" href="/page/recover_account/">
                                Olvidaste tu contraseña?
                            </a>
                        </div>
                    </div>
                    <div>
                        <button data-testid="login" type="submit"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-lock text-[17px] text-indigo-500 duration-300 group-hover:text-indigo-400"></i>
                            </span>
                            Inicia sesión
                        </button>
                    </div>
                </form>
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-white px-2 text-gray-500 ">O continua con</span>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white  px-4 py-2 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50 disabled:cursor-wait disabled:opacity-50">
                            <span class="sr-only">Inicio de sesión con Google</span>
                            <i class="fa-brands fa-google text-[20px]"></i>
                        </button>
                        <button class="inline-flex w-full justify-center items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50 disabled:cursor-wait disabled:opacity-50">
                            <span class="sr-only">Inicio de sesión con facebook</span>
                            <i class="fa-brands fa-facebook text-[20px]"></i>
                        </button>
                    </div>
                </div>
                <div class="m-auto mt-6 w-fit md:mt-8">
                    <span class="m-auto">No tienes cuenta aún?
                        <a class="font-semibold text-indigo-600" href="/page/register">Regístrate</a>
                    </span>
                </div>
            </div>
        </div>
    </main> 
    <script src="/public/js/login.js"></script>   
</body>
</html>