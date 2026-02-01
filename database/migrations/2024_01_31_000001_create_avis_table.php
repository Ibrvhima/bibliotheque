<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livre_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('note')->check('note >= 1 AND note <= 5');
            $table->text('commentaire')->nullable();
            $table->boolean('approuve')->default(false);
            $table->timestamps();
            
            // Un utilisateur ne peut donner qu'un avis par livre
            $table->unique(['livre_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('avis');
    }
};
