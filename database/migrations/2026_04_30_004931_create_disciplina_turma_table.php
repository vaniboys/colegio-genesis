<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disciplina_turma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turma_id')->constrained()->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');
            $table->foreignId('professor_id')->nullable()->constrained('professores')->onDelete('set null');
            $table->integer('carga_horaria_semanal')->default(4);
            $table->boolean('obrigatoria')->default(true);
            $table->timestamps();

            $table->unique(['turma_id', 'disciplina_id']);
            $table->index('turma_id');
            $table->index('disciplina_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disciplina_turma');
    }
};