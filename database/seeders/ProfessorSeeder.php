<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        Professor::create([
            'nome_completo' => 'João Pedro',
            'email' => 'professor@escola.ao',
            'bi' => '123456789LA045',
            'telefone' => '900000000',
            'especialidade' => 'Matemática',
            'habilitacoes' => 'Licenciatura',
            'data_contratacao' => now(),
            'situacao' => 'activo',
        ]);
    }
}