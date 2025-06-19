<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

    <!-- Tabla -->
    <div class="bg-white shadow-lg rounded-2xl p-6 overflow-auto">
        <table id="example" class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-center">Mes</th>
                    <th class="px-4 py-3 text-center">Total</th>
                    <th class="px-4 py-3 text-center">Externos</th>
                    <th class="px-4 py-3 text-center">% Externos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalSum = 0;
                $externalSum = 0;
                $result2Sum = 0;
                $count = count($result);

                foreach ($result as $r) {
                    $totalSum += $r['total'];
                    $externalSum += $r['external'];
                    $result2Sum += $r['result2'];
                }

                $avgTotal = $count > 0 ? intval(round($totalSum / $count)) : 0;
                $avgExternal = $count > 0 ? intval(round($externalSum / $count)) : 0;
                $avgResult2 = $count > 0 ? intval(round($result2Sum / $count)) : 0;
                $totalResult2 = $totalSum > 0 ? intval(round($externalSum / $totalSum * 100)) : 0;

                foreach ($result as $r): ?>
                <tr class="border-b hover:bg-gray-50 transition">
                    <th class="px-4 py-3 text-center"><?php echo $r['dateStr'] ?></th>
                    <td class="text-center px-4 py-3 detail" data-id="total" data-date="<?php echo $r['date'] ?>"><?php echo $r['total'] ?></td>
                    <td class="text-center px-4 py-3 detail" data-id="external" data-date="<?php echo $r['date'] ?>"><?php echo $r['external'] ?></td>
                    <th class="text-center px-4 py-3">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            <?php
                                echo match(true) {
                                    $r['result2'] >= 80 => 'bg-green-100 text-green-800',
                                    $r['result2'] >= 50 => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-red-100 text-red-800',
                                };
                    ?>">
                            <?php echo intval($r['result2']) ?>%
                        </span>
                    </th>
                </tr>
                <?php endforeach; ?>

                <!-- Fila Promedio -->
                <tr class="bg-gray-50 font-semibold border-t">
                    <td class="px-4 py-3 text-center">Promedio</td>
                    <td class="text-center px-4 py-3"><?= $avgTotal ?></td>
                    <td class="text-center px-4 py-3"><?= $avgExternal ?></td>
                    <td class="text-center px-4 py-3">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            <?= match(true) {
                                $avgResult2 >= 80 => 'bg-green-100 text-green-800',
                                $avgResult2 >= 50 => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-red-100 text-red-800',
                            } ?>">
                            <?= $avgResult2 ?>%
                        </span>
                    </td>
                </tr>

                <!-- Fila Total -->
                <tr class="bg-gray-100 font-semibold border-b">
                    <td class="px-4 py-3 text-center">Total</td>
                    <td class="text-center px-4 py-3"><?= $totalSum ?></td>
                    <td class="text-center px-4 py-3"><?= $externalSum ?></td>
                    <td class="text-center px-4 py-3">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            <?= match(true) {
                                $totalResult2 >= 80 => 'bg-green-100 text-green-800',
                                $totalResult2 >= 50 => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-red-100 text-red-800',
                            } ?>">
                            <?= $totalResult2 ?>%
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Gráfica -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <canvas id="myChart2" height="160"></canvas>
    </div>

</div>

<script>
const ctx2 = document.getElementById('myChart2').getContext('2d');
new Chart(ctx2, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
            label: 'Porcentaje de Externos',
            data: <?php echo json_encode(array_map('intval', $result2)); ?>,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.15)',
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: '#3b82f6',
            pointBorderColor: '#fff',
            pointHoverRadius: 6
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                min: 0,
                max: 100,
                ticks: {
                    stepSize: 20,
                    callback: function(value) {
                        return value + "%";
                    }
                },
                grid: {
                    color: "#e5e7eb"
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
