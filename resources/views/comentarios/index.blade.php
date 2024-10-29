<x-app-layout>

    <div class="col-span-full xl:col-span-8 bg-white dark:bg-slate-900 shadow-lg rounded-sm">

        <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h2 class="font-semibold text-center text-slate-800 dark:text-slate-100 mt-4"> @if ($grupo)
               {{ $grupo->materia->nombre}} | {{ $grupo->nombre}}
            @endif</h2>

            {{-- c:\Users\danie\Desktop\Nueva carpeta\superficct\img\perfil.png --}}
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ $reg }}</h2>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ $nombre }}</h2>




            @if ($grupo && $grupo->docente)
                <p>Docente: {{ $grupo->docente->nombre }}</p>
            @endif

            <div class="mt-4 mb-4">
                <a id="modal-toggle-button"
                    class="flex-shrink-0 bg-green-800 hover:bg-green-900 dark:bg-slate-700 dark:hover:bg-gray-600 text-white dark:text-gray-200 font-semibold px-3 py-2 rounded-md text-sm sm:text-sm ml-1 mr-1">
                    <i class="fas fa-plus mr-1"></i> Recomendar
                </a>
            </div>
        </header>
        <div class="p-4">
            @include('comentarios.tabla')
        </div>
    </div>

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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('comentarios.store') }}" method="POST">
                    @csrf
                    <div class="p-4 md:p-5">
                        <input id="estudiante" type="hidden" name="registro" value="{{ $reg }}" required />
                        <input id="estudiante" type="hidden" name="estudiante" value="{{ $nombre }}" required />
                        <div class="col-span-1">
                        <input id="grupoId" type="hidden" name="grupoId" value="{{ $grupo->id}}" required />
                        <div class="col-span-1">
                            <x-label for="name" :value="__('nombre')" />
                            <textarea id="nombre" class="block mt-1 w-full" name="nombre" required></textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="flex-shrink-0 bg-green-800 hover:bg-green-900 dark:bg-slate-700 dark:hover:bg-gray-600 text-white dark:text-gray-200 font-semibold px-3 py-2 rounded-md text-sm sm:text-sm ml-1 mr-1">
                                Agregar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal end -->


    @push('scripts')
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
    @endpush
</x-app-layout>
