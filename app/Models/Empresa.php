<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

     public function moneda()
     {
       return $this->belongsTo(\App\Models\Currency::class, 'moneda');
     }


    public function users(){
        return $this->hasMany( User::class);
    }
}
