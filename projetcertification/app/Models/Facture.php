<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

   

    public function payement()
    {
        return $this->belongsTo(Payement::class, 'payement_id');
    }
}