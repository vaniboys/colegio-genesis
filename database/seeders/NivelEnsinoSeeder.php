<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelEnsinoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('niveis_ensino')->insert([
            [
                'nome' => 'Ensino Primário',
                'codigo' => 'PRIM',
                'classe_inicio' => 1,
                'classe_fim' => 6,
                'duracao_anos' => 6,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'I Ciclo do Secundário',
                'codigo' => 'SEC1',
                'classe_inicio' => 7,
                'classe_fim' => 9,
                'duracao_anos' => 3,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'II Ciclo do Secundário',
                'codigo' => 'SEC2',
                'classe_inicio' => 10,
                'classe_fim' => 12,
                'duracao_anos' => 3,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'II Ciclo Técnico',
                'codigo' => 'SEC2_T',
                'classe_inicio' => 10,
                'classe_fim' => 13,
                'duracao_anos' => 4,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}