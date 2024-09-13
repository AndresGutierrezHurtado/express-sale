<div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col items-center justify-center pr-5 py-5 max-h-[100dvh] overflow-y-auto">
        <!-- Main -->
        <main class="w-full h-full p-5 rounded-[30px] bg-gray-200 overflow-y-auto overflow-x-hidden flex flex-col gap-5">
            <?php require_once($content); ?>
        </main>
    </div>
    <div class="h-[100dvh] overflow-visible w-full max-w-[70px] md:max-w-[280px]">
        <ul class="menu min-h-full w-full bg-white py-5 p-1 md:px-3 flex flex-col justify-between text-lg">
            <div>
                <a href="/" class="w-full tooltip tooltip-right" data-tip="Ir a inicio">
                    <figure class="w-full max-w-[150px] aspect-square mx-auto">
                        <img src="/public/images/logo.png" alt="Logo express sale"
                            class="object-contain h-full w-full">
                    </figure>
                </a>
            </div>
            <div class="flex-grow flex flex-col gap-2 items-center justify-center">
                <li class="w-full">
                    <a href="/" class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start" data-tip="Ir a inicio">
                        <i class="fa-solid fa-house"></i>
                        <p class="hidden md:block">Inicio</p>
                    </a>
                </li>
                <li class="w-full">
                    <a href="/page/stats/?id=<?= $user['usuario_id'] ?>" class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start <?= $current_page == "stats" ? "bg-gradient-to-r from-violet-600/80 from-10% to-white to-90% font-semibold" : "" ?>" data-tip="Ver estadísticas de la cuenta">
                        <i class="fa-solid fa-user-gear"></i>
                        <p class="hidden md:block">Panel de <?= $user['rol_nombre'] ?></p>
                    </a>
                </li>
                <?php if ($user['rol_id'] == 2): ?>
                    <li class="w-full">
                        <a href="/page/seller_products/?seller=<?= $user['usuario_id'] ?>" class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start <?= $current_page == "products" ? "bg-gradient-to-r from-violet-600/80 from-10% to-white to-90% font-semibold" : "" ?>" data-tip="Ver los productos del vendedor">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            <p class="hidden md:block">Productos</p>
                        </a>
                    </li>
                <?php elseif ($user['rol_id'] == 3): ?>
                    <li class="w-full">
                        <a href="/page/shipments/" class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start <?= $current_page == "products" ? "bg-gradient-to-r from-violet-600/80 from-10% to-white to-90% font-semibold" : "" ?>" data-tip="Ver los productos del vendedor">
                            <i class="fa-solid fa-truck"></i>
                            <p class="hidden md:block">Envíos</p>
                        </a>
                    </li>
                <?php endif; ?>
            </div>
            <div>
                <?php if ($user['rol_id'] == 2): ?>
                    <li>
                        <a class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start" onclick="new_product_modal.show()" data-tip="Crear un nuevo producto">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            <p class="hidden md:block">Subir producto</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="javascript:history.back()" class="flex ga-2 items-center justify-center md:justify-start">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p class="hidden md:block">Volver</p>
                    </a>
                </li>
            </div>
        </ul>
    </div>
</div>

<!-- Nuevo producto modal -->
<dialog id="new_product_modal" class="modal bg-black/40">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Nuevo producto:</h3>
        <form id="new-product-form" action="/product/create" method="post" class="fetch-form flex flex-col gap-2 my-5">
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
