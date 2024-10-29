<?php

namespace App\Exports;

use App\Models\Compras;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Compraexport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    // Constructor para aceptar las fechas de filtrado
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Incluir la relación con el usuario y comenzar la consulta
        $query = Compras::with('user')
            ->select('nombre', 'preciocompra', 'precioventa', 'cantidad', 'total', 'metodo', 'proveedor', 'user_id');

        // Aplicar filtro por fecha de inicio si está presente
        if (!empty($this->startDate)) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        // Aplicar filtro por fecha de fin si está presente
        if (!empty($this->endDate)) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        // Obtener los resultados filtrados y mapear para la exportación
        return $query->get()->map(function ($compra) {
            return [
                'nombre' => $compra->nombre,
                'preciocompra' => $compra->preciocompra,
                'cantidad' => $compra->cantidad,
                'total' => $compra->total,
                'precioventa' => $compra->precioventa,
                'metodo' => $compra->metodo,
                'proveedor' => $compra->proveedor,
                'usuario' => $compra->user->name ?? 'Usuario no disponible',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Precio Compra',
            'Cantidad',
            'Total',
            'Precio Venta',
            'Método',
            'Proveedor',
            'Usuario',
        ];
    }
}
