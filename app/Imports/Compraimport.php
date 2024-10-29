<?php

namespace App\Imports;

use App\Models\Compras;
use App\Models\producto;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class CompraImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Limpiar y normalizar el nombre y el código del producto
        $nombreProducto = trim(strtolower($row['nombre']));
        $codigoProducto = trim(strtoupper($row['codigo']));

        // Verificar si el nombre del producto está vacío
        if (empty($row['nombre'])) {
            throw new Exception("El nombre del producto no puede ser nulo.");
        }

        // Buscar o crear el producto
        $producto = producto::where('codigo', $codigoProducto)->first();

        if (!$producto) {
            // Crear el producto si no existe
            $producto = producto::create([
                'codigo' => $codigoProducto,
                'nombre' => ucfirst($nombreProducto),
                'precio' => $row['precioventa'],
                'cantidad' => $row['cantidad'],
                'estado' => 'activado',
                'img' => null, // Aquí podrías agregar la ruta de la imagen si se requiere
            ]);

            // Establecer estado en 'agotado' para la primera compra del producto
            $estadoCompra = 'agotado';
        } else {
            // Estado de la compra cuando el producto ya existe
            $estadoCompra = 'activado';
        }

        // Crear el registro de compra en la tabla `compras`
        $compra = Compras::create([
            'nombre' => $row['nombre'],
            'cantidad' => $row['cantidad'],
            'preciocompra' => $row['preciocompra'],
            'precioventa' => $row['precioventa'],
            'total' => $row['preciocompra'] * $row['cantidad'],
            'metodo' => $row['metodo'],
            'proveedor' => $row['proveedor'],
            'producto_id' => $producto->id,
            'user_id' => Auth::id(), // ID del usuario autenticado
            'estado' => $estadoCompra, // Estado de la compra
        ]);

        // Registrar actividad
        activity()
            ->causedBy(Auth::user())
            ->log('Se importó una compra para el producto: ' . $compra->nombre . ' (ID: ' . $compra->id . ')');

        return $compra;
    }
}
