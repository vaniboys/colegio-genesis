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
            $table->string('telefone')->nullable();
            $table->string('nuit')->nullable();

            // Académico
            $table->string('categoria')->nullable();
            $table->string('especialidade');
            $table->string('habilitacoes');
            $table->date('data_contratacao')->nullable();

            // Carga horária
            $table->integer('carga_horaria_max')->default(40);
            $table->integer('carga_atual')->default(0);

            // Regime e situação
            $table->enum('regime', ['integral', 'parcial'])->default('integral');
            $table->enum('situacao', ['activo', 'inactivo', 'licenca', 'exonerado'])->default('activo');

            // Observações e soft delete
            $table->text('observacoes')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professores');
    }
};