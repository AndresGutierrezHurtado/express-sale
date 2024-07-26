<?php
// Calculate total price of items in the cart
$totalPrice = 0;
foreach ($_SESSION['user_cart'] as $item) {
    $totalPrice += floatval($item['product_price']) * intval($item['product_quantity']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen flex justify-center items-center bg-gray-100">
    <form id="order-form" class="w-full lg:w-5/12 flex flex-col items-center gap-5 p-5 bg-white rounded-lg shadow-lg my-[70px]">
        <input type="hidden" name="order_user_id" value="<?= $_SESSION['user_id'] ?>">
        <input type="hidden" name="order_data" id="cart" value="<?= htmlspecialchars(json_encode($_SESSION['user_cart'])) ?>">
        <input type="hidden" name="order_coords" id="cords" value="">
        <input type="hidden" name="order_amount" id="price" value="<?= htmlspecialchars($totalPrice) ?>">
        <input type="hidden" name="order_date" value="">
        <script>
            let currentDate = new Date();
            let formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' ');
            document.querySelector('input[name="order_date"]').value = formattedDate;
        </script>
        <h1 class="text-3xl font-bold mb-4">Detalles de envío</h1>
        <div class="w-full">
            <div class="w-full flex gap-5">
                <div class="w-full md:w-1/2 ">
                    <label for="order_first_name" class="text-gray-700">Nombre completo:</label>
                    <input type="text" id="order_first_name" placeholder="Nombres" name="order_first_name" value="<?= $_SESSION['user_first_name'] ?>" 
                    class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
                </div>

                <div class="w-full md:w-1/2 ">
                    <label for="order_last_name" class="text-gray-700">Nombre completo:</label>
                    <input type="text" id="order_last_name" placeholder="Apellidos" name="order_last_name" value="<?= $_SESSION['user_last_name'] ?>" 
                    class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
                </div>
            </div>
        </div>
        <div class="w-full">
            <label for="order_email" class="text-gray-700">Correo electrónico:</label>
            <input type="email" id="order_email" placeholder="Correo electrónico" name="order_email" value="<?= $_SESSION['user_email'] ?>" 
            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
        </div>
        <div class="w-full">
            <label for="order_phone_number" class="text-gray-700">Teléfono:</label>
            <input type="tel" id="order_phone_number" placeholder="Teléfono" name="order_phone_number" value="<?= $_SESSION['user_phone_number'] ?>" 
            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
        </div>
        <div class="w-full">
            <label for="address_sale" class="text-gray-700">Dirección de envío:</label>
            <input type="text" id="address_sale" name="order_address" placeholder="Dirección de envío" 
            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1" autocomplete="off">
            <div id="map" class="w-11/12 h-[400px] mt-5 mx-auto rounded-lg shadow-md"></div>
        </div>
        <div class="w-full">
            <label for="order_message" class="text-gray-700">Mensaje para el domiciliario:</label>
            <textarea id="order_message" placeholder="Notas adicionales" name="order_message" 
            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1 h-36 resize-none"></textarea>
        </div>
        <button id="submit-button" type="submit" class="bg-violet-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Continuar</button>
    </form>

    <script src="/public/js/googleMaps.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0&libraries=places&callback=initMap" async defer></script>
    <script src="/public/js/sale.js"></script>
</body>
</html>