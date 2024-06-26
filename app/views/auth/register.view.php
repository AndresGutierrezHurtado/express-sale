<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-50 flex items-center justify-center relative">
    <div class="aboslte inset-0 fixed overflow-hidden">
        <div class="absolute bg-violet-800 h-[120%] md:h-[140vh] w-[100%] right-[-50%] rounded-full top-1/2 transform -translate-y-1/2"></div>
    </div>
    <main class="flex items-center justify-center ">
        <div class="mx-auto max-w-md md:max-w-lg z-50 py-10">
            <div class="bg-white px-4 pb-4 pt-8 sm:rounded-xl sm:px-10 sm:pb-6 sm:shadow-xl z-50">
                <a href="/" class="flex justify-center items-center mx-auto w-5/12 pb-5">
                    <img src="/public/images/logo.png" alt="logo.png" class="inicio">
                </a>
                <div class="text-center sm:mx-auto sm:w-full sm:max-w-md pb-5">                
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Crea tu cuenta
                    </h1>
                </div>
                <form id="register_form" method="post" class="space-y-4">
                    <div>
                        <label for="user_first_name" class="block text-sm font-medium text-gray-700">Nombres</label>
                        <div class="mt-1">
                            <input id="user_first_name" type="text" name="user_first_name" required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="user_last_name" class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <div class="mt-1">
                            <input id="user_last_name" type="text" name="user_last_name" required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="user_document_type" class="block text-sm font-medium text-gray-700">Documento</label>
                        <div class="flex">
                            <select name="user_document_type" required class="bg-gray-200 rounded-l-md text-center px-2">
                                <option value=""> -- seleccione --</option>
                                <option value="CC">Cédula de ciudadanía</option>
                                <option value="TI">Tarjeta de identidad</option>
                                <option value="CE">Cédula de extranjería</option>
                            </select>

                            <input type="number" name="user_document_number" id="user_document_number" required value=""
                                class="block w-full appearance-none rounded-r-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="user_email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <div class="mt-1">
                            <input id="user_email" type="email" name="user_email" required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                value="">
                        </div>
                    </div>
                    <div>
                        <label for="user_username" class="block text-sm font-medium text-gray-700">Usuario</label>
                        <div class="mt-1">
                            <input id="user_username" type="text" name="user_username" required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                value="">
                        </div>
                    </div>
                    <div>
                        <label for="user_password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="mt-1">
                            <input id="user_password" type="password" name="user_password" autocomplete="current-password" required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                value="">
                        </div>
                    </div>
                    <div>
                        <label for="user_role_id" class="block text-sm font-medium text-gray-700">Tipo de cuenta</label>
                        <select id="user_role_id" name="user_role_id" required class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option value="" disabled selected>Selecciona el tipo de cuenta</option>
                            <option value="1">Cliente</option>
                            <option value="2">Vendedor</option>
                            <option value="3">Domiciliario</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-lock text-[17px] text-indigo-500 duration-300 group-hover:text-indigo-400"></i>
                            </span>
                            Regístrate
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
                        <button class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white  px-4 py-2 text-sm font-medium text-gray-500 shadow-sm duration-300 hover:bg-gray-100 disabled:cursor-wait disabled:opacity-50">
                            <span class="sr-only">Registro con Google</span>
                            <i class="fa-brands fa-google text-[20px]"></i>
                        </button>
                        <button class="inline-flex w-full justify-center items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 shadow-sm duration-300 hover:bg-gray-100 disabled:cursor-wait disabled:opacity-50">
                            <span class="sr-only">Registro con facebook</span>
                            <i class="fa-brands fa-facebook text-[20px]"></i>
                        </button>
                    </div>
                </div>
                <div class="m-auto mt-6 w-fit md:mt-8">
                    <span class="m-auto">¿Ya tienes una cuenta?
                        <a class="font-semibold text-indigo-600" href="/page/login">Inicia sesión</a>
                    </span>
                </div>
            </div>
        </div>
    </main>    
    <script src="/public/js/register.js"></script>
</body>
</html>