<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->string('nome'); 
            // Ex: Informática, Contabilidade, Electricidade

            $table->string('codigo')->unique();

            $table->foreignId('nivel_ensino_id')
                ->constrained('niveis_ensino')
                ->cascadeOnDelete();

            $table->text('descricao')->nullable();

            $table->boolean('ativo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};