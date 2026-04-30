<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('niveis_ensino', function (Blueprint $table) {
            $table->id();

            // Identificação
            $table->string('nome'); // Ex: Primário, I Ciclo
            $table->string('codigo')->unique(); // PRIM, SEC1, SEC2

            // Estrutura académica
            $table->integer('classe_inicio')->nullable(); // 1, 7, 10
            $table->integer('classe_fim')->nullable();    // 6, 9, 12
            $table->integer('duracao_anos')->nullable();  // 6, 3, 3

            // Organização do sistema
            $table->boolean('ativo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('niveis_ensino');
    }
};