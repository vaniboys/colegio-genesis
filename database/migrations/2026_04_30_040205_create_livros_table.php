<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('autor')->nullable();
            $table->string('editora')->nullable();
            $table->string('isbn')->nullable();
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');
            $table->foreignId('turma_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('ano_publicacao')->nullable();
            $table->text('descricao')->nullable();
            $table->string('capa')->nullable();
            $table->string('arquivo_pdf')->nullable();
            $table->integer('visualizacoes')->default(0);
            $table->integer('downloads')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->index('disciplina_id');
            $table->index('turma_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};