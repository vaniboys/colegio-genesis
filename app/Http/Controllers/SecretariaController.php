<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Matricula;
use App\Models\Matricula as ModelsMatricula;

class SecretariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
{
    // Estatísticas
    $totalAlunos = Aluno::count();
    $totalProfessores = Professor::count();
    $totalTurmas = Turma::count();
    $totalMatriculasAno = Matricula::whereYear('data_matricula', date('Y'))->count();
    
    // Matrículas recentes
    $matriculasRecentes = Matricula::with(['aluno', 'turma'])
                                   ->orderBy('data_matricula', 'desc')
                                   ->limit(5)
                                   ->get();
    
    // Alunos por turma
    $alunosPorTurma = Turma::withCount('alunos')->get();
    
    return view('secretaria.dashboard', compact(
        'totalAlunos', 'totalProfessores', 'totalTurmas', 
        'totalMatriculasAno', 'matriculasRecentes', 'alunosPorTurma'
    ));
}
    
    public function matriculas()
    {
        $matriculas = Matricula::with(['aluno', 'turma'])
                               ->orderBy('created_at', 'desc')
                               ->paginate(15);
        
        return view('secretaria.matriculas', compact('matriculas'));
    }
    
    public function criarMatricula()
    {
        $alunos = Aluno::where('situacao', 'activo')->get();
        $turmas = Turma::all();
        
        return view('secretaria.criar-matricula', compact('alunos', 'turmas'));
    }
    
    public function salvarMatricula(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'turma_id' => 'required|exists:turmas,id',
            'data_matricula' => 'required|date',
            'tipo' => 'required'
        ]);
        
        // Gerar número de matrícula
        $numeroMatricula = 'MAT' . date('Y') . str_pad(Matricula::count() + 1, 4, '0', STR_PAD_LEFT);
        
        Matricula::create([
            'numero_matricula' => $numeroMatricula,
            'aluno_id' => $request->aluno_id,
            'turma_id' => $request->turma_id,
            'data_matricula' => $request->data_matricula,
            'tipo' => $request->tipo,
            'situacao' => 'ativa'
        ]);
        
        // Atualizar vagas da turma
        $turma = Turma::find($request->turma_id);
        $turma->vagas_ocupadas = Matricula::where('turma_id', $request->turma_id)->count();
        $turma->save();
        
        return redirect()->route('secretaria.matriculas')
                         ->with('success', 'Matrícula realizada com sucesso!');
    }
    
    public function documentos()
    {
        return view('secretaria.documentos');
    }
    
    public function pagamentos()
    {
        return view('secretaria.pagamentos');
    }
    
    public function relatorios()
    {
        return view('secretaria.relatorios');
    }
    
    public function gerarRelatorio(Request $request)
    {
        $tipo = $request->tipo;
        
        if ($tipo == 'alunos') {
            $dados = Aluno::all();
            return view('secretaria.relatorio-alunos', compact('dados'));
        } elseif ($tipo == 'matriculas') {
            $dados = Matricula::with(['aluno', 'turma'])->get();
            return view('secretaria.relatorio-matriculas', compact('dados'));
        }
        
        return redirect()->back();
    }
}