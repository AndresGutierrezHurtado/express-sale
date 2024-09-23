<section class="w-full flex flex-col xl:flex-row gap-5">
    <!-- Sección de gráfica -->
    <article class="w-full p-4 flex flex-col gap-3 card bg-base-100 ">
        <nav class="w-full flex flex-col lg:flex-row justify-between">
            <h3 class="text-xl font-bold tracking-tight">Ventas del mes de <?= isset($_GET['mes']) ? date('F', mktime(0, 0, 0, $_GET['mes'], 1, date('Y'))) : date('F', mktime(0, 0, 0, $result['domicilios_mensuales'][count($result['domicilios_mensuales']) - 1]['mes'], 1, date('Y'))) ?> del <?= isset($_GET['año']) ? $_GET['año'] : date('Y') ?></h3>
            <select onchange="window.location.href = this.value">
                <option <?= !isset($_GET['año']) ? 'selected' : '' ?> value="/page/stats/<?= $this->buildQueryString([], ['año', 'mes']) ?>">Ultimos 12 meses</option>
                <option <?= isset($_GET['año']) && $_GET['año'] == date('Y') ? 'selected' : '' ?> value="/page/stats/<?= $this->buildQueryString(['año' => date('Y')], ['mes']) ?>">año <?= date('Y') ?></option>
                <option <?= isset($_GET['año']) && $_GET['año'] == date('Y') - 1 ? 'selected' : '' ?> value="/page/stats/<?= $this->buildQueryString(['año' => date('Y') - 1], ['mes']) ?>">año <?= date('Y') - 1 ?></option>
                <option <?= isset($_GET['año']) && $_GET['año'] == date('Y') - 2 ? 'selected' : '' ?> value="/page/stats/<?= $this->buildQueryString(['año' => date('Y') - 2], ['mes']) ?>">año <?= date('Y') - 2 ?></option>
            </select>
        </nav>
        <div class="w-full h-full overflow-auto">
            <canvas class="min-w-[600px] w-full min-h-[400px] max-h-[400px] rounded-lg" id="sales-chart">

            </canvas>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-between">
            <div class="stat text-center items-center justify-center">
                <div class="stat-title whitespace-normal">Dinero total domicilios</div>
                <div class="stat-value whitespace-normal">
                    <?= number_format(isset($_GET['mes']) ? $result['domicilios_mensuales'][$_GET['mes'] - 1]['dinero_envios'] : $result['domicilios_mensuales'][count($result['domicilios_mensuales']) - 1]['dinero_envios']) ?>
                    COP
                </div>
                <div class="stat-desc whitespace-normal">En el mes de <?= isset($_GET['mes']) ? date('F', mktime(0, 0, 0, $_GET['mes'], 1, date('Y'))) : date('F', mktime(0, 0, 0, $result['domicilios_mensuales'][count($result['domicilios_mensuales']) - 1]['mes'], 1, date('Y'))) ?></div>
            </div>
            <div class="stat text-center items-center justify-center">
                <div class="stat-title whitespace-normal">Número de domicilios hechos</div>
                <div class="stat-value whitespace-normal">
                    <?= $result['domicilios_mensuales'][isset($_GET['mes']) ? $_GET['mes'] - 1 : count($result['domicilios_mensuales']) - 1]['numero_envios'] ?>
                </div>
                <div class="stat-desc whitespace-normal">En el mes de <?= isset($_GET['mes']) ? date('F', mktime(0, 0, 0, $_GET['mes'], 1, date('Y'))) : date('F', mktime(0, 0, 0, $result['domicilios_mensuales'][count($result['domicilios_mensuales']) - 1]['mes'], 1, date('Y'))) ?></div>
            </div>
        </div>
    </article>

    <!-- Dinero disponible -->
    <div class="flex flex-col gap-5 w-full max-w-[450px]">
        <article class="w-full mx-auto h-fit p-10 flex flex-col items-center justify-center gap-1 card bg-base-100 stat text-center">
            <div class="stat-title whitespace-normal">Saldo actual</div>
            <div class="stat-value whitespace-normal"><?= number_format($user['trabajador_saldo']) ?> COP</div>
            <div class="stat-desc whitespace-normal"><?= 5 - $result['retiros_mes'] ?> retiros disponibles</div>
            <div class="divider"></div>
            <div class="space-y-2">
                <p><span class="font-bold text-violet-600 hover:underline cursor-pointer" onclick="withdrawal_history.showModal()">Ver historial de retiros</span>, <br> Se actualiza cada 2 minutos aproximadamente</p>
                <div class="<?= $user['trabajador_saldo'] < 10000 || $result['retiros_mes'] >= 5 ? 'tooltip tooltip-left' : '' ?>" <?= $result['retiros_mes'] >= 5 ? 'disabled data-tip="Ya no tienes retiros disponibles"' : ($user['trabajador_saldo'] >= 10000 ? 'onclick="retirar_dinero.show()"' : 'data-tip="Debes tener al menos 10.000 COP"') ?>>
                    <button class="btn btn-success text-white rounded-full px-10" <?= $result['retiros_mes'] >= 5 || $user['trabajador_saldo'] < 10000 ? 'disabled' : '' ?>>
                        <i class="fa-solid fa-money-bill-wave"></i>
                        Retirar ahora
                    </button>
                </div>
            </div>
        </article>

        <nav class="flex justify-center items-center flex-wrap gap-3">
            <!-- Cartas información -->
            <article class="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center">
                <div>
                    <i class="fa-solid fa-truck-ramp-box text-5xl"></i>
                </div>
                <div class="flex-grow">
                    <div class="stat-value text-xl"><?= $result['cantidad_total_envios'] ?></div>
                    <div class="text-gray-500 leading-none">Domicilios realizados</div>
                </div>
            </article>
        </nav>
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
                <button type="submit" class="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg">
                    Retirar
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- withdrawal_history -->
<dialog id="withdrawal_history" class="modal">
    <div class="modal-box space-y-4">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <!-- Contenido modal -->
        <h3 class="font-bold text-3xl tracking-tight">Historial de retiros</h3>
        <div>
            <table class="table min-w-full text-center border">
                <thead>
                    <tr class="text-[15px] text-base-content bg-base-300">
                        <th>Fecha</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($result['withdraws'])): ?>
                        <tr>
                            <td colspan="3" class="font-bold text-center text-lg">No hay retiros</td>
                        </tr>
                    <?php endif ?>
                    <?php foreach ($result['withdraws'] as $withdrawal): ?>
                        <?php if (!$withdrawal['fecha']) continue; ?>
                        <tr>
                            <td><?= date('d-m-y H:i', strtotime($withdrawal['fecha'])) ?></td>
                            <td class="<?= ($withdrawal['tipo'] == 'retiro' ? 'text-red-500' : 'text-green-500') ?> font-semibold"> <?= ($withdrawal['tipo'] == 'retiro' ? '-' : '+') . number_format($withdrawal['valor']) ?> COP</td>
                            <td class="capitalize"><?= $withdrawal['tipo'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('sales-chart').getContext('2d');

        // Datos del PHP
        const data = <?= json_encode($result['domicilios_mensuales']) ?>;

        const labels = [];
        const salesData = [];

        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        data.forEach(item => {
            const mes = parseInt(item.mes);

            labels.push(meses[mes - 1]);

            salesData.push(item.numero_envios);
        })

        // Crear el gráfico
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Número de domicilios mensuales',
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
                            text: 'Número de domicilios entregados'
                        },
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
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