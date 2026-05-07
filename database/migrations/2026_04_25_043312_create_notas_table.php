<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();

            // Relacionamentos
            $table->foreignId('matricula_id')
                ->constrained('matriculas')
                ->cascadeOnDelete();

            $table->foreignId('disciplina_id')
                ->constrained('disciplinas')
                ->cascadeOnDelete();

            // Período
            $table->integer('trimestre')->comment('1, 2 ou 3');

            // Avaliações
            $table->decimal('avaliacao_continua', 5, 2)->nullable()->comment('MAC - 0 a 20');
            $table->decimal('prova_trimestral', 5, 2)->nullable()->comment('Prova - 0 a 20');
            $table->decimal('media_trimestral', 5, 2)->nullable()->comment('(MAC + Prova) / 2');
            $table->decimal('exame_final', 5, 2)->nullable()->comment('Exame - 0 a 20');
            $table->decimal('media_final', 5, 2)->nullable()->comment('Média Final');

            // Faltas
            $table->integer('faltas')->default(0);

            // Situação
            $table->string('situacao')->default('cursando')->comment('cursando, aprovado, reprovado, exame');

            // Observações
            $table->text('observacoes')->nullable();

            // Timestamps
            $table->timestamps();

            // Índices
            $table->unique(['matricula_id', 'disciplina_id', 'trimestre'], 'nota_unica');
            $table->index('trimestre');
            $table->index('situacao');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};