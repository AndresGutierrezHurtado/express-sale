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
    <!-- Fondo Morado -->
    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute bg-violet-800 h-[120%] md:h-[140vh] w-[100%] right-[-50%] rounded-full top-1/2 transform -translate-y-1/2"></div>
    </div>

    <!-- Login -->
    <main class="flex items-center justify-center z-50 py-5 md:py-10">
        <div class="w-full max-w-[500px] bg-white px-4 py-7 sm:rounded-xl sm:px-10 sm:shadow-xl z-50 flex flex-col gap-5">
            <!-- Logo y Titulo -->
            <div>
                <a href="/" class="flex justify-center items-center mx-auto w-5/12">
                    <img src="/public/images/logo.png" alt="logo.png" class="inicio">
                </a>
                <div class="text-center sm:mx-auto sm:w-full sm:max-w-md">                
                    <h1 class="text-3xl font-extrabold text-gray-900"> Crea tu cuenta </h1>
                </div>
            </div>
            
            <!-- Formulario -->
            <form id="register_form" method="post" class="space-y-4">
                <div>
                    <label for="usuario_nombre" class="block text-sm font-medium text-gray-700">Nombres</label>
                    <div class="mt-1">
                        <input id="usuario_nombre" type="text" name="usuario_nombre" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-violet-500 focus:outline-none focus:ring-violet-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label for="usuario_apellido" class="block text-sm font-medium text-gray-700">Apellidos</label>
                    <div class="mt-1">
                        <input id="usuario_apellido" type="text" name="usuario_apellido" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-violet-500 focus:outline-none focus:ring-violet-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label for="usuario_correo" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <div class="mt-1">
                        <input id="usuario_correo" type="email" name="usuario_correo" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-violet-500 focus:outline-none focus:ring-violet-500 sm:text-sm"
                            value="">
                    </div>
                </div>
                <div>
                    <label for="usuario_alias" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <div class="mt-1">
                        <input id="usuario_alias" type="text" name="usuario_alias" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-violet-500 focus:outline-none focus:ring-violet-500 sm:text-sm"
                            value="">
                    </div>
                </div>
                <div>
                    <label for="usuario_contraseña" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="mt-1">
                        <input id="usuario_contraseña" type="password" name="usuario_contraseña" autocomplete="current-password" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-violet-500 focus:outline-none focus:ring-violet-500 sm:text-sm"
                            value="">
                    </div>
                </div>
                <div>
                    <label for="rol_id" class="block text-sm font-medium text-gray-700">Tipo de cuenta</label>
                    <select id="rol_id" name="rol_id" required 
                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-violet-500 focus:outline-none focus:ring-violet-500 sm:text-sm">
                        <option value="" disabled selected>Selecciona el tipo de cuenta</option>
                        <option value="1">Cliente</option>
                        <option value="2">Vendedor</option>
                        <option value="3">Domiciliario</option>
                    </select>
                </div>
                <div class="mt-4">
                    <button type="submit" 
                    class="relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white duration-300 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa-solid fa-lock text-[17px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                        </span>
                        Regístrate
                    </button>
                </div>
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
            <a href="<?= $auth_url ?>" onclick="return confirm('Si te registras con Google tu cuenta será de CLIENTE, ¿estás seguro?')" 
            class="w-full bg-gray-50 border border-gray-300 py-1.5 px-4 rounded text-gray-500 font-semibold duration-300 hover:bg-gray-100 flex items-center justify-center">
                <i class="fa-brands fa-google text-[20px] mr-2"></i>
                <span>Ingresa con Google</span>
            </a>

            <div class="m-auto w-fit">
                <span class="m-auto">¿Ya tienes una cuenta?
                    <a class="font-semibold text-violet-600" href="/page/login">Inicia sesión</a>
                </span>
            </div>
        </div>
    </main>    
    <script src="/public/js/register.js"></script>
</body>
</html>