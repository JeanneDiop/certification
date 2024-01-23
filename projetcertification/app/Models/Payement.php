<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    use HasFactory;
    public function vente()
    {
        return $this->belongsTo(Vente::class, 'vente_id');
    }
}