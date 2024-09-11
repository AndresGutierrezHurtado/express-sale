<form id="paymentForm" action="<?= PAYU_REQUEST_URI ?>" method="post"
class="w-full max-w-[700px] my-10 flex flex-col items-center gap-5 p-5 bg-white rounded-lg shadow-lg">
    <input name="merchantId"      type="hidden"  value="<?= PAYU_MERCHANT_ID ?>"   >
    <input name="accountId"       type="hidden"  value="<?= PAYU_ACCOUNT_ID ?>" >
    <input name="test"            type="hidden"  value="<?= PAYU_TEST_MODE ?>" >
    <input name="description"     type="hidden"  value="<?= 'Compra de ' . count($products) . ' productos.' ?>"  >
    <input name="referenceCode"   type="hidden"  value="<?= $reference_code ?>" >
    <input name="amount"          type="hidden"  value="<?= $totalPrice ?>"   >
    <input name="signature"       type="hidden"  value="<?= $signature ?>"  >
    <input name="tax"             type="hidden"  value="0">
    <input name="taxReturnBase"   type="hidden"  value="0" >
    <input name="currency"        type="hidden"  value="COP" >
    <input name="responseUrl"     type="hidden"  value="<?= DOMAIN . '/order/response/' ?>" >
    <input name="shippingCity"    type="hidden"  value="Bogotá" >
    <input name="shippingCountry" type="hidden"  value="CO"  >
    <input name="ing"             type="hidden"  value="es" >
    <input name="order_coords"    type="hidden"  value="" id="cords">

    <!-- Formulario -->
    <h1 class="text-3xl font-bold mb-4">Formulario de pago</h1>
    <div class="w-full">
        <div class="w-full space-y-2">
            <label for="order_last_name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Nombre completo</label>
            <input type="text" id="order_last_name" placeholder="Apellidos" name="buyerFullName" required value="<?= $_SESSION['usuario']['usuario_nombre'] . ' ' . $_SESSION['usuario']['usuario_apellido'] ?>" 
            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 focus:border-violet-600 focus:outline-none sm:text-sm">
        </div>
    </div>

    <div class="w-full space-y-2">
        <label for="order_email" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Correo electrónico</label>
        <input type="email" id="order_email" placeholder="Correo electrónico" name="buyerEmail" required value="<?= $_SESSION['usuario']['usuario_correo'] ?>" 
        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 focus:border-violet-600 focus:outline-none sm:text-sm">
    </div>

    <div class="w-full space-y-2">
        <label for="payerPhone" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Teléfono</label>
        <input type="number" id="payerPhone" placeholder="Teléfono" name="payerPhone" required value="<?= $_SESSION['usuario']['usuario_telefono'] ?? '' ?>" 
        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 focus:border-violet-600 focus:outline-none sm:text-sm">
    </div>
    
    <div class="w-full space-y-2">
        <label for="order_phone_number" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Tipo y número de documento</label>
        <div class="flex flex-col md:flex-row gap-4">
            <select name="payerDocumentType" required
            class="block w-full md:w-fit appearance-none rounded-md border border-gray-300 px-3 py-2 focus:border-violet-600 focus:outline-none sm:text-sm" >
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="CE">Cédula de Extranjería</option>
                <option value="TI">Tarjeta de Identidad</option>
                <option value="PPN">Pasaporte</option>
                <option value="NIT">Número de Identificación Tributaria</option>
                <option value="SSN">Social Security Number</option>
                <option value="EIN">Employer Identification Number</option>
            </select>
            <input name="payerDocument" id="payerDocument" type="number" required 
            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 focus:border-violet-600 focus:outline-none sm:text-sm" >
        </div>
    </div>

    <div class="w-full space-y-2">
        <label for="address_sale" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Dirección de envío</label>
        <input type="text" id="address_sale" name="shippingAddress" placeholder="Dirección de envío" required
        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 focus:border-violet-600 focus:outline-none sm:text-sm" autocomplete="off">
    </div>

    <!-- Mapa -->
    <div id="map" class="w-11/12 h-[400px] mt-5 mx-auto rounded-lg shadow-md"></div>

    <div class="w-full space-y-2">
        <label for="order_message" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Mensaje para el domiciliario</label>
        <textarea id="order_message" placeholder="Notas adicionales" name="order_message"
        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:border-violet-600 mt-1 h-36 resize-none" required></textarea>
    </div>
    <button id="submit-button" type="submit" class="bg-violet-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Continuar</button>
</form>

<script>    
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch('/order/store_session_data', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.submit();
            } else {
                alert('Error al guardar los datos.');
            }
        })
    });
</script>

