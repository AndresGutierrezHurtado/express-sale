<?php
function buildQueryString($add = [], $remove = [])
{
    $params = $_GET;
    $queryString = '?';
    foreach ($params as $key => $param) {
        if (!in_array($key, $remove) && !array_key_exists($key, $add)) {
            $queryString .= $key . '=' . $param . '&';
        }
    }
    foreach ($add as $key => $param) {
        $queryString .= $key . '=' . $param . '&';
    }
    $queryString = rtrim($queryString, '&');
    return $queryString;
}
?>
<style>
    th,
    td {
        padding: 8px;
    }
</style>
<main class="w-full max-w-[1200px] space-y-10 py-12 mx-auto px-3">

    <form id="user_profile_form" class="w-full flex flex-col md:flex-row justify-between items-start gap-5" enctype="multipart/form-data">
        <input type="hidden" class="hidden" name="usuario_id" id="user_id" value="<?= isset($_GET['id']) ? $_GET['id'] : $_SESSION['usuario_id'] ?>">

        <!-- Contenedor de imagen -->
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

        <!-- Contenedor de información -->
        <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-2 w-full md:max-w-[1fr]">
            <h1 class="text-lg uppercase tracking-tight font-bold">Datos de <?= $user['usuario_alias'] ?> :</h1>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Nombres:</span>
                </div>
                <input type="text" id="usuario_nombre" name="usuario_nombre" placeholder="Ingresa tus nombres." value="<?= $user['usuario_nombre']; ?>" disabled required
                    class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Apellidos:</span>
                </div>
                <input type="text" id="usuario_apellido" name="usuario_apellido" placeholder="Ingresa tus apellidos." value="<?= $user['usuario_apellido']; ?>" disabled required
                class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Usuario:</span>
                </div>
                <input type="text" id="usuario_alias" name="usuario_alias" placeholder="Ingresa tu usuario." value="<?= $user['usuario_alias']; ?>" disabled required
                class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Correo electrónico:</span>
                </div>
                <input type="email" id="usuario_correo" name="usuario_correo" placeholder="correo@ejemplo.com" value="<?= $user['usuario_correo']; ?>" disabled required
                class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Dirección:</span>
                </div>
                <input type="text" id="usuario_direccion" name="usuario_direccion" placeholder="Ingresa tu direccion." value="<?= $user['usuario_direccion']; ?>" disabled disabled <?= $user['rol_id'] == 2 ? 'required' : '' ?>
                class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto" autocomplete="off">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Número de Teléfono:</span>
                </div>
                <input type="number" id="usuario_telefono" name="usuario_telefono" placeholder="320 9202178" value="<?= $user['usuario_telefono']; ?>" disabled
                class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <?php if ($user['rol_id'] == 2 || $user['rol_id'] == 3): ?>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium text-gray-700">Descripcion:</span>
                    </div>
                    <textarea type="text" id="description" name="trabajador_descripcion" placeholder="Ingresa una descripción breve." required
                    class="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded" disabled><?= $user['trabajador_descripcion'] ?></textarea>
                </label>
            <?php endif; ?>

            <label for="account_type">Tipo de Cuenta: <strong class="capitalize"> <?= $user['rol_nombre'] ?> </strong></label>

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
        <div class="w-full bg-white gap-5 p-5 rounded-b-lg overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-900 text-center">
                <thead>
                    <tr class="bg-gray-200">
                        <th>Fecha</th>
                        <th>Productos</th>
                        <th>Estado</th>
                        <th>Precio</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="min-w-[100px]"><?= $order['pedido_fecha'] ?></td>
                            <td class="min-w-[250px]">
                                <ol>
                                    <?php foreach ($order['productos'] as $product) : ?>
                                        <li>(<?= $product['producto_cantidad'] ?>) - <?= $product['producto_nombre'] ?></li>
                                    <?php endforeach; ?>
                                </ol>
                            </td>
                            <td> <?= $order['pedido_estado'] ?> </td>
                            <td><?= number_format($order['pago_valor']); ?> COP</td>
                            <td class="align-middle text-center">
                                <div class="flex justify-center items-center">
                                    <a href="/page/order/?order=<?= $order['pedido_id'] ?>">
                                        <button class="relative group flex items-center justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer tooltip tooltip-left" data-tip="Ver más información sobre tu compra">
                                            <i class="fa-solid fa-eye text-[18px] text-violet-400 duration-300 group-hover:text-violet-300"></i>
                                            <?php if ($order['pedido_estado'] == 'entregado'): ?>
                                                <span class=" absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-5 h-5 ms-2 text-center font-bold text-red-800 bg-red-400 rounded-full">
                                                    !
                                                </span>
                                            <?php endif; ?>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <?php if (count($orders) < 1) : ?>
                <p class="font-bold text-md text-center w-full">No se encontraron compras.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($user['rol_id'] == 2) : ?>
        <!-- Contenedor de productos vendedor -->
        <div class="w-full flex flex-col shadow-lg rounded-lg">
            <span class="w-full flex flex-col sm:flex-row gap-2 justify-between bg-slate-800 text-white p-3 rounded-t-lg">
                <h1 class="text-xl tracking-tight font-bold ">Productos de <?= $user['usuario_alias'] ?></h1>
                <?php if ($_SESSION['rol_id'] == 2) : ?>
                    <div class="flex gap-5">
                        <button class="btn btn-success btn-sm text-white" onclick="new_product_modal.showModal()">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Añadir nuevo producto
                        </button>
                    </div>
                <?php endif; ?>
            </span>
            <div class="w-full bg-white flex flex-col gap-5 justify-center items-center p-5 rounded-b-lg">
                <div class="w-full overflow-x-auto">
                    <table class="w-full table-auto border-collapse border border-gray-900 text-center">
                        <thead>
                            <tr class="bg-gray-200">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products['data'] as $product): ?>
                                <tr>
                                    <td><?= $product['producto_id'] ?></td>
                                    <td><?= $product['producto_nombre'] ?></td>
                                    <td><?= number_format($product['producto_precio']) ?> COP</td>
                                    <td><?= $product['producto_cantidad'] ?></td>
                                    <td><?= $product['categoria_nombre'] ?></td>
                                    <td class="flex flex-col sm:flex-row gap-3 justify-center items-center">

                                        <a href="/page/product_profile/?producto=<?= $product['producto_id'] ?>">
                                            <button class="group flex items-center justify-center rounded-md border border-transparent bg-gray-300 px-4 py-2 text-sm font-medium text-white hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                                                <i class="fa-solid fa-pen-to-square text-[18px] text-gray-400 duration-300 group-hover:text-gray-500"></i>
                                            </button>
                                        </a>

                                        <button class="group flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer"
                                            onclick="if(confirm('¿Deseas eliminar este producto?')) deleteElement(<?= $product['producto_id'] ?>)">
                                            <i class="fa-solid fa-trash-can text-[18px] text-red-400 duration-300 group-hover:text-red-300"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Paginación -->
                <div class="w-full bg-white p-3 flex gap-3 justify-center">

                    <?php if ($products_page > 1): ?>
                        <a href="/page/profile/<?= buildQueryString(['products_page' => $products_page - 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> anterior </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> anterior </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $products['pages']; $i++): ?>
                        <a href="/page/profile/<?= buildQueryString(['products_page' => $i]) ?>" class="font-semibold bg-gray-200 size-[30px] flex items-center justify-center rounded-sm duration-300 <?= $i == $products_page ? 'bg-gray-400 font-bold' : ' hover:bg-gray-300' ?>"> <?= $i ?> </a>
                    <?php endfor; ?>

                    <?php if ($products_page < $products['pages']): ?>
                        <a href="/page/profile/<?= buildQueryString(['products_page' => $products_page + 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> siguiente </a>
                    <?php else: ?>
                        <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> siguiente </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

</main>

<dialog id="new_product_modal" class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Nuevo producto:</h3>
        <form id="new-product-form" class="flex flex-col gap-2 my-5">
            <input type="hidden" id="usuario_id" name="usuario_id" value="<?= $user['usuario_id'] ?>">

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Nombre:</span>
                </div>
                <input type="text" id="producto_nombre" name="producto_nombre" placeholder="Escribe acá el nombre del producto" required
                    class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Descripción:</span>
                </div>
                <textarea placeholder="Ingresa la descripción del producto" id="producto_descripcion" name="producto_descripcion" 
                class="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded"></textarea>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Precio:</span>
                </div>
                <input type="number" id="producto_precio" name="producto_precio" placeholder="100.000" required
                    class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Stock:</span>
                </div>
                <input type="number" id="producto_cantidad" name="producto_cantidad" placeholder="10" required
                    class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <div class="space-y-2">
                <label for="producto_imagen" class="label-text font-medium text-gray-700">Imagen:</label>
                <input type="file" id="producto_imagen" name="producto_imagen" required
                    class="w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
            </div>

            <div class="flex flex-col gap-1">
                <label for="categoria_id" class="label-text font-medium text-gray-700">Categoría:</label>
                <select name="categoria_id" id="categoria_id" class="w-full border rounded-lg py-1 px-3" required>
                    <option value="1">Moda</option>
                    <option value="2">Comida</option>
                    <option value="3">Tecnología</option>
                    <option value="4">Otros</option>
                </select>
            </div>

            <div class="space-y-2">
                <label for="producto_estado" class="label-text font-medium text-gray-700">Estado:</label>
                <select name="producto_estado" id="producto_estado" class="w-full border rounded-lg py-1 px-3" required>
                    <option value="publico">Público</option>
                    <option value="privado" selected>Privado</option>
                </select>
            </div>

            <button type="submit" id="btn-submit"
                class="mt-4 group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-arrow-up-from-bracket text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                </span>
                Subir
            </button>
        </form>

        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button class="cursor-auto">close</button>
    </form>
</dialog>

<script>
    function deleteElement(idProducto) {
        fetch('/product/delete', {
                method: 'POST',
                body: JSON.stringify({
                    'id': idProducto
                }),
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
<script src="https://maps.googleapis.com/maps/api/js?key=<?= API_MAPS ?>&libraries=places&callback=initMap" async defer></script>
<script>
    function initMap() {
        geocoder = new google.maps.Geocoder();
        autocomplete = new google.maps.places.Autocomplete(document.getElementById("usuario_direccion"));
    }
</script>
<script src="/public/js/user_profile.js"></script>