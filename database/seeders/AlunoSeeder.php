<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aluno;
use App\Models\Provincia;

class AlunoSeeder extends Seeder
{
    public function run(): void
    {
        $provincia = Provincia::first();

        $alunos = [
            [
                'processo' => '2600001',
                'nome_completo' => 'Carlos Alberto',
                'sexo' => 'M',
                'data_nascimento' => '2010-05-10',
                'provincia_id' => $provincia?->id,
                'municipio' => 'Talatona',
                'endereco' => 'Kilamba, Rua 12',
                'bi' => '987654321LA045',
                'telefone' => '923000000',
                'email' => 'carlos@email.com',
                'encarregado_id' => null,
                'foto' => null,
                'situacao' => 'inactivo',
            ],
            [
                'processo' => '2600002',
                'nome_completo' => 'Maria Silva',
                'sexo' => 'F',
                'data_nascimento' => '2011-03-15',
                'provincia_id' => $provincia?->id,
                'municipio' => 'Luanda',
                'endereco' => 'Maianga, Rua 5',
                'bi' => '123456789LA012',
                'telefone' => '923111111',
                'email' => 'maria@email.com',
                'encarregado_id' => null,
                'foto' => null,
                'situacao' => 'inactivo',
            ],
            [
                'processo' => '2600003',
                'nome_completo' => 'Pedro Santos',
                'sexo' => 'M',
                'data_nascimento' => '2009-07-22',
                'provincia_id' => $provincia?->id,
                'municipio' => 'Viana',
                'endereco' => 'Zango, Rua 8',
                'bi' => '456789123LA034',
                'telefone' => '923222222',
                'email' => 'pedro@email.com',
                'encarregado_id' => null,
                'foto' => null,
                'situacao' => 'inactivo',
            ],
        ];

        foreach ($alunos as $aluno) {
            Aluno::updateOrCreate(
                ['processo' => $aluno['processo']],
                $aluno
            );
        }

    }
}