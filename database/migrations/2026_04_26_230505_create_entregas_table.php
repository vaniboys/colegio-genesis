<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarefa_id')->constrained('tarefas')->cascadeOnDelete();
            $table->foreignId('aluno_id')->constrained('alunos')->cascadeOnDelete();
            $table->string('arquivo');
            $table->text('comentario')->nullable();
            $table->decimal('nota', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->dateTime('data_entrega');
            $table->enum('status', ['entregue', 'corrigido', 'atrasado'])->default('entregue');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};