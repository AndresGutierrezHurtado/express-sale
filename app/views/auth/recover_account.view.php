<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupera tu cuenta | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen flex justify-center items-center bg-violet-600">
    <article class="bg-white p-10 rounded-md flex flex-col gap-5 w-full sm:w-9/12 md:w-7/12 lg:w-5/12 xl:w-3/12">
        <a href="/page/login" class="w-full h-auto max-h-[230px] ">
            <img src="/public/images/logo.png" alt="recover_account" class="h-full max-h-[230px] mx-auto">
        </a>
        <div class="w-full flex flex-col gap-2">
            <h1 class="font-bold text-2xl tracking-tight text-center">¿Tienes problemas iniciando sesión?</h1>
            <p class="text-center">Ingresa el correo vinculado a tu cuenta 
                y te enviaremos un correo con las credenciales para iniciar sesión. </p>
        </div>
        <form onsubmit="recover_account(event)" id="form-recover-account"class="w-full flex flex-col gap-2">
            <input type="email" id="email-recover" name="email" class="border border-gray-700 rounded-md px-3 p-1 focus:border-violet-800" placeholder="Correo electrónico.. " required>
            <div class="flex w-full gap-4">
                <a href="/page/login" class="p-1 px-3 bg-white border-2 border-violet-800 text-violet-800 font-bold rounded-lg">Cancelar</a>
                <button class="p-1 px-3 bg-violet-800 text-white font-bold rounded-lg ">Enviar Crendenciales</button>
            </div>
        </form>
    </article>
    
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
</body>
</html>