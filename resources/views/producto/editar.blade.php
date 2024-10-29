<x-app-layout>
    <div class="px-2 sm:px-6 lg:px-8 py-4 w-full max-w-10x2 mx-auto">
        <div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-100 dark:border-slate-700">
            <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-4 md:p-5">

                    <div class="mb-2 flex items-center justify-between">
                        <a href="{{ route('productos.index') }}" class="inline-flex items-center bg-red-500 text-white hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-xs px-2 py-1 text-center dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-700">
                            <svg class="h-5 w-5 text-white mr-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" />
                            </svg>
                            Volver
                        </a>

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Editar Producto
                        </h3>

                    </div>

                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}"
                            class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                        @error('nombre')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                            <input type="number" name="precio" id="precio" value="{{ old('precio', $producto->precio) }}"
                            step="0.01" class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                            @error('precio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="cantidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad', $producto->cantidad) }}"
                                class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                            @error('cantidad')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        @if($producto->img)
                        <div class="flex items-center justify-center h-40 w-40">
                            <a class="text-center" href="{{ asset('img/' . $producto->img) }}" target="_blank">
                                <img src="{{ asset('img/' . $producto->img) }}" alt="Imagen del producto" class="w-40 h-40 object-cover rounded-full">
                            </a>
                        </div>

                        @endif
                        @error('multimedia')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <label for="multimedia" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen</label>
                        <input type="file" name="multimedia" id="multimedia"
                            class="p-2 block w-full shadow-sm focus:ring-indigo-500  focus:border-indigo-500 border-blue-100 dark:border-blue-600   dark:bg-gray-800 dark:text-white rounded-md">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="codigo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código</label>
                            <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $producto->codigo) }}"
                                class="p-2 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                            @error('codigo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                            <select name="estado" id="estado"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required>
                                <option value="activo" {{ old('estado', $producto->estado) == 'activo' ? 'selected' : '' }}>Activado</option>
                                <option value="desactivado" {{ old('estado', $producto->estado) == 'desactivado' ? 'selected' : '' }}>Desactivado</option>
                            </select>
                            @error('estado')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit"
                            class="text-white inline-flex items-center bg-red-600 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-xs px-4 py-1.5 text-center dark:bg-slate-600 dark:hover:bg-slate-500 dark:focus:ring-cyan-800">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
