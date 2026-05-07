<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();

            // Identificação
            $table->string('nome');

            // Nível de Ensino
            $table->foreignId('nivel_ensino_id')
                ->constrained('niveis_ensino')
                ->cascadeOnDelete();

            // Classe (NOVO)
            $table->foreignId('classe_id')
                ->nullable()
                ->constrained('classes')
                ->nullOnDelete();

            // Curso (opcional - apenas 10ª-13ª)
            $table->foreignId('curso_id')
                ->nullable()
                ->constrained('cursos')
                ->nullOnDelete();

            // Sala
            $table->foreignId('sala_id')
                ->nullable()
                ->constrained('salas')
                ->nullOnDelete();

            // Turno
            $table->enum('turno', ['manha', 'tarde', 'noite']);

            // Ano Lectivo
            $table->foreignId('ano_lectivo_id')
                ->constrained('ano_lectivos')
                ->cascadeOnDelete();

            // Professor Principal
            $table->foreignId('professor_principal_id')
                ->nullable()
                ->constrained('professores')
                ->nullOnDelete();

            // Capacidade
            $table->integer('capacidade_maxima')->default(40);
            $table->integer('vagas_ocupadas')->default(0);

            // Estado
            $table->enum('estado', ['ativa', 'inativa'])
                ->default('ativa');

            // Timestamps
            $table->timestamps();

            // Índices
            $table->index(['nivel_ensino_id', 'ano_lectivo_id']);
            $table->index(['classe_id', 'turno']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turmas');
    }
};