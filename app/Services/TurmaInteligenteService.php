<?php

namespace App\Services;

use App\Models\Turma;
use App\Models\NivelEnsino;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TurmaInteligenteService
{
    /**
     * Criar turma inteligente
     */
    public function criarTurma(array $data): Turma
    {
        return DB::transaction(function () use ($data) {

            //  Validação obrigatória
            if (empty($data['nivel_ensino_id']) || empty($data['ano_lectivo_id'])) {
                throw ValidationException::withMessages([
                    'erro' => 'Nível de ensino e ano lectivo são obrigatórios.'
                ]);
            }

            $nivelEnsino = NivelEnsino::findOrFail($data['nivel_ensino_id']);

            // Nome automático
            $nome = $data['nome'] ?? $this->gerarNomeTurma($data, $nivelEnsino);

            // Evitar duplicação
            if (Turma::where('nome', $nome)
                ->where('ano_lectivo_id', $data['ano_lectivo_id'])
                ->exists()) {

                throw ValidationException::withMessages([
                    'nome' => "Já existe uma turma com o nome {$nome}"
                ]);
            }

            return Turma::create([
                'nome'                   => $nome,
                'nivel_ensino_id'        => $data['nivel_ensino_id'],
                'curso_id'               => $data['curso_id'] ?? null,
                'sala_id'                => $data['sala_id'] ?? null,
                'turno'                  => $data['turno'] ?? 'manha',
                'ano_lectivo_id'         => $data['ano_lectivo_id'],
                'professor_principal_id' => $data['professor_principal_id'] ?? null,
                'capacidade_maxima'      => $data['capacidade_maxima'] ?? 40,
                'vagas_ocupadas'         => 0,
                'estado'                 => 'ativa',
            ]);
        });
    }

    /**
     * Gerar nome inteligente
     */
    private function gerarNomeTurma(array $data, NivelEnsino $nivelEnsino): string
    {
        $count = Turma::where('nivel_ensino_id', $data['nivel_ensino_id'])
            ->where('ano_lectivo_id', $data['ano_lectivo_id'])
            ->count();

        $letra = $this->gerarLetraTurma($count);

        $classe = $nivelEnsino->classe_inicio;

        $turno = match ($data['turno'] ?? 'manha') {
            'manha' => 'Manhã',
            'tarde' => 'Tarde',
            'noite' => 'Noite',
            default => 'Manhã',
        };

        return "{$classe}ª {$letra} - {$turno}";
    }

    /**
     * Geração de letras avançada (A, B... Z, AA, AB...)
     */
    private function gerarLetraTurma(int $index): string
    {
        $result = '';
        do {
            $result = chr(65 + ($index % 26)) . $result;
            $index = intdiv($index, 26) - 1;
        } while ($index >= 0);

        return $result;
    }

    /**
     * Encontrar turma com vagas (com lock)
     */
    public function encontrarTurmaComVagas(array $filtros): ?Turma
    {
        return DB::transaction(function () use ($filtros) {

            return Turma::where('nivel_ensino_id', $filtros['nivel_ensino_id'])
                ->where('turno', $filtros['turno'] ?? 'manha')
                ->where('ano_lectivo_id', $filtros['ano_lectivo_id'])
                ->where('estado', 'ativa')
                ->whereColumn('vagas_ocupadas', '<', 'capacidade_maxima')
                ->lockForUpdate() // 🔒 EVITA BUG DE CONCORRÊNCIA
                ->orderBy('vagas_ocupadas')
                ->first();
        });
    }

    /**
     * Verifica se turma está lotada
     */
    public function turmaLotada(Turma $turma): bool
    {
        return $turma->vagas_ocupadas >= $turma->capacidade_maxima;
    }

    /**
     * Vagas disponíveis
     */
    public function vagasDisponiveis(Turma $turma): int
    {
        return max(0, $turma->capacidade_maxima - $turma->vagas_ocupadas);
    }

    /**
     * Incrementar vagas com segurança
     */
    public function incrementarVagas(Turma $turma): void
    {
        DB::transaction(function () use ($turma) {

            $turma->refresh();

            if ($this->turmaLotada($turma)) {
                throw ValidationException::withMessages([
                    'turma' => 'Turma já está lotada.'
                ]);
            }

            $turma->increment('vagas_ocupadas');
        });
    }

    /**
     * Listar turmas por nível
     */
    public function listarPorNivel(): array
    {
        return NivelEnsino::with(['turmas' => function ($q) {
            $q->where('estado', 'ativa')
              ->orderBy('nome');
        }])->get()->toArray();
    }

    /**
     * Criar turmas em massa
     */
    public function gerarTurmasPadrao(int $nivelEnsinoId, int $anoLectivoId, int $quantidade = 3): array
    {
        $turmas = [];
        $turnos = ['manha', 'tarde', 'noite'];

        for ($i = 0; $i < $quantidade; $i++) {
            $turmas[] = $this->criarTurma([
                'nivel_ensino_id' => $nivelEnsinoId,
                'ano_lectivo_id'  => $anoLectivoId,
                'turno'           => $turnos[$i % 3],
                'capacidade_maxima' => 40,
            ]);
        }

        return $turmas;
    }
}