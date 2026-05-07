<?php

namespace App\Services;

use App\Models\Matricula;
use App\Models\Aluno;
use App\Models\User;
use App\Models\Turma;
use App\Models\AnoLectivo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class MatriculaService
{
    /**
     * Realiza a matrícula de um aluno
     * 
     * @param array $data
     * @return Matricula
     * @throws \Exception
     */
    public static function matricular(array $data): Matricula
    {
        return DB::transaction(function () use ($data) {
            
            // 1. Verificar se o aluno existe
            $aluno = Aluno::find($data['aluno_id']);
            if (!$aluno) {
                throw new \Exception('Aluno não encontrado.');
            }
            
            // 2. Verificar se o ano lectivo existe e está activo
            $anoLectivo = AnoLectivo::find($data['ano_lectivo_id']);
            if (!$anoLectivo) {
                throw new \Exception('Ano lectivo não encontrado.');
            }
            
            // 3. VERIFICAR MATRÍCULA DUPLICADA
            $matriculaExistente = Matricula::where('aluno_id', $aluno->id)
                ->where('ano_lectivo_id', $anoLectivo->id)
                ->first();
            
            if ($matriculaExistente) {
                Notification::make()
                    ->title('❌ Matrícula duplicada')
                    ->body("O aluno {$aluno->nome_completo} já está matriculado no ano lectivo {$anoLectivo->ano}.")
                    ->danger()
                    ->send();
                
                throw new \Exception('Aluno já matriculado neste ano lectivo.');
            }
            
            // 4. VERIFICAR VAGAS NA TURMA
            $turma = Turma::find($data['turma_id']);
            if (!$turma) {
                throw new \Exception('Turma não encontrada.');
            }
            
            $vagasOcupadas = Matricula::where('turma_id', $turma->id)
                ->where('ano_lectivo_id', $anoLectivo->id)
                ->where('situacao', 'ativa')
                ->count();
            
            if ($vagasOcupadas >= $turma->capacidade_maxima) {
                Notification::make()
                    ->title('❌ Turma sem vagas')
                    ->body("A turma {$turma->nome} está lotada. Capacidade máxima: {$turma->capacidade_maxima} alunos.")
                    ->danger()
                    ->send();
                
                throw new \Exception('Turma sem vagas disponíveis.');
            }
            
            // 5. GERAR NÚMERO DE MATRÍCULA
            $numeroMatricula = self::gerarNumeroMatricula($aluno, $anoLectivo);
            
            // 6. CRIAR MATRÍCULA
            $matricula = Matricula::create([
                'numero_matricula' => $numeroMatricula,
                'aluno_id'         => $aluno->id,
                'turma_id'         => $turma->id,
                'ano_lectivo_id'   => $anoLectivo->id,
                'data_matricula'   => $data['data_matricula'] ?? now(),
                'tipo'             => $data['tipo'] ?? 'nova',
                'situacao'         => $data['situacao'] ?? 'ativa',
                'observacoes'      => $data['observacoes'] ?? null,
            ]);
            
            // 7. ATUALIZAR SITUAÇÃO DO ALUNO para activo
            if ($aluno->situacao !== 'activo') {
                $aluno->update(['situacao' => 'activo']);
            }
            
            // 8. ATUALIZAR VAGAS OCUPADAS DA TURMA
            $turma->increment('vagas_ocupadas');
            
            // 9. CRIAR CONTA DE USUÁRIO PARA O ALUNO
            self::criarContaUsuario($aluno);
            
            // 10. NOTIFICAÇÃO DE SUCESSO
            Notification::make()
                ->title('✅ Matrícula realizada com sucesso!')
                ->body("Aluno {$aluno->nome_completo} matriculado na turma {$turma->nome}.")
                ->success()
                ->send();
            
            return $matricula;
        });
    }
    
    /**
     * Cancela uma matrícula
     */
    public static function cancelarMatricula(Matricula $matricula): bool
    {
        return DB::transaction(function () use ($matricula) {
            
            $aluno = $matricula->aluno;
            $turma = $matricula->turma;
            
            // Atualizar situação da matrícula
            $matricula->update(['situacao' => 'cancelada']);
            
            // Liberar vaga na turma
            if ($turma) {
                $turma->decrement('vagas_ocupadas');
            }
            
            // Verificar se o aluno tem outras matrículas ativas
            $outrasMatriculas = Matricula::where('aluno_id', $aluno->id)
                ->where('id', '!=', $matricula->id)
                ->where('situacao', 'ativa')
                ->exists();
            
            // Se não tiver outras matrículas ativas, desativar o aluno
            if (!$outrasMatriculas && $aluno) {
                $aluno->update(['situacao' => 'inactivo']);
            }
            
            Notification::make()
                ->title('✅ Matrícula cancelada')
                ->body("A matrícula de {$aluno->nome_completo} foi cancelada.")
                ->success()
                ->send();
            
            return true;
        });
    }
    
    /**
     * Gera número de matrícula único
     */
    private static function gerarNumeroMatricula(Aluno $aluno, AnoLectivo $anoLectivo): string
    {
        $ano = substr($anoLectivo->ano, 0, 4); // Pega o primeiro ano do lectivo
        $sequencial = str_pad($aluno->id, 5, '0', STR_PAD_LEFT);
        
        return "MAT-{$ano}-{$sequencial}";
    }
    
    /**
     * Cria conta de usuário para o aluno
     * Email: processo@escola.ao
     * Senha: processo
     */
    private static function criarContaUsuario(Aluno $aluno): void
    {
        $email = $aluno->processo . '@escola.ao';
        $senha = $aluno->processo;
        
        // Verificar se o usuário já existe
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            // Atualizar usuário existente
            $existingUser->update([
                'name' => $aluno->nome_completo,
                'email' => $email,
                'password' => Hash::make($senha),
                'role' => 'aluno',
                'aluno_id' => $aluno->id,
                'email_verified_at' => now(),
            ]);
        } else {
            // Criar novo usuário
            User::create([
                'name' => $aluno->nome_completo,
                'email' => $email,
                'password' => Hash::make($senha),
                'role' => 'aluno',
                'aluno_id' => $aluno->id,
                'email_verified_at' => now(),
            ]);
        }
    }
    
    /**
     * Verifica se um aluno já está matriculado no ano lectivo
     */
    public static function alunoJaMatriculado(int $alunoId, int $anoLectivoId): bool
    {
        return Matricula::where('aluno_id', $alunoId)
            ->where('ano_lectivo_id', $anoLectivoId)
            ->whereIn('situacao', ['ativa', 'pendente'])
            ->exists();
    }
    
    /**
     * Obtém o número de vagas disponíveis numa turma
     */
    public static function vagasDisponiveis(int $turmaId, int $anoLectivoId): int
    {
        $turma = Turma::find($turmaId);
        if (!$turma) {
            return 0;
        }
        
        $ocupadas = Matricula::where('turma_id', $turmaId)
            ->where('ano_lectivo_id', $anoLectivoId)
            ->where('situacao', 'ativa')
            ->count();
        
        return max(0, $turma->capacidade_maxima - $ocupadas);
    }
}