<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnoLectivo;

class AnoLectivoSeeder extends Seeder
{
    public function run(): void
    {
        AnoLectivo::create([
            'ano' => '2025/2026',
            'data_inicio' => '2025-09-01',
            'data_fim' => '2026-07-31',
            'activo' => true,
        ]);
    }
}