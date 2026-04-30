<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;
use App\Models\Classe;
use App\Models\NivelEnsino;
use App\Models\Professor;
use App\Models\AnoLectivo;
use App\Models\Disciplina;
use App\Models\Curso;

class TurmaSeeder extends Seeder
{
    public function run(): void
    {
        $ano = AnoLectivo::first();
        $prof = Professor::first();

        if (!$ano || !$prof) {
            $this->command->warn('⚠️ Faltam registros base. Execute os seeders anteriores primeiro.');
            return;
        }

        // Buscar classes existentes com suas disciplinas (sem cursos para evitar erro)
        $classes = Classe::with('disciplinas')->get();

        if ($classes->isEmpty()) {
            $this->command->warn('⚠️ Nenhuma classe encontrada. Execute ClasseSeeder primeiro.');
            return;
        }

        // Buscar cursos disponíveis
        $cursos = Curso::all();

        $turmas = [
            // 1º Ciclo do Ensino Secundário (7ª, 8ª, 9ª)
            ['nome' => '7A', 'classe_nome' => '7ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '7B', 'classe_nome' => '7ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '8A', 'classe_nome' => '8ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '8B', 'classe_nome' => '8ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '9A', 'classe_nome' => '9ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '9B', 'classe_nome' => '9ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            
            // 2º Ciclo do Ensino Secundário - Científico (10ª, 11ª, 12ª, 13ª)
            ['nome' => '10A', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências'],
            ['nome' => '10B', 'classe_nome' => '10ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Ciências'],
            ['nome' => '10C', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Humanidades'],
            ['nome' => '10D', 'classe_nome' => '10ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Humanidades'],
            ['nome' => '10E-N', 'classe_nome' => '10ª Classe', 'turno' => 'noite', 'curso_nome' => 'Ciências'],
            
            ['nome' => '11A', 'classe_nome' => '11ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências'],
            ['nome' => '11B', 'classe_nome' => '11ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Ciências'],
            ['nome' => '11C', 'classe_nome' => '11ª Classe', 'turno' => 'manha', 'curso_nome' => 'Humanidades'],
            ['nome' => '11D', 'classe_nome' => '11ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Humanidades'],
            
            ['nome' => '12A', 'classe_nome' => '12ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências'],
            ['nome' => '12B', 'classe_nome' => '12ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Ciências'],
            ['nome' => '12C', 'classe_nome' => '12ª Classe', 'turno' => 'manha', 'curso_nome' => 'Humanidades'],
            ['nome' => '12D', 'classe_nome' => '12ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Humanidades'],
            
            ['nome' => '13A', 'classe_nome' => '13ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências'],
            ['nome' => '13B', 'classe_nome' => '13ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Ciências'],
            ['nome' => '13C', 'classe_nome' => '13ª Classe', 'turno' => 'manha', 'curso_nome' => 'Humanidades'],
            ['nome' => '13D', 'classe_nome' => '13ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Humanidades'],
            
            // Cursos Técnicos
            ['nome' => '10TI', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Técnico de Informática'],
            ['nome' => '10AC', 'classe_nome' => '10ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Técnico de Contabilidade'],
            ['nome' => '10EF', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Técnico de Enfermagem'],
            ['nome' => '11TI', 'classe_nome' => '11ª Classe', 'turno' => 'manha', 'curso_nome' => 'Técnico de Informática'],
            ['nome' => '11AC', 'classe_nome' => '11ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Técnico de Contabilidade'],
            ['nome' => '12TI', 'classe_nome' => '12ª Classe', 'turno' => 'manha', 'curso_nome' => 'Técnico de Informática'],
            ['nome' => '12EF', 'classe_nome' => '12ª Classe', 'turno' => 'manha', 'curso_nome' => 'Técnico de Enfermagem'],
            ['nome' => '13TI', 'classe_nome' => '13ª Classe', 'turno' => 'manha', 'curso_nome' => 'Técnico de Informática'],
            ['nome' => '13AC', 'classe_nome' => '13ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Técnico de Contabilidade'],
        ];

        $countTurmas = 0;
        $countDisciplinasAssociadas = 0;
        $turmasComCurso = 0;

        foreach ($turmas as $t) {
            // Encontrar a classe pelo nome
            $classe = $classes->firstWhere('nome', $t['classe_nome']);
            
            if (!$classe) {
                $this->command->warn("⚠️ Classe '{$t['classe_nome']}' não encontrada. Turma '{$t['nome']}' ignorada.");
                continue;
            }

            // Buscar curso
            $cursoId = null;
            if ($t['curso_nome'] && $cursos->isNotEmpty()) {
                $curso = $cursos->firstWhere('nome', $t['curso_nome']);
                if ($curso) {
                    $cursoId = $curso->id;
                    $turmasComCurso++;
                    $this->command->line("   🎓 Turma {$t['nome']} - Curso: {$t['curso_nome']}");
                } else {
                    $this->command->warn("   ⚠️ Curso '{$t['curso_nome']}' não encontrado para turma {$t['nome']}");
                }
            }

            // Verificar se turma já existe
            $existingTurma = Turma::where('nome', $t['nome'])
                                  ->where('ano_lectivo_id', $ano->id)
                                  ->first();
            
            if ($existingTurma) {
                $this->command->info("⏩ Turma {$t['nome']} já existe. Atualizando...");
                $turma = $existingTurma;
                $turma->update([
                    'classe_id' => $classe->id,
                    'nivel_ensino_id' => $classe->nivel_ensino_id,
                    'turno' => $t['turno'],
                    'professor_principal_id' => $prof->id,
                    'capacidade_maxima' => 40,
                    'estado' => 'ativa',
                    'curso_id' => $cursoId ?? $turma->curso_id,
                ]);
            } else {
                // Criar nova turma
                $turma = Turma::create([
                    'nome' => $t['nome'],
                    'classe_id' => $classe->id,
                    'nivel_ensino_id' => $classe->nivel_ensino_id,
                    'turno' => $t['turno'],
                    'ano_lectivo_id' => $ano->id,
                    'professor_principal_id' => $prof->id,
                    'capacidade_maxima' => 40,
                    'vagas_ocupadas' => 0,
                    'estado' => 'ativa',
                    'curso_id' => $cursoId,
                ]);
                $this->command->info("✅ Turma {$t['nome']} criada!");
            }
            
            $countTurmas++;
            
            // Sincronizar disciplinas da classe com a turma
            if ($classe->disciplinas->count() > 0) {
                $disciplinasData = [];
                foreach ($classe->disciplinas as $disciplina) {
                    $disciplinasData[$disciplina->id] = [
                        'carga_horaria_semanal' => $disciplina->pivot->carga_horaria_semanal ?? 4,
                        'obrigatoria' => $disciplina->pivot->obrigatoria ?? true,
                        'professor_id' => null,
                    ];
                }
                $turma->disciplinas()->sync($disciplinasData);
                $countDisciplinasAssociadas += count($disciplinasData);
                $this->command->line("   📚 {$classe->disciplinas->count()} disciplinas associadas à turma {$t['nome']}");
            } else {
                $this->command->warn("   ⚠️ Classe '{$classe->nome}' não tem disciplinas associadas!");
            }
        }

        $this->command->newLine();
        $this->command->info("✅ {$countTurmas} turmas criadas/atualizadas!");
        $this->command->info("🎓 {$turmasComCurso} turmas com curso associado!");
        $this->command->info("📚 Total de associações disciplina_turma: {$countDisciplinasAssociadas}");
        
        // Resumo por classe
        $this->command->newLine();
        $this->command->info("📊 RESUMO POR CLASSE:");
        $resumo = Turma::with('classe')->get()->groupBy('classe.nome');
        foreach ($resumo as $classeNome => $turmasClasse) {
            $this->command->line("   {$classeNome}: " . $turmasClasse->count() . " turma(s)");
        }
        
        // Resumo por curso
        if ($turmasComCurso > 0) {
            $this->command->newLine();
            $this->command->info("🎓 RESUMO POR CURSO:");
            $resumoCurso = Turma::whereNotNull('curso_id')->with('curso')->get()->groupBy('curso.nome');
            foreach ($resumoCurso as $cursoNome => $turmasCurso) {
                $this->command->line("   {$cursoNome}: " . $turmasCurso->count() . " turma(s)");
            }
        }
    }
}