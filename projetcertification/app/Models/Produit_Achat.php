<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit_Achat extends Model
{
    use HasFactory;
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
    public function achat()
    {
        return $this->belongsTo(Achat::class, 'achat_id');
    }
}