<?php

namespace App\Exports;
use App\Models\producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Productoexport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return producto::select('codigo', 'nombre', 'precio', 'cantidad')->get();
    }

    public function headings(): array
    {
        return [
            'codigo',
            'nombre',
            'precio',
            'cantidad',
        ];
    }
}
