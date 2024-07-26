<?php 
function buildQueryString( $add = [], $remove = []) {
    $params = $_GET;
    $queryString = '?';
    foreach ($params as $key => $param) {
        if (!in_array($key, $remove) && !array_key_exists($key, $add)) {
            $queryString.= $key . '=' . $param . '&';
        }
    }
    foreach ($add as $key => $param) {
        $queryString.= $key . '=' . $param . '&';
    }
    $queryString = rtrim($queryString, '&');
    return $queryString;
}
?>
<style>
    th, td {
        padding: 8px;
    }
</style>
<main class="w-full max-w-[1200px] space-y-10 py-10 mx-auto">

    <form id="user_profile_form" class="w-full flex flex-col md:flex-row justify-between items-start gap-5" enctype="multipart/form-data">
        <input type="hidden" class="hidden" name="usuario_id" id="user_id" value="<?= isset($_GET['id']) ? $_GET['id'] : $_SESSION['usuario_id'] ?>">
        
        <!-- Image container -->
        <div class="w-full max-w-[350px] p-5 mx-auto flex flex-col gap-3 bg-white rounded-lg shadow-lg">

            <h1 class="text-3xl tracking-tight font-bold">Imagen:</h1>
            <div class="w-full aspect-square overflow-hidden rounded-md shadow-lg mb-3">
                <img src="<?= $user['usuario_imagen_url'] ?>" alt="foto <?= $user['usuario_nombre'] ?>"
                class="object-cover h-full w-full">
            </div>

            <input type="file" id="usuario_imagen" name="usuario_imagen" 
            class="hidden w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
            
            <!-- Botones de edición y cerrar sesión -->
            <a id="btn-edit" 
            class="group relative flex w-full justify-center rounded-md border border-transparent bg-gray-100 px-4 py-2 text-sm font-medium text-black hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-pen text-[17px] text-gray-300 duration-300 group-hover:text-gray-500"></i>
                </span>
                Editar
            </a>
            <a id="btn-logout"
            class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-right-from-bracket text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                </span>
                Cerrar sesión
            </a>
            
        </div>

        <!-- Information container -->
        <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-4 w-full md:max-w-[1fr]">

            <h1 class="text-lg uppercase tracking-tight font-bold">Datos de <?= $user['usuario_alias'] ?>:</h1>

            <div class="space-y-1">
                <label for="full_name" class="text-md font-medium text-gray-700">Nombres:</label>
                <input type="text" id="full_name" name="usuario_nombre" value="<?= $user['usuario_nombre']; ?>" 
                class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled required>
            </div>

            <div class="space-y-1">
                <label for="full_name" class="text-md font-medium text-gray-700">Apellidos:</label>
                <input type="text" id="full_name" name="usuario_apellido" value="<?= $user['usuario_apellido']; ?>" 
                class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled required>
            </div>

            <div class="space-y-1">
                <label for="username" class="text-md font-medium text-gray-700">Nombre de Usuario:</label>
                <input type="text" id="username" name="usuario_alias" value="<?= $user['usuario_alias']; ?>" 
                class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled required>
            </div>

            <div class="space-y-1">
                <label for="email" class="text-md font-medium text-gray-700">Correo Electrónico:</label>
                <input type="email" id="email" name="usuario_correo" value="<?= $user['usuario_correo']; ?>" 
                class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled required>
            </div>

            <div class="space-y-1">
                <label for="address" class="text-md font-medium text-gray-700">Dirección:</label>
                <input type="text" id="address_input" name="usuario_direccion" value="<?= $user['usuario_direccion']; ?>" 
                class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled autocomplete="off">
            </div>

            <div class="space-y-1">
                <label for="phone_number" class="text-md font-medium text-gray-700">Número de Teléfono:</label>
                <input type="number" id="phone_number" name="usuario_telefono" value="<?= $user['usuario_telefono']; ?>" 
                class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled>
            </div>

            <?php if ($user['rol_id'] == 2 || $user['rol_id'] == 3):?>
                <div class="space-y-1">
                    <label for="description" class="text-md font-medium text-gray-700">Descripción:</label>
                    <textarea type="text" id="description" name="trabajador_descripcion" required
                    class="h-24 w-full border rounded-lg py-1 px-3 resize-none disabled:opacity-50" disabled><?= $user['trabajador_descripcion'] ?></textarea>
                </div>
            <?php endif; ?>

            <label for="account_type">Tipo de Cuenta: <strong class="capitalize"> <?= $user['rol_nombre']?> </strong></label>

            <button type="submit" id="btn-submit" name="submit" 
            class="hidden group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-arrow-up-from-bracket text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                </span>
                Actualizar perfil
            </button>
        </div>
    </form>

    <!-- Contenedor de compras -->
    <div class="w-full flex flex-col shadow-lg rounded-lg">
        <span class="w-full flex flex-col sm:flex-row gap-2 justify-between bg-slate-800 text-white p-3 rounded-t-lg">
            <h1 class="text-xl tracking-tight font-bold ">Compras de <?= $user['usuario_alias'] ?></h1>
        </span>
        <div class="w-full bg-white flex flex-col gap-5 justify-center items-center p-5 rounded-b-lg">
            <table class="w-full table-auto border-collapse border border-gray-900 text-[13px] sm:text-[16px] text-center max-w-full" >
                <thead>
                    <tr class="bg-gray-200">
                        <th>Fecha</th>
                        <th class=" hidden lg:table-cell">Productos</th>
                        <th>Estado</th>
                        <th>Precio</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td ><?= $order['pedido_fecha'] ?></td>
                        <td >
                            <ol>
                                <?php foreach ($order['productos'] as $product) :?>
                                    <li>(<?= $product['producto_cantidad'] ?>) - <?= $product['producto_nombre'] ?></li> 
                                <?php endforeach; ?>
                            </ol>
                        </td>
                        <td > <?= $order['pedido_estado'] ?> </td>
                        <td ><?= number_format($order['pago_valor']); ?> COP</td>
                        <td > 
                            <a href="/page/order/?order=<?= $order['pedido_id'] ?>">
                                <button class="p-[2px] sm:px-3 border-2 border-violet-800 text-violet-800 rounded-md font-bold duration-300 hover:bg-gray-200">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
            <?php if ($orders_consulta['rows'] < 1) : ?>
                <p class="font-bold text-md">No se encontraron compras.</p>
            <?php endif;?>
        </div>
    </div>

    <?php if ( $user['rol_id'] == 2 ) : ?> 
        <!-- Contenedor de productos vendedor -->
        <div class="w-full flex flex-col shadow-lg rounded-lg">
            <span class="w-full flex flex-col sm:flex-row gap-2 justify-between bg-slate-800 text-white p-3 rounded-t-lg">
                <h1 class="text-xl tracking-tight font-bold ">Productos de <?= $user['usuario_alias'] ?></h1>
                <?php if ($_SESSION['rol_id'] == 2) : ?>
                <div class="flex gap-5">
                    <button class="bg-green-600 px-3 p-1 rounded-lg flex items-center gap-3" onclick="toggleModal('producto')"> <i class="fa-solid fa-plus"></i> Añadir nuevo producto</button>
                </div>
                <?php endif; ?>
            </span>
            <div class="w-full bg-white flex flex-col gap-5 justify-center items-center p-5 rounded-b-lg">
                <table class="w-full table-auto border-collapse border border-gray-900 text-[13px] sm:text-[16px] text-center max-w-full" >
                    <thead>
                        <tr class="bg-gray-200">
                            <th>ID</th>
                            <th class="hidden lg:table-cell">Nombre</th>
                            <th>Precio</th>
                            <th class="hidden sm:table-cell">Stock</th>
                            <th>Categoría</th>                            
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $products['data'] as $product ): ?>
                        <tr>
                            <td ><?= $product['producto_id']; ?></td>
                            <td class="hidden lg:table-cell"><?= $product['producto_nombre']; ?></td>
                            <td ><?= number_format($product['producto_precio']); ?> COP</td>
                            <td class="hidden sm:table-cell"><?= $product['producto_cantidad']; ?></td>
                            <td ><?= $product['categoria_nombre'] ?> </td>
                            <td class="flex flex-col gap-3 sm:flex-row justify-center"> 
                                <a href="/page/product_profile/?id=<?= $product['producto_id'] ?>"><button class="p-[2px] sm:px-3 border-2 border-violet-800 text-violet-800 rounded-md font-bold duration-300 hover:bg-gray-200"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                <button class="p-[2px] sm:px-3 bg-violet-800 text-white rounded-md font-bold duration-300 hover:bg-violet-600 btn-delete" onclick="if(confirm('¿Deseas eliminar este producto?')) deleteElement(<?= $product['producto_id'] ?>)"><i class="fa-solid fa-trash-can"></i></button> 
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Paginación -->
                <div class="w-full bg-white p-3 rounded-lg shadow-lg flex gap-3 justify-center">
                    
                    <?php if($products_page > 1): ?>
                        <a href="/page/profile/<?= buildQueryString(['products_page' => $products_page - 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> anterior </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> anterior </a>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $products['pages']; $i++): ?>
                        <a href="/page/profile/<?= buildQueryString(['products_page' => $i]) ?>" class="font-semibold bg-gray-200 size-[30px] flex items-center justify-center rounded-sm duration-300 <?= $i == $products_page ? 'bg-gray-400 font-bold' : ' hover:bg-gray-300' ?>"> <?= $i ?> </a>
                    <?php endfor; ?>
                    
                    <?php if($products_page < $products['pages']): ?>
                        <a href="/page/profile/<?= buildQueryString(['products_page' => $products_page + 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> siguiente </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> siguiente </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

</main>

<div class="fixed inset-0 hidden z-50" id="modalproducto">
    <div id="modalBackground" class="fixed inset-0 bg-black bg-opacity-40" onclick="toggleModal('producto')"></div>
    <div id="myModal" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-full max-w-[500px]">
        <div class="w-full bg-white p-5 rounded-md">
            <span class="flex justify-between items-center mb-3">
                <span class="text-lg font-bold">Nuevo producto:</span>
                <button id="closeModalButton" class="text-gray-500 hover:text-gray-700"  onclick="toggleModal('producto')">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </span>
            <form id="new-product-form" class="flex flex-col gap-4">
                <input type="hidden" id="usuario_id" name="usuario_id" value="<?= $user['usuario_id'] ?>">

                <div class="space-y-2">
                    <label for="producto_nombre" class="text-md font-medium text-gray-700">Nombre:</label>
                    <input type="text" id="producto_nombre" name="producto_nombre" class="w-full border rounded-lg py-1 px-3" required>
                </div> 

                <div class="space-y-2">
                    <label for="producto_descripcion" class="text-md font-medium text-gray-700">Descripción:</label>
                    <textarea id="producto_descripcion" name="producto_descripcion" class="w-full h-24 resize-none border rounded-lg py-1 px-3" required></textarea>
                </div>

                <div class="space-y-2">
                    <label for="producto_precio" class="text-md font-medium text-gray-700">Precio:</label>
                    <input type="text" id="producto_precio" name="producto_precio" class="w-full border rounded-lg py-1 px-3" required>
                </div>

                <div class="space-y-2">
                    <label for="producto_cantidad" class="text-md font-medium text-gray-700">Stock:</label>
                    <input type="text" id="producto_cantidad" name="producto_cantidad" class="w-full border rounded-lg py-1 px-3" required>
                </div>

                <div class="space-y-2">
                    <label for="producto_imagen" class="text-md font-medium text-gray-700">Imagen:</label>
                    <input type="file" id="producto_imagen" name="producto_imagen" required
                    class="w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
                </div>

                <div class="flex flex-col gap-1">
                    <label for="categoria_id" class="text-md font-medium text-gray-700">Categoría:</label>
                    <select name="categoria_id" id="categoria_id" class="w-full border rounded-lg py-1 px-3" required>
                        <option value="1">Moda</option>
                        <option value="2">Comida</option>
                        <option value="3">Tecnología</option>
                        <option value="4">Otros</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="producto_estado" class="text-md font-medium text-gray-700">Estado:</label>
                    <select name="producto_estado" id="producto_estado" class="w-full border rounded-lg py-1 px-3" required>
                        <option value="publico">Público</option>
                        <option value="privado" selected>Privado</option>
                    </select>
                </div>

                <button type="submit" id="btn-submit" name="submit" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold">Subir</button>
            </form>

        </div>
    </div>
</div>
<script>
    function toggleModal(nombre) {
        document.getElementById('modal' + nombre).classList.toggle('hidden');
    }
    
    function deleteElement(idProducto) {
        fetch('/product/delete', {
        method: 'POST',
        body: JSON.stringify({'id' : idProducto}),
        })
        .then(Response => Response.json())
        .then(Data => {
            console.log(Data);
            if (Data.success) {
                alert(Data.message)
                window.location.reload();
            } else {
                alert(Data.message)
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0&libraries=places&callback=initMap" async defer></script>
<script>
    function initMap() {
        geocoder = new google.maps.Geocoder();
        autocomplete = new google.maps.places.Autocomplete(document.getElementById("address_input"));
    }
</script>
<script src="/public/js/user_profile.js"></script>