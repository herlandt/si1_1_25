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
                <div class="flex flex-col sm:flex-row items-center">
                    <!-- Grupo 1: Añadir, input de búsqueda y botón de búsqueda -->
                    <div class="flex flex-1 items-center mb-2 sm:mb-0">
                        @hasanyrole('ejecutivo|general|secretario')
                            <a id="modal-toggle-button"
                                class="flex-shrink-0 bg-red-500 hover:bg-red-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs ml-1 mr-1">
                                <i class="fas fa-plus mr-1"></i> Añadir
                            </a>
                        @endhasanyrole
                        <input id="searchInput" type="text"
                            class="px-3 py-1 border rounded-md w-full sm:w-auto dark:bg-gray-800 dark:text-white text-xs font-medium mr-2"
                            style="font-size: 12px;" placeholder="Buscar..." onkeyup="searchTable()">

                    </div>
                    <!-- Grupo 2: Exportar y importar -->
                    @hasanyrole('ejecutivo|general|secretario')
                        <div class="flex flex-2 items-center">
                            <a href="{{ route('productos.export') }}"
                                class="flex-shrink-0 bg-green-500 hover:bg-green-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs ml-1 mr-1">
                                <i class="fas fa-file-excel mr-1"></i> Exportar
                            </a>
                            <a id="modal-toggle-button4"
                                class="flex-shrink-0 bg-cyan-500 hover:bg-blue-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs ml-1 mr-1">
                                <i class="fas fa-file-excel mr-1"></i> Importar
                            </a>
                            <a href="{{ route('productos.pdf') }}" target="_blank"
                                class="flex-shrink-0 bg-red-500 hover:bg-red-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs ml-1 mr-1">
                                <i class="fas fa-file-pdf mr-1"></i> PDF
                            </a>
                            <form action="{{ route('productos.actualizar') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex-shrink-0 bg-red-500 hover:bg-red-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white dark:text-gray-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs ml-1 mr-1">
                                    <i class="fas fa-file mr-1"></i> Actualizar Productos
                                </button>
                            </form>


                        </div>
                    @endhasanyrole
                </div>


                <!-- Main modal -->
                <div id="crud-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-lg max-h-full"
                        style="left: 50%; transform: translateX(-50%);">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Registrar
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    id="modal-close-button">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <!-- Modal body -->
                            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="p-4 md:p-5">
                                    <div class="mb-4">
                                        <label for="nombre"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                        <input type="text" name="nombre" id="nombre"
                                            class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="precio"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                                            <input type="number" name="precio" id="precio" step="0.01"
                                                class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md"
                                                placeholder="Introduzca el precio">

                                        </div>
                                        <div>
                                            <label for="cantidad"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                                            <input type="number" name="cantidad" id="cantidad"
                                                class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="multimedia"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Multimedia</label>
                                        <input type="file" name="multimedia" id="multimedia"
                                            class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-blue-300 dark:border-blue-600 dark:bg-gray-800 dark:text-white rounded-md">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="estado"
                                                class="block  text-sm font-medium text-gray-900 dark:text-white">Codigo</label>
                                            <input type="text" name="codigo" id="codigo"
                                                class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                        </div>
                                        <div>
                                            <label for="estado"
                                                class="block  text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                            <select name="estado" id="estado"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                required>
                                                <option value="activado">Activado</option>
                                                <option value="desactivado">Desactivado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <button type="submit"
                                            class="text-white inline-flex items-center bg-cyan-600 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-xs px-4 py-1.5 text-center dark:bg-slate-600 dark:hover:bg-slate-500 dark:focus:ring-cyan-800">
                                            Añadir
                                        </button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
                {{-- modal1 end --}}


                <!-- Main modal 4 -->
                <div id="crud-modal4" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 left-0 z-50 w-full h-full bg-black bg-opacity-50 md:inset-0">

                    <div class="flex items-center justify-center h-full">
                        <div class="relative p-4 w-full max-w-lg bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Importar Archivo Excel
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    id="modal-close-button4">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="mt-2">
                                <form method="POST" action="{{ route('productos.import') }}"
                                    enctype="multipart/form-data" class="flex-shrink-0 ml-1 mb-4">
                                    @csrf
                                    <input type="file" name="documento"
                                        class="bg-red-500 hover:bg-red-700 dark:bg-slate-600 dark:hover:bg-slate-500 text-white dark:text-slate-200 font-semibold px-1.5 py-1 rounded-md text-xs sm:text-xs mb-4"
                                        style="font-size: 12px;" />
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-800 dark:bg-slate-600 dark:hover:bg-slate-500 text-white dark:text-gray-200 font-semibold px-1.5 py-1.5 rounded-md text-xs sm:text-xs ml-1">
                                        <i class="fas fa-plus mr-1 "></i>Importar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- modal4 end --}}
            </header>
            <div class="p-3">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <h1 class="text-xs text-center font-semibold text-slate-500 dark:text-slate-300 mb-2">PRODUCTOS
                        </h1>
                        <!-- Table header -->
                        <thead
                            class="text-xs font-semibold uppercase text-slate-400 dark:text-slate-400 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nro</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Img</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Codigo</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nombre</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Precio</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Cantidad</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Estado</div>
                                </th>
                                @hasanyrole('ejecutivo|general|secretario')
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
                            @foreach ($productos as $p)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="ml-2 text-left font-medium"> {{ $i }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="flex items-center">

                                            <div class="flex-shrink-0 h-10 w-10">
                                                <a href="{{ asset('img/' . ($p->img ?? 'imagendefecto.png')) }}" target="_blank">
                                                    <img src="{{ asset('img/' . ($p->img ?? 'imagendefecto.png')) }}" alt="Imagen del producto"
                                                         class="w-10 h-10 object-cover rounded-full">
                                                </a>
                                            </div>
                                        </div>
                                    </td>


                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-left font-medium">{{ $p->codigo }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-left font-medium">{{ $p->nombre }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ number_format($p->precio, 2) }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ number_format($p->cantidad,0) }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $p->estado }}</div>
                                    </td>

                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium flex space-x-2">
                                            <!-- Botón de editar -->
                                            @hasanyrole('ejecutivo|genera')
                                                <a title="EDITAR" href="{{ route('productos.edit', $p->id) }}"
                                                    class="rounded-lg p-2 text-white hover:scale-125 transition-transform delay-75">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-5 h-5 text-cyan-800">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </a>
                                            @endhasanyrole
                                            @hasanyrole('ejecutivo|general')
                                                <!-- Botón de eliminar -->
                                                <form action="{{ route('productos.destroy', $p->id) }}" method="POST">
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

    @push('scripts')
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
