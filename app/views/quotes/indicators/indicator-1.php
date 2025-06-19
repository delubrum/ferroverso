<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

    <!-- Tabla -->
    <div class="bg-white shadow-lg rounded-2xl p-6 overflow-auto">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3">Mes</th>
                    <th class="px-4 py-3 text-center">Total</th>
                    <th class="px-4 py-3 text-center text-green-600">Ganados</th>
                    <th class="px-4 py-3 text-center text-red-600">Perdidos</th>
                    <th class="px-4 py-3 text-center text-yellow-600">Pendientes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($months as $month): ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= ucfirst($month) ?></td>
                        <td class="px-4 py-2 text-center"><?= $quotes_by_month[$month]['total'] ?></td>
                        <td class="px-4 py-2 text-center text-green-600"><?= $quotes_by_month[$month]['ganados'] ?></td>
                        <td class="px-4 py-2 text-center text-red-600"><?= $quotes_by_month[$month]['perdidos'] ?></td>
                        <td class="px-4 py-2 text-center text-yellow-600"><?= $quotes_by_month[$month]['pendientes'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Gráfico -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <canvas id="myChart" height="160"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?= json_encode($months) ?>;
    const data = <?= json_encode(array_values($quotes_by_month)) ?>;

    const ganados = data.map(item => item.ganados);
    const perdidos = data.map(item => item.perdidos);
    const pendientes = data.map(item => item.pendientes);

    new Chart(document.getElementById('myChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Ganados',
                    data: ganados,
                    backgroundColor: 'rgba(34,197,94,0.7)'
                },
                {
                    label: 'Perdidos',
                    data: perdidos,
                    backgroundColor: 'rgba(239,68,68,0.7)'
                },
                {
                    label: 'Pendientes',
                    data: pendientes,
                    backgroundColor: 'rgba(234,179,8,0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Cotizaciones por mes - Año <?= $year ?>'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
