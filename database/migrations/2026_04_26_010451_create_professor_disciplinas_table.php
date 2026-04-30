<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professor_disciplinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professores')->cascadeOnDelete();
            $table->foreignId('disciplina_id')->constrained('disciplinas')->cascadeOnDelete();
            $table->integer('prioridade')->default(1);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->unique(['professor_id', 'disciplina_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professor_disciplinas');
    }
};