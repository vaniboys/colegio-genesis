<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            if (!Schema::hasColumn('turmas', 'professor_principal_id')) {
                $table->foreignId('professor_principal_id')
                    ->nullable()
                    ->after('curso_id')
                    ->constrained('professores')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            $table->dropForeign(['professor_principal_id']);
            $table->dropColumn('professor_principal_id');
        });
    }
};