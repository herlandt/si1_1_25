<?php

namespace App\Http\Controllers;


use App\Models\Detalleventas;
use App\Models\Ventas;
use App\Models\producto;
use App\Models\cliente;
use App\Exports\Ventasexport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener las fechas de inicio y fin desde la solicitud
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Inicializar la consulta de ventas
        $query = ventas::query();

        // Filtrar por fecha de inicio si está presente
        if (!empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        // Filtrar por fecha de fin si está presente
        if (!empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Obtener las ventas ordenadas por fecha de creación
        $ventas = $query->orderBy('created_at', 'desc')->get();

        // Devolver la vista con las ventas filtradas
        return view('ventas.nota', compact('ventas'));
    }

    public function export(Request $request)
    {
        // Obtener las fechas de la solicitud
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Pasar los parámetros al exportador
        return Excel::download(new Ventasexport($startDate, $endDate), 'ventas.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}


    /**
     * Display the specified resource.
     */
    public function show(Ventas $ventas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ventas $ventas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ventas $ventas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ventas $ventas)
    {
        //
    }

    public function destroy2(Ventas $ventas)
    {

        // Obtener todos los detalles de venta asociados
        $detalles = Detalleventas::where('venta_id', $ventas->id)->get();
        foreach ($detalles as $detalle) {
            // Encontrar el producto asociado
            $producto = Producto::find($detalle->producto_id);

            if ($producto) {
                // Aumentar la cantidad del producto en el inventario
                $producto->cantidad += $detalle->cantidad;
                $producto->save();
            }

            // Eliminar el detalle de la venta
            $detalle->delete();
        }

        // Eliminar la venta
        $ventas->delete();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($ventas)
            ->log('Se elimino una venta: ' . $ventas->id . ' con un total de: ' . $ventas->total);

        // Redirigir a la lista de ventas o a donde lo necesites
        return redirect()->route('notas.index')
            ->with('success', 'Venta eliminada con éxito.');
    }
}
