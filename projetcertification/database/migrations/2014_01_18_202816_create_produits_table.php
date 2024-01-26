<?php

use App\Models\Categorie;
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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nomproduit');
            $table->string('image');
            $table->integer('prixU');
            $table->integer('quantite');
            $table->integer('quantiteseuil');
            $table->enum('etat', ['en_stock', 'rupture','critique','en_cours','terminé'])->default('en_stock');
            $table->foreignIdFor(Categorie::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};

//         $table->date('delai');
//         $table->boolean('etat')->default(true);
//         $table->foreignIdFor(TypeProjet::class)->constrained()->cascadeOnDelete();
//         $table->foreignIdFor(EtatProjet::class)->constrained()->cascadeOnDelete(1);
//         $table->timestamps();
//     });
// }
