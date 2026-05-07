<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\NivelEnsino;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📚 Criando cursos do sistema...');
        $this->command->newLine();

        // Buscar níveis
        $prim = NivelEnsino::where('codigo', 'PRIM')->first(); // Ensino Primário
        $sec1 = NivelEnsino::where('codigo', 'SEC1')->first(); // I Ciclo (7ª-9ª)
        $sec2 = NivelEnsino::where('codigo', 'SEC2')->first(); // II Ciclo Geral (10ª-12ª)
        $sec2t = NivelEnsino::where('codigo', 'SEC2_T')->first(); // II Ciclo Técnico (10ª-13ª)

        if (!$sec2 && !$sec2t) {
            $this->command->warn('⚠️ Execute o NivelEnsinoSeeder primeiro!');
            return;
        }

        $this->command->info("📌 Níveis encontrados:");
        $this->command->line("   - I Ciclo Geral: " . ($sec1 ? '✓' : '✗'));
        $this->command->line("   - II Ciclo Geral: " . ($sec2 ? '✓' : '✗'));
        $this->command->line("   - II Ciclo Técnico: " . ($sec2t ? '✓' : '✗'));
        $this->command->newLine();

        $cursos = [
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
            [
                'nome' => 'Contabilidade Geral',
                'codigo' => 'CG',
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
                'nome' => 'Técnico de Contabilidade',
                'codigo' => 'TEC-CONT',
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

        $count = 0;
        $criados = 0;
        $atualizados = 0;

        // Filtrar apenas cursos com nível válido
        $cursosValidos = array_filter($cursos, fn($c) => $c['nivel_ensino_id'] !== null);

        foreach ($cursosValidos as $cursoData) {
            // Usar updateOrCreate para evitar duplicatas
            $curso = Curso::updateOrCreate(
                ['codigo' => $cursoData['codigo']],
                [
                    'nome' => $cursoData['nome'],
                    'codigo' => $cursoData['codigo'],
                    'nivel_ensino_id' => $cursoData['nivel_ensino_id'],
                    'descricao' => $cursoData['descricao'],
                    'ativo' => $cursoData['ativo'],
                ]
            );
            $count++;
            
            if ($curso->wasRecentlyCreated) {
                $criados++;
                $this->command->line("   ✓ Criado: {$curso->nome} ({$curso->codigo})");
            } else {
                $atualizados++;
                $this->command->line("   🔄 Atualizado: {$curso->nome} ({$curso->codigo})");
            }
        }

        $this->command->newLine();
        $this->command->info("══════════════════════════════════════════");
        $this->command->info("✅ TOTAL: {$count} cursos processados!");
        $this->command->info("   ✨ Criados: {$criados}");
        $this->command->info("   🔄 Atualizados: {$atualizados}");
        $this->command->info("══════════════════════════════════════════");

        // Resumo por nível
        $this->command->newLine();
        $this->command->info("📊 RESUMO POR NÍVEL DE ENSINO:");
        
        if ($sec2) {
            $totalSec2 = Curso::where('nivel_ensino_id', $sec2->id)->count();
            $this->command->info("   🎓 II Ciclo Geral (Científico): {$totalSec2} curso(s)");
        }
        
        if ($sec2t) {
            $totalSec2t = Curso::where('nivel_ensino_id', $sec2t->id)->count();
            $this->command->info("   🔧 II Ciclo Técnico: {$totalSec2t} curso(s)");
        }

    }
}