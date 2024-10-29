<?php

namespace App\Http\Controllers;

use App\Models\caja;
use App\Models\Ventas;
use Illuminate\Http\Request;

class CajaController extends Controller
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
        $query = Caja::query();

        // Filtrar por fecha de inicio si se proporciona
        if (!empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        // Filtrar por fecha de fin si se proporciona
        if (!empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Ordenar los resultados por fecha de creación en orden descendente
        $cajas = $query->orderBy('created_at', 'desc')->get();

        // Obtener el último registro de apertura de caja (independientemente del usuario)
        $ultimaApertura = Caja::where('descripcion', 'abrió caja')
            ->latest()
            ->first();

        $cierreCaja = null;

        if ($ultimaApertura) {
            // Buscar el registro de cierre de caja posterior a la última apertura
            $cierreCaja = Caja::where('descripcion', 'cerró caja')
                ->where('created_at', '>', $ultimaApertura->created_at)
                ->first();
        }

        // Obtener la fecha de hoy en el formato Y-m-d
        $hoy = now()->format('Y-m-d');

        // Sumar solo las ventas de hoy
        $ventasHoy = Ventas::whereDate('created_at', $hoy)->sum('total');


        return view('cajas.index', compact('cajas', 'ultimaApertura', 'cierreCaja', 'ventasHoy'));
    }


    public function eliminarTodo()
    {
        // Eliminar todos los registros de la tabla `cajas`
        Caja::truncate();
        activity()
            ->causedBy(auth()->user())
            ->log('Se elimino de caja todo los reg. de caja');
        return redirect()->back()->with('success', 'Todos los registros han sido eliminados.');
    }

    public function eliminarAnteriores()
    {
        // Obtener la fecha de hoy
        $hoy = now()->format('Y-m-d');

        // Eliminar todos los registros que tengan una fecha anterior a hoy
        Caja::whereDate('created_at', '<', $hoy)->delete();
        activity()
            ->causedBy(auth()->user())
            ->log('Se elimino de caja todo los reg. anteriores');
        return redirect()->back()->with('success', 'Registros anteriores al día actual han sido eliminados.');
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
        // Determinar si el formulario es para abrir o cerrar la caja
        $descripcion = $request->input('descripcion'); // "abrió caja" o "cerró caja"

        // Validación de datos según el tipo de registro
        if ($descripcion === 'abrió caja') {
            if (!$request->has('caja_inicial') || $request->input('caja_inicial') == null) {
                return redirect()->back()->with('error', 'Debe ingresar un monto para el inicio de caja.');
            }

            // Lógica para registrar el inicio de la caja
            $caja = Caja::create([
                'caja' => $request->caja_inicial,
                'descripcion' => $descripcion,
                'user_id' => auth()->id(),
            ]);

            return redirect()->back()->with('success', 'Inicio de caja registrado.');
        }

        if ($descripcion === 'cerró caja') {
            if (!$request->has('caja_final') || $request->input('caja_final') == null) {
                return redirect()->back()->with('error', 'Debe ingresar un monto para el cierre de caja.');
            }

            // Lógica para registrar el cierre de la caja
            $caja = Caja::create([
                'caja' => $request->caja_final,
                'descripcion' => $descripcion,
                'user_id' => auth()->id(),
            ]);

            return redirect()->back()->with('success', 'Cierre de caja registrado.');
        }

        return redirect()->back()->with('error', 'No se pudo registrar la caja. Datos incompletos.');
    }



    /**
     * Display the specified resource.
     */
    public function show(caja $caja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(caja $caja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, caja $caja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caja $caja)
    {
        try {
            // Intentar eliminar el registro de la caja
            $caja->delete();
            activity()
            ->causedBy(auth()->user())
            ->log('Se elimino de el reg. caja el ID: ', $caja->id);
            // Redirigir con un mensaje de éxito
            return redirect()->route('cajas.index')->with('success', 'Registro de caja eliminado correctamente.');
        } catch (\Exception $e) {
            // Redirigir con un mensaje de error en caso de fallo
            return redirect()->route('cajas.index')->with('error', 'No se pudo eliminar el registro de caja.');
        }
    }

}
