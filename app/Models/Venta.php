<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\detalleVenta;
use App\Models\Cliente;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'cliente_id',
        'precio_total',
        'empresa_id',
    ];

    public function detalleVenta(){
        return $this->hasMany(DetalleVenta::class);
    }

    public function cliente()
   {
    return $this->belongsTo(Cliente::class);
   }
}
