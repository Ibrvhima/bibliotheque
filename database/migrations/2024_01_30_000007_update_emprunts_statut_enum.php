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
        Schema::table('emprunts', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'valide', 'refuse', 'en_cours', 'retourne', 'en_retard'])->default('en_attente')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'valide', 'en_cours', 'retourne', 'en_retard'])->default('en_attente')->change();
        });
    }
};
