<nav class="flex flex-col md:flex-row items-center justify-between gap-3">
    <h1 class="text-3xl font-bold tracking-tight w-fit">
        Estadísticas de <?= $user['rol_nombre'] ?> <?= $user['usuario_nombre'] ?> <?= $user['usuario_apellido'] ?> 
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
<section class="w-full flex flex-col xl:flex-row gap-5">
    <!-- Sección de gráfica -->
    <article class="w-full p-4 flex flex-col gap-3 card bg-base-100 ">
        <nav class="w-full flex flex-col lg:flex-row justify-between">
            <h3 class="text-xl font-bold tracking-tight">Ventas del mes de <?= !isset($_GET['mes']) ? date('F', mktime(0, 0, 0, $result['ventas_mensuales'][count($result['ventas_mensuales']) - 1]['mes'], 1, date('Y'))) : date('F', mktime(0, 0, 0, $_GET['mes'], 1, date('Y'))) ?> del <?= !isset($_GET['año']) ? date('Y') : $_GET['año'] ?></h3>
            <select name="" id="" onchange="window.location.href = this.value">
                <option <?= !isset($_GET['año']) ? 'selected' : '' ?> value="/page/stats/<?= $this->buildQueryString([], ['año', 'mes']) ?>">Ultimos 12 meses</option>
                <option <?= isset($_GET['año']) && $_GET['año'] == date('Y') ? 'selected' : '' ?> value="/page/stats/<?= $this->buildQueryString(['año' => date('Y')], ['mes']) ?>">año <?= date('Y') ?></option>
                <option <?= isset($_GET['año']) && $_GET['año'] == date('Y') - 1 ? 'selected' : '' ?> value="/page/stats/<?= $this->buildQueryString(['año' => date('Y') - 1], ['mes']) ?>">año <?= date('Y') - 1 ?></option>
                <option <?= isset($_GET['año']) && $_GET['año'] == date('Y') - 2 ? 'selected' : '' ?> value="/page/stats/<?= $this->buildQueryString(['año' => date('Y') - 2], ['mes']) ?>">año <?= date('Y') - 2 ?></option>
            </select>
        </nav>
        <div class="w-full h-full overflow-auto">
            <canvas class="min-w-[600px] w-full min-h-[400px]  rounded-lg" id="sales-chart">

            </canvas>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-between">
            <div class="stat text-center items-center justify-center">
                <div class="stat-title whitespace-normal">Dinero total ventas</div>
                <div class="stat-value whitespace-normal">
                    <?= number_format(isset($_GET['mes']) ? $result['ventas_mensuales'][$_GET['mes'] - 1]['dinero_ventas'] : $result['ventas_mensuales'][count($result['ventas_mensuales']) - 1]['dinero_ventas']) ?>
                    COP
                </div>
                <div class="stat-desc whitespace-normal">En el mes de <?= isset($_GET['mes']) ? date('F', mktime(0, 0, 0, $_GET['mes'], 1, date('Y'))) : date('F', mktime(0, 0, 0, $result['ventas_mensuales'][count($result['ventas_mensuales']) - 1]['mes'], 1, date('Y'))) ?></div>
            </div>
            <div class="stat text-center items-center justify-center">
                <div class="stat-title whitespace-normal">Número de productos vendidos</div>
                <div class="stat-value whitespace-normal"><?= isset($_GET['mes']) ? $result['ventas_mensuales'][$_GET['mes'] - 1]['numero_productos'] :  $result['ventas_mensuales'][count($result['ventas_mensuales']) - 1]['numero_productos'] ?></div>
                <div class="stat-desc whitespace-normal">En el mes de <?= isset($_GET['mes']) ? date('F', mktime(0, 0, 0, $_GET['mes'], 1, date('Y'))) : date('F', mktime(0, 0, 0, $result['ventas_mensuales'][count($result['ventas_mensuales']) - 1]['mes'], 1, date('Y'))) ?></div>
            </div>
        </div>
    </article>

    <!-- Dinero disponible -->
    <article class="w-full max-w-[500px] mx-auto h-fit p-10 flex flex-col items-center justify-center gap-1 card bg-base-100 stat text-center">
        <div class="stat-title whitespace-normal">Saldo actual</div>
        <div class="stat-value whitespace-normal"><?= number_format($user['trabajador_saldo']) ?> COP</div>
        <div class="stat-desc whitespace-normal"><?= 5 - $result['retiros_mes'] ?> retiros disponibles</div>
        <div class="divider"></div>
        <div class="space-y-2">
            <p>Se actualiza cada 2 minutos aproximadamente</p>
            <div class="<?= $user['trabajador_saldo'] < 10000 || $result['retiros_mes'] >= 5 ? 'tooltip tooltip-left' : '' ?>" <?= $result['retiros_mes'] >= 5 ? 'disabled data-tip="Ya no tienes retiros disponibles"' : ($user['trabajador_saldo'] > 10000 ? 'onclick="retirar_dinero.showModal()"' : 'data-tip="Debes tener al menos 10.000 COP" disabled') ?>>
                <button class="btn btn-success text-white rounded-full px-10" <?= $result['retiros_mes'] >= 5 ? 'disabled data-tip="Ya no tienes retiros disponibles"' : ($user['trabajador_saldo'] > 10000 ? 'onclick="retirar_dinero.showModal()"' : 'data-tip="Debes tener al menos 10.000 COP" disabled') ?>>
                    <i class="fa-solid fa-money-bill-wave"></i>
                    Retirar ahora
                </button>
            </div>
        </div>
    </article>
</section>
<section class="w-full flex flex-col xl:flex-row gap-5">
    <div class="flex flex-grow flex-col gap-5">
        <nav class="flex flex-wrap gap-3">
            <!-- Cartas información -->
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
        <!-- Tabla de pedidos -->
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
                        <?= empty($result['todos_los_pedidos']) ? '<tr><td colspan="7" class="text-center text-xl font-medium text-gray-600">No hay pedidos</td></tr>' : '' ?>
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

    <!-- Mas vendidos -->
    <div class="w-full max-w-[400px] mx-auto p-4 flex flex-col items-center gap-4 card bg-base-100 stat text-center">
        <h1 class="text-xl font-bold">Productos más vendidos</h1>
        <div class="w-full space-y-3 overflow-y-auto">
            <?php foreach ($result['productos_mas_vendidos'] as $product): ?>
                <article class="bg-gray-100 rounded-lg p-3 flex flex-col md:flex-row gap-4 justify-between items-center">
                    <div class="flex flex-col md:flex-row items-center gap-2">
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

<dialog id="retirar_dinero" class="modal">
    <div class="modal-box space-y-2">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <!-- Contenido modal -->
        <h3 class="text-xl font-bold">Retira tu dinero:</h3>
        <p class="leading-none text-gray-600">Esta es la sección donde podrás retirar tu dinero, <span class="font-semibold text-violet-600">debes tener en cuenta que tienes que ser mayor de 18 años, el valor mínimo es de 10.000.</span></p>

        <form action="/user/withdraw" method="post" enctype="multipart/form-data" class="fetch-form space-y-5">
            <input type="hidden" name="trabajador_id" value="<?= $user['trabajador_id'] ?>">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-medium text-gray-700">Valor a retirar:</span>
                </div>
                <input type="number"
                    name="retiro_valor" id="retiro_valor" required
                    placeholder="10,000 ~ <?= number_format($user['trabajador_saldo']) ?>" min="10000" max="<?= $user['trabajador_saldo'] ?>"
                    class="input input-sm input-bordered w-full focus:outline-0 focus:border-violet-600 rounded py-1 h-auto">
            </label>

            <div class="my-3">
                <button class="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">
                    Retirar
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('sales-chart').getContext('2d');

        // Datos del PHP
        const data = <?= json_encode($result['ventas_mensuales']) ?>;

        const labels = [];
        const salesData = [];

        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        data.forEach(item => {
            const mes = parseInt(item.mes);

            labels.push(meses[mes - 1]);

            salesData.push(item.numero_productos);
        })

        // Crear el gráfico
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Número de Ventas mensuales',
                    data: salesData,
                    borderColor: 'rgb(124 58 237 / 1)',
                    backgroundColor: 'rgb(124 58 237 / 0.2)',
                    fill: true
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Meses'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'N° Productos Vendidos'
                        },
                        beginAtZero: true
                    }
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const mesSeleccionado = data[index].mes;
                        const añoSeleccionado = data[index].año;

                        // Construir la URL con los parámetros mes y año
                        const queryString = `<?= count($_GET) > 0 ? $this->buildQueryString([], ['mes', 'año']) . '&' : '?' ?>mes=${mesSeleccionado}&año=${añoSeleccionado}`;
                        window.location.href = window.location.pathname + queryString;
                    }
                }
            }
        });
    });
</script>