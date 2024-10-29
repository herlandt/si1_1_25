<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'precio',
        'cantidad',
        'estado',
        'codigo',
        'img',
    ];
    public function compras()
    {
        return $this->hasMany(Compras::class, 'producto_id');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVentas::class, 'producto_id');
    }
    
}
