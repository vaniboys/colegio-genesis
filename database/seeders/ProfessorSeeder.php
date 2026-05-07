<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;
use Illuminate\Support\Facades\Hash;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        $professores = [
            [
                'nome_completo' => 'João Pedro Santos',
                'email' => 'professor@escola.ao',
                'bi' => '123456789LA045',
                'telefone' => '900000001',
                'especialidade' => 'Matemática',
                'habilitacoes' => 'Licenciatura em Matemática',
                'data_contratacao' => '2023-01-15',
                'situacao' => 'activo',
            ],
            [
                'nome_completo' => 'Maria Antónia Silva',
                'email' => 'maria.silva@escola.ao',
                'bi' => '987654321LA032',
                'telefone' => '900000002',
                'especialidade' => 'Língua Portuguesa',
                'habilitacoes' => 'Mestrado em Linguística',
                'data_contratacao' => '2023-02-10',
                'situacao' => 'activo',
            ],
            [
                'nome_completo' => 'Carlos Alberto Mendes',
                'email' => 'carlos.mendes@escola.ao',
                'bi' => '456789123LA078',
                'telefone' => '900000003',
                'especialidade' => 'Ciências da Natureza',
                'habilitacoes' => 'Licenciatura em Biologia',
                'data_contratacao' => '2023-03-05',
                'situacao' => 'activo',
            ],
            [
                'nome_completo' => 'Ana Paula Ferreira',
                'email' => 'ana.ferreira@escola.ao',
                'bi' => '789123456LA056',
                'telefone' => '900000004',
                'especialidade' => 'História',
                'habilitacoes' => 'Licenciatura em História',
                'data_contratacao' => '2023-04-20',
                'situacao' => 'activo',
            ],
            [
                'nome_completo' => 'Fernando José Lima',
                'email' => 'fernando.lima@escola.ao',
                'bi' => '321654987LA091',
                'telefone' => '900000005',
                'especialidade' => 'Geografia',
                'habilitacoes' => 'Mestrado em Geografia',
                'data_contratacao' => '2023-05-12',
                'situacao' => 'activo',
            ],
            [
                'nome_completo' => 'Isabel Cristina Dias',
                'email' => 'isabel.dias@escola.ao',
                'bi' => '654987321LA067',
                'telefone' => '900000006',
                'especialidade' => 'Educação Musical',
                'habilitacoes' => 'Licenciatura em Música',
                'data_contratacao' => '2023-06-08',
                'situacao' => 'activo',
            ],
            [
                'nome_completo' => 'Ricardo Paulo Gomes',
                'email' => 'ricardo.gomes@escola.ao',
                'bi' => '147258369LA024',
                'telefone' => '900000007',
                'especialidade' => 'Educação Física',
                'habilitacoes' => 'Licenciatura em Educação Física',
                'data_contratacao' => '2023-07-01',
                'situacao' => 'activo',
            ],
            [
                'nome_completo' => 'Patrícia Sousa',
                'email' => 'patricia.sousa@escola.ao',
                'bi' => '369258147LA089',
                'telefone' => '900000008',
                'especialidade' => 'Educação Moral e Cívica',
                'habilitacoes' => 'Licenciatura em Filosofia',
                'data_contratacao' => '2023-08-14',
                'situacao' => 'activo',
            ],
        ];

        $count = 0;

        foreach ($professores as $data) {
            // Criar ou atualizar professor (SEM user_id)
            Professor::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nome_completo' => $data['nome_completo'],
                    'email' => $data['email'],
                    'bi' => $data['bi'],
                    'telefone' => $data['telefone'],
                    'especialidade' => $data['especialidade'],
                    'habilitacoes' => $data['habilitacoes'],
                    'data_contratacao' => $data['data_contratacao'],
                    'situacao' => $data['situacao'],
                ]
            );
            $count++;
            
            $this->command->line("  ✓ Professor: {$data['nome_completo']} - {$data['email']}");
        }

        $this->command->newLine();
        $this->command->info("✅ {$count} professores criados/atualizados!");
        $this->command->warn("⚠️ Nota: Os usuários para professores serão criados no UserSeeder!");
    }
}