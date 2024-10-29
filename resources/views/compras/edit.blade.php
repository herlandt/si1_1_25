<x-app-layout>
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white dark:bg-slate-700 shadow rounded-lg p-6">
            <h2 class="text-1xl text-center font-bold mb-6 text-gray-900 dark:text-white">Editar Compra</h2>

            <!-- Formulario de edición -->
            <form action="{{ route('compras.update', $compra->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="nombre"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $compra->nombre) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                    </div>

                    <!-- Cantidad -->
                    <div class="mb-4">
                        <label for="cantidad"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad"
                            value="{{ old('cantidad', $compra->cantidad) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                    </div>

                    <!-- Precio de Compra -->
                    <div class="mb-4">
                        <label for="preciocompra"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio de Compra</label>
                        <input type="number" name="preciocompra" id="preciocompra" step="0.01"
                            value="{{ old('preciocompra', $compra->preciocompra) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                    </div>

                    <!-- Precio de Venta -->
                    <div class="mb-4">
                        <label for="precioventa"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio de Venta</label>
                        <input type="number" name="precioventa" id="precioventa" step="0.01"
                            value="{{ old('precioventa', $compra->precioventa) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                    </div>

                    <!-- Total -->
                    <div class="mb-4">
                        <label for="total"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total</label>
                        <input type="number" name="total" id="total" step="0.01"
                            value="{{ old('total', $compra->total) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                    </div>

                    <!-- Método -->
                    <div class="mb-4">
                        <label for="metodo"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Método</label>
                        <select name="metodo" id="metodo"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                            <option value="efectivo"
                                {{ old('metodo', $compra->metodo) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="qr" {{ old('metodo', $compra->metodo) == 'qr' ? 'selected' : '' }}>QR
                            </option>
                            <option value="tarjeta" {{ old('metodo', $compra->metodo) == 'tarjeta' ? 'selected' : '' }}>
                                Tarjeta</option>
                        </select>
                    </div>

                    <!-- Proveedor -->
                    <div class="mb-4">
                        <label for="proveedor"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proveedor</label>
                        <input type="text" name="proveedor" id="proveedor"
                            value="{{ old('proveedor', $compra->proveedor) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                    </div>

                    <!-- Producto -->
                    <div class="mb-4">
                        <label for="producto_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Producto</label>
                        <select name="producto_id" id="producto_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}"
                                    {{ old('producto_id', $compra->producto_id) == $producto->id ? 'selected' : '' }}>
                                    {{ $producto->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Estado -->
                    <div class="mb-4">
                        <label for="estado"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                        <select name="estado" id="estado"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                            <option value="activado"
                                {{ old('estado', $compra->estado) == 'activado' ? 'selected' : '' }}>Activado</option>
                            <option value="agotado"
                                {{ old('estado', $compra->estado) == 'agotado' ? 'selected' : '' }}>Agotado</option>
                        </select>

                    </div>
                </div>

                <!-- Botón de actualizar -->
                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-900 text-white dark:bg-slate-600 dark:hover:bg-slate-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Actualizar Compra
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
