<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Compras;


class Producto extends Model
{
    use HasFactory;

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function compras(){
        return $this->hasMany(Compras::class);
    }
}
