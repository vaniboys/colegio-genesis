<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classe_disciplina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');
            $table->integer('carga_horaria_semanal')->default(4);
            $table->boolean('obrigatoria')->default(true);
            $table->timestamps();

            $table->unique(['classe_id', 'disciplina_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe_disciplina');
    }
};