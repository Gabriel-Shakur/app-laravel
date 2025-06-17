<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arqueo extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_apertura',
        'monto_inicial',
        'descripcion',
        'empresa_id',
        'fecha_cierre',
        'monto_final',
    ];


    public function movimientos(){
        return $this->hasMany(MovimientoCaja::class);
    }
}
