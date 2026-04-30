<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salas', function (Blueprint $table) {
            $table->id();

            $table->string('nome'); // Ex: Sala 1, Laboratório A
            $table->string('codigo')->unique();

            $table->integer('capacidade')->default(40);

            $table->string('tipo')->nullable();
            // Ex: normal, laboratorio, informatica

            $table->enum('estado', ['ativa', 'manutencao'])->default('ativa');

            $table->string('localizacao')->nullable(); 
            // Ex: Bloco A, Piso 1

            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salas');
    }
};