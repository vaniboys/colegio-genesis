<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('professores', function (Blueprint $table) {
            if (!Schema::hasColumn('professores', 'carga_horaria_max')) {
                $table->integer('carga_horaria_max')->default(20)->after('especialidade');
            }
            if (!Schema::hasColumn('professores', 'carga_atual')) {
                $table->integer('carga_atual')->default(0)->after('carga_horaria_max');
            }
        });
    }

    public function down(): void
    {
        Schema::table('professores', function (Blueprint $table) {
            $table->dropColumn(['carga_horaria_max', 'carga_atual']);
        });
    }
};