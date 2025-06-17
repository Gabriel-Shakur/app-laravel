<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Proveedores;
use App\Models\detallecompra;
use App\Models\empresa;

class Compras extends Model
{
    use HasFactory;

    public function detalles(){
        return $this->hasMany(detallecompra::class);
    }

    public function proveedores()
   {
    return $this->belongsTo(Proveedores::class);
   }

      public function producto()
   {
    return $this->belongsTo(Producto::class);
   }

   public function empresa()
   {
    return $this->belongsTo(Empresa::class);
   }


    


}
