<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Turma;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Disciplina;
use App\Models\Material;
use App\Models\Avaliacao;
use App\Models\Questao;
use App\Models\Tarefa;
use App\Models\Entrega;
use App\Models\Conversa;
use App\Models\Mensagem;
use App\Models\Notificacao;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfessorController extends Controller
{
    /**
     * Dashboard do Professor
     */
    public function dashboard()
    {
        $user = Auth::user();
        $professorId = $user->professor_id;
        
        $turmas = Turma::where('professor_principal_id', $professorId)
                       ->withCount(['matriculas' => function($q) {
                           $q->where('situacao', 'ativa');
                       }])
                       ->get();
        
        $totalAlunos = $turmas->sum('matriculas_count');
        $totalTurmas = $turmas->count();
        
        $totalTarefasPendentes = Tarefa::whereIn('turma_id', $turmas->pluck('id'))
                                       ->where('data_entrega', '>=', now())
                                       ->where('publicado', true)
                                       ->count();
        
        return view('professor.dashboard', compact('user', 'turmas', 'totalAlunos', 'totalTurmas', 'totalTarefasPendentes'));
    }
    
    /**
     * Lista de Turmas do Professor
     */
    public function minhasTurmas()
    {
        $user = Auth::user();
        $professorId = $user->professor_id;
        
        $turmas = Turma::where('professor_principal_id', $professorId)
                       ->withCount(['matriculas' => function($q) {
                           $q->where('situacao', 'ativa');
                       }])
                       ->get();
        
        return view('professor.turmas', compact('user', 'turmas'));
    }
    
    /**
     * Lançar Notas com disciplina e trimestre
     */
    public function lancarNotas($turmaId, $trimestre = null, Request $request = null)
    {
        $turma = Turma::findOrFail($turmaId);
        
        if ($trimestre === null) {
            $trimestre = 1;
        }
        $trimestre = (int) $trimestre;
        
        // Buscar ano lectivo da turma (através da primeira matrícula)
        $primeiraMatricula = Matricula::where('turma_id', $turmaId)->first();
        $anoLectivo = $primeiraMatricula?->anoLectivo?->ano ?? date('Y');
        
        // Buscar disciplinas da turma
        $disciplinas = collect();
        
        try {
            if ($turma->classe_id) {
                $disciplinas = Disciplina::whereHas('classes', function($q) use ($turma) {
                    $q->where('classe_id', $turma->classe_id);
                })->get();
            }
            
            if ($disciplinas->isEmpty()) {
                $disciplinas = Disciplina::all();
            }
            
            if ($disciplinas->isEmpty()) {
                $disciplinas = collect([
                    (object) ['id' => 1, 'nome' => 'Matemática'],
                    (object) ['id' => 2, 'nome' => 'Português'],
                    (object) ['id' => 3, 'nome' => 'Ciências'],
                ]);
            }
        } catch (\Exception $e) {
            $disciplinas = collect([
                (object) ['id' => 1, 'nome' => 'Matemática'],
                (object) ['id' => 2, 'nome' => 'Português'],
                (object) ['id' => 3, 'nome' => 'Ciências'],
            ]);
        }
        
        // Disciplina selecionada
        $disciplinaId = 1;
        $disciplinaSelecionada = null;
        
        if ($request && $request->get('disciplina_id')) {
            $disciplinaId = $request->get('disciplina_id');
        } elseif ($disciplinas->isNotEmpty() && $disciplinas->first()) {
            $disciplinaId = $disciplinas->first()->id;
        }
        
        $disciplinaSelecionada = $disciplinas->firstWhere('id', $disciplinaId);
        
        if (!$disciplinaSelecionada && $disciplinas->isNotEmpty()) {
            $disciplinaId = $disciplinas->first()->id;
            $disciplinaSelecionada = $disciplinas->first();
        }
        
        $matriculas = Matricula::where('turma_id', $turmaId)
                              ->where('situacao', 'ativa')
                              ->with(['aluno', 'notas' => function($q) use ($trimestre, $disciplinaId) {
                                  $q->where('trimestre', $trimestre)
                                    ->where('disciplina_id', $disciplinaId);
                              }])
                              ->get();
        
        return view('professor.notas', compact('turma', 'matriculas', 'trimestre', 'disciplinas', 'disciplinaId', 'disciplinaSelecionada', 'anoLectivo'));
    }
    
    /**
     * Salvar Notas
     */
    public function salvarNotas(Request $request)
    {
        $request->validate([
            'turma_id' => 'required|exists:turmas,id',
            'trimestre' => 'required|in:1,2,3',
            'disciplina_id' => 'required|exists:disciplinas,id',
            'notas' => 'required|array',
            'notas.*.avaliacao_continua' => 'nullable|numeric|min:0|max:20',
            'notas.*.prova_trimestral' => 'nullable|numeric|min:0|max:20',
            'notas.*.exame_final' => 'nullable|numeric|min:0|max:20',
            'notas.*.faltas' => 'nullable|integer|min:0',
        ]);
        
        foreach($request->notas as $matriculaId => $dados) {
            Nota::updateOrCreate(
                [
                    'matricula_id' => $matriculaId,
                    'disciplina_id' => $request->disciplina_id,
                    'trimestre' => $request->trimestre,
                ],
                [
                    'avaliacao_continua' => $dados['avaliacao_continua'] ?? null,
                    'prova_trimestral' => $dados['prova_trimestral'] ?? null,
                    'exame_final' => $dados['exame_final'] ?? null,
                    'faltas' => $dados['faltas'] ?? 0,
                ]
            );
        }
        
        return redirect()->back()->with('success', 'Notas salvas com sucesso!');
    }
    
    /**
     * Salvar Notas via AJAX (Auto-save)
     */
    public function salvarNotasAjax(Request $request)
    {
        try {
            $request->validate([
                'turma_id' => 'required|exists:turmas,id',
                'trimestre' => 'required|in:1,2,3',
                'disciplina_id' => 'required|exists:disciplinas,id',
                'notas' => 'required|array',
            ]);
            
            foreach($request->notas as $matriculaId => $dados) {
                Nota::updateOrCreate(
                    [
                        'matricula_id' => $matriculaId,
                        'disciplina_id' => $request->disciplina_id,
                        'trimestre' => $request->trimestre,
                    ],
                    [
                        'avaliacao_continua' => $dados['avaliacao_continua'] ?? null,
                        'prova_trimestral' => $dados['prova_trimestral'] ?? null,
                        'exame_final' => $dados['exame_final'] ?? null,
                        'faltas' => $dados['faltas'] ?? 0,
                    ]
                );
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // ==================== MATERIAIS ====================
    
    public function materiais($turmaId)
    {
        $turma = Turma::findOrFail($turmaId);
        $materiais = Material::where('turma_id', $turmaId)
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('professor.materiais', compact('turma', 'materiais'));
    }
    
    public function criarMaterial($turmaId)
    {
        $turma = Turma::findOrFail($turmaId);
        return view('professor.criar-material', compact('turma'));
    }
    
    public function salvarMaterial(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'nullable',
            'arquivo' => 'required|file|max:10240',
            'turma_id' => 'required'
        ]);
        
        $arquivo = $request->file('arquivo');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
        $caminho = $arquivo->storeAs('materiais', $nomeArquivo, 'public');
        
        Material::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'arquivo' => $caminho,
            'tipo' => $arquivo->getClientOriginalExtension(),
            'turma_id' => $request->turma_id,
            'professor_id' => Auth::user()->professor_id,
            'visualizacoes' => 0,
            'downloads' => 0
        ]);
        
        return redirect()->route('professor.materiais', $request->turma_id)
                         ->with('success', 'Material enviado com sucesso!');
    }
    
    public function downloadMaterial($id)
    {
        $material = Material::findOrFail($id);
        
        if (!Storage::disk('public')->exists($material->arquivo)) {
            Storage::disk('public')->put($material->arquivo, 'Conteúdo do material didático - Colégio Gênesis');
        }
        
        $material->increment('downloads');
        
        return Storage::disk('public')->download($material->arquivo);
    }
    
    public function deletarMaterial($id)
    {
        $material = Material::findOrFail($id);
        Storage::disk('public')->delete($material->arquivo);
        $material->delete();
        
        return redirect()->back()->with('success', 'Material removido!');
    }
    
    // ==================== AVALIAÇÕES ====================
    
    public function avaliacoes($turmaId)
    {
        $turma = Turma::findOrFail($turmaId);
        $avaliacoes = Avaliacao::where('turma_id', $turmaId)
                               ->orderBy('created_at', 'desc')
                               ->get();
        return view('professor.avaliacoes', compact('turma', 'avaliacoes'));
    }
    
    public function criarAvaliacao($turmaId)
    {
        $turma = Turma::findOrFail($turmaId);
        return view('professor.criar-avaliacao', compact('turma'));
    }
    
    public function salvarAvaliacao(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'tipo' => 'required',
            'data_entrega' => 'required|date',
            'pontuacao_maxima' => 'required|integer',
            'arquivo' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
        ]);

        $dados = [
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo,
            'turma_id' => $request->turma_id,
            'professor_id' => Auth::user()->professor_id,
            'data_entrega' => $request->data_entrega,
            'duracao' => $request->duracao,
            'pontuacao_maxima' => $request->pontuacao_maxima,
            'publicado' => $request->has('publicado')
        ];

        if ($request->hasFile('arquivo')) {
            $arquivo = $request->file('arquivo');
            $nomeArquivo = time() . '_avaliacao_' . $arquivo->getClientOriginalName();
            $caminho = $arquivo->storeAs('avaliacoes', $nomeArquivo, 'public');
            $dados['arquivo'] = $caminho;
        }

        Avaliacao::create($dados);

        return redirect()->route('professor.avaliacoes', $request->turma_id)
                         ->with('success', 'Avaliação criada com sucesso!');
    }

    public function editarAvaliacao($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        return view('professor.editar-avaliacao', compact('avaliacao'));
    }

    public function atualizarAvaliacao(Request $request, $id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        
        $request->validate([
            'titulo' => 'required|max:255',
            'tipo' => 'required',
            'data_entrega' => 'required|date',
            'pontuacao_maxima' => 'required|integer'
        ]);

        $avaliacao->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo,
            'data_entrega' => $request->data_entrega,
            'duracao' => $request->duracao,
            'pontuacao_maxima' => $request->pontuacao_maxima,
            'publicado' => $request->has('publicado')
        ]);

        return redirect()->route('professor.avaliacoes', $avaliacao->turma_id)
                        ->with('success', 'Avaliação atualizada!');
    }

    public function deletarAvaliacao($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        $turmaId = $avaliacao->turma_id;
        $avaliacao->delete();

        return redirect()->route('professor.avaliacoes', $turmaId)
                        ->with('success', 'Avaliação removida!');
    }
    
    public function questoes($avaliacaoId)
    {
        $avaliacao = Avaliacao::with('questoes')->findOrFail($avaliacaoId);
        return view('professor.questoes', compact('avaliacao'));
    }

    public function salvarQuestao(Request $request)
    {
        $request->validate([
            'avaliacao_id' => 'required',
            'pergunta' => 'required',
            'tipo' => 'required',
            'pontos' => 'required|integer'
        ]);

        Questao::create([
            'avaliacao_id' => $request->avaliacao_id,
            'pergunta' => $request->pergunta,
            'tipo' => $request->tipo,
            'opcoes' => $request->opcoes ? json_encode(explode("\n", $request->opcoes)) : null,
            'resposta_correta' => $request->resposta_correta,
            'pontos' => $request->pontos
        ]);

        return redirect()->back()->with('success', 'Questão adicionada!');
    }

    public function deletarQuestao($id)
    {
        $questao = Questao::findOrFail($id);
        $avaliacaoId = $questao->avaliacao_id;
        $questao->delete();

        return redirect()->route('professor.questoes', $avaliacaoId)
                        ->with('success', 'Questão removida!');
    }
    
    // ==================== TAREFAS ====================
    
    public function tarefas($turmaId)
    {
        $turma = Turma::findOrFail($turmaId);
        $tarefas = Tarefa::where('turma_id', $turmaId)
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        return view('professor.tarefas', compact('turma', 'tarefas'));
    }
    
    public function criarTarefa($turmaId)
    {
        $turma = Turma::findOrFail($turmaId);
        return view('professor.criar-tarefa', compact('turma'));
    }
    
    public function salvarTarefa(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'data_entrega' => 'required|date',
            'pontuacao_maxima' => 'required|integer',
            'arquivo' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
        ]);

        $dados = [
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'turma_id' => $request->turma_id,
            'professor_id' => Auth::user()->professor_id,
            'data_entrega' => $request->data_entrega,
            'pontuacao_maxima' => $request->pontuacao_maxima,
            'publicado' => $request->has('publicado')
        ];

        if ($request->hasFile('arquivo')) {
            $arquivo = $request->file('arquivo');
            $nomeArquivo = time() . '_tarefa_' . $arquivo->getClientOriginalName();
            $caminho = $arquivo->storeAs('tarefas', $nomeArquivo, 'public');
            $dados['arquivo'] = $caminho;
        }

        Tarefa::create($dados);

        return redirect()->route('professor.tarefas', $request->turma_id)
                         ->with('success', 'Tarefa criada com sucesso!');
    }
    
    public function editarTarefa($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        return view('professor.editar-tarefa', compact('tarefa'));
    }

    public function atualizarTarefa(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        
        $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'data_entrega' => 'required|date',
            'pontuacao_maxima' => 'required|integer'
        ]);

        $tarefa->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_entrega' => $request->data_entrega,
            'pontuacao_maxima' => $request->pontuacao_maxima,
            'publicado' => $request->has('publicado')
        ]);

        return redirect()->route('professor.tarefas', $tarefa->turma_id)
                         ->with('success', 'Tarefa atualizada com sucesso!');
    }
    
    public function deletarTarefa($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $turmaId = $tarefa->turma_id;
        
        $tarefa->entregas()->delete();
        $tarefa->delete();
        
        return redirect()->route('professor.tarefas', $turmaId)
                         ->with('success', 'Tarefa removida com sucesso!');
    }
    
    public function entregas($tarefaId)
    {
        $tarefa = Tarefa::with(['entregas.aluno'])->findOrFail($tarefaId);
        $entregas = $tarefa->entregas;
        
        return view('professor.entregas', compact('tarefa', 'entregas'));
    }

    public function corrigirEntrega(Request $request, $entregaId)
    {
        $request->validate([
            'nota' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);
        
        $entrega = Entrega::findOrFail($entregaId);
        $entrega->update([
            'nota' => $request->nota,
            'feedback' => $request->feedback,
            'status' => 'corrigido'
        ]);
        
        return redirect()->back()->with('success', 'Entrega corrigida com sucesso!');
    }
    
    // ==================== ALUNOS POR TURMA ====================
    
    public function verAlunos($turmaId)
    {
        $turma = Turma::with(['alunos'])->findOrFail($turmaId);
        $alunos = $turma->alunos;
        
        return view('professor.alunos-turma', compact('turma', 'alunos'));
    }

    public function downloadAlunosPDF($turmaId)
    {
        $turma = Turma::with(['alunos'])->findOrFail($turmaId);
        $alunos = $turma->alunos;
        
        $pdf = Pdf::loadView('pdf.alunos-turma', compact('turma', 'alunos'));
        return $pdf->download('alunos_turma_' . $turma->nome . '.pdf');
    }
    
    // ==================== MENSAGENS ====================
    
    public function mensagens()
    {
        $user = auth()->user();
        $conversas = Conversa::where('user_1_id', $user->id)
                            ->orWhere('user_2_id', $user->id)
                            ->orderBy('ultima_mensagem', 'desc')
                            ->get();
        
        return view('professor.mensagens', compact('conversas'));
    }

    public function conversa($id)
    {
        $user = auth()->user();
        $conversa = Conversa::findOrFail($id);
        
        if ($conversa->user_1_id != $user->id && $conversa->user_2_id != $user->id) {
            abort(403);
        }
        
        Mensagem::where('conversa_id', $id)
                ->where('user_id', '!=', $user->id)
                ->where('lida', false)
                ->update(['lida' => true, 'lida_em' => now()]);
        
        $mensagens = Mensagem::where('conversa_id', $id)->orderBy('created_at')->get();
        $outroUser = $conversa->user_1_id == $user->id ? $conversa->user2 : $conversa->user1;
        
        return view('professor.conversa', compact('conversa', 'mensagens', 'outroUser'));
    }

    public function enviarMensagem(Request $request)
    {
        $request->validate([
            'conversa_id' => 'required',
            'mensagem' => 'required|max:1000'
        ]);
        
        $user = auth()->user();
        
        $mensagem = Mensagem::create([
            'conversa_id' => $request->conversa_id,
            'user_id' => $user->id,
            'mensagem' => $request->mensagem,
            'lida' => false
        ]);
        
        Conversa::where('id', $request->conversa_id)->update(['ultima_mensagem' => now()]);
        
        $conversa = Conversa::find($request->conversa_id);
        $outroUserId = $conversa->user_1_id == $user->id ? $conversa->user_2_id : $conversa->user_1_id;
        
        Notificacao::create([
            'user_id' => $outroUserId,
            'titulo' => 'Nova mensagem de ' . $user->name,
            'mensagem' => substr($request->mensagem, 0, 100),
            'tipo' => 'info',
            'link' => '/aluno/mensagens/conversa/' . $request->conversa_id
        ]);
        
        return redirect()->back()->with('success', 'Mensagem enviada!');
    }

    public function novaConversa(Request $request)
    {
        $user = auth()->user();
        $outroUserId = $request->user_id;
        
        $conversa = Conversa::where(function($q) use ($user, $outroUserId) {
            $q->where('user_1_id', $user->id)->where('user_2_id', $outroUserId);
        })->orWhere(function($q) use ($user, $outroUserId) {
            $q->where('user_1_id', $outroUserId)->where('user_2_id', $user->id);
        })->first();
        
        if (!$conversa) {
            $conversa = Conversa::create([
                'user_1_id' => $user->id,
                'user_2_id' => $outroUserId,
                'ultima_mensagem' => now()
            ]);
        }
        
        return redirect()->route('professor.conversa', $conversa->id);
    }

    public function buscarAlunosTurma()
    {
        $user = auth()->user();
        $professorId = $user->professor_id;
        
        $turmas = Turma::where('professor_principal_id', $professorId)->pluck('id');
        
        if ($turmas->isEmpty()) {
            return response()->json([]);
        }
        
        $alunos = \App\Models\Aluno::whereHas('matriculas', function($q) use ($turmas) {
            $q->whereIn('turma_id', $turmas)->where('situacao', 'ativa');
        })->get();
        
        $resultados = [];
        foreach($alunos as $aluno) {
            $userAluno = \App\Models\User::where('aluno_id', $aluno->id)->first();
            if ($userAluno) {
                $resultados[] = [
                    'id' => $userAluno->id,
                    'name' => $aluno->nome_completo,
                    'email' => $userAluno->email
                ];
            }
        }
        
        return response()->json($resultados);
    }
    
    // ==================== NOTIFICAÇÕES ====================
    
    public function notificacoesLista()
    {
        $user = auth()->user();
        $notificacoes = Notificacao::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        return view('professor.notificacoes', compact('notificacoes'));
    }

    public function mensagensCount()
    {
        $user = auth()->user();
        $count = Mensagem::whereHas('conversa', function($q) use ($user) {
            $q->where('user_1_id', $user->id)->orWhere('user_2_id', $user->id);
        })->where('user_id', '!=', $user->id)->where('lida', false)->count();
        
        return response()->json(['count' => $count]);
    }

    public function notificacoesCount()
    {
        $user = auth()->user();
        $count = Notificacao::where('user_id', $user->id)->where('lida', false)->count();
        
        return response()->json(['count' => $count]);
    }

    public function marcarNotificacaoLida($id)
    {
        $notificacao = Notificacao::findOrFail($id);
        if ($notificacao->user_id == auth()->id()) {
            $notificacao->update(['lida' => true]);
        }
        return response()->json(['success' => true]);
    }

    public function marcarTodasNotificacoes()
    {
        Notificacao::where('user_id', auth()->id())->where('lida', false)->update(['lida' => true]);
        return response()->json(['success' => true]);
    }
}