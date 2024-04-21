<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Express Sale</title>
    <link rel="shortcut icon" href="./public/img/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <main class="w-full min-h-screen bg-gray-50 flex items-center justify-center">         
        <div class="mx-auto max-w-md">
            <div class="bg-white px-4 pb-4 pt-8 sm:rounded-xl sm:px-10 sm:pb-6 sm:shadow-xl  z-50">
                <div class="flex justify-center items-center sm:mx-auto w-5/12 pb-5">     
                    <a href="/public/">
                        <img src="/public/assets/images/logo.png" alt="logo.png" class="">
                    </a>           
                </div>
                <div class="text-center sm:mx-auto sm:w-full sm:max-w-md pb-5">                
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Inicia Sesión
                    </h1>
                </div>
                <form class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico / Usuario</label>
                        <div class="mt-1">
                            <input id="email" type="text" data-testid="username" required=""
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                value="">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" data-testid="password"
                                autocomplete="current-password" required=""
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                value="">
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember_me" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 disabled:cursor-wait disabled:opacity-50">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">Recuerdame</label>
                        </div>
                        <div class="text-sm">
                            <a class="font-medium text-indigo-400 hover:text-indigo-500" href="">
                                Olvidaste tu contraseña?
                            </a>
                        </div>
                    </div>
                    <div>
                        <button data-testid="login" type="submit"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
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
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <clipPath id="p.0">
                                    <path d="m0 0l20.0 0l0 20.0l-20.0 0l0 -20.0z" clip-rule="nonzero"></path>
                                </clipPath>
                                <g clip-path="url(#p.0)">
                                    <path fill="currentColor" fill-opacity="0.0" d="m0 0l20.0 0l0 20.0l-20.0 0z"
                                        fill-rule="evenodd"></path>
                                    <path fill="currentColor"
                                        d="m19.850197 8.270351c0.8574047 4.880001 -1.987587 9.65214 -6.6881847 11.218641c-4.700598 1.5665016 -9.83958 -0.5449295 -12.08104 -4.963685c-2.2414603 -4.4187555 -0.909603 -9.81259 3.1310139 -12.6801605c4.040616 -2.867571 9.571754 -2.3443127 13.002944 1.2301085l-2.8127813 2.7000687l0 0c-2.0935059 -2.1808972 -5.468274 -2.500158 -7.933616 -0.75053835c-2.4653416 1.74962 -3.277961 5.040613 -1.9103565 7.7366734c1.3676047 2.6960592 4.5031037 3.9843292 7.3711267 3.0285425c2.868022 -0.95578575 4.6038647 -3.8674583 4.0807285 -6.844941z"
                                        fill-rule="evenodd"></path>
                                    <path fill="currentColor" d="m10.000263 8.268785l9.847767 0l0 3.496233l-9.847767 0z"
                                        fill-rule="evenodd"></path>
                                </g>
                            </svg>
                        </button>
                        <button class="inline-flex w-full justify-center items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50 disabled:cursor-wait disabled:opacity-50">
                            <span class="sr-only">Inicio de sesión con facebook</span>
                            <i class="fa-brands fa-facebook text-[20px]"></i>
                        </button>
                    </div>
                </div>
                <div class="m-auto mt-6 w-fit md:mt-8">
                    <span class="m-auto">No tienes cuenta aún?
                        <a class="font-semibold text-indigo-600" href="/register">Regístrate</a>
                    </span>
                </div>
            </div>
        </div>
    </main>    
</body>
</html>