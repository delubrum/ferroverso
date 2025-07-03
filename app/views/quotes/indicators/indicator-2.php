<!-- Tabla de valores monetarios -->
<div class="bg-white shadow-lg rounded-2xl p-6 overflow-auto">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs uppercase bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3">Mes</th>
                <th class="px-4 py-3 text-center">Total ($)</th>
                <th class="px-4 py-3 text-center text-gray-600">Costeo ($)</th>
                <th class="px-4 py-3 text-center text-blue-600">Seguimiento ($)</th>
                <th class="px-4 py-3 text-center text-green-600">Ganadas ($)</th>
                <th class="px-4 py-3 text-center text-red-600">Perdidas ($)</th>
                <th class="px-4 py-3 text-center text-yellow-600">Modificadas ($)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $value_totals = [
                'total_value' => 0,
                'costeo_value' => 0,
                'seguimiento_value' => 0,
                'ganadas_value' => 0,
                'perdidas_value' => 0,
                'modificadas_value' => 0,
            ];

            foreach ($months as $month): 
                foreach ($value_totals as $key => &$val) {
                    $val += $quotes_by_month[$month][$key];
                }
            ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?= ucfirst($month) ?></td>
                    <td class="px-4 py-2 text-center">
                        $<?= number_format($quotes_by_month[$month]['total_value'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-2 text-center text-gray-600">
                        $<?= number_format($quotes_by_month[$month]['costeo_value'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-2 text-center text-blue-600">
                        $<?= number_format($quotes_by_month[$month]['seguimiento_value'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-2 text-center text-green-600">
                        $<?= number_format($quotes_by_month[$month]['ganadas_value'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-2 text-center text-red-600">
                        $<?= number_format($quotes_by_month[$month]['perdidas_value'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-2 text-center text-yellow-600">
                        $<?= number_format($quotes_by_month[$month]['modificadas_value'], 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; unset($val); 

            $month_count = count($months);
            $value_averages = array_map(fn($val) => $val / $month_count, $value_totals);
            ?>

            <!-- Fila Promedio -->
            <tr class="font-semibold bg-gray-100 border-t">
                <td class="px-4 py-2">Promedio</td>
                <td class="px-4 py-2 text-center">
                    $<?= number_format($value_averages['total_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-gray-600">
                    $<?= number_format($value_averages['costeo_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-blue-600">
                    $<?= number_format($value_averages['seguimiento_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-green-600">
                    $<?= number_format($value_averages['ganadas_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-red-600">
                    $<?= number_format($value_averages['perdidas_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-yellow-600">
                    $<?= number_format($value_averages['modificadas_value'], 0, ',', '.') ?>
                </td>
            </tr>

            <!-- Fila Total -->
            <tr class="font-bold bg-gray-200 border-t">
                <td class="px-4 py-2">Total</td>
                <td class="px-4 py-2 text-center">
                    $<?= number_format($value_totals['total_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-gray-600">
                    $<?= number_format($value_totals['costeo_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-blue-600">
                    $<?= number_format($value_totals['seguimiento_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-green-600">
                    $<?= number_format($value_totals['ganadas_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-red-600">
                    $<?= number_format($value_totals['perdidas_value'], 0, ',', '.') ?>
                </td>
                <td class="px-4 py-2 text-center text-yellow-600">
                    $<?= number_format($value_totals['modificadas_value'], 0, ',', '.') ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Gráfico de valores monetarios -->
<div class="bg-white shadow-lg rounded-2xl p-6">
    <canvas id="valueChart" height="160"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const valueLabels = <?= json_encode($months) ?>;
    const valueData = <?= json_encode(array_values($quotes_by_month)) ?>;

    const costeoValue = valueData.map(item => item.costeo_value);
    const seguimientoValue = valueData.map(item => item.seguimiento_value);
    const ganadasValue = valueData.map(item => item.ganadas_value);
    const perdidasValue = valueData.map(item => item.perdidas_value);
    const modificadasValue = valueData.map(item => item.modificadas_value);

    new Chart(document.getElementById('valueChart'), {
        type: 'bar',
        data: {
            labels: valueLabels,
            datasets: [
                {
                    label: 'Costeo ($)',
                    data: costeoValue,
                    backgroundColor: 'rgba(0, 0, 0, 0.7)'
                },
                {
                    label: 'Seguimiento ($)',
                    data: seguimientoValue,
                    backgroundColor: 'rgba(8, 102, 234, 0.7)'
                },
                {
                    label: 'Ganadas ($)',
                    data: ganadasValue,
                    backgroundColor: 'rgba(34,197,94,0.7)'
                },
                {
                    label: 'Perdidas ($)',
                    data: perdidasValue,
                    backgroundColor: 'rgba(239,68,68,0.7)'
                },
                {
                    label: 'Modificadas ($)',
                    data: modificadasValue,
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
                    text: 'Valor de cotizaciones por mes - Año <?= $year ?>'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.parsed.y || 0;
                            return context.dataset.label + ': $' + value.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
