<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matricula;
use App\Models\Turma;
use App\Models\AnoLectivo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Aluno;

class MatriculaSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📝 Registrando matrículas e criando contas de alunos...');
        $this->command->newLine();

        $anoLectivo = AnoLectivo::where('activo', true)->first();
        
        if (!$anoLectivo) {
            $this->command->error('❌ Nenhum ano lectivo activo encontrado!');
            return;
        }

        // Buscar turmas agrupadas por classe
        $turmas = Turma::with('classe')->get();
        $turmasPorClasse = [];
        foreach ($turmas as $turma) {
            $classeNome = $turma->classe->nome;
            if (!isset($turmasPorClasse[$classeNome])) {
                $turmasPorClasse[$classeNome] = [];
            }
            $turmasPorClasse[$classeNome][] = $turma;
        }

        // Buscar alunos do banco
        $alunos = Aluno::all();
        
        if ($alunos->isEmpty()) {
            $this->command->error('❌ Nenhum aluno encontrado! Execute AlunoSeeder primeiro.');
            return;
        }

        $capacidadeMaxima = 40;
        $tiposMatricula = ['nova', 'renovacao', 'transferencia'];
        $situacoes = ['ativa', 'ativa', 'ativa', 'ativa', 'pendente']; // 80% ativa
        
        $totalMatriculas = 0;
        $totalUsuariosCriados = 0;
        $totalUsuariosAtualizados = 0;
        $totalAlunosAtivados = 0;
        
        $bar = $this->command->getOutput()->createProgressBar($alunos->count());
        $bar->start();
        
        foreach ($alunos as $aluno) {
            // Determinar a classe do aluno baseada no processo
            $classeNome = $this->determinarClassePorProcesso($aluno->processo);
            
            if (!isset($turmasPorClasse[$classeNome]) || empty($turmasPorClasse[$classeNome])) {
                $this->command->warn("\n⚠️ Nenhuma turma encontrada para {$classeNome} - Aluno: {$aluno->processo}");
                continue;
            }
            
            // Inicializar ocupação das turmas
            $ocupacaoTurmas = [];
            foreach ($turmasPorClasse[$classeNome] as $turma) {
                $ocupacaoTurmas[$turma->id] = Matricula::where('turma_id', $turma->id)
                    ->where('ano_lectivo_id', $anoLectivo->id)
                    ->where('situacao', 'ativa')
                    ->count();
            }
            
            // Escolher turma com menos alunos
            $turmaEscolhida = null;
            $menorOcupacao = PHP_INT_MAX;
            
            foreach ($turmasPorClasse[$classeNome] as $turma) {
                $ocupacao = $ocupacaoTurmas[$turma->id];
                if ($ocupacao < $capacidadeMaxima && $ocupacao < $menorOcupacao) {
                    $menorOcupacao = $ocupacao;
                    $turmaEscolhida = $turma;
                }
            }
            
            // Se todas as turmas estão cheias, escolher a primeira
            if (!$turmaEscolhida) {
                $turmaEscolhida = $turmasPorClasse[$classeNome][0];
            }
            
            // Gerar número de matrícula
            $numeroMatricula = 'MAT-' . date('Y') . '-' . str_pad($aluno->id, 5, '0', STR_PAD_LEFT);
            $situacao = $situacoes[array_rand($situacoes)];
            
            // Se matrícula ativa, atualizar situação do aluno
            $alunoAtivado = false;
            if ($situacao === 'ativa' && $aluno->situacao !== 'activo') {
                $aluno->update(['situacao' => 'activo']);
                $alunoAtivado = true;
                $totalAlunosAtivados++;
            }
            
            // ==================== CRIAR CONTA DO ALUNO ====================
            // Login = número de processo
            // Senha = número de processo
            // Email = processo@escola.ao
            $login = $aluno->processo;
            $senha = $aluno->processo;
            $email = $aluno->processo . '@escola.ao';
            
            $existingUser = User::where('email', $login)->orWhere('email', $email)->first();
            
            if ($existingUser) {
                $existingUser->update([
                    'name' => $aluno->nome_completo,
                    'email' => $email,
                    'password' => Hash::make($senha),
                    'role' => 'aluno',
                    'aluno_id' => $aluno->id,
                    'email_verified_at' => now(),
                ]);
                $totalUsuariosAtualizados++;
            } else {
                User::create([
                    'name' => $aluno->nome_completo,
                    'email' => $email,
                    'password' => Hash::make($senha),
                    'role' => 'aluno',
                    'aluno_id' => $aluno->id,
                    'email_verified_at' => now(),
                ]);
                $totalUsuariosCriados++;
            }
            
            // ==================== CRIAR MATRÍCULA ====================
            Matricula::updateOrCreate(
                [
                    'aluno_id' => $aluno->id,
                    'ano_lectivo_id' => $anoLectivo->id,
                ],
                [
                    'numero_matricula' => $numeroMatricula,
                    'aluno_id' => $aluno->id,
                    'turma_id' => $turmaEscolhida->id,
                    'ano_lectivo_id' => $anoLectivo->id,
                    'data_matricula' => now()->subDays(rand(0, 60)),
                    'tipo' => $tiposMatricula[array_rand($tiposMatricula)],
                    'situacao' => $situacao,
                ]
            );
            
            $totalMatriculas++;
            $bar->advance();
        }
        
        $bar->finish();
        $this->command->newLine();
        $this->command->newLine();
        
        // Atualizar vagas ocupadas nas turmas
        $this->command->info('📊 Atualizando vagas ocupadas das turmas...');
        foreach ($turmas as $turma) {
            $ocupadas = Matricula::where('turma_id', $turma->id)
                ->where('ano_lectivo_id', $anoLectivo->id)
                ->where('situacao', 'ativa')
                ->count();
            $turma->update(['vagas_ocupadas' => $ocupadas]);
            $this->command->line("   {$turma->nome}: {$ocupadas}/{$turma->capacidade_maxima} alunos");
        }
        
        // ==================== RESUMO FINAL ====================
        $this->command->newLine();
        $this->command->info("═══════════════════════════════════════════════════════════");
        $this->command->info("✅ MATRÍCULAS REGISTADAS: {$totalMatriculas}");
        $this->command->info("✅ ALUNOS ACTIVADOS: {$totalAlunosAtivados}");
        $this->command->info("✅ USUÁRIOS CRIADOS: {$totalUsuariosCriados}");
        $this->command->info("✅ USUÁRIOS ATUALIZADOS: {$totalUsuariosAtualizados}");
        $this->command->info("═══════════════════════════════════════════════════════════");
        
        // Estatísticas de alunos activos
        $this->command->newLine();
        $this->command->info("📊 SITUAÇÃO DOS ALUNOS:");
        $this->command->line("   🟢 Alunos Activos: " . Aluno::where('situacao', 'activo')->count());
        $this->command->line("   🔴 Alunos Inactivos: " . Aluno::where('situacao', 'inactivo')->count());
        
        // Estatísticas de usuários
        $this->command->newLine();
        $this->command->info("📊 USUÁRIOS DO SISTEMA:");
        $this->command->line("   👑 Admin: " . User::where('role', 'admin')->count());
        $this->command->line("   👨‍🏫 Professores: " . User::where('role', 'professor')->count());
        $this->command->line("   🧑‍🎓 Alunos: " . User::where('role', 'aluno')->count());
        $this->command->line("   📋 Secretaria: " . User::where('role', 'secretaria')->count());
        
        // Exemplo de credenciais
        $this->command->newLine();
        $this->command->info("🔑 EXEMPLO DE CREDENCIAIS DE ACESSO:");
        $primeiroAluno = Aluno::orderBy('processo')->first();
        if ($primeiroAluno) {
            $this->command->line("   ┌─────────────────────────────────────────────────────┐");
            $this->command->line("   │  📧 Email: {$primeiroAluno->processo}@escola.ao");
            $this->command->line("   │  🔑 Senha: {$primeiroAluno->processo}");
            $this->command->line("   │  👤 Nome: {$primeiroAluno->nome_completo}");
            $this->command->line("   │  🏫 Classe: " . $this->determinarClassePorProcesso($primeiroAluno->processo));
            $this->command->line("   └─────────────────────────────────────────────────────┘");
        }
        
        // Resumo por classe
        $this->command->newLine();
        $this->command->info("📊 RESUMO DE MATRÍCULAS POR CLASSE:");
        $resumoClasse = Matricula::where('ano_lectivo_id', $anoLectivo->id)
            ->with('turma.classe')
            ->get()
            ->groupBy(fn($m) => $m->turma->classe->nome);
        
        foreach ($resumoClasse as $classeNome => $matriculasClasse) {
            $this->command->line("   📚 {$classeNome}: " . $matriculasClasse->count() . " matrículas");
        }
        
        $this->command->newLine();
        $this->command->info("🏆 SISTEMA PRONTO PARA APRESENTAÇÃO!");
        $this->command->info("💡 Alunos podem aceder com: processo@escola.ao | senha: processo");
    }
    
    private function determinarClassePorProcesso(string $processo): string
    {
        $numero = (int) $processo;
        
        if ($numero <= 2600050) return '1ª Classe';
        if ($numero <= 2600100) return '2ª Classe';
        if ($numero <= 2600150) return '3ª Classe';
        if ($numero <= 2600200) return '4ª Classe';
        if ($numero <= 2600250) return '5ª Classe';
        if ($numero <= 2600300) return '6ª Classe';
        if ($numero <= 2600350) return '7ª Classe';
        if ($numero <= 2600400) return '8ª Classe';
        if ($numero <= 2600450) return '9ª Classe';
        if ($numero <= 2600500) return '10ª Classe';
        if ($numero <= 2600550) return '11ª Classe';
        if ($numero <= 2600600) return '12ª Classe';
        if ($numero <= 2600650) return '13ª Classe';
        
        return '1ª Classe';
    }
}