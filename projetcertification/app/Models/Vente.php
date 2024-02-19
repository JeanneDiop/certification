<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function produit()
    {
        return $this->hasMany(Produit::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function historiquevente()
    {
        return $this->hasMany(Historiquevente::class);
    }

    public function payement()
    {
        return $this->hasMany(Payement::class);
    }
}

