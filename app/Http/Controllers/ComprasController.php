<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Compraexport;
use App\Imports\Compraimport;

class ComprasController extends Controller
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
        $query = Compras::query();

        // Filtrar por fecha de inicio si se proporciona
        if (!empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        // Filtrar por fecha de fin si se proporciona
        if (!empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Ordenar los resultados por fecha de creación en orden descendente
        $compras = $query->orderBy('created_at', 'desc')->get();
        $productos = Producto::all();
        // Devolver la vista con los resultados
        return view('compras.index', compact('compras', 'productos'));
    }


    public function import(Request $request)
    {
        $file = $request->file('documento');
        Excel::import(new Compraimport, $file);
        activity()
            ->causedBy(auth()->user())
            ->log('Se importaron las Compras');
        return back()->with('status', 'Compras importados con éxito');
    }
    public function export(Request $request)
    {
        // Obtener las fechas de inicio y fin desde la solicitud
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Pasar los parámetros al exportador
        return Excel::download(new Compraexport($startDate, $endDate), 'compras.xlsx');
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
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'preciocompra' => 'required|numeric|min:0',
            'precioventa' => 'required|numeric|min:0',
            'metodo' => 'required|string',
            'proveedor' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Validación de la imagen
        ]);

        // Verificar si el producto existe
        $producto = Producto::where('codigo', $request->codigo)->first();

        if (!$producto) {

            // Crear el producto si no existe
            $producto = Producto::create([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'precio' => $request->precioventa,
                'cantidad' => $request->cantidad,
                'img' => null, // Ruta de la imagen guardada
                'estado' => 'activado',
            ]);
            // Crear el registro de compra en la tabla `compras`
            $compra = Compras::create([
                'nombre' => $request->nombre,
                'cantidad' => $request->cantidad,
                'preciocompra' => $request->preciocompra,
                'precioventa' => $request->precioventa,
                'total' => $request->preciocompra * $request->cantidad,
                'metodo' => $request->metodo,
                'proveedor' => $request->proveedor,
                'producto_id' => $producto->id,
                'user_id' => auth()->id(),
                'estado' => 'agotado',
            ]);
        } else {
            // Crear el registro de compra en la tabla `compras`
            $compra = Compras::create([
                'nombre' => $request->nombre,
                'cantidad' => $request->cantidad,
                'preciocompra' => $request->preciocompra,
                'precioventa' => $request->precioventa,
                'total' => $request->preciocompra * $request->cantidad,
                'metodo' => $request->metodo,
                'proveedor' => $request->proveedor,
                'producto_id' => $producto->id,
                'user_id' => auth()->id(),
                'estado' => 'activado',
            ]);
        }



        // Registrar actividad
        activity()
            ->causedBy(auth()->user())
            ->log('Se creó una compra para el producto: ' . $compra->nombre . ' (ID: ' . $compra->id . ')');

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }




    /**
     * Display the specified resource.
     */
    public function show(Compras $compras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compras $compra)
    {
        $productos = Producto::all();
        return view('compras.edit', compact('compra', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compras $compra)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'preciocompra' => 'required|numeric|min:0',
            'precioventa' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metodo' => 'required|string',
            'proveedor' => 'required|string|max:255',
            'producto_id' => 'required|exists:productos,id',
            'estado' => 'required|string|in:activado,agotado',
        ]);

        // Actualizar los datos de la compra
        $compra->update([
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad,
            'preciocompra' => $request->preciocompra,
            'precioventa' => $request->precioventa,
            'total' => $request->total,
            'metodo' => $request->metodo,
            'proveedor' => $request->proveedor,
            'producto_id' => $request->producto_id,
            'estado' => $request->estado,
        ]);

        // Registrar la actividad
        activity()
            ->causedBy(auth()->user())
            ->performedOn($compra)
            ->log('Se editó una compra: ' . $compra->id);

        // Redirigir con un mensaje de éxito
        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compras $compra)
    {
        // Eliminar la compra
        $compra->delete();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($compra)
            ->log('Se elimino una compra: ' . $compra->id);
        // Redirigir a la lista de compras con un mensaje de éxito
        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }
}
