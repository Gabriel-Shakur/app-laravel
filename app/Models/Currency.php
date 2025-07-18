<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    public function moneda()
  {
     return $this->belongsTo(Currency::class, 'moneda');
  }
    
}


