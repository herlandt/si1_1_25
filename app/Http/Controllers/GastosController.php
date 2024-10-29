<?php

namespace App\Http\Controllers;

use App\Models\Gastos;
use App\Models\User;
use Illuminate\Http\Request;

class GastosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          // Obtener las fechas de la solicitud
          $startDate = $request->input('start_date');
          $endDate = $request->input('end_date');

          // Iniciar la consulta
          $query = Gastos::query();

          // Filtrar por fecha de inicio si se proporciona
          if (!empty($startDate)) {
              $query->whereDate('created_at', '>=', $startDate);
          }

          // Filtrar por fecha de fin si se proporciona
          if (!empty($endDate)) {
              $query->whereDate('created_at', '<=', $endDate);
          }

          // Ordenar los resultados por fecha de creación en orden descendente
          $gastos = $query->orderBy('created_at', 'desc')->get();
        return view('gastos.index', compact('gastos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validación de los datos del formulario
         $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'metodo' => 'required|string|max:50',
        ]);

        // Calcular el total basado en la cantidad y el precio
        $validatedData['total'] = $request->precio * $request->cantidad;
        $validatedData['user_id'] = auth()->id(); // Asigna el ID del usuario autenticado

        // Crear un nuevo gasto en la base de datos y obtener la instancia creada
        $gasto = Gastos::create($validatedData);

        // Registrar actividad incluyendo el nombre y el ID del gasto
        activity()
            ->causedBy(auth()->user())
            ->log('Se creó un gasto con el nombre: ' . $gasto->nombre . ' (ID: ' . $gasto->id . ')');

        // Redirigir con un mensaje de éxito
        return redirect()->route('gastos.index')->with('success', 'Gasto registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gastos $gastos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gastos $gasto)
    {
        return view('gastos.edit', compact('gasto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gastos $gasto)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'metodo' => 'required|string|max:50'
        ]);

        // Calcular el nuevo total basado en la cantidad y el precio
        $validatedData['total'] = $request->precio * $request->cantidad;

        // Actualizar el gasto en la base de datos con los datos validados
        $gasto->update($validatedData);

        // Registrar actividad incluyendo el nombre y el ID del gasto actualizado
        activity()
            ->causedBy(auth()->user())
            ->log('Se actualizó el gasto con el nombre: ' . $gasto->nombre . ' (ID: ' . $gasto->id . ')');

        // Redirigir con un mensaje de éxito
        return redirect()->route('gastos.index')->with('success', 'Gasto actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gastos $gasto)
    {
        try {
            // Intentar eliminar el registro
            $gasto->delete();
            activity()
            ->causedBy(auth()->user())
            ->log('Se elimino el gasto con el:  (ID: ' . $gasto->id . ')');
            // Redirigir con mensaje de éxito
            return redirect()->route('gastos.index')->with('success', 'Gasto eliminado correctamente.');
        } catch (\Exception $e) {
            // En caso de error, redirigir con un mensaje de error
            return redirect()->route('gastos.index')->with('error', 'Error al eliminar el gasto.');
        }
    }

}
