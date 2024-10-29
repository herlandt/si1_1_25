<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto dark:bg-gray-900">
        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />

        <form action="{{ route('dashboard') }}" method="GET">
            <div class="flex flex-col sm:flex-row items-center sm:space-x-4 space-y-4 sm:space-y-0 mb-6">
                <div class="w-full sm:w-auto">
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha
                        Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}"
                        class="mt-1 block w-full sm:w-48 md:w-56 lg:w-64 border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300">
                </div>
                <div class="w-full sm:w-auto">
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha
                        Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}"
                        class="mt-1 block w-full sm:w-48 md:w-56 lg:w-64 border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300">
                </div>
                <div class="w-full sm:w-auto pt-2 sm:pt-6">
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-900 dark:bg-slate-700 dark:hover:bg-cyan-800 transition duration-200">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Mostrar Ventas, Compras y Ganancias -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-4 text-blue-600 dark:text-blue-400">Ventas</h3>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ number_format($ventas, 2) }}
                    Bs.</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total de ventas realizadas en el período.</p>
            </div>
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-4 text-green-600 dark:text-green-400">Compras</h3>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ number_format($compras, 2) }}
                    Bs.
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total de compras realizadas en el período.</p>
            </div>
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-4 text-cyan-600 dark:text-cyan-400">Ganancias</h3>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ number_format($ganancias, 2) }}
                    Bs.
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Ganancias calculadas después de costos.</p>
            </div>
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-4 text-red-900 dark:text-red-400">Gastos</h3>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ number_format($gastos, 2) }}
                    Bs.
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Gastos calculados en el periodo.</p>
            </div>
        </div>

        <div class="container mx-auto py-8">
            <!-- Contenedor para el gráfico de línea -->
            <div class="mt-8">
                <canvas id="ventasChart"></canvas>
            </div>

            <!-- Contenedor para el gráfico de barras -->
            <div class="mt-8">
                <canvas id="ventasBarChart"></canvas>
            </div>
        </div>
    </div>
    @push('scripts')
        <!-- Incluyendo Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            // Obtenemos solo las últimas 10 fechas y totales de ventas
            const fechas = @json(array_slice($fechas, -10)); // Últimas 10 fechas
            const totalesVentas = @json(array_slice($totalesVentas, -10)); // Últimos 10 totales de ventas

            // Configuración del gráfico de línea
            const ctxLine = document.getElementById('ventasChart').getContext('2d');
            const ventasChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: fechas,
                    datasets: [{
                        label: 'Ventas Totales',
                        data: totalesVentas,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4 // Suaviza las líneas en las gráficas de línea
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutBounce',
                    },
                    hover: {
                        animationDuration: 500
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Fecha'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Ventas'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });

            // Configuración del gráfico de barras
            const ctxBar = document.getElementById('ventasBarChart').getContext('2d');
            const ventasBarChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: fechas,
                    datasets: [{
                        label: 'Ventas Totales',
                        data: totalesVentas,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.6)',
                        hoverBorderColor: 'rgba(255, 99, 132, 1)',
                        hoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuad'
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true,
                        animationDuration: 400,
                        onHover: (event, chartElement) => {
                            event.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Fecha'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Ventas'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
