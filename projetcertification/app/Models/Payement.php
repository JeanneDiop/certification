<?php

namespace App\Models;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payement extends Model
{
    use HasFactory;
    protected $fillable = [
        'montant_payement',
        'vente_id',
        'etat',
        'montant_restant'
     
    ];
    public function vente()
    {
        return $this->belongsTo(Vente::class, 'vente_id');
    }
}