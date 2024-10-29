<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\producto;
use App\Models\Detalleventas;
use App\Models\Ventas;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = cliente::all();
        return view('cliente.index', compact('clientes'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cliente $cliente)
    {
        return view('cliente.editar', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cliente $cliente)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'celular' => 'required|numeric|digits_between:1,15',
        ]);

        // Actualizar los datos del usuario
        $cliente->update([
            'nombre' => $request->nombre,
            'celular' => $request->celular,
        ]);

        activity()
        ->causedBy(auth()->user())
        ->performedOn($cliente)
        ->log('Se edito un cliente: '.$cliente->id);
        // Redirigir con un mensaje de éxito
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Obtener todas las ventas asociadas al cliente
        $ventas = Ventas::where('cliente_id', $cliente->id)->get();

        foreach ($ventas as $venta) {
            // Obtener todos los detalles de venta asociados a la venta
            $detalles = Detalleventas::where('venta_id', $venta->id)->get();

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
            $venta->delete();
        }

        // Ahora eliminar el cliente
        $cliente->delete();
        activity()
        ->causedBy(auth()->user())
        ->performedOn($cliente)
        ->log('Se elimino un cliente: '.$cliente->id);
        // Redirigir con mensaje de éxito
        return redirect()->route('clientes.index')->with('success', 'Cliente y sus ventas eliminados correctamente.');
    }

}
