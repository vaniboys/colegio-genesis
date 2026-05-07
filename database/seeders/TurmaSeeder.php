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
        
        if (!$ano) {
            $this->command->error('❌ Nenhum Ano Lectivo encontrado! Execute AnoLectivoSeeder primeiro.');
            return;
        }

        // Buscar professores disponíveis
        $professores = Professor::all();
        if ($professores->isEmpty()) {
            $this->command->warn('⚠️ Nenhum professor encontrado. Execute ProfessorSeeder primeiro.');
            $professorPrincipal = null;
        } else {
            $professorPrincipal = $professores->first();
        }

        // Buscar classes existentes com suas disciplinas
        $classes = Classe::with('disciplinas')->get();

        if ($classes->isEmpty()) {
            $this->command->warn('⚠️ Nenhuma classe encontrada. Execute ClasseSeeder primeiro.');
            return;
        }

        // Buscar cursos disponíveis
        $cursos = Curso::all();
        $cursosMap = $cursos->keyBy('nome');

        $turmas = [
            // ==================== ENSINO PRIMÁRIO (1ª-6ª) ====================
            ['nome' => '1A', 'classe_nome' => '1ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '1B', 'classe_nome' => '1ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '2A', 'classe_nome' => '2ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '2B', 'classe_nome' => '2ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '3A', 'classe_nome' => '3ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '3B', 'classe_nome' => '3ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '4A', 'classe_nome' => '4ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '4B', 'classe_nome' => '4ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '5A', 'classe_nome' => '5ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '5B', 'classe_nome' => '5ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '6A', 'classe_nome' => '6ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '6B', 'classe_nome' => '6ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            
            // ==================== 1º CICLO (7ª-9ª) ====================
            ['nome' => '7A', 'classe_nome' => '7ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '7B', 'classe_nome' => '7ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '7C', 'classe_nome' => '7ª Classe', 'turno' => 'noite', 'curso_nome' => null],
            ['nome' => '8A', 'classe_nome' => '8ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '8B', 'classe_nome' => '8ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            ['nome' => '9A', 'classe_nome' => '9ª Classe', 'turno' => 'manha', 'curso_nome' => null],
            ['nome' => '9B', 'classe_nome' => '9ª Classe', 'turno' => 'tarde', 'curso_nome' => null],
            
            // ==================== 2º CICLO - CIENTÍFICO (10ª-13ª) ====================
            // 10ª Classe
            ['nome' => '10A', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências Físicas e Biológicas'],
            ['nome' => '10B', 'classe_nome' => '10ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Ciências Físicas e Biológicas'],
            ['nome' => '10C', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Humanidades'],
            ['nome' => '10D', 'classe_nome' => '10ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Humanidades'],
            ['nome' => '10E', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências Económicas e Jurídicas'],
            ['nome' => '10F', 'classe_nome' => '10ª Classe', 'turno' => 'noite', 'curso_nome' => 'Ciências Físicas e Biológicas'],
            
            // 11ª Classe
            ['nome' => '11A', 'classe_nome' => '11ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências Físicas e Biológicas'],
            ['nome' => '11B', 'classe_nome' => '11ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Ciências Físicas e Biológicas'],
            ['nome' => '11C', 'classe_nome' => '11ª Classe', 'turno' => 'manha', 'curso_nome' => 'Humanidades'],
            ['nome' => '11D', 'classe_nome' => '11ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Humanidades'],
            ['nome' => '11E', 'classe_nome' => '11ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências Económicas e Jurídicas'],
            
            // 12ª Classe
            ['nome' => '12A', 'classe_nome' => '12ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências Físicas e Biológicas'],
            ['nome' => '12B', 'classe_nome' => '12ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Ciências Económicas e Jurídicas'],
            ['nome' => '12C', 'classe_nome' => '12ª Classe', 'turno' => 'manha', 'curso_nome' => 'Humanidades'],
            ['nome' => '12D', 'classe_nome' => '12ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Humanidades'],
            ['nome' => '12E', 'classe_nome' => '12ª Classe', 'turno' => 'noite', 'curso_nome' => 'Ciências Físicas e Biológicas'],
            
            // 13ª Classe
            ['nome' => '13A', 'classe_nome' => '13ª Classe', 'turno' => 'manha', 'curso_nome' => 'Ciências Económicas e Jurídicas'],
            ['nome' => '13B', 'classe_nome' => '13ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Ciências Físicas e Biológicas'],
            ['nome' => '13C', 'classe_nome' => '13ª Classe', 'turno' => 'manha', 'curso_nome' => 'Humanidades'],
            ['nome' => '13D', 'classe_nome' => '13ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Humanidades'],
            
            // ==================== CURSOS TÉCNICOS ====================
            ['nome' => '10TI', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Informática de Gestão'],
            ['nome' => '10AC', 'classe_nome' => '10ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Técnico de Contabilidade'],
            ['nome' => '10EF', 'classe_nome' => '10ª Classe', 'turno' => 'manha', 'curso_nome' => 'Análises Clínicas'],
            ['nome' => '11TI', 'classe_nome' => '11ª Classe', 'turno' => 'manha', 'curso_nome' => 'Informática e Sistemas'],
            ['nome' => '11AC', 'classe_nome' => '11ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Produção Agrícola'],
            ['nome' => '12TI', 'classe_nome' => '12ª Classe', 'turno' => 'manha', 'curso_nome' => 'Construção Civil'],
            ['nome' => '12EF', 'classe_nome' => '12ª Classe', 'turno' => 'manha', 'curso_nome' => 'Enfermagem Geral'],
            ['nome' => '13TI', 'classe_nome' => '13ª Classe', 'turno' => 'manha', 'curso_nome' => 'Electricidade Industrial'],
            ['nome' => '13AC', 'classe_nome' => '13ª Classe', 'turno' => 'tarde', 'curso_nome' => 'Contabilidade Geral'],
            ['nome' => '13ENF', 'classe_nome' => '13ª Classe', 'turno' => 'manha', 'curso_nome' => 'Enfermagem Geral'],
        ];

        $countTurmas = 0;
        $countDisciplinasAssociadas = 0;
        $turmasComCurso = 0;
        $turmasAtualizadas = 0;

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
                $curso = $cursosMap[$t['curso_nome']] ?? null;
                if ($curso) {
                    $cursoId = $curso->id;
                    $turmasComCurso++;
                } else {
                    $this->command->warn("   ⚠️ Curso '{$t['curso_nome']}' não encontrado para turma {$t['nome']}");
                }
            }

            // Escolher um professor diferente por turno/classe
            $professor = $this->getProfessorPorTurno($professores, $t['turno'], $classe->id);
            
            // Verificar se turma já existe
            $existingTurma = Turma::where('nome', $t['nome'])
                                  ->where('ano_lectivo_id', $ano->id)
                                  ->first();
            
            if ($existingTurma) {
                $existingTurma->update([
                    'classe_id' => $classe->id,
                    'nivel_ensino_id' => $classe->nivel_ensino_id,
                    'turno' => $t['turno'],
                    'professor_principal_id' => $professor?->id,
                    'capacidade_maxima' => 40,
                    'vagas_ocupadas' => rand(15, 38),
                    'estado' => 'ativa',
                    'curso_id' => $cursoId ?? $existingTurma->curso_id,
                ]);
                $turma = $existingTurma;
                $turmasAtualizadas++;
                $this->command->info("🔄 Turma {$t['nome']} atualizada!");
            } else {
                // Criar nova turma
                $turma = Turma::create([
                    'nome' => $t['nome'],
                    'classe_id' => $classe->id,
                    'nivel_ensino_id' => $classe->nivel_ensino_id,
                    'turno' => $t['turno'],
                    'ano_lectivo_id' => $ano->id,
                    'professor_principal_id' => $professor?->id,
                    'capacidade_maxima' => 40,
                    'vagas_ocupadas' => rand(10, 35),
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
                    // Verificar se existe pivot (para evitar erro)
                    $cargaHoraria = 4;
                    $obrigatoria = true;
                    
                    if ($disciplina->pivot) {
                        $cargaHoraria = $disciplina->pivot->carga_horaria_semanal ?? 4;
                        $obrigatoria = $disciplina->pivot->obrigatoria ?? true;
                    }
                    
                    $disciplinasData[$disciplina->id] = [
                        'carga_horaria_semanal' => $cargaHoraria,
                        'obrigatoria' => $obrigatoria,
                        'professor_id' => $this->getProfessorPorDisciplina($professores, $disciplina->nome),
                    ];
                }
                $turma->disciplinas()->sync($disciplinasData);
                $countDisciplinasAssociadas += count($disciplinasData);
                $this->command->line("   📚 {$classe->disciplinas->count()} disciplinas associadas à turma {$t['nome']}");
            } else {
                $this->command->warn("   ⚠️ Classe '{$classe->nome}' não tem disciplinas associadas!");
                
                // Associar disciplinas padrão para o Primário
                if ($classe->nivel_ensino_id == 1) { // Ensino Primário
                    $disciplinasPadrao = Disciplina::whereIn('codigo', ['LP', 'MAT', 'EMP', 'EMU', 'EM'])->get();
                    $disciplinasData = [];
                    foreach ($disciplinasPadrao as $disciplina) {
                        $disciplinasData[$disciplina->id] = [
                            'carga_horaria_semanal' => 4,
                            'obrigatoria' => true,
                            'professor_id' => null,
                        ];
                    }
                    $turma->disciplinas()->sync($disciplinasData);
                    $countDisciplinasAssociadas += count($disciplinasData);
                    $this->command->line("   📚 {$disciplinasPadrao->count()} disciplinas padrão associadas à turma {$t['nome']}");
                }
            }
        }

        $this->command->newLine();
        $this->command->info("══════════════════════════════════════════");
        $this->command->info("✅ {$countTurmas} turmas criadas/atualizadas!");
        $this->command->info("🔄 {$turmasAtualizadas} turmas atualizadas!");
        $this->command->info("🎓 {$turmasComCurso} turmas com curso associado!");
        $this->command->info("📚 Total de associações disciplina_turma: {$countDisciplinasAssociadas}");
        $this->command->info("══════════════════════════════════════════");
        
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
        
        // Resumo por turno
        $this->command->newLine();
        $this->command->info("🕐 RESUMO POR TURNO:");
        $turnos = Turma::selectRaw('turno, count(*) as total')->groupBy('turno')->get();
        foreach ($turnos as $turno) {
            $icone = $turno->turno == 'manha' ? '🌅' : ($turno->turno == 'tarde' ? '☀️' : '🌙');
            $this->command->line("   {$icone} {$turno->turno}: {$turno->total} turma(s)");
        }
    }
    
    /**
     * Selecionar professor baseado no turno
     */
    private function getProfessorPorTurno($professores, string $turno, int $classeId): ?Professor
    {
        if ($professores->isEmpty()) return null;
        
        // Professores diferentes para turnos diferentes
        $index = ($turno === 'manha' ? 0 : ($turno === 'tarde' ? 1 : 2));
        
        return $professores->get($index % $professores->count());
    }
    
    /**
     * Selecionar professor baseado na disciplina
     */
    private function getProfessorPorDisciplina($professores, string $disciplinaNome): ?int
    {
        if ($professores->isEmpty()) return null;
        
        // Mapeamento de disciplina para professor
        $map = [
            'Matemática' => 0,
            'Língua Portuguesa' => 1,
            'Ciências da Natureza' => 2,
            'Educação Musical' => 3,
            'Educação Manual e Plástica' => 4,
            'Estudo do Meio' => 0,
            'História' => 2,
            'Geografia' => 3,
        ];
        
        $index = $map[$disciplinaNome] ?? random_int(0, $professores->count() - 1);
        
        return $professores->get($index % $professores->count())?->id;
    }
}