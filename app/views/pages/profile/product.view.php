<main class="w-full max-w-[1200px] flex flex-col gap-10 py-12 justify-center items-center mx-auto px-3">
    <form id="product_profile_form" class="w-full flex flex-col md:flex-row justify-center items-start gap-5 my-12" enctype="multipart/form-data">
        <input type="hidden" id="id" name="producto_id" value="<?= $_GET['producto'] ?>">
        
        <div class="w-full max-w-[300px] space-y-5 mx-auto">
            <!-- Imagen -->
            <div class="bg-white p-5 space-y-5 rounded-lg shadow-lg w-full">
                <h1 class="text-lg uppercase tracking-tight font-bold">Imagen:</h1>
                        <div class="w-[250px] h-[250px] border-2 border-black rounded-lg shadow-lg overflow-hidden mx-auto"> 
                            <img src="<?= $product['producto_imagen_url'] ?>" alt="Producto <?= $product['producto_nombre'] ?>" class="object-contain w-full h-full">
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

                <a href="/page/product/?product=<?= $product['producto_id'] ?>"
                class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-eye text-[17px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                    </span>
                    Ver perfil
                </a>
            </div>

            <!-- Archivos multimedia -->
            <div class="bg-white p-5 space-y-4 rounded-lg shadow-lg w-full mx-auto">
                <h1 class="text-lg uppercase tracking-tight font-bold">Archivos multimedia:</h1>
                <?= count($multimedias) < 1 ? '<p class="text-gray-600 font-medium">Aún no hay archivos multimedia...</p>' : '' ?>
                <div class="divide-y divide-gray-300">
                    <?php foreach($multimedias as $index => $file): ?>
                        <article class="py-5 space-y-2">
                            <div class="w-[200px] h-[200px] border border-black rounded-lg shadow-lg flex items-center justify-center overflow-hidden mx-auto">
                                <?php if ($file['multimedia_tipo'] == 'imagen'): ?>
                                    <img src="<?= $file['multimedia_url'] ?>" alt="Archivo multimedia <?= $index?>">
                                <?php else: ?>
                                    <video class="object-contain w-full h-full border border-gray-400 rounded duration-300 hover:scale-[1.01] hover:shadow-md">
                                        <source src="<?= $file['multimedia_url'] ?>" type="video/mp4">
                                        Tu navegador no soporta video HTML5.
                                    </video>                                
                                <?php endif; ?>
                            </div>
                            <div>
                                <a onclick="deleteMultimedia(<?= $file['multimedia_id'] ?>)"
                                    class="btn-delete group relative flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-trash-can text-[17px] text-red-500 duration-300 group-hover:text-red-400"></i>
                                    </span>
                                    Eliminar
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col gap-4 w-full md:w-6/12 lg:w-9/12">
            <h1 class="text-lg uppercase tracking-tight font-bold">Datos de <?= $product['producto_nombre'] ?>:</h1>
            
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Nombre:</span>
                </div>
                <input type="text" id="producto_nombre" name="producto_nombre" placeholder="Ingresa el nombre del producto." value="<?= $product['producto_nombre']; ?>" disabled required
                    class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Descripción:</span>
                </div>
                <textarea type="text" id="producto_descripcion" name="producto_descripcion" placeholder="Ingresa una descripción breve del producto." required
                class="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded" disabled><?= $product['producto_descripcion'] ?></textarea>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Precio:</span>
                </div>
                <input type="number" id="producto_precio" name="producto_precio" placeholder="$10.000" value="<?= $product['producto_precio']; ?>" disabled required
                    class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Cantidad:</span>
                </div>
                <input type="number" id="producto_cantidad" name="producto_cantidad" placeholder="10" value="<?= $product['producto_cantidad']; ?>" disabled required
                    class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

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

            <!-- Botón de actualizar y de administrador -->
            <span class="w-full flex justify-between items-center">
                <div class="flex gap-5 w-full">
                    <button type="submit" id="btn-submit" name="submit" 
                    class="hidden group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa-solid fa-arrow-up-from-bracket text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                        </span>
                        Actualizar producto
                    </button>

                    <?php if ($_SESSION['rol_id'] == 4): ?>
                        <a href="/page/dashboard_products" 
                        class="group relative flex w-full justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-gear text-[18px] text-violet-500 duration-300 group-hover:text-violet-400"></i>
                            </span>
                            Administrador 
                        </a>
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

    function deleteMultimedia(idMultimedia) {
        if (confirm('¿Estas seguro de eliminar este archivo multimedia?')) {

            fetch('/product/deleteMultimedia', {
            method: 'POST',
            body: JSON.stringify({'id' : idMultimedia}),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message)
                if (data.success) {
                    window.location.reload();
                }
            });
        }
    }
</script>