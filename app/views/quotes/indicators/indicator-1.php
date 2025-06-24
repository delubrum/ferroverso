<div class="grid grid-cols-1 lg:grid-cols-1 gap-6 items-start">

    <!-- Tabla -->
    <div class="bg-white shadow-lg rounded-2xl p-6 overflow-auto">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3">Mes</th>
                    <th class="px-4 py-3 text-center">Total</th>
                    <th class="px-4 py-3 text-center text-gray-600">Costeo</th>
                    <th class="px-4 py-3 text-center text-blue-600">Seguimiento</th>
                    <th class="px-4 py-3 text-center text-green-600">Ganadas</th>
                    <th class="px-4 py-3 text-center text-red-600">Perdidas</th>
                    <th class="px-4 py-3 text-center text-yellow-600">Modificadas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($months as $month): ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= ucfirst($month) ?></td>
                        <td class="px-4 py-2 text-center"><?= $quotes_by_month[$month]['total'] ?></td>
                        <td class="px-4 py-2 text-center text-gray-600"><?= $quotes_by_month[$month]['costeo'] ?></td>
                        <td class="px-4 py-2 text-center text-blue-600"><?= $quotes_by_month[$month]['seguimiento'] ?></td>
                        <td class="px-4 py-2 text-center text-green-600"><?= $quotes_by_month[$month]['ganadas'] ?></td>
                        <td class="px-4 py-2 text-center text-red-600"><?= $quotes_by_month[$month]['perdidas'] ?></td>
                        <td class="px-4 py-2 text-center text-yellow-600"><?= $quotes_by_month[$month]['modificadas'] ?></td>
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

    const costeo = data.map(item => item.costeo);
    const seguimiento = data.map(item => item.seguimiento);
    const ganadas = data.map(item => item.ganadas);
    const perdidas = data.map(item => item.perdidas);
    const modificadas = data.map(item => item.modificadas);

    new Chart(document.getElementById('myChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Costeo',
                    data: costeo,
                    backgroundColor: 'rgba(0, 0, 0, 0.7)'
                },
                {
                    label: 'Seguimiento',
                    data: seguimiento,
                    backgroundColor: 'rgba(8, 102, 234, 0.7)'
                },
                {
                    label: 'Ganadas',
                    data: ganadas,
                    backgroundColor: 'rgba(34,197,94,0.7)'
                },
                {
                    label: 'Perdidas',
                    data: perdidas,
                    backgroundColor: 'rgba(239,68,68,0.7)'
                },
                {
                    label: 'Modificadas',
                    data: modificadas,
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
