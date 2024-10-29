<?php

namespace App\Http\Controllers;


use App\Models\Detalleventas;
use App\Models\Ventas;
use App\Models\producto;
use App\Models\cliente;
use App\Models\Compras;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = producto::all();
        $ventas = ventas::all();
        $detalleventas = Detalleventas::all();
        return view('ventas.index', compact('productos', 'ventas', 'detalleventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ventas = ventas::all();
        return view('ventas.nota', compact('ventas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'cliente' => 'required|string|max:255',
            'metodo' => 'required|string|max:50',
            'celular' => 'required|numeric',
            'descuento' => 'nullable|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'producto_id' => 'required|exists:productos,id',
        ]);

        // Obtener el producto
        $producto = producto::find($validated['producto_id']);

        if (!$producto) {
            // Si el producto no existe
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // Verificar si hay suficiente cantidad del producto antes de crear la venta
        if ($producto->cantidad < $validated['cantidad']) {
            return redirect()->back()->with('error', 'Cantidad insuficiente de producto.');
        }

        // Obtener o crear el cliente
        $cliente = cliente::where('celular', $validated['celular'])->first();

        if (!$cliente) {
            // Si el cliente no existe, lo creamos
            $cliente = cliente::create([
                'nombre' => $validated['cliente'],
                'celular' => $validated['celular'],
            ]);
        }

        // Crear la venta
        $venta = ventas::create([
            'fecha' => now(), // Fecha actual
            'metodo' => $validated['metodo'],
            'total' => 0, // Inicializar el total, se actualizará posteriormente
            'cliente_id' => $cliente->id,
            'user_id' => auth()->id(),
        ]);

        // Calcular el total del producto con descuento
        $totalProducto = $producto->precio * $validated['cantidad'];
        $totalConDescuento = $totalProducto - ($validated['descuento'] ?? 0);

        // Crear el detalle de la venta
        Detalleventas::create([
            'venta_id' => $venta->id,
            'producto_id' => $validated['producto_id'],
            'monto' => $totalConDescuento,
            'cantidad' => $validated['cantidad'],
            'descuento' => $validated['descuento'] ?? 0,
            'preciocompra' => Compras::where('producto_id', $producto->id)
            ->orderBy('created_at', 'desc')
            ->value('preciocompra') ?? 0, // Obtiene el precio de compra actual
        ]);

        // Reducir la cantidad del producto en inventario
        $producto->cantidad -= $validated['cantidad'];
        $producto->save();

        // Actualizar el total de la venta sumando los montos de los detalles de la venta
        if ($venta->detalleventas) {
            $venta->update(['total' => $venta->detalleventas->sum('monto')]);
        } else {
            return redirect()->back()->with('error', 'No se han creado detalles de venta.');
        }
        activity()
        ->causedBy(auth()->user())
        ->performedOn($venta)
        ->log('Registro una nueva venta: '.$venta->id. ' con un total de: '.$venta->total);
        // Redirigir con un mensaje de éxito
        return redirect()->route('detalleventas.index2', ['id' => $venta->id])->with('success', 'Venta realizada con éxito.');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $venta = Ventas::findOrFail($id);
        return view('ventas.show', compact('venta'));
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
}
