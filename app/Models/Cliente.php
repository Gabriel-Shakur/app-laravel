<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre_cliente', 'nit_codigo', 'telefono', 'email'];

    use HasFactory;

    // app/Models/Cliente.php

 public function ventas()
  {
    return $this->hasMany(Venta::class);
  }

}


