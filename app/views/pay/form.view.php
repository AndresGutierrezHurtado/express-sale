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
    <form id="sale-form" class="w-full lg:w-5/12 flex flex-col items-center gap-5 p-5 bg-white rounded-lg shadow-lg my-[70px]">
        <input type="hidden" name="sale_user_id" value="<?= $_SESSION['user_id'] ?>">
        <input type="hidden" name="sale_description" id="cart" value="<?= htmlspecialchars(json_encode($_SESSION['user_cart'])) ?>">
        <input type="hidden" name="sale_coords" id="cords" value="">
        <input type="hidden" name="sale_price" id="price" value="<?= htmlspecialchars($totalPrice) ?>">
        <input type="hidden" name="sale_date" value="">
        <script>
            let currentDate = new Date();
            let formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' ');
            document.querySelector('input[name="sale_date"]').value = formattedDate;
        </script>
        <h1 class="text-3xl font-bold mb-4">Detalles de envío</h1>
        <div class="w-full">
            <label for="full_name_sale" class="text-gray-700">Nombre completo:</label>
            <input type="text" id="full_name_sale" placeholder="Nombre completo" name="sale_full_name" value="<?= $_SESSION['user_full_name'] ?>" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
        </div>
        <div class="w-full">
            <label for="email_sale" class="text-gray-700">Correo electrónico:</label>
            <input type="email" id="email_sale" placeholder="Correo electrónico" name="sale_email" value="<?= $_SESSION['user_email'] ?>" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
        </div>
        <div class="w-full">
            <label for="phone_number_sale" class="text-gray-700">Teléfono:</label>
            <input type="tel" id="phone_number_sale" placeholder="Teléfono" name="sale_phone_number" value="<?= $_SESSION['user_phone_number'] ?>" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1">
        </div>
        <div class="w-full">
            <label for="address_sale" class="text-gray-700">Dirección de envío:</label>
            <input type="text" id="address_sale" name="sale_address" placeholder="Dirección de envío" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1" autocomplete="off">
            <div id="map" class="w-11/12 h-[400px] mt-5 mx-auto rounded-lg shadow-md"></div>
        </div>
        <div class="w-full">
            <label for="message_sale" class="text-gray-700">Notas adicionales:</label>
            <textarea id="message_sale" placeholder="Notas adicionales" name="sale_message" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1 h-36 resize-none"></textarea>
        </div>
        <button id="submit-button" type="submit" class="bg-violet-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Continuar</button>
    </form>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0&libraries=places&callback=initMap" async defer></script>
    <script src="/public/js/googleMaps.js"></script>
    <script src="/public/js/sale.js"></script>
</body>
</html>