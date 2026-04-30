<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professor_turma_disciplina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professores')->cascadeOnDelete();
            $table->foreignId('turma_id')->constrained('turmas')->cascadeOnDelete();
            $table->foreignId('disciplina_id')->constrained('disciplinas')->cascadeOnDelete();
            $table->foreignId('ano_lectivo_id')->nullable()->constrained('ano_lectivos')->nullOnDelete();
            $table->integer('carga_horaria')->default(2);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->unique(['professor_id', 'turma_id', 'disciplina_id', 'ano_lectivo_id'], 'prof_turma_disc_unico');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professor_turma_disciplina');
    }
};