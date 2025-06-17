<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Compras;

class Proveedores extends Model
{
    use HasFactory;

    public function compras(){
        return $this->hasMany(Compras::class);
    }
}
