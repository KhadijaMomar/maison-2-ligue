<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('utilisateur', function (Blueprint $table) {
             // Ajout de la colonne 'civilite'
            $table->string('civilite')->nullable()->after('est_admin'); // Ou une autre colonne pour la position
            // Ajout de la colonne 'categorie'
            $table->string('categorie')->nullable()->after('civilite'); // Place 'categorie' après 'civilite'
            // Ou si 'civilite' n'existe pas encore dans le fichier, mettez-le après 'est_admin' ou autre
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilisateur', function (Blueprint $table) {
            $table->dropColumn('civilite');
            $table->dropColumn('categorie');
        });
    }
};
