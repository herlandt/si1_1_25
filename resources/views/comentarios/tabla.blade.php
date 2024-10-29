  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="table-auto w-full dark:text-slate-300">
        <!-- Table header -->
        <thead
            class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
            <tr>
                <th class="p-2">
                    <div class="font-semibold text-center">Comentario</div>
                </th>
                <th class="p-2">
                    <div class="font-semibold text-center">Acciones</div>
                </th>

            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
            <!-- Row -->
            @foreach ($comentarios as $r)
                <tr>

                    <td class="p-2">
                        <div class="text-left text-slate-800 dark:text-slate-100">
                            {{ $r->nombre }}</div>
                    </td>
                    <td class="p-2">
                        <div class="text-center text-blue-800">
                            <a href="#"
                            onclick="event.preventDefault(); { document.getElementById('delete-form-{{ $r->id }}').submit(); }">
                            <i class="fa fa-trash-alt"></i> editar
                        </a>
                            <a href="#"
                                onclick="event.preventDefault(); if (confirm('¿Estás seguro de eliminar?')) { document.getElementById('delete-form-{{ $r->id }}').submit(); }">
                                <i class="fa fa-trash-alt"></i> Eliminar
                            </a>

                            <form id="delete-form-{{ $r->id }}"
                                action="{{ route('comentarios.destroy', $r->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input id="estudiante" type="hidden" name="registro" value="{{ $reg }}" required />
                                <input id="estudiante" type="hidden" name="estudiante" value="{{ $nombre }}" required />
                                <div class="col-span-1">
                                <input id="grupoId" type="hidden" name="grupoId" value="{{ $grupo->id}}" required />
                            </form>
                        </div>
                    </td>


                </tr>
                <!-- Row -->
            @endforeach

        </tbody>
    </table>

</div>
