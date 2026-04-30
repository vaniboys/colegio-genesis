<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_1_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_2_id')->constrained('users')->cascadeOnDelete();
            $table->string('titulo')->nullable();
            $table->timestamp('ultima_mensagem')->nullable();
            $table->timestamps();
            
            $table->unique(['user_1_id', 'user_2_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversas');
    }
};