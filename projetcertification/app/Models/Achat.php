<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    use HasFactory;

   

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'catagorie_id');
    }
}
