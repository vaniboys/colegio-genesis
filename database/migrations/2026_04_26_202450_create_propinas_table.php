<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('propinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matricula_id')->constrained('matriculas')->cascadeOnDelete();
            $table->foreignId('aluno_id')->constrained('alunos')->cascadeOnDelete();
            $table->integer('mes_referencia');
            $table->integer('ano_referencia');
            $table->decimal('valor', 10, 2);
            $table->decimal('multa', 10, 2)->default(0);
            $table->decimal('desconto', 10, 2)->default(0);
            $table->decimal('valor_pago', 10, 2)->nullable();
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->enum('status', ['pendente', 'pago', 'atraso', 'cancelado'])->default('pendente');
            $table->string('metodo_pagamento')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            $table->unique(['matricula_id', 'mes_referencia', 'ano_referencia'], 'propina_unica');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propinas');
    }
};