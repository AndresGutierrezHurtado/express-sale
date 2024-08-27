<nav class="flex flex-col md:flex-row items-center justify-between gap-3">
    <h1 class="text-3xl font-bold tracking-tight w-fit">
        Productos de <?= $user['usuario_nombre'] . " " . $user['usuario_apellido'] ?>
    </h1>

    <div class="flex gap-2 items-start w-full max-w-[400px]">
        <form action="/page/seller_products/" method="GET" class="grow">
            <input type="hidden" name="seller" value="<?= $user['usuario_id'] ?>">
            <label class="input input-bordered flex w-full items-center gap-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 16"
                    fill="currentColor"
                    class="h-4 w-4 opacity-70">
                    <path
                        fill-rule="evenodd"
                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                        clip-rule="evenodd" />
                </svg>
                <input type="text" class="w-full" name="search" placeholder="Buscar productos..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" />
            </label>
        </form>
        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
            <a href="/page/seller_products/?seller=<?= $user['usuario_id'] ?>" role="button" class="btn bg-white">
                <i class="fa-solid fa-arrows-rotate rotate-90"></i>
            </a>
        <?php endif; ?>
    </div>
</nav>
<!-- Contenedor de productos vendedor -->
<div class="w-full flex flex-col shadow-lg rounded-lg">
    <span class="w-full flex flex-col sm:flex-row gap-2 justify-between bg-slate-800 text-white p-3 rounded-t-lg">
        <h1 class="text-xl tracking-tight font-bold ">Productos de <?= $user['usuario_alias'] ?></h1>
        <?php if ($_SESSION['usuario_id'] == $user['usuario_id']) : ?>
            <div class="flex gap-5 flex-none">
                <button class="btn btn-success btn-sm text-white" onclick="new_product_modal.showModal()">
                    <i class="fa-solid fa-plus mr-2"></i>
                    <p>
                        <span class="hidden sm:inline">Añadir</span> nuevo producto
                    </p>
                </button>
            </div>
        <?php endif; ?>
    </span>
    <div class="w-full bg-white flex flex-col gap-5 justify-center items-center p-5 rounded-b-lg">
        <div class="w-full overflow-x-auto overflow-y-visible border border-gray-500">
            <table class="w-full table text-left">
                <thead>
                    <tr class="bg-gray-200 text-md font-bold text-gray-700 text-left">
                        <th><a href="/page/seller_products/<?= $this->buildQueryString([], ['order', 'sort']) ?>" class="tooltip tooltip-bottom" data-tip="Ordenar por ID">ID</a></th>
                        <th><a href="/page/seller_products/<?= $this->buildQueryString(['order' => 'asc', 'sort' => 'producto_nombre']) ?>" class="tooltip tooltip-bottom" data-tip="Ordenar por ID">Nombre</a></th>
                        <th><a href="/page/seller_products/<?= $this->buildQueryString(['order' => 'asc', 'sort' => 'producto_precio']) ?>" class="tooltip tooltip-bottom" data-tip="Ordenar por precio">Precio</a></th>
                        <th><a href="/page/seller_products/<?= $this->buildQueryString(['order' => 'asc', 'sort' => 'producto_cantidad']) ?>" class="tooltip tooltip-bottom" data-tip="Ordenar por cantidad">Stock</a></th>
                        <th><a href="/page/seller_products/<?= $this->buildQueryString(['order' => 'asc', 'sort' => 'categoria_nombre']) ?>" class="tooltip tooltip-bottom" data-tip="Ordenar por categoria">Categoria</a></th>
                        <th class="text-center">Acciones</th>
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
                <a href="/page/profile/<?= $this->buildQueryString(['products_page' => $i]) ?>" class="font-semibold bg-gray-200 size-[30px] flex items-center justify-center rounded-sm duration-300 <?= $i == $products_page ? 'bg-gray-400 font-bold' : ' hover:bg-gray-300' ?>"> <?= $i ?> </a>
            <?php endfor; ?>

            <?php if ($products_page < $products['pages']): ?>
                <a href="/page/profile/<?= $this->buildQueryString(['products_page' => $products_page + 1]) ?>" class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300"> siguiente </a>
            <?php else: ?>
                <a class="font-semibold bg-gray-200 h-[30px] px-3 flex items-center justify-center rounded-sm duration-300 hover:bg-gray-300 opacity-50 cursor-not-allowed"> siguiente </a>
            <?php endif; ?>

        </div>
    </div>
</div>

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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>