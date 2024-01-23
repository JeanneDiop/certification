<?php

use App\Models\Achat;
use App\Models\Produit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produit_achats', function (Blueprint $table) {
            $table->id();
            $table->string('quantité_achat');
            $table->foreignIdFor(Produit::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Achat::class)->constrained()->onDelete('cascade');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_achats');
    }
};