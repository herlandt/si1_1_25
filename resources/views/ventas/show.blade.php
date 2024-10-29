<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-6 w-full max-w-4xl mx-auto">
        <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg border border-slate-200 dark:border-slate-700 p-6">
            <!-- Título -->
            <h2 class="text-lg font-bold text-center text-gray-800 dark:text-gray-100 mb-6">Recibo de Venta</h2>

            <!-- Detalles del cliente -->
            <div class="mb-6">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">Cliente: {{ $venta->cliente->nombre }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono: {{ $venta->cliente->celular }}</p>
            </div>

            <!-- Detalles de la venta -->
            <div class="mb-6">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-4">Detalles de la Venta:</h3>
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-100">
                            <th class="border p-2 text-left text-sm">Producto</th>
                            <th class="border p-2 text-right text-sm">Cantidad</th>
                            <th class="border p-2 text-right text-sm">Precio</th>
                            <th class="border p-2 text-right text-sm">Descuento</th>
                            <th class="border p-2 text-right text-sm">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venta->detalleVentas as $detalle)
                            <tr class="text-gray-800 dark:text-gray-300">
                                <td class="border p-2 text-sm">{{ $detalle->producto->nombre }}</td>
                                <td class="border p-2 text-right text-sm">{{ $detalle->cantidad }}</td>
                                <td class="border p-2 text-right text-sm">Bs. {{ number_format($detalle->producto->precio, 2) }}</td>
                                <td class="border p-2 text-right text-sm">Bs. {{ number_format($detalle->descuento, 2) }}</td>
                                <td class="border p-2 text-right text-sm">Bs. {{ number_format($detalle->monto, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-100">
                            <td colspan="4" class="border p-2 text-right font-bold text-sm">Total Venta:</td>
                            <td class="border p-2 text-right font-bold text-base">Bs. {{ number_format($venta->detalleVentas->sum(fn($d) => $d->cantidad * $d->producto->precio), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Botón de regreso -->
            <div class="text-left mt-8">
                <a href="{{ route('notas.index') }}"
                class="flex-shrink-0 bg-red-500 hover:bg-red-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs ml-1 mr-1">
                <i class="fas fa-plus mr-1"></i> Volver
            </a>
            </div>
        </div>
    </div>
</x-app-layout>
