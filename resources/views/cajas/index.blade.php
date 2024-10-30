<x-app-layout>
    <div class="px-2 sm:px-6 lg:px-8 py-4 w-full max-w-10x2 mx-auto">

        <!-- Mensaje de éxito o error -->
        @if (session('success'))
            <div class="bg-green-500 text-white text-sm font-semibold p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-500 text-white text-sm font-semibold p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        <!-- Mostrar Ventas, Compras y Ganancias -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-2 text-red-600 dark:text-red-400">Ventas Monto</h3>
                <p class="text-xl font-bold text-gray-800 dark:text-gray-200">Total: {{ number_format($ventasHoy, 2) }}
                    Bs.</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Ventas Realizadas de Hoy</p>
            </div>
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-2 text-blue-600 dark:text-blue-400">Caja Inicial</h3>
                <p class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    Total: {{ $ultimaApertura ? number_format($ultimaApertura->caja, 2) : 'N/A' }} Bs.
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Aperturó caja usuario: {{ $ultimaApertura ? $ultimaApertura->user->name : 'N/A' }}
                </p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 transform hover:scale-105 transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-2 text-blue-600 dark:text-blue-400">Caja Final</h3>
                <p class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    Total: {{ $cierreCaja ? number_format($cierreCaja->caja, 2) : 'N/A' }} Bs.
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Cerró caja el usuario: {{ $cierreCaja ? $cierreCaja->user->name : 'N/A' }}
                </p>
            </div>

        </div>

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 transform transition duration-300 ease-in-out">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4 text-center">Registro de Caja</h2>

            <!-- Formulario para iniciar y finalizar caja en dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Formulario para iniciar caja -->
                <form action="{{ route('cajas.store') }}" method="POST" class="flex flex-col space-y-2">
                    @csrf
                    <input type="hidden" name="descripcion" value="abrió caja">
                    <!-- Campo oculto con la descripción -->

                    <label for="caja_inicial" class="text-sm font-medium text-gray-700 dark:text-gray-300">Inicio de
                        Caja</label>
                    <input type="number" step="0.01" name="caja_inicial" id="caja_inicial"
                        placeholder="Monto inicial"
                        class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300 p-2 text-sm">
                    <button type="submit"
                        class="w-full px-2 py-1 bg-cyan-600 text-white rounded-md hover:bg-cyan-700 dark:bg-slate-700 dark:hover:bg-cyan-800 text-sm transition duration-200">
                        Registrar Inicio
                    </button>
                </form>

                <!-- Formulario para fin de caja -->
                <form action="{{ route('cajas.store') }}" method="POST" class="flex flex-col space-y-2">
                    @csrf
                    <input type="hidden" name="descripcion" value="cerró caja">
                    <!-- Campo oculto con la descripción -->

                    <label for="caja_final" class="text-sm font-medium text-gray-700 dark:text-gray-300">Fin de
                        Caja</label>
                    <input type="number" step="0.01" name="caja_final" id="caja_final" placeholder="Monto final"
                        class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300 p-2 text-sm">
                    <button type="submit"
                        class="w-full px-2 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 dark:bg-slate-700 dark:hover:bg-green-800 text-sm transition duration-200">
                        Registrar Fin
                    </button>
                </form>

            </div>

            <div class="mt-3 p-3">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">

                        <!-- Table header -->
                        <thead
                            class="text-xs font-semibold uppercase text-slate-400 dark:text-slate-400 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nro</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Caja</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Descripcion</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Fecha</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Usuario</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Acciones</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody id="searchTableBody" class="text-xs divide-y divide-slate-100 dark:divide-slate-700">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($cajas as $c)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="ml-2 text-left font-medium"> {{ $c->id }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="ml-2 text-left font-medium"> {{ $c->caja }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="ml-2 text-center font-medium"> {{ $c->descripcion }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $c->created_at }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="ml-2 text-center font-medium"> {{ $c->user->name }}</div>
                                    </td>


                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium flex space-x-2">
                                            <!-- Botón de editar -->
                                            @if (auth()->id() === $c->user_id)
                                                <!-- Botón de eliminar -->
                                                <form action="{{ route('cajas.destroy', $c->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="ELIMINAR"
                                                        class="p-2 rounded-lg text-white hover:scale-125 transition-transform delay-75"
                                                        onclick="return confirm('Desea Eliminar?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            class="w-5 h-5 text-red-600">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @hasanyrole('ejecutivo')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Formulario para eliminar todos los registros -->
                    <form action="{{ route('cajas.eliminarTodo') }}" method="POST" class="flex flex-col space-y-2">
                        @csrf
                        <button type="submit"
                            class="w-full px-2 py-1 bg-cyan-600 text-white rounded-md hover:bg-cyan-700 dark:bg-slate-700 dark:hover:bg-cyan-800 text-sm transition duration-200">
                            Eliminar Todos los Registros
                        </button>
                    </form>

                    <!-- Formulario para eliminar registros anteriores al día actual -->
                    <form action="{{ route('cajas.eliminarAnteriores') }}" method="POST"
                        class="flex flex-col space-y-2">
                        @csrf
                        <button type="submit"
                            class="w-full px-2 py-1 bg-red-600 text-white rounded-md hover:bg-green-700 dark:bg-slate-700 dark:hover:bg-green-800 text-sm transition duration-200">
                            Eliminar Registros Anteriores
                        </button>
                    </form>


                </div>
            @endhasanyrole

        </div>





    </div>
</x-app-layout>
