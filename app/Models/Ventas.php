<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'metodo',
        'total',
        'cliente_id',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cliente()
    {
        return $this->belongsTo(cliente::class, 'cliente_id');
    }
    public function ventas()
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }
    public function detalleVentas()
    {
        return $this->hasMany(Detalleventas::class, 'venta_id');
    }
    public function detalles()
    {
        return $this->hasMany(Detalleventas::class, 'venta_id');
    }
    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }
}
