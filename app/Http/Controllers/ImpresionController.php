<?php

namespace App\Http\Controllers;

use App\Models\Impresion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpresionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener las fechas del formulario de filtro o establecerlas por defecto al día actual
        $startDate = $request->input('start_date', now()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Obtener el usuario seleccionado en el filtro
        $selectedUser = $request->input('user_id') ?? Auth::id();

        // Iniciar la consulta para el historial total de impresiones en el rango de fechas
        $query = Impresion::query()
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Aplicar filtro de usuario si hay uno seleccionado
        if ($selectedUser) {
            $query->where('user_id', $selectedUser);
        }

        // Obtener impresiones en el rango y calcular el total
        $impresiones = $query->orderBy('created_at', 'desc')->get();
        $impresionesTotales = $query->sum('total');

        // Calcular las impresiones para el usuario autenticado en el rango de fechas
        $impresionesUsuario = $query->where('user_id', Auth::id())->sum('total');

        // Calcular las impresiones de hoy aplicando el filtro de usuario y fecha
        $impresionesHoy = Impresion::whereDate('created_at', now()->toDateString())
            ->where('user_id', $selectedUser)
            ->sum('total');

        // Obtener lista de todos los usuarios (solo para roles `ejecutivo` y `general`)
        $usuarios = User::all();

        // Pasar las variables a la vista
        return view('impresiones.index', compact('impresiones', 'impresionesTotales', 'impresionesUsuario', 'impresionesHoy', 'startDate', 'endDate', 'selectedUser', 'usuarios'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer|min:1',
            'metodo' => 'required|string|max:255',
        ]);

        // Cálculo del total
        $total = $request->precio * $request->cantidad;

        // Creación de la impresión en la base de datos
        Impresion::create([
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'total' => $total,
            'metodo' => $request->metodo,
            'estado' => 'impreso',
            'user_id' => Auth::id(), // Asigna el ID del usuario autenticado
        ]);

        // Redirección con mensaje de éxito
        return redirect()->back()->with('success', 'Impresión registrada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Busca la primera impresión que coincida con el ID proporcionado
            $impresion = Impresion::where('id', $id)->first();

            if ($impresion) {
                $impresion->delete(); // Elimina el registro
                activity()
                ->causedBy(auth()->user())
                ->log('Se elimino de el reg. caja el ID: ', $impresion->id);
                return redirect()->back()->with('success', 'La impresión ha sido eliminada correctamente.');
            } else {
                return redirect()->back()->with('error', 'La impresión no fue encontrada.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al intentar eliminar la impresión.');
        }
    }

    
}
