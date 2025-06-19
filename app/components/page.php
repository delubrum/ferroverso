
    <!-- Contenedor principal sin padding en los bordes extremos -->
    <div class="p-4 w-full">
        <!-- Header del Dashboard - Mantener padding interno para la sección del título -->
        <div class="mb-8 pt-6 pl-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard de Cotizaciones</h1>
        </div>

        <!-- Sección de Tarjetas KPI (Key Performance Indicators) - Con padding horizontal -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 px-6">
            <!-- Tarjeta: Cotizaciones Hoy -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Cotizaciones Hoy</p>
                        <p class="text-2xl font-bold text-gray-900">247</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <!-- Icono en tono de gris -->
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- Indicador de cambio en tono de gris -->
                    <span class="text-gray-700 text-sm font-medium">+12%</span>
                    <span class="text-gray-500 text-sm ml-2">vs ayer</span>
                </div>
            </div>

            <!-- Tarjeta: Cotizaciones Ganadas -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Obras Ganadas</p>
                        <p class="text-2xl font-bold text-gray-900">48</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <!-- Icono en tono de gris -->
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- Indicador de cambio en tono de gris -->
                    <span class="text-gray-700 text-sm font-medium">+7.5%</span>
                    <span class="text-gray-500 text-sm ml-2">este mes</span>
                </div>
            </div>

            <!-- Tarjeta: Cotizaciones Pendientes -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pendientes</p>
                        <p class="text-2xl font-bold text-gray-900">34</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <!-- Icono en tono de gris -->
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- Indicador de cambio en tono de gris -->
                    <span class="text-gray-700 text-sm font-medium">-5</span>
                    <span class="text-gray-500 text-sm ml-2">desde ayer</span>
                </div>
            </div>

            <!-- Tarjeta: Cotizaciones Perdidas -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Obras Perdidas</p>
                        <p class="text-2xl font-bold text-gray-900">12</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <!-- Icono en tono de gris -->
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- Indicador de cambio en tono de gris -->
                    <span class="text-gray-700 text-sm font-medium">+3</span>
                    <span class="text-gray-500 text-sm ml-2">esta semana</span>
                </div>
            </div>
        </div>

        <!-- Sección de Gráficos - Con padding horizontal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8 px-6">
            <!-- Gráfico: Tendencia de Valores de Obras por Tipo de Material -->
            <!-- Se agregó una altura fija para que el gráfico se renderice correctamente -->
            <div class="bg-white rounded-lg shadow-md p-6 h-[300px]">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tendencia de Valores de Obras por Material</h3>
                <canvas id="priceChart" width="400" height="300"></canvas>
            </div>

            <!-- Gráfico: Volumen de Cotizaciones por Estatus (Ganadas, Pendientes, Perdidas) -->
            <!-- Se agregó una altura fija para que el gráfico se renderice correctamente -->
            <div class="bg-white rounded-lg shadow-md p-6 h-[300px]">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Volumen de Cotizaciones por Estatus</h3>
                <canvas id="statusVolumeChart" width="400" height="300"></canvas>
            </div>
        </div>

        <!-- Sección de Tablas - Con padding horizontal -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 px-6">
            <!-- Tabla: Cotizaciones Recientes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Cotizaciones Recientes</h3>
                    <button class="text-gray-700 hover:text-gray-900 text-sm font-medium">Ver todas</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obra / Cliente</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Est.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Envío</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <!-- Ejemplo de fila Ganada -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Proyecto "Estructura Nave Ind."</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">$125,000</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2025-06-15</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs font-semibold">Ganada</span>
                                </td>
                            </tr>
                            <!-- Ejemplo de fila Pendiente -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Ampliación "Taller Mecánico"</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">$82,000</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2025-06-12</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-xs font-medium">Pendiente</span>
                                </td>
                            </tr>
                            <!-- Ejemplo de fila Perdida -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Instalación "Equipos Planta Z"</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">$45,000</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2025-06-10</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="bg-gray-800 text-white px-2 py-1 rounded-full text-xs font-bold">Perdida</span>
                                </td>
                            </tr>
                            <!-- Más ejemplos de filas -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Fabricación "Componentes X"</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">$18,500</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2025-06-08</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs font-semibold">Ganada</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Mantenimiento "Línea Producción"</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">$32,000</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2025-06-05</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-xs font-medium">Pendiente</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabla/Lista: Resumen por Categoría de Obra -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Resumen por Categoría de Obra</h3>
                    <span class="text-xs text-gray-500">Actualizado hace 15 min</span>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-700 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-900">Construcción Industrial</span>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-gray-900">25 Cotizaciones</div>
                            <div class="text-gray-600 text-sm">10 Ganadas</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-600 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-900">Ingeniería y Diseño</span>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-gray-900">18 Cotizaciones</div>
                            <div class="text-gray-600 text-sm">7 Ganadas</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-500 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-900">Mantenimiento Estructural</span>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-gray-900">15 Cotizaciones</div>
                            <div class="text-gray-600 text-sm">5 Ganadas</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-400 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-900">Fabricación a Medida</span>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-gray-900">12 Cotizaciones</div>
                            <div class="text-gray-600 text-sm">4 Ganadas</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-300 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-900">Otros Servicios Metalúrgicos</span>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-gray-900">8 Cotizaciones</div>
                            <div class="text-gray-600 text-sm">2 Ganadas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para los Gráficos de Chart.js -->
<!-- Agrega esto en el <head> o antes del script que usa Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script para los Gráficos de Chart.js -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gráfico de Tendencia de Valores de Obras por Material
    const priceCtx = document.getElementById('priceChart').getContext('2d');
    new Chart(priceCtx, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Acero Estructural',
                data: [78000, 81000, 83000, 80000, 82000, 82450],
                borderColor: 'rgb(75, 85, 99)',
                backgroundColor: 'rgba(75, 85, 99, 0.1)',
                tension: 0.4,
                fill: false
            }, {
                label: 'Acero Inoxidable',
                data: [18500, 19000, 19500, 19200, 19800, 19500],
                borderColor: 'rgb(107, 114, 128)',
                backgroundColor: 'rgba(107, 114, 128, 0.1)',
                tension: 0.4,
                fill: false
            }, {
                label: 'Aluminio',
                data: [17500, 18000, 18200, 17800, 18100, 18450],
                borderColor: 'rgb(156, 163, 175)',
                backgroundColor: 'rgba(156, 163, 175, 0.1)',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: 'rgb(55, 65, 81)'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) label += '$' + context.parsed.y.toLocaleString();
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: 'rgb(107, 114, 128)' },
                    grid: { color: 'rgb(229, 231, 235)' }
                },
                y: {
                    beginAtZero: false,
                    ticks: {
                        color: 'rgb(107, 114, 128)',
                        callback: value => '$' + value.toLocaleString()
                    },
                    grid: { color: 'rgb(229, 231, 235)' }
                }
            }
        }
    });

    // Gráfico de Volumen de Cotizaciones por Estatus
    const statusVolumeCtx = document.getElementById('statusVolumeChart').getContext('2d');
    new Chart(statusVolumeCtx, {
        type: 'bar',
        data: {
            labels: ['Ganadas', 'Pendientes', 'Perdidas'],
            datasets: [{
                label: 'Número de Cotizaciones',
                data: [48, 62, 15],
                backgroundColor: [
                    'rgb(107, 114, 128)',
                    'rgb(156, 163, 175)',
                    'rgb(209, 213, 219)'
                ],
                borderColor: [
                    'rgb(75, 85, 99)',
                    'rgb(107, 114, 128)',
                    'rgb(156, 163, 175)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) label += context.parsed.y + ' Cotizaciones';
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: 'rgb(107, 114, 128)' },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'rgb(107, 114, 128)',
                        precision: 0
                    },
                    grid: { color: 'rgb(229, 231, 235)' }
                }
            }
        }
    });
});
</script>
