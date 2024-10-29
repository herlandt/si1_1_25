<x-app-layout>
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white dark:bg-slate-700 shadow rounded-lg p-6">
            <h2 class="text-1xl text-center font-bold mb-6 text-gray-900 dark:text-white">Editar Gasto</h2>

            <!-- Formulario de edición -->
            <form action="{{ route('gastos.update', $gasto->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $gasto->nombre) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                        <textarea name="descripcion" id="descripcion"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">{{ old('descripcion', $gasto->descripcion) }}</textarea>
                    </div>

                    <!-- Cantidad -->
                    <div class="mb-4">
                        <label for="cantidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" min="1" value="{{ old('cantidad', $gasto->cantidad) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600"
                            oninput="calcularTotal()">
                    </div>

                    <!-- Precio -->
                    <div class="mb-4">
                        <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                        <input type="number" name="precio" id="precio" step="0.01" min="0" value="{{ old('precio', $gasto->precio) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600"
                            oninput="calcularTotal()">
                    </div>

                    <!-- Total (Calculado automáticamente) -->
                    <div class="mb-4">
                        <label for="total" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total</label>
                        <input type="number" name="total" id="total" step="0.01" min="0" value="{{ old('total', $gasto->total) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600"
                            readonly>
                    </div>

                    <!-- Método de Pago -->
                    <div class="mb-4">
                        <label for="metodo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Método</label>
                        <select name="metodo" id="metodo"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                            <option value="efectivo" {{ old('metodo', $gasto->metodo) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="qr" {{ old('metodo', $gasto->metodo) == 'qr' ? 'selected' : '' }}>QR</option>
                            <option value="tarjeta" {{ old('metodo', $gasto->metodo) == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        </select>
                    </div>
                </div>

                <!-- Botón de actualizar -->
                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-900 text-white dark:bg-slate-600 dark:hover:bg-slate-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Actualizar Gasto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script para cálculo automático del total -->
    <script>
        function calcularTotal() {
            const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
            const precio = parseFloat(document.getElementById('precio').value) || 0;
            const total = cantidad * precio;
            document.getElementById('total').value = total.toFixed(2);
        }
    </script>
</x-app-layout>
