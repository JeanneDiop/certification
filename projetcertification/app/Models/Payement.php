<?php

namespace App\Models;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payement extends Model
{
    use HasFactory;
    public function vente()
    {
        return $this->belongsTo(Vente::class, 'vente_id');
    }

    public function facture()
    {
        return $this->hasMany(Facture::class);
    }
}