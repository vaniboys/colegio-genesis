<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Material;
use App\Models\Tarefa;
use App\Models\Comunicado;
use App\Models\Entrega;
use App\Models\Conversa;
use App\Models\Mensagem;
use App\Models\Notificacao;
use App\Models\Aluno;
use App\Models\Livro;
use Barryvdh\DomPDF\Facade\Pdf;

class AlunoController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        $matricula = Matricula::where('aluno_id', $aluno->id ?? 0)
                              ->where('situacao', 'ativa')
                              ->with(['turma', 'anoLectivo'])
                              ->first();
        
        $turma = $matricula->turma ?? null;
        
        $notas = collect();
        $mediaGeral = 0;
        $totalFaltas = 0;
        $ultimasNotas = collect();
        $proximasTarefas = collect();
        $tarefasPendentes = 0;
        $comunicadosNaoLidos = 0;
        $ultimosComunicados = collect();
        
        if ($matricula) {
            $notas = Nota::where('matricula_id', $matricula->id)
                        ->with('disciplina')
                        ->get();
            $mediaGeral = $notas->avg('media_trimestral') ?? 0;
            $totalFaltas = $notas->sum('faltas');
            $ultimasNotas = $notas->take(5);
            
            $proximasTarefas = Tarefa::where('turma_id', $matricula->turma_id)
                                     ->where('publicado', true)
                                     ->where('data_entrega', '>=', now())
                                     ->orderBy('data_entrega', 'asc')
                                     ->limit(3)
                                     ->get();
            $tarefasPendentes = Tarefa::where('turma_id', $matricula->turma_id)
                                      ->where('publicado', true)
                                      ->where('data_entrega', '>=', now())
                                      ->count();
            
            $ultimosComunicados = Comunicado::where('turma_id', $matricula->turma_id)
                                            ->orWhere('para_todos', true)
                                            ->orderBy('created_at', 'desc')
                                            ->limit(3)
                                            ->get();
            $comunicadosNaoLidos = Comunicado::where(function($q) use ($matricula) {
                                                $q->where('turma_id', $matricula->turma_id)
                                                  ->orWhere('para_todos', true);
                                            })->count();
        }
        
        return view('aluno.dashboard', compact('aluno', 'matricula', 'turma', 'notas', 'mediaGeral', 
                                               'totalFaltas', 'ultimasNotas', 'tarefasPendentes', 
                                               'comunicadosNaoLidos', 'ultimosComunicados', 'proximasTarefas'));
    }
    
    public function boletim(Request $request)
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        $trimestre = $request->get('trimestre', 1);
        
        $matricula = Matricula::where('aluno_id', $aluno->id ?? 0)
                              ->where('situacao', 'ativa')
                              ->with('turma')
                              ->first();
        
        $turma = $matricula->turma ?? null;
        
        if (!$matricula) {
            return redirect()->route('aluno.dashboard')->with('error', 'Nenhuma matrícula ativa encontrada.');
        }
        
        $notas = Nota::where('matricula_id', $matricula->id)
                    ->where('trimestre', $trimestre)
                    ->with('disciplina')
                    ->get();
        
        $mediaGeral = $notas->avg('media_trimestral') ?? 0;
        
        return view('aluno.boletim', compact('aluno', 'turma', 'matricula', 'notas', 'mediaGeral', 'trimestre'));
    }
    
    public function notas(Request $request)
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        $trimestre = $request->get('trimestre', 1);
        
        $matricula = Matricula::where('aluno_id', $aluno->id ?? 0)
                              ->where('situacao', 'ativa')
                              ->with(['turma', 'turma.disciplinas', 'anoLectivo'])
                              ->first();
        
        $turma = $matricula->turma ?? null;
        $anoLectivo = $matricula->anoLectivo->ano ?? date('Y');
        
        $disciplinas = collect();
        if ($turma) {
            $disciplinas = $turma->disciplinas()
                ->withPivot('carga_horaria_semanal', 'obrigatoria', 'professor_id')
                ->get();
        }
        
        $notas = collect();
        if ($matricula) {
            $notas = Nota::where('matricula_id', $matricula->id)
                        ->where('trimestre', $trimestre)
                        ->with('disciplina')
                        ->get();
        }
        
        return view('aluno.notas', compact('aluno', 'turma', 'disciplinas', 'notas', 'trimestre', 'anoLectivo'));
    }
    
    public function minhasDisciplinas()
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        $matricula = Matricula::where('aluno_id', $aluno->id ?? 0)
                              ->where('situacao', 'ativa')
                              ->with('turma.disciplinas')
                              ->first();
        
        $disciplinas = collect();
        
        if ($matricula && $matricula->turma) {
            $disciplinas = $matricula->turma->disciplinas()
                ->withPivot('carga_horaria_semanal', 'obrigatoria', 'professor_id')
                ->get();
        }
        
        return view('aluno.minhas-disciplinas', compact('disciplinas'));
    }
    
    public function materiais()
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        $materiais = collect();
        
        if ($aluno) {
            $matricula = Matricula::where('aluno_id', $aluno->id)
                                  ->where('situacao', 'ativa')
                                  ->first();
            
            if ($matricula) {
                $materiais = Material::where('turma_id', $matricula->turma_id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            }
        }
        
        return view('aluno.materiais', compact('materiais'));
    }
    
    public function downloadMaterial($id)
    {
        $material = Material::findOrFail($id);
        $material->increment('downloads');
        
        $filePath = storage_path('app/public/' . $material->arquivo);
        
        if (!file_exists($filePath)) {
            $conteudo = "Material: " . $material->titulo . "\n\nConteúdo do material didático.";
            file_put_contents($filePath, $conteudo);
        }
        
        return response()->download($filePath, $material->titulo . '.' . $material->tipo);
    }
    
    public function tarefas()
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        if (!$aluno) {
            return view('aluno.tarefas', ['tarefas' => collect([])]);
        }
        
        $matricula = Matricula::where('aluno_id', $aluno->id)
                              ->where('situacao', 'ativa')
                              ->first();
        
        $tarefas = collect();
        if ($matricula) {
            $tarefas = Tarefa::where('turma_id', $matricula->turma_id)
                            ->where('publicado', true)
                            ->orderBy('data_entrega', 'asc')
                            ->get();
        }
        
        return view('aluno.tarefas', compact('tarefas'));
    }
    
    public function enviarTarefa(Request $request)
    {
        $request->validate([
            'tarefa_id' => 'required',
            'arquivo' => 'required|file|max:10240'
        ]);
        
        $arquivo = $request->file('arquivo');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
        $caminho = $arquivo->storeAs('entregas', $nomeArquivo, 'public');
        
        Entrega::create([
            'tarefa_id' => $request->tarefa_id,
            'aluno_id' => auth()->user()->aluno_id,
            'arquivo' => $caminho,
            'comentario' => $request->comentario,
            'data_entrega' => now(),
            'status' => 'entregue'
        ]);
        
        return redirect()->back()->with('success', 'Tarefa enviada com sucesso!');
    }
    
    public function comunicados()
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        $matricula = Matricula::where('aluno_id', $aluno->id ?? 0)
                              ->where('situacao', 'ativa')
                              ->first();
        
        $comunicados = Comunicado::where('para_todos', true)
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        if ($matricula && $matricula->turma_id) {
            $comunicadosTurma = Comunicado::where('turma_id', $matricula->turma_id)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
            $comunicados = $comunicados->merge($comunicadosTurma)->sortByDesc('created_at');
        }
        
        return view('aluno.comunicados', compact('comunicados'));
    }

    public function mensagens()
    {
        $user = auth()->user();
        $conversas = Conversa::where('user_1_id', $user->id)
                             ->orWhere('user_2_id', $user->id)
                             ->orderBy('ultima_mensagem', 'desc')
                             ->get();
        
        return view('aluno.mensagens', compact('conversas'));
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
        
        return view('aluno.conversa', compact('conversa', 'mensagens', 'outroUser'));
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
            'link' => $user->role == 'aluno' ? '/professor/mensagens/conversa/' . $request->conversa_id : '/aluno/mensagens/conversa/' . $request->conversa_id
        ]);
        
        return redirect()->back()->with('success', 'Mensagem enviada!');
    }

    public function notificacoesLista()
    {
        $user = auth()->user();
        $notificacoes = Notificacao::where('user_id', $user->id)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        
        return view('aluno.notificacoes', compact('notificacoes'));
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

    public function buscarProfessores()
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        if (!$aluno) {
            return response()->json([]);
        }
        
        $matriculas = Matricula::where('aluno_id', $aluno->id)
                               ->where('situacao', 'ativa')
                               ->with('turma.professor')
                               ->get();
        
        $professores = [];
        foreach($matriculas as $matricula) {
            if ($matricula->turma && $matricula->turma->professor) {
                $professor = $matricula->turma->professor;
                $professorUser = \App\Models\User::where('professor_id', $professor->id)->first();
                
                if ($professorUser) {
                    $professores[] = [
                        'id' => $professorUser->id,
                        'name' => $professor->nome_completo,
                        'email' => $professorUser->email,
                        'disciplina' => $professor->especialidade ?? 'Professor'
                    ];
                }
            }
        }
        
        $professores = collect($professores)->unique('id')->values()->all();
        return response()->json($professores);
    }
    
    public function novaConversa(Request $request)
    {
        $user = auth()->user();
        $professorId = $request->professor_id;
        
        $conversa = Conversa::where(function($q) use ($user, $professorId) {
            $q->where('user_1_id', $user->id)->where('user_2_id', $professorId);
        })->orWhere(function($q) use ($user, $professorId) {
            $q->where('user_1_id', $professorId)->where('user_2_id', $user->id);
        })->first();
        
        if (!$conversa) {
            $conversa = Conversa::create([
                'user_1_id' => $user->id,
                'user_2_id' => $professorId,
                'ultima_mensagem' => now()
            ]);
        }
        
        return redirect()->route('aluno.conversa', $conversa->id);
    }

    public function boletimPDF(Request $request)
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        $trimestre = $request->get('trimestre', 1);
        
        $matricula = Matricula::where('aluno_id', $aluno->id ?? 0)
                              ->where('situacao', 'ativa')
                              ->with('turma')
                              ->first();
        
        if (!$matricula) {
            return redirect()->route('aluno.dashboard')->with('error', 'Nenhuma matrícula ativa encontrada.');
        }
        
        $turma = $matricula->turma ?? null;
        
        $notas = Nota::where('matricula_id', $matricula->id)
                    ->where('trimestre', $trimestre)
                    ->with('disciplina')
                    ->get();
        
        $mediaGeral = $notas->avg('media_trimestral') ?? 0;
        $melhorNota = $notas->max('media_trimestral') ?? 0;
        $piorNota = $notas->min('media_trimestral') ?? 0;
        $totalFaltas = $notas->sum('faltas');
        
        $data = [
            'aluno' => $aluno,
            'turma' => $turma,
            'matricula' => $matricula,
            'notas' => $notas,
            'mediaGeral' => $mediaGeral,
            'melhorNota' => $melhorNota,
            'piorNota' => $piorNota,
            'totalFaltas' => $totalFaltas,
            'trimestre' => $trimestre,
            'anoLectivo' => date('Y'),
            'dataEmissao' => now()
        ];
        
        $pdf = Pdf::loadView('pdf.boletim', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('boletim_' . ($aluno->codigo ?? $aluno->id) . '.pdf');
    }

    // ==================== HISTÓRICO ESCOLAR ====================
    
    public function historico()
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        $matriculas = Matricula::where('aluno_id', $aluno->id ?? 0)
                              ->with(['turma', 'turma.classe', 'anoLectivo', 'notas.disciplina'])
                              ->orderBy('ano_lectivo_id', 'desc')
                              ->get();
        
        $historico = [];
        $totalDisciplinas = 0;
        $totalAprovacoes = 0;
        $totalReprovacoes = 0;
        $mediaGeralHistorico = 0;
        $totalNotas = 0;
        
        foreach ($matriculas as $matricula) {
            $ano = $matricula->anoLectivo->ano ?? 'Ano não definido';
            $turma = $matricula->turma;
            
            $disciplinasNotas = [];
            foreach ($matricula->notas->groupBy('disciplina_id') as $disciplinaId => $notasDisciplina) {
                $disciplina = $notasDisciplina->first()->disciplina;
                
                $mediaFinal = $notasDisciplina->avg('media_final') ?? $notasDisciplina->avg('media_trimestral') ?? 0;
                $totalFaltas = $notasDisciplina->sum('faltas');
                $situacaoAnual = $this->calcularSituacaoAnual($notasDisciplina);
                
                if ($situacaoAnual == 'aprovado') {
                    $totalAprovacoes++;
                } elseif ($situacaoAnual == 'reprovado') {
                    $totalReprovacoes++;
                }
                
                $disciplinasNotas[] = [
                    'disciplina' => $disciplina,
                    'notas_trimestres' => [
                        '1' => $notasDisciplina->firstWhere('trimestre', 1),
                        '2' => $notasDisciplina->firstWhere('trimestre', 2),
                        '3' => $notasDisciplina->firstWhere('trimestre', 3),
                    ],
                    'media_final' => $mediaFinal,
                    'total_faltas' => $totalFaltas,
                    'situacao' => $situacaoAnual,
                ];
                
                $totalNotas++;
                $mediaGeralHistorico += $mediaFinal;
            }
            
            $situacaoAno = $this->calcularSituacaoAnualGeral($disciplinasNotas);
            
            $historico[] = [
                'ano_lectivo' => $ano,
                'ano_lectivo_id' => $matricula->ano_lectivo_id,
                'turma' => $turma,
                'disciplinas' => $disciplinasNotas,
                'media_geral' => count($disciplinasNotas) > 0 ? round($mediaGeralHistorico / count($disciplinasNotas), 1) : 0,
                'total_disciplinas' => count($disciplinasNotas),
                'situacao' => $situacaoAno,
                'data_matricula' => $matricula->data_matricula,
            ];
            
            $totalDisciplinas += count($disciplinasNotas);
        }
        
        $mediaGeralHistorico = $totalNotas > 0 ? round($mediaGeralHistorico / $totalNotas, 1) : 0;
        
        $percentagemAprovacao = $totalDisciplinas > 0 ? round(($totalAprovacoes / $totalDisciplinas) * 100, 1) : 0;
        $percentagemReprovacao = $totalDisciplinas > 0 ? round(($totalReprovacoes / $totalDisciplinas) * 100, 1) : 0;
        
        return view('aluno.historico', compact('aluno', 'historico', 'totalDisciplinas', 'totalAprovacoes', 
                                              'totalReprovacoes', 'mediaGeralHistorico', 'percentagemAprovacao', 
                                              'percentagemReprovacao'));
    }

    

// ==================== LIVROS DE APOIO ====================



    public function livros()
    {
        $user = auth()->user();
        $aluno = $user->aluno;
        
        if (!$aluno) {
            return view('aluno.livros')->with('error', 'Aluno não encontrado.');
        }
        
        $matricula = Matricula::where('aluno_id', $aluno->id)
                            ->where('situacao', 'ativa')
                            ->first();
        
        if (!$matricula) {
            return view('aluno.livros')->with('error', 'Você não está matriculado em nenhuma turma ativa.');
        }
        
        // Buscar livros APENAS da turma do aluno (usando turma_id)
        $livros = Livro::where('ativo', true)
                    ->where('turma_id', $matricula->turma_id)
                    ->with('disciplina')
                    ->get();
        
        // Agrupar por disciplina (simplificado)
        $livrosPorDisciplina = $livros->groupBy(function($livro) {
            return $livro->disciplina ? $livro->disciplina->nome : 'Materiais Gerais';
        });
        
        $classe = $matricula->turma->classe ?? null;
        
        return view('aluno.livros', compact('livros', 'livrosPorDisciplina', 'classe'));
    }

    // App\Http\Controllers\AlunoController.php

public function downloadLivro($id)
{
    $user = auth()->user();
    $aluno = $user->aluno;
    
    if (!$aluno) {
        abort(403, 'Aluno não encontrado.');
    }
    
    $livro = Livro::where('id', $id)->where('ativo', true)->firstOrFail();
    
    // Verificar se o aluno tem acesso ao livro
    $matricula = Matricula::where('aluno_id', $aluno->id)
                          ->where('situacao', 'ativa')
                          ->first();
    
    if (!$matricula) {
        abort(403, 'Você não está matriculado.');
    }
    
    $turmaId = $matricula->turma_id;
    
    // Verificar se o livro pertence à turma do aluno
    $temAcesso = ($livro->turma_id == $turmaId);
    
    if (!$temAcesso) {
        abort(403, 'Você não tem acesso a este livro.');
    }
    
    // Incrementar downloads
    $livro->increment('downloads');
    
    // Verificar se o arquivo existe
    if ($livro->arquivo_pdf && Storage::disk('public')->exists($livro->arquivo_pdf)) {
        return response()->download(Storage::disk('public')->path($livro->arquivo_pdf), $livro->titulo . '.pdf');
    }
    
    // Gerar PDF placeholder
    $pdf = Pdf::loadView('pdf.livro-placeholder', ['livro' => $livro]);
    return $pdf->download($livro->titulo . '.pdf');
}

    // ==================== MÉTODOS PRIVADOS ====================

    private function calcularSituacaoAnual($notasDisciplina)
    {
        $mediaFinal = $notasDisciplina->avg('media_final') ?? $notasDisciplina->avg('media_trimestral') ?? 0;
        
        $exameCount = $notasDisciplina->where('situacao', 'exame')->count();
        $reprovadoCount = $notasDisciplina->where('situacao', 'reprovado')->count();
        
        if ($mediaFinal >= 10 && $reprovadoCount == 0) {
            return 'aprovado';
        } elseif ($exameCount > 0 || ($mediaFinal >= 7 && $mediaFinal < 10)) {
            return 'exame';
        } else {
            return 'reprovado';
        }
    }

    private function calcularSituacaoAnualGeral($disciplinasNotas)
    {
        $aprovadas = 0;
        $exame = 0;
        $reprovadas = 0;
        
        foreach ($disciplinasNotas as $disciplina) {
            if ($disciplina['situacao'] == 'aprovado') {
                $aprovadas++;
            } elseif ($disciplina['situacao'] == 'exame') {
                $exame++;
            } elseif ($disciplina['situacao'] == 'reprovado') {
                $reprovadas++;
            }
        }
        
        if ($reprovadas > 0) {
            return 'reprovado';
        } elseif ($exame > 0) {
            return 'exame';
        } else {
            return 'aprovado';
        }
    }
}