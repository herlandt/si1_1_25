<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class impresion extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'precio',
        'cantidad',
        'metodo',
        'estado',
        'total',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}