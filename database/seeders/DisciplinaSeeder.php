<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disciplina;
use App\Models\Classe;
use App\Models\NivelEnsino;

class DisciplinaSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== VERIFICAR SE NÍVEIS EXISTEM ====================
        $niveisExistentes = NivelEnsino::pluck('codigo')->toArray();
        
        if (empty($niveisExistentes)) {
            $this->command->error("❌ Nenhum nível de ensino encontrado! Execute NivelEnsinoSeeder primeiro.");
            return;
        }
        
        $this->command->info("📚 Níveis encontrados: " . implode(', ', $niveisExistentes));
        
        // ==================== DISCIPLINAS ====================
        $disciplinas = [
            // Ensino Primário (1ª-6ª)
            ['nome' => 'Língua Portuguesa', 'codigo' => 'LP', 'carga_horaria' => 6, 'niveis' => ['PRIM', 'SEC1', 'SEC2', 'SEC2_T'], 'obrigatoria' => true],
            ['nome' => 'Matemática', 'codigo' => 'MAT', 'carga_horaria' => 6, 'niveis' => ['PRIM', 'SEC1', 'SEC2', 'SEC2_T'], 'obrigatoria' => true],
            ['nome' => 'Ciências da Natureza', 'codigo' => 'CN', 'carga_horaria' => 3, 'niveis' => ['PRIM', 'SEC1'], 'obrigatoria' => false],
            ['nome' => 'Educação Física', 'codigo' => 'EF', 'carga_horaria' => 2, 'niveis' => ['PRIM', 'SEC1', 'SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Educação Moral e Cívica', 'codigo' => 'EMC', 'carga_horaria' => 2, 'niveis' => ['PRIM', 'SEC1'], 'obrigatoria' => false],
            ['nome' => 'Educação Artística', 'codigo' => 'EA', 'carga_horaria' => 2, 'niveis' => ['PRIM', 'SEC1'], 'obrigatoria' => false],
            
            // I e II Ciclo (7ª-13ª)
            ['nome' => 'História', 'codigo' => 'HIST', 'carga_horaria' => 3, 'niveis' => ['SEC1', 'SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Geografia', 'codigo' => 'GEO', 'carga_horaria' => 3, 'niveis' => ['SEC1', 'SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Física', 'codigo' => 'FIS', 'carga_horaria' => 4, 'niveis' => ['SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Química', 'codigo' => 'QUI', 'carga_horaria' => 4, 'niveis' => ['SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Biologia', 'codigo' => 'BIO', 'carga_horaria' => 4, 'niveis' => ['SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Filosofia', 'codigo' => 'FIL', 'carga_horaria' => 2, 'niveis' => ['SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Inglês', 'codigo' => 'ING', 'carga_horaria' => 3, 'niveis' => ['SEC1', 'SEC2', 'SEC2_T'], 'obrigatoria' => false],
            
            // Cursos Técnicos
            ['nome' => 'Tecnologias de Informação', 'codigo' => 'TI', 'carga_horaria' => 4, 'niveis' => ['SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Economia', 'codigo' => 'ECO', 'carga_horaria' => 3, 'niveis' => ['SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Direito', 'codigo' => 'DIR', 'carga_horaria' => 3, 'niveis' => ['SEC2', 'SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Contabilidade', 'codigo' => 'CONT', 'carga_horaria' => 4, 'niveis' => ['SEC2_T'], 'obrigatoria' => false],
            ['nome' => 'Enfermagem', 'codigo' => 'ENF', 'carga_horaria' => 5, 'niveis' => ['SEC2_T'], 'obrigatoria' => false],
        ];

        $count = 0;
        $associacoes = 0;
        
        foreach ($disciplinas as $disc) {
            $niveis = $disc['niveis'];
            $obrigatoria = $disc['obrigatoria'];
            unset($disc['niveis'], $disc['obrigatoria']);
            
            // Criar ou atualizar disciplina
            $disciplina = Disciplina::updateOrCreate(
                ['codigo' => $disc['codigo']],
                $disc
            );
            $count++;
            
            // Filtrar apenas níveis que existem no banco
            $niveisValidos = array_intersect($niveis, $niveisExistentes);
            
            if (empty($niveisValidos)) {
                $this->command->warn("⚠️ Disciplina {$disc['nome']} - Nenhum nível válido encontrado");
                continue;
            }
            
            // Associar às classes dos níveis correspondentes
            $classes = Classe::whereHas('nivelEnsino', function ($q) use ($niveisValidos) {
                $q->whereIn('codigo', $niveisValidos);
            })->get();
            
            foreach ($classes as $classe) {
                $classe->disciplinas()->syncWithoutDetaching([
                    $disciplina->id => [
                        'carga_horaria_semanal' => $disc['carga_horaria'],
                        'obrigatoria' => $obrigatoria
                    ]
                ]);
                $associacoes++;
            }
            
            $this->command->line("  ✓ {$disciplina->nome} - associado a {$classes->count()} classes");
        }

        $this->command->newLine();
        $this->command->info("✅ {$count} disciplinas criadas/atualizadas!");
        $this->command->info("✅ {$associacoes} associações classe-disciplina criadas!");
        
        // ==================== RESUMO FINAL ====================
        $totalDisciplinas = Disciplina::count();
        $totalAssociacoes = \DB::table('classe_disciplina')->count();
        
        $this->command->newLine();
        $this->command->info("📊 RESUMO FINAL:");
        $this->command->info("   Total de disciplinas no banco: {$totalDisciplinas}");
        $this->command->info("   Total de associações: {$totalAssociacoes}");
    }
}