<?php

namespace App\Http\Controllers;

use App\Models\Detalleventas;
use App\Models\Ventas;
use App\Models\producto;
use App\Models\cliente;
use App\Models\Compras;
use Illuminate\Http\Request;

class DetalleventasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = producto::all();
        $detalleventas = Detalleventas::all();
        return view('detalleventas.index', compact('productos', 'detalleventas'));
    }
    public function index2($id)
    {
        $productos = producto::all();
        $detalleventas = Detalleventas::where('venta_id', $id)->get(); // Filtra detalles por ID de venta
        $venta = ventas::find($id); // Obtiene la venta actual por ID
        return view('detalleventas.index', compact('productos', 'detalleventas', 'venta'));
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
    public function store(Request $request) {}

    public function store2(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'cliente' => 'required|string|max:255',
            'metodo' => 'required|string|max:50',
            'celular' => 'required|numeric',
            'descuento' => 'nullable|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'producto_id' => 'required|exists:productos,id',
            'venta_id' => 'required|exists:ventas,id',
        ]);

        // Obtener el producto
        $producto = producto::find($validated['producto_id']);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // Verificar si hay suficiente cantidad del producto antes de proceder
        if ($producto->cantidad < $validated['cantidad']) {
            return redirect()->back()->with('error', 'Cantidad insuficiente de producto.');
        }

        // Calcular el total del producto con descuento
        $totalProducto = $producto->precio * $validated['cantidad'];
        $totalConDescuento = $totalProducto - ($validated['descuento'] ?? 0);

        // Crear un detalle de la venta
        Detalleventas::create([
            'venta_id' => $validated['venta_id'],
            'producto_id' => $validated['producto_id'],
            'monto' => $totalConDescuento,
            'cantidad' => $validated['cantidad'],
            'descuento' => $validated['descuento'] ?? 0,
            'preciocompra' => Compras::where('producto_id', $producto->id)
            ->orderBy('created_at', 'desc')
            ->value('preciocompra') ?? 0, // Obtiene el precio de compra actual
        ]);

        // Obtener la venta
        $venta = ventas::find($validated['venta_id']);

        if (!$venta) {
            return redirect()->back()->with('error', 'Venta no encontrada.');
        }

        // Verificar que haya detalles de la venta antes de hacer el sum
        $totalVenta = $venta->detalles ? $venta->detalles->sum('monto') : 0;

        // Actualizar el total de la venta
        $venta->update(['total' => $totalVenta]);

        // Reducir la cantidad del producto en inventario
        $producto->cantidad -= $validated['cantidad'];
        $producto->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('detalleventas.index2', ['id' => $validated['venta_id']])->with('success', 'Detalle de venta añadido con éxito.');
    }


    public function store3(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'cantidad.*' => 'required|integer|min:1',
            'descuento.*' => 'nullable|numeric',
            'venta_id' => 'required|exists:ventas,id',
        ]);

        // Obtener la venta
        $venta = ventas::find($validated['venta_id']);

        if (!$venta) {
            return redirect()->back()->with('error', 'Venta no encontrada.');
        }

        // Actualizar cada detalle de la venta
        foreach ($validated['cantidad'] as $detalle_id => $cantidad) {
            // Buscar el detalle de la venta por ID de Detalleventas
            $detalle = Detalleventas::find($detalle_id);

            if ($detalle && $detalle->venta_id == $venta->id) {
                // Obtener el producto asociado
                $producto = $detalle->producto;

                if (!$producto) {
                    return redirect()->back()->with('error', 'Producto no encontrado.');
                }

                // Obtener la cantidad anterior del detalle
                $cantidadAnterior = $detalle->cantidad;

                // Verificar si hay suficiente cantidad del producto
                // La cantidad disponible es la cantidad actual más la cantidad anterior del detalle (porque vamos a recalcular)
                $cantidadDisponible = $producto->cantidad + $cantidadAnterior;

                if ($cantidadDisponible < $cantidad) {
                    return redirect()->back()->with('error', 'Cantidad insuficiente de producto para actualizar el detalle de venta.');
                }

                // Calcular el total
                $totalProducto = $producto->precio * $cantidad;
                $totalConDescuento = $totalProducto - ($validated['descuento'][$detalle_id] ?? 0);

                // Actualizar el detalle de la venta
                $detalle->update([
                    'cantidad' => $cantidad,
                    'descuento' => $validated['descuento'][$detalle_id] ?? 0,
                    'monto' => $totalConDescuento,
                ]);

                // Ajustar la cantidad del producto en el inventario
                // Devolver al inventario la cantidad anterior
                $producto->cantidad += $cantidadAnterior;
                // Restar del inventario la nueva cantidad
                $producto->cantidad -= $cantidad;
                $producto->save();
            }
        }

        // Recalcular el total de la venta
        $totalVenta = $venta->detalles->sum('monto');
        $venta->update(['total' => $totalVenta]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('detalleventas.index2', ['id' => $venta->id])->with('success', 'Detalles de venta actualizados con éxito.');
    }








    /**
     * Display the specified resource.
     */
    public function show(Detalleventas $detalleventas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Detalleventas $detalleventas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Detalleventas $detalleventas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detalleventas $detalle) {}

    public function destroy2($detalle_id)
    {
        // Encontrar el detalle de la venta por su ID
        $detalle = Detalleventas::find($detalle_id);

        if (!$detalle) {
            return redirect()->back()->with('error', 'Detalle de venta no encontrado.');
        }

        // Encontrar el producto asociado
        $producto = Producto::find($detalle->producto_id);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // Aumentar la cantidad del producto en el inventario
        $producto->cantidad += $detalle->cantidad;
        $producto->save();

        // Eliminar el detalle de la venta
        $detalle->delete();

        // Actualizar el total de la venta
        $venta = ventas::find($detalle->venta_id);

        if ($venta) {
            // Recalcular el total de la venta
            $venta->total -= $detalle->monto;  // Suponiendo que $detalle->monto es el monto total del detalle
            $venta->save();
        }

        // Redirigir a la vista de detalles de la venta (ajusta según tu ruta)
        return redirect()->route('detalleventas.index2', ['id' => $detalle->venta_id])
            ->with('success', 'Detalle de venta eliminado con éxito.');
    }
}
