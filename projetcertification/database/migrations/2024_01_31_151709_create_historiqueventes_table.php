<?php

use App\Models\Vente;
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
        Schema::create('historiqueventes', function (Blueprint $table) {
            $table->id();
            $table->string('quantite_vendu');
            $table->foreignIdFor(Vente::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(Produit::class)->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiqueventes');
    }
};
