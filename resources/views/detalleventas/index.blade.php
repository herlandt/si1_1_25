<x-app-layout>
    <div class="px-2 sm:px-6 lg:px-8 py-4 w-full max-w-10x2 mx-auto">
        <div
            class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-100 dark:border-slate-700">

            <form action="{{ route('detalleventas.store2') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4 md:p-5">
                    <h3 class="text-center text-tx font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Realizar Venta
                    </h3>
                    <input type="hidden" id="venta_id" name="venta_id" value="{{ $venta->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                                    </svg>
                                </span>
                                <input type="text" id="cliente" name="cliente"
                                    class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Introduzca el nombre del cliente..."
                                    value="{{ $venta->cliente->nombre ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    Celular
                                </span>
                                <input type="text" id="celular" name="celular"
                                    class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Introduzca el celular..." value="{{ $venta->cliente->celular ?? '' }}"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    M.Pago
                                </span>

                                <input type="text" id="metodo" name="metodo"
                                    class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Introduzca el celular..." value="{{ $venta->metodo ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    Descuento
                                </span>
                                <input type="text" id="descuento" name="descuento" value="0"
                                    class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Introduzca el Descuento...">
                            </div>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <div class="flex">
                                <span
                                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                Cantidad
                            </span>
                            <input type="text" id="cantidad" name="cantidad" value="1"
                                class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Introduzca el Descuento...">
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="flex">
                                <span
                                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                Buscador
                            </span>
                            <input type="text" id="searchInput" placeholder="Buscar por nombre o código"
                                class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Introduzca el celular...">

                            </div>
                        </div>

                    </div>
                    <div class="">
                        <div class="flex flex-col">
                            <!-- Campo de búsqueda -->

                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    Producto
                                </span>
                                <select name="producto_id" id="productoSelect"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                                    <option value="" selected disabled data-nombre="" data-codigo=""
                                        data-precio="">Ningun Producto Seleccionado
                                    </option>
                                    @foreach ($productos as $p)
                                        <option value="{{ $p->id }}" data-nombre="{{ $p->nombre }}"
                                            data-codigo="{{ $p->codigo }}" data-precio="{{ $p->precio }}">{{ $p->nombre }} | Precio: {{ $p->precio }} Bs | Cant: {{ $p->cantidad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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

    <div class="px-2 sm:px-6 lg:px-8  w-full max-w-10x2 mx-auto">
        <div
            class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-100 dark:border-slate-700">
            <form action="{{ route('detalleventas.store3') }}" method="POST">
                @csrf
                <input type="hidden" id="venta_id" name="venta_id" value="{{ $venta->id }}">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table header -->
                        <thead
                            class="text-xs font-semibold uppercase text-slate-400 dark:text-slate-400 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Nro</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Codigo</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Nombre</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Descuento</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Precio</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Cantidad</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Monto</div>
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
                                $total = 0;
                                $descuento = 0;
                            @endphp
                            @foreach ($detalleventas as $p)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="ml-2 text-center font-medium"> {{ $i }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $p->producto->codigo }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $p->producto->nombre }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap text-center flex justify-center items-center">
                                        <input type="number" id="descuento{{ $p->id }}"
                                            name="descuento[{{ $p->id }}]"
                                            class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-1 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="0" required value="{{ $p->descuento }}" /> Bs.
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $p->producto->precio }} Bs</div>
                                    </td>

                                    <td class="p-2 whitespace-nowrap text-center flex justify-center items-center">
                                        <input type="number" id="cantidad{{ $p->id }}"
                                            name="cantidad[{{ $p->id }}]"
                                            class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-1 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="" required value="{{ $p->cantidad }}" /> Unid.
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $p->monto }} Bs</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium flex space-x-2">
                                            <!-- Botón de eliminar -->
                                            <button type="button"
                                                class="text-red-600 hover:scale-125 transition-transform delay-75"
                                                onclick="confirmDelete({{ $p->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                    $total += $p->monto;
                                    $descuento += $p->descuento;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="ml-6 mb-3">
                        <button type="submit"
                            class="text-white inline-flex items-center bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-xs px-4 py-1.5 text-center dark:bg-slate-600 dark:hover:bg-slate-500 dark:focus:ring-cyan-800">
                            Actualizar
                        </button>
                        <a
                            href="{{ route('ventas.show', $venta->id) }}"
                            class="text-white inline-flex items-center bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-xs px-4 py-1.5 text-center dark:bg-slate-600 dark:hover:bg-slate-500 dark:focus:ring-cyan-800">
                            Recibo
                        </a>
                    </div>
            </form>
        </div>

        <div class="mt-3 flex justify-end">
            <div class="mb-4 mr-6">
                <span>Descuento : {{ $descuento }} Bs</span>
            </div>
            <div class="mb-4 mr-9">
                <span>Total : {{ $total }} Bs</span>
            </div>
        </div>

        <div class="mt-1 mb-3 flex justify-end">

            <div class="mb-4 mr-3">
                <div class="flex">
                    <span
                        class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Recibido
                    </span>
                    <input type="number" id="montoRecibido" placeholder="Monto Recibido"
                        class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0  text-sm border-gray-300 p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        oninput="calcularCambio()">
                </div>
            </div>

            <div class="mb-4 mr-9">
                <span id="cambio">Cambio: 0 Bs</span>
            </div>
            <!-- Formulario de Eliminación (fuera de la tabla) -->
            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    </div>
    @push('scripts')
        <script>
            function confirmDelete(id) {
                if (confirm('Desea Eliminar?')) {
                    // Obtener el formulario de eliminación
                    const form = document.getElementById('deleteForm');
                    // Configurar la acción del formulario con la URL correcta
                    form.action = `/detalleventas/${id}`;
                    // Enviar el formulario
                    form.submit();
                }
            }
        </script>
        <script>
            // Función para calcular el cambio
            function calcularCambio() {
                // Obtener el total de la venta (esto debe ser obtenido del backend o definido en JavaScript)
                var total = {{ $total }};

                // Obtener el monto recibido desde el input
                var montoRecibido = parseFloat(document.getElementById('montoRecibido').value) || 0;

                // Calcular el cambio
                var cambio = montoRecibido - total;

                // Mostrar el cambio en el span correspondiente
                document.getElementById('cambio').textContent = 'Cambio: ' + (cambio >= 0 ? cambio.toFixed(2) : '0') + ' Bs';
            }
        </script>
        <script>
            document.getElementById('searchInput').addEventListener('input', function() {
                var searchQuery = this.value.toLowerCase();
                var options = document.querySelectorAll('#productoSelect option');

                options.forEach(function(option) {
                    var nombre = option.getAttribute('data-nombre').toLowerCase();
                    var codigo = option.getAttribute('data-codigo').toLowerCase();

                    if (nombre.includes(searchQuery) || codigo.includes(searchQuery)) {
                        option.style.display = ''; // Mostrar opción
                    } else {
                        option.style.display = 'none'; // Ocultar opción
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
