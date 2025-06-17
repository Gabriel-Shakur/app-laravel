<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    use HasFactory;

    protected $fillable = [
        //'fecha',
        'tipo',
        'monto',
        'descripcion',
        'arqueo_id', 
    ];

    public function arqueo(){
        return $this->belongsTo(Arqueo::class);
    }
}
