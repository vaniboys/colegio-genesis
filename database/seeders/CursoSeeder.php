<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\NivelEnsino;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar níveis
        $sec1 = NivelEnsino::where('codigo', 'SEC1')->first(); // I Ciclo (7ª-9ª)
        $sec2 = NivelEnsino::where('codigo', 'SEC2')->first(); // II Ciclo Geral (10ª-12ª)
        $sec2t = NivelEnsino::where('codigo', 'SEC2_T')->first(); // II Ciclo Técnico (10ª-13ª)

        if (!$sec2 && !$sec2t) {
            $this->command->warn('⚠️ Execute o NivelEnsinoSeeder primeiro!');
            return;
        }

        $cursos = [
            // ==================== I CICLO (7ª-9ª) ====================
            // Sem cursos - apenas disciplinas gerais
            // (não adicionar cursos aqui)

            // ==================== II CICLO GERAL (10ª-12ª) ====================
            [
                'nome' => 'Ciências Físicas e Biológicas',
                'codigo' => 'CFB',
                'nivel_ensino_id' => $sec2?->id,
                'descricao' => 'Curso geral de ciências - Matemática, Física, Química, Biologia',
                'ativo' => true,
            ],
            [
                'nome' => 'Ciências Económicas e Jurídicas',
                'codigo' => 'CEJ',
                'nivel_ensino_id' => $sec2?->id,
                'descricao' => 'Curso geral de ciências sociais - Economia, Direito, Contabilidade',
                'ativo' => true,
            ],
            [
                'nome' => 'Humanidades',
                'codigo' => 'HUM',
                'nivel_ensino_id' => $sec2?->id,
                'descricao' => 'Curso geral de humanidades - Línguas, História, Geografia',
                'ativo' => true,
            ],

            // ==================== II CICLO TÉCNICO (10ª-13ª) ====================
            // Informática
            [
                'nome' => 'Informática de Gestão',
                'codigo' => 'INF-GES',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Gestão de sistemas informáticos empresariais',
                'ativo' => true,
            ],
            [
                'nome' => 'Informática e Sistemas',
                'codigo' => 'INF-SIS',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Desenvolvimento e manutenção de sistemas',
                'ativo' => true,
            ],

            // Contabilidade
            [
                'nome' => 'Contabilidade Geral',
                'codigo' => 'CONT-GER',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Contabilidade e escrituração empresarial',
                'ativo' => true,
            ],
            [
                'nome' => 'Gestão Empresarial',
                'codigo' => 'GEST-EMP',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Administração e gestão de empresas',
                'ativo' => true,
            ],

            // Saúde
            [
                'nome' => 'Enfermagem Geral',
                'codigo' => 'ENF-GER',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Formação em enfermagem básica',
                'ativo' => true,
            ],
            [
                'nome' => 'Análises Clínicas',
                'codigo' => 'ANL-CLI',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Laboratório e análises clínicas',
                'ativo' => true,
            ],

            // Engenharia
            [
                'nome' => 'Electricidade Industrial',
                'codigo' => 'ELC-IND',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Instalações eléctricas industriais',
                'ativo' => true,
            ],
            [
                'nome' => 'Construção Civil',
                'codigo' => 'CONST-CIV',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Obras e edificações',
                'ativo' => true,
            ],

            // Agricultura
            [
                'nome' => 'Produção Agrícola',
                'codigo' => 'AGR-PROD',
                'nivel_ensino_id' => $sec2t?->id,
                'descricao' => 'Técnicas de produção agropecuária',
                'ativo' => true,
            ],
        ];

        // Inserir apenas se o nível existir
        $cursosValidos = array_filter($cursos, fn($c) => $c['nivel_ensino_id'] !== null);
        
        Curso::insert($cursosValidos);

        $this->command->info('✅ ' . count($cursosValidos) . ' cursos criados!');
        $this->command->info('   - II Ciclo Geral: ' . count(array_filter($cursosValidos, fn($c) => $c['nivel_ensino_id'] === ($sec2?->id))));
        $this->command->info('   - II Ciclo Técnico: ' . count(array_filter($cursosValidos, fn($c) => $c['nivel_ensino_id'] === ($sec2t?->id))));
    }
}