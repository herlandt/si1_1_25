<x-app-layout>
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white dark:bg-slate-700 shadow rounded-lg p-6">
            <h2 class="text-1xl text-center font-bold mb-6 text-gray-900 dark:text-white">Editar Cliente</h2>

            <!-- Formulario de edición -->
            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Celular</label>
                    <input type="number" name="celular" id="celular" value="{{ old('celular', $cliente->celular) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-slate-800 dark:focus:border-indigo-600">
                </div>



                <!-- Botón de actualizar -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-cyan-500 hover:bg-blue-900 text-white dark:bg-slate-600 dark:hover:bg-slate-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
