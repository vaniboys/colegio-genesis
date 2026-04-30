<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();

            $table->string('processo')->unique();
            $table->string('nome_completo');
            $table->enum('sexo', ['M','F']);
            $table->date('data_nascimento');

            $table->foreignId('provincia_id')->nullable()->constrained()->nullOnDelete();

            $table->string('municipio');
            $table->string('endereco');

            $table->string('bi')->nullable()->unique();

            $table->string('telefone')->nullable();
            $table->string('email')->nullable();

            $table->foreignId('encarregado_id')->nullable()->constrained()->nullOnDelete();

            $table->string('foto')->nullable();

            $table->enum('situacao', ['activo','inactivo','transferido','desistente','concluido'])->default('inactivo');

            $table->softDeletes();
            $table->timestamps();

            $table->index('nome_completo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
