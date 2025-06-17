<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Proveedores;
use App\Models\Compras;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detallecompras'; // Asegura que apunta a la tabla correcta


    public function compras(){
        return $this->belongsTo(Compras::class);
    }

      
    
    /*public function proveedores(){
       return $this->belongsTo(Proveedores::class);
    }*/

      
    public function Producto(){
        return $this->belongsTo(Producto::class);
    }
}
