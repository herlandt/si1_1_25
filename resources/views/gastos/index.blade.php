<x-app-layout>
    <div class="px-2 sm:px-6 lg:px-8 py-4 w-full max-w-10x2 mx-auto">
        <div
            class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-100 dark:border-slate-700">
            @if (session('success'))
            <div class="bg-green-500 text-white text-sm font-semibold p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-500 text-white text-sm font-semibold p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
            <header
                class="px-5 py-4 border-b border-blue-50 dark:border-slate-900 flex flex-col sm:flex-row items-center">
                <div class="flex flex-col sm:flex-row items-center w-full justify-between">
                    <!-- Grupo 1: Añadir, input de búsqueda y botón de búsqueda -->
                    <div class="flex flex-1 items-center mb-2 sm:mb-0 space-x-2">
                        @hasanyrole('ejecutivo|general')
                        <a id="modal-toggle-button"
                            class="flex-shrink-0 bg-red-500 hover:bg-red-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs ml-1 mr-1">
                            <i class="fas fa-plus mr-1"></i> Añadir
                        </a>
                        @endhasanyrole
                        <input id="searchInput" type="text"
                            class="px-3 py-1 border rounded-md w-full sm:w-auto dark:bg-gray-800 dark:text-white text-xs font-medium"
                            style="font-size: 12px;" placeholder="Buscar..." onkeyup="searchTable()">
                        @hasanyrole('ejecutivo|general')
                            {{-- <a href="{{ route('gastos.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                                class="flex-shrink-0 bg-green-700 hover:bg-green-500 dark:bg-gray-700 dark:hover:bg-gray-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs">
                                <i class="fas fa-file-excel mr-1"></i>Exportar
                            </a> --}}

                            {{-- <a id="modal-toggle-button4"
                                class="flex-shrink-0 bg-red-500 hover:bg-red-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs ml-1 mr-1">
                                <i class="fas fa-file-excel mr-1"></i> Importar
                            </a> --}}
                        @endhasanyrole
                    </div>

                    <!-- Grupo 2: Exportar, importar y filtrado por fechas -->
                    <div class="flex flex-col sm:flex-row items-center space-x-2">

                        <!-- Filtrado por fechas -->
                        <form method="GET" action="{{ route('gastos.index') }}" class="flex items-center space-x-2">
                            <!-- Fecha de inicio -->
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <label for="start_date"
                                    class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-0 sm:mr-2">Inicio</label>
                                <input id="start_date" name="start_date" type="date"
                                    value="{{ request('start_date') }}"
                                    class="px-2 py-1 border rounded-md dark:bg-gray-800 dark:text-white text-xs font-medium">
                            </div>

                            <!-- Fecha de fin -->
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <label for="end_date"
                                    class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-0 sm:mr-2">Fin</label>
                                <input id="end_date" name="end_date" type="date" value="{{ request('end_date') }}"
                                    class="px-2 py-1 border rounded-md dark:bg-gray-800 dark:text-white text-xs font-medium">
                            </div>

                            <!-- Botón de filtrado -->
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <label for="start_date"
                                    class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-0 sm:mr-2">Filtrar</label>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-bold py-1 px-3 rounded-md text-xs">
                                    Aceptar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </header>

            <div class="p-3">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <h1 class="text-xs text-center font-semibold text-slate-500 dark:text-slate-300 mb-2">GASTOS
                        </h1>
                        <!-- Table header -->
                        <thead
                            class="text-xs font-semibold uppercase text-slate-400 dark:text-slate-400 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nro</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nombre</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Descripcion</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Cantidad</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Precio</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Total</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Metodo</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Usuario</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Fecha</div>
                                </th>
                                @hasanyrole('ejecutivo|general')
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Acciones</div>
                                </th>
                                @endhasanyrole
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody id="searchTableBody" class="text-xs divide-y divide-slate-100 dark:divide-slate-700">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($gastos as $c)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="ml-2 text-left font-medium"> {{ $c->id}}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="ml-2 text-left font-medium"> {{ $c->nombre }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $c->descripcion }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $c->cantidad }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ number_format($c->precio, 2) }}</div>
                                    </td>

                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ number_format($c->total, 2) }}</div>
                                    </td>

                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $c->metodo }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $c->user->name}}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $c->created_at}}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium flex space-x-2">
                                            <!-- Botón de editar -->
                                            @hasanyrole('ejecutivo|general')
                                            <a title="Ver" href="{{ route('gastos.edit', $c->id) }}"
                                                class="rounded-lg p-2 text-blue-800 dark:text-blue-300 hover:scale-125 transition-transform delay-75">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="w-5 h-5 text-cyan-800">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>


                                                <!-- Botón de eliminar -->
                                                <form action="{{ route('gastos.destroy', $c->id) }}" method="POST">
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
                                            @endhasanyrole
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

        </div>
    </div>

    <!-- Main modal 4 -->

    {{-- modal4 end --}}

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full" style="left: 50%; transform: translateX(-50%);">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Registrar
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        id="modal-close-button">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <!-- Modal body -->
                <form action="{{ route('gastos.store') }}" method="POST">
                    @csrf
                    <div class="p-4 md:p-5">
                        <!-- Nombre del Gasto -->
                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" name="nombre" id="nombre"
                                class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md"
                                required>
                        </div>

                        <!-- Descripción del Gasto -->
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                            <textarea name="descripcion" id="descripcion"
                                class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md"></textarea>
                        </div>

                        <!-- Cantidad y Precio -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="cantidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" min="1"
                                    class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md"
                                    required>
                            </div>
                            <div>
                                <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                                <input type="number" name="precio" id="precio" step="0.01" min="0"
                                    class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md"
                                    required>
                            </div>
                        </div>

                        <!-- Método de Pago -->
                        <div class="mb-4">
                            <label for="metodo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Método</label>
                            <select name="metodo" id="metodo"
                                class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                <option value="efectivo">Efectivo</option>
                                <option value="qr">QR</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                        </div>



                        <!-- Botón de Envío -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="text-white inline-flex items-center bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-xs px-4 py-1.5 text-center dark:bg-slate-600 dark:hover:bg-slate-500 dark:focus:ring-cyan-800">
                                Añadir
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal1 end --}}
    @push('scripts')
        <script>
            function actualizarNombreProducto() {
                // Obtener el elemento select y el input de nombre
                const productoSelect = document.getElementById('producto_id');
                const nombreInput = document.getElementById('nombre');

                // Obtener el nombre del producto seleccionado
                const selectedOption = productoSelect.options[productoSelect.selectedIndex];
                const nombreProducto = selectedOption.getAttribute('data-nombre');

                // Establecer el nombre en el input de nombre
                nombreInput.value = nombreProducto;
            }
        </script>
        <script>
            function searchTable() {
                var input, filter, table, tbody, tr, td, i, j, txtValue;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.querySelector("table");
                tbody = document.getElementById("searchTableBody");
                tr = tbody.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    tr[i].style.display = "none";
                    td = tr[i].getElementsByTagName("td");

                    for (j = 0; j < td.length; j++) {
                        if (td[j]) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                                break;
                            }
                        }
                    }
                }
            }
        </script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <script>
            // JavaScript para abrir y cerrar el primer modal
            const modalToggleButton = document.getElementById('modal-toggle-button');
            const modalCloseButton = document.getElementById('modal-close-button');
            const crudModal = document.getElementById('crud-modal');

            modalToggleButton.addEventListener('click', function() {
                crudModal.classList.toggle('hidden');
            });

            modalCloseButton.addEventListener('click', function() {
                crudModal.classList.add('hidden');
            });
        </script>
        <script>
            // JavaScript para abrir y cerrar el modal 4
            const modalToggleButton4 = document.getElementById('modal-toggle-button4');
            const modalCloseButton4 = document.getElementById('modal-close-button4');
            const crudModal4 = document.getElementById('crud-modal4');

            modalToggleButton4.addEventListener('click', function() {
                crudModal4.classList.toggle('hidden');
            });

            modalCloseButton4.addEventListener('click', function() {
                crudModal4.classList.add('hidden');
            });
        </script>
    @endpush
</x-app-layout>
