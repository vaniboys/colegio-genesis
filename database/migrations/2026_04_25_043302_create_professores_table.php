<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professores', function (Blueprint $table) {
            $table->id();

            // Dados pessoais
            $table->string('nome_completo');
            $table->string('email')->unique();
            $table->string('bi')->unique();
            $table->string('telefone');

            // Académico
            $table->string('especialidade');
            $table->string('habilitacoes'); // ✔ FIX
            $table->date('data_contratacao');

            // Estado
            $table->enum('situacao', ['activo', 'licenca', 'exonerado'])->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professores');
    }
};