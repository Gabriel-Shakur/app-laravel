<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class TmpVenta extends Model
{
    protected $fillable = [
        'producto_id', 'cantidad', 'precio_venta', 'total', 'session_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
