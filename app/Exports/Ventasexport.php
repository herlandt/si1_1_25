<?php

namespace App\Exports;

use App\Models\Ventas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Ventasexport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    // Constructor para recibir los filtros
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Filtrar los datos según los parámetros recibidos
    public function collection()
    {
        $query = Ventas::query()->with(['cliente', 'detalleventas.producto', 'user']);

        // Filtrar por fechas
        if (!empty($this->startDate)) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if (!empty($this->endDate)) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        // Obtener los resultados con las relaciones necesarias
        $ventas = $query->get();

        // Mapear los datos al formato que necesitas para el Excel
        return $ventas->map(function($venta) {
            // Crear una cadena de los productos con cantidad, precio de venta y compra
            $productos = $venta->detalleventas->map(function($detalle) {
                $precioVentaUnitario = $detalle->monto / $detalle->cantidad;
                return $detalle->producto->nombre .
                       ' (Cant: ' . $detalle->cantidad .
                       ', P. Venta: ' . number_format($precioVentaUnitario, 2) .
                       ', P. Compra: ' . number_format($detalle->preciocompra, 2) . ')';
            })->implode(', ');

            // Calcular la ganancia para cada detalle de venta
            $gananciaTotal = $venta->detalleventas->sum(function($detalle) {
                $precioVentaUnitario = $detalle->monto / $detalle->cantidad;
                $gananciaUnit = $precioVentaUnitario - $detalle->preciocompra;
                return $gananciaUnit * $detalle->cantidad;
            });

            return [
                'id' => $venta->id,
                'fecha' => $venta->created_at->format('Y-m-d'),
                'cliente' => $venta->cliente->nombre ?? 'N/A',
                'productos' => $productos, // Lista de productos con cantidad y precios
                'cantidad' => $venta->detalleventas->sum('cantidad'),
                'precioventa' => $venta->detalleventas->sum('monto'), // Precio total de venta
                'preciocompra' => $venta->detalleventas->sum(function($detalle) {
                    return $detalle->preciocompra * $detalle->cantidad;
                }), // Precio total de compra
                'ganancia' => number_format($gananciaTotal, 2),
                'usuario' => $venta->user->name ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Cliente',
            'Productos (Cantidad, P. Venta, P. Compra)',
            'Cantidad Total',
            'Precio Venta Total',
            'Precio Compra Total',
            'Ganancia',
            'Usuario',
        ];
    }
}
