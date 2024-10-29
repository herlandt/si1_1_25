<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto">

        <!-- Mensaje de éxito o error -->
        @if (session('success'))
            <div class="bg-green-500 text-white text-sm font-semibold p-3 rounded mb-4 shadow-lg">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-500 text-white text-sm font-semibold p-3 rounded mb-4 shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filtro de Fechas y Usuario -->
        <div class="mb-6 bg-gradient-to-r from-blue-500 to-blue-400 dark:from-blue-700 dark:to-blue-600 p-6 rounded-lg shadow-lg">
            <form method="GET" action="{{ route('impresiones.index') }}" class="flex flex-wrap gap-4">
                <div class="w-full sm:w-auto">
                    <label for="start_date" class="text-sm font-medium text-white dark:text-gray-300">Fecha Inicio</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" 
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300 p-2 text-sm">
                </div>
                <div class="w-full sm:w-auto">
                    <label for="end_date" class="text-sm font-medium text-white dark:text-gray-300">Fecha Fin</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300 p-2 text-sm">
                </div>
                
                <!-- Selector de Usuario - Solo para roles `ejecutivo` y `general` -->
                @hasanyrole('ejecutivo|general')
                <div class="w-full sm:w-auto">
                    <label for="user_id" class="text-sm font-medium text-white dark:text-gray-300">Usuario</label>
                    <select name="user_id" id="user_id" class="w-full border border-gray-200 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300 p-2 text-sm">
                        <option value="">Todos</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ $selectedUser == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endhasanyrole

                <div class="w-full flex justify-end gap-2">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-700 text-white rounded-md hover:bg-blue-800 dark:bg-blue-500 dark:hover:bg-blue-600 text-sm transition duration-200 shadow-lg">
                        Filtrar
                    </button>
                    <a href="{{ route('impresiones.index') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 dark:bg-gray-500 dark:hover:bg-gray-600 text-sm transition duration-200 shadow-lg">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Mostrar Impresiones Totales, Ventas del Usuario y del Día -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-red-500 to-red-400 dark:from-red-700 dark:to-red-600 shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-2 text-white">Total de Impresiones en Rango</h3>
                <p class="text-2xl font-bold text-white">Total: {{ number_format($impresionesTotales, 2) }} Bs.</p>
                <p class="text-sm text-gray-200">Impresiones en el rango de fechas seleccionado</p>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-blue-400 dark:from-blue-700 dark:to-blue-600 shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-2 text-white">Ventas del Usuario en Rango</h3>
                <p class="text-2xl font-bold text-white">Total: {{ number_format($impresionesUsuario, 2) }} Bs.</p>
                <p class="text-sm text-gray-200">Ventas realizadas por el usuario autenticado</p>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-400 dark:from-green-700 dark:to-green-600 shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-2 text-white">Impresiones del Día</h3>
                <p class="text-2xl font-bold text-white">
                    Total: {{ number_format($impresionesHoy, 2) }} Bs.
                </p>
                <p class="text-sm text-gray-200">
                    Impresiones realizadas hoy {{ $selectedUser ? 'por el usuario seleccionado' : '' }}
                </p>
            </div>
        </div>

        <!-- Contenedor principal con el formulario de registro de impresiones -->
        {{-- Productos --}}
        <div class="overflow-x-auto bg-white dark:bg-slate-800 shadow-lg rounded-lg border border-slate-100 dark:border-slate-700 p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">🖨 Ventas de Impresiones</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Encuentra la mejor calidad en impresiones con opciones de personalización para cada necesidad.
            </p>

            <div class="space-y-4">
                {{-- Encabezado de columnas (solo para pantallas grandes) --}}
                <div
                    class="hidden md:grid grid-cols-5 gap-4 p-4 bg-gradient-to-r from-cyan-600 to-cyan-400 dark:from-slate-700 dark:to-slate-500 text-white rounded-lg text-sm font-semibold shadow-md">
                    <div>Descripción</div>
                    <div>Método Pago</div>
                    <div>Precio</div>
                    <div>Cantidad</div>
                    <div>Opciones</div>
                </div>

                {{-- Producto 1 --}}
                <form action="{{ route('impresiones.store') }}" method="POST"
                    class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-4 grid grid-cols-1 md:grid-cols-5 gap-4 items-center transform hover:scale-85 transition-transform duration-300">
                    @csrf
                    <div class="text-gray-700 dark:text-gray-200">
                        <input type="hidden" name="descripcion" value="Impresión o Fotocopia | Blanco-Negro">
                        <span class="md:hidden font-semibold">Descripción: </span>Impresión o Fotocopia | Blanco-Negro
                    </div>
                    <div>
                        <label class="md:hidden font-semibold text-gray-700 dark:text-gray-200">Método Pago</label>
                        <select name="metodo"
                            class="w-full p-2 border border-gray-300 dark:border-slate-600 rounded text-gray-700 dark:text-gray-200 dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:shadow-md">
                            <option value="Efectivo">Efectivo</option>
                            <option value="QR">QR</option>
                        </select>
                    </div>
                    <div>
                        <label class="md:hidden font-semibold text-gray-700 dark:text-gray-200">Precio</label>
                        <input type="number" name="precio" placeholder="Precio" min="0.01" step="0.01" value="0.50"
                            class="w-full p-2 border border-gray-300 dark:border-slate-600 rounded text-gray-700 dark:text-gray-200 dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:shadow-md">
                    </div>
                    <div>
                        <label class="md:hidden font-semibold text-gray-700 dark:text-gray-200">Cantidad</label>
                        <input type="number" name="cantidad" placeholder="Cant" min="1" value="1"
                            class="w-full p-2 border border-gray-300 dark:border-slate-600 rounded text-gray-700 dark:text-gray-200 dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:shadow-md">
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-gray-900 to-gray-700 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 transition-transform transform hover:scale-105">
                            Registrar
                        </button>
                    </div>
                </form>

                {{-- Producto 2 --}}
                <form action="{{ route('impresiones.store') }}" method="POST"
                    class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-4 grid grid-cols-1 md:grid-cols-5 gap-4 items-center transform hover:scale-85 transition-transform duration-300">
                    @csrf
                    <div class="text-gray-700 dark:text-gray-200">
                        <input type="hidden" name="descripcion" value="Impresión o Fotocopia | Color">
                        <span class="md:hidden font-semibold">Descripción: </span>Impresión o Fotocopia | Color
                    </div>
                    <div>
                        <label class="md:hidden font-semibold text-gray-700 dark:text-gray-200">Método Pago</label>
                        <select name="metodo"
                            class="w-full p-2 border border-gray-300 dark:border-slate-600 rounded text-gray-700 dark:text-gray-200 dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:shadow-md">
                            <option value="Efectivo">Efectivo</option>
                            <option value="QR">QR</option>
                        </select>
                    </div>
                    <div>
                        <label class="md:hidden font-semibold text-gray-700 dark:text-gray-200">Precio</label>
                        <input type="number" name="precio" placeholder="Precio" min="0.01" step="0.01" value="1.00"
                            class="w-full p-2 border border-gray-300 dark:border-slate-600 rounded text-gray-700 dark:text-gray-200 dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:shadow-md">
                    </div>
                    <div>
                        <label class="md:hidden font-semibold text-gray-700 dark:text-gray-200">Cantidad</label>
                        <input type="number" name="cantidad" placeholder="Cant" min="1" value="1"
                            class="w-full p-2 border border-gray-300 dark:border-slate-600 rounded text-gray-700 dark:text-gray-200 dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:shadow-md">
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-400 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition-transform transform hover:scale-105">
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- Historial de impresiones -->
        <div class="mt-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4 text-center">Historial de Impresiones</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-slate-400 dark:text-slate-400 bg-slate-50 dark:bg-slate-700">
                        <tr>
                            <th class="p-2">ID</th>
                            <th class="p-2">Descripción</th>
                            <th class="p-2">Precio</th>
                            <th class="p-2">Cantidad</th>
                            <th class="p-2">Total</th>
                            <th class="p-2">Método de Pago</th>
                            <th class="p-2">Usuario</th>
                            <th class="p-2">Fecha</th>
                            @hasanyrole('ejecutivo|general')
                            <th class="p-2">Acciones</th>
                            @endhasanyrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($impresiones as $impresion)
                            <tr>
                                <td class="p-2">{{ $impresion->id }}</td>
                                <td class="p-2">{{ $impresion->descripcion }}</td>
                                <td class="p-2">{{ number_format($impresion->precio, 2) }} Bs.</td>
                                <td class="p-2">{{ $impresion->cantidad }}</td>
                                <td class="p-2">{{ number_format($impresion->total, 2) }} Bs.</td>
                                <td class="p-2">{{ $impresion->metodo }}</td>
                                <td class="p-2">{{ $impresion->user->name ?? 'No asignado' }}</td>
                                <td class="p-2">{{ $impresion->created_at }}</td>
                                @hasanyrole('ejecutivo|general')
                                <td class="p-2">
                                    <form action="{{ route('impresiones.destroy', $impresion->id) }}" method="POST" onsubmit="return confirm('¿Desea eliminar esta impresión?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Eliminar</button>
                                    </form>
                                </td>
                                @endhasanyrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
