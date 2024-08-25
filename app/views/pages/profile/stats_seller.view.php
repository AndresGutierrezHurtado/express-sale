<main class="w-full h-full p-5 rounded-[30px] bg-gray-200 overflow-y-auto overflow-x-hidden flex flex-col gap-5">
    <nav class="flex flex-col md:flex-row items-center justify-between gap-3">
        <h1 class="text-3xl font-bold tracking-tight w-fit">
            Estadísticas de <?= $user['rol_nombre'] ?>
        </h1>

        <div class="flex gap-2 items-start w-full max-w-[400px]">
            <form action="/profile/stats" method="GET" class="grow">
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
                    <input type="text" class="w-full" placeholder="Search" />
                </label>
            </form>
            <div class="dropdown dropdown-end dropdown-hover">
                <div tabindex="0" role="button" class="btn bg-white">
                    <i class="fa-solid fa-ellipsis rotate-90"></i>
                </div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <li><a>Item 1</a></li>
                    <li><a>Item 2</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="w-full flex gap-5">
        <!-- Sección de gráfica -->
        <article class="w-full p-4 flex flex-col gap-3 card bg-base-100 ">
            <nav class="w-full flex flex-col md:flex-row justify-between">
                <h3 class="text-xl font-bold tracking-tight">Ventas del mes de <?= !isset($_GET['mes']) ? date('F') : date('F', mktime(0, 0, 0, $_GET['mes'], 10)) ?> del <?= !isset($_GET['año']) ? date('Y') : $_GET['año'] ?></h3>
                <select name="" id="">
                    <option value="">Este mes</option>
                    <option value="">Hace 3 meses</option>
                    <option value="">Hace 6 meses</option>
                    <option value="">Hace 12 meses</option>
                </select>
            </nav>
            <figure class="w-full min-h-[200px] bg-violet-500 rounded-lg">

            </figure>
            <div class="w-full flex flex-col md:flex-row justify-between">
                <div class="stat text-center">
                    <div class="stat-title">Dinero total ventas</div>
                    <div class="stat-value"><?= number_format($result['informacion_mes']['dinero_ventas'] ?? 0) ?> COP</div>
                    <div class="stat-desc">21% more than last month</div>
                </div>
                <div class="stat text-center">
                    <div class="stat-title">Número de productos vendidos</div>
                    <div class="stat-value"><?= $result['informacion_mes']['numero_ventas'] ?? 0 ?></div>
                    <div class="stat-desc">21% more than last month</div>
                </div>
            </div>
        </article>

        <!-- Dinero disponible -->
        <article class="w-full max-w-[500px] p-4 flex flex-col items-center justify-center gap-1 card bg-base-100 stat text-center">
            <div class="stat-title">Saldo actual</div>
            <div class="stat-value"><?= number_format($result['informacion_mes']['dinero_ventas']) ?> COP</div>
            <div class="stat-desc">* retiros disponibles</div>
            <div class="divider"></div>
            <div class="space-y-2">
                <p>Se actualiza cada 2 minutos aproximadamente</p>
                <button class="btn btn-success text-white rounded-full px-10">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    Retirar ahora
                </button>
            </div>
        </article>
    </section>
    <section class="w-full flex gap-5">
        <div class="flex flex-grow flex-col gap-5">
            <nav class="flex flex-col md:flex-row gap-3">
                <!-- Dinero disponible -->
                <article class="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center">
                    <div>
                        <i class="fa-solid fa-boxes-stacked text-5xl"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="stat-value text-xl"><?= $result['cantidad_total_productos'] ?></div>
                        <div class="text-gray-500 leading-none">Productos</div>
                    </div>
                </article>
                <article class="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center">
                    <div>
                        <i class="fa-solid fa-clipboard-list text-5xl"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="stat-value text-xl"><?= $user['trabajador_numero_trabajos'] ?></div>
                        <div class="text-gray-500 leading-none">Productos vendidos</div>
                    </div>
                </article>
                <article class="min-w-[170px] w-fit max-w-full p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center">
                    <div>
                        <i class="fa-solid fa-truck-ramp-box text-5xl"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="stat-value text-xl"><?= $result['cantidad_pedidos_pendientes'] ?></div>
                        <div class="text-gray-500 leading-none">Ordenes pendientes</div>
                    </div>
                </article>
            </nav>
            <article class="min-w-[170px] w-full p-4 flex flex-col items-center gap-4 card bg-base-100 stat text-center">
                <nav class="w-full flex justify-between">
                    <h1 class="text-xl font-bold">Ventas recientes</h1>
                </nav>
                <div class="w-full overflow-auto">
                    <table class="w-full table table-zebra">
                        <thead class="text-left">
                            <tr>
                                <th>Productos</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Comprador</th>
                                <th>Estado</th>
                                <th>Domiciliario</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result['todos_los_pedidos'] as $order): ?>
                                <tr>
                                    <td>
                                        <?php foreach ($order['productos'] as $product): ?>
                                            <?php
                                            $total = 0;
                                            $total += $product['producto_precio'] * $product['producto_cantidad']
                                            ?>
                                            <div class="flex items-center gap-3">
                                                <div class="avatar">
                                                    <div class="mask mask-squircle h-12 w-12">
                                                        <img
                                                            src="<?= $product['producto_imagen_url'] ?>"
                                                            alt="<?= $product['producto_nombre'] ?>" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold"><?= $product['producto_cantidad'] . ' - ' . $product['producto_nombre'] ?></div>
                                                    <div class="text-sm opacity-60 capitalize"><?= number_format($product['producto_precio']) ?> COP - <?= $product['producto_categoria'] ?></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </td>
                                    <td><?= number_format($total) ?></td>
                                    <td><?= $order['pedido_fecha'] ?></td>
                                    <td><?= $order['comprador_nombre'] ?></td>
                                    <td>
                                        <span class="badge <?php
                                                            switch ($order['pedido_estado']) {
                                                                case 'pendiente':
                                                                    echo 'badge-warning';
                                                                    break;
                                                                case 'enviando':
                                                                    echo 'badge-primary';
                                                                    break;
                                                                case 'entregado':
                                                                    echo 'badge-info';
                                                                    break;
                                                                case 'recibido':
                                                                    echo 'badge-success';
                                                                    break;
                                                            }
                                                            ?> bg-opacity-70 badge-sm py-1 px-3">
                                            <?= $order['pedido_estado'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= $order['domiciliario_alias'] ?? 'Pendiente' ?>
                                    </td>
                                    <td>
                                        <a href="/page/order/?order=<?= $order['pedido_id'] ?>">
                                            <button class="relative group flex items-center justify-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50 cursor-pointer tooltip tooltip-left" data-tip="Ver más información sobre el pedido">
                                                <i class="fa-solid fa-eye text-[18px] text-violet-400 duration-300 group-hover:text-violet-300"></i>
                                                <?php if ($order['pedido_estado'] == 'entregado'): ?>
                                                    <span class=" absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-5 h-5 ms-2 text-center font-bold text-red-800 bg-red-400 rounded-full">
                                                        !
                                                    </span>
                                                <?php endif; ?>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
        <div class="w-full max-w-[400px] p-4 flex flex-col items-center gap-4 card bg-base-100 stat text-center">
            <h1 class="text-xl font-bold">Productos más vendidos</h1>
            <div class="w-full space-y-3 overflow-y-auto">
                <?php foreach ($result['productos_mas_vendidos'] as $product): ?>
                    <article class="bg-gray-100 rounded-lg p-3 flex gap-4 justify-between items-center">
                        <div class="flex items-center gap-2">
                            <figure class="w-[50px] aspect-square">
                                <img class="object-contain h-full w-full"
                                    src="<?= $product['producto_imagen_url'] ?>"
                                    alt="<?= $product['producto_nombre'] ?>" />
                            </figure>
                            <p><?= $product['producto_nombre'] ?></p>
                        </div>
                        <div>
                            <h1 class="font-extrabold text-2xl ">
                                <?= $product['numero_ventas'] ?>
                            </h1>
                        </div>

                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>