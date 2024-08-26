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
    <div class="flex flex-col gap-5">
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

        <nav class="flex flex-wrap gap-3">
            <!-- Cartas información -->
            <article class="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center">
                <div>
                    <i class="fa-solid fa-truck-ramp-box text-5xl"></i>
                </div>
                <div class="flex-grow">
                    <div class="stat-value text-xl"><?= $result['cantidad_total_productos_vendidos'] ?></div>
                    <div class="text-gray-500 leading-none">Domicilios realizados</div>
                </div>
            </article>
        </nav>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
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