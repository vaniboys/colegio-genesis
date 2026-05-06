<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encarregados', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('parentesco')->nullable();
            $table->text('endereco')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('nome_completo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encarregados');
    }
};