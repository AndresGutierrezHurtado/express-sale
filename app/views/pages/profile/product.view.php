<main class="w-full max-w-[1200px] flex flex-col gap-10 py-12 justify-center items-center mx-auto">
    <form id="product_profile_form" class="w-full flex flex-col md:flex-row justify-center items-start gap-5 my-12" enctype="multipart/form-data">
        <input type="hidden" id="id" name="producto_id" value="<?= $_GET['producto'] ?>">
        
        <div class="w-full max-w-[300px] space-y-5">
            <!-- Imagen -->
            <div class="bg-white p-5 space-y-4 rounded-lg shadow-lg w-full mx-auto">
                <h1 class="text-lg uppercase tracking-tight font-bold">Imagen:</h1>
                    <div class="w-full aspect-square rounded-lg shadow-lg flex justify-center items-center"> 
                        <img src="<?= $product['producto_imagen_url'] ?>" alt="Producto <?= $product['producto_nombre'] ?>" class="max-w-full max-h-full">
                    </div>
                <input type="file" id="image" name="producto_imagen" 
                class="hidden w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3">
                
                <!-- Botón de editar -->
                <a id="btn-edit" 
                class="group relative flex w-full justify-center rounded-md border border-transparent bg-gray-100 px-4 py-2 text-sm font-medium text-black hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-pen text-[17px] text-gray-300 duration-300 group-hover:text-gray-500"></i>
                    </span>
                    Editar
                </a>
            </div>

            <!-- Archivos multimedia -->
            <div class="bg-white p-5 space-y-4 rounded-lg shadow-lg w-full mx-auto">
                <h1 class="text-lg uppercase tracking-tight font-bold">Archivos multimedia:</h1>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-4 w-full md:w-6/12 lg:w-9/12">
            <h1 class="text-lg uppercase tracking-tight font-bold">Datos de <?= $product['producto_nombre'] ?>:</h1>   
            <div class="flex flex-col gap-1">
                <label for="producto_nombre" class="text-md font-medium text-gray-700">Nombre:</label>
                <input type="text" id="producto_nombre" name="producto_nombre" value="<?= $product['producto_nombre']; ?>" class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled>
            </div> 

            <div class="flex flex-col gap-1">
                <label for="producto_descripcion" class="text-md font-medium text-gray-700">Descripción:</label>
                <textarea id="producto_descripcion" name="producto_descripcion" class="w-full h-24 resize-none border rounded-lg py-1 px-3 disabled:opacity-50" disabled><?= $product['producto_descripcion']; ?></textarea>
            </div>

            <div class="flex flex-col gap-1">
                <label for="producto_precio" class="text-md font-medium text-gray-700">Precio:</label>
                <input type="number" id="producto_precio" name="producto_precio" value="<?= $product['producto_precio']; ?>" class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled>
            </div>

            <div class="flex flex-col gap-1">
                <label for="producto_cantidad" class="text-md font-medium text-gray-700">Cantidad:</label>
                <input type="number" id="producto_cantidad" name="producto_cantidad" value="<?= $product['producto_cantidad']; ?>" class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled>
            </div>

            <div class="flex flex-col gap-1">
                <label for="categoria_id" class="text-md font-medium text-gray-700">Categoría:</label>
                <select name="categoria_id" id="categoria_id" class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled>
                    <option value="1" <?= $product['categoria_id'] == '1' ? 'selected' : '' ?>>Moda</option>
                    <option value="2" <?= $product['categoria_id'] == '2' ? 'selected' : '' ?>>Comida</option>
                    <option value="3" <?= $product['categoria_id'] == '3' ? 'selected' : '' ?>>Tecnología</option>
                    <option value="4" <?= $product['categoria_id'] == '4' ? 'selected' : '' ?>>Otros</option>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label for="multimedia" class="text-md font-medium text-gray-700">Archivos multimedia: <span class="text-sm text-gray-500">(máximo 7)</span></label>
                <input id="multimedia" name="multimedia[]"
                    accept=".jpg,.jpeg,.png,.mp4,.avi,.mpeg,.mov,.mkv,.mp3,.wav,.webm,.ogg"
                    type="file"
                    class="block w-full border border-gray-300 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 bg-gray-200 cursor-pointer
                        disabled:opacity-50 disabled:pointer-events-none                        
                        file:bg-gray-50 file:border-0 file:mr-4 file:py-2 file:px-4 file:cursor-pointer"
                        multiple disabled onchange="checkFileCount(this <?= ',' . $product['numero_multimedias'] ?>)">
            </div>

            <div class="flex flex-col gap-1">
                <label for="producto_estado" class="text-md font-medium text-gray-700">Estado:</label>
                <select name="producto_estado" id="producto_estado" class="w-full border rounded-lg py-1 px-3 disabled:opacity-50" disabled>
                    <option value="publico" <?= $product['producto_estado'] == 'publico' ? 'selected' : '' ?>>Publico</option>
                    <option value="privado" <?= $product['producto_estado'] == 'privado' ? 'selected' : '' ?>>Privado</option>
                </select>
            </div>

            <span class="w-full flex justify-between items-center">
                <div>
                    <button type="submit" id="btn-submit" name="submit" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold hidden">Actualizar Perfil</button>
                </div>
                
                <div class="flex gap-5">
                    <?php if ($_SESSION['rol_id'] == 4): ?>
                        <a href="/page/dashboard_products" class="bg-violet-800 text-white py-2 px-4 rounded-md mt-auto w-max font-bold"> Administrador </a>
                    <?php endif; ?>
                </div>
            </span>
        </div>
    </form>
</main>

<script src="/public/js/product_profile.js"></script>   
<script>
    function checkFileCount(input, archivos = 7) {
        let maximo = 7;
        let files = input.files;
        
        // Verificar la cantidad de archivos seleccionados
        if (files.length > ( maximo - archivos) ) {
            alert("Solo puedes seleccionar un máximo de " + (maximo - archivos) +" archivos");
            input.value = '';
        }
    }
</script>