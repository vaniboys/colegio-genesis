<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\MensagemController;

// ============================================
// ROTA PRINCIPAL
// ============================================
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin' || $user->role === 'secretaria') {
            return redirect('/admin');
        } elseif ($user->role === 'professor') {
            return redirect('/professor/dashboard');
        } elseif ($user->role === 'aluno') {
            return redirect('/aluno/dashboard');
        }
    }
    return redirect('/login');
});

// ============================================
// ROTAS DE AUTENTICAÇÃO
// ============================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// ROTAS DO PROFESSOR (SÓ PROFESSORES)
// ============================================
Route::middleware(['auth', 'role:professor'])->prefix('professor')->name('professor.')->group(function () {
    Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('dashboard');
    Route::get('/minhas-turmas', [ProfessorController::class, 'minhasTurmas'])->name('turmas');
    
    // Rotas de Notas
    Route::get('/notas/{turma}', [ProfessorController::class, 'lancarNotas'])->name('notas');
    Route::get('/notas/{turma}/{trimestre}', [ProfessorController::class, 'lancarNotas'])->name('notas.trimestre');
    Route::post('/notas/salvar', [ProfessorController::class, 'salvarNotas'])->name('notas.salvar');
    Route::post('/notas/salvar-ajax', [ProfessorController::class, 'salvarNotasAjax'])->name('notas.salvar.ajax'); // <-- ADICIONAR ESTA
    
    // Rotas de Materiais
    Route::get('/materiais/{turma}', [ProfessorController::class, 'materiais'])->name('materiais');
    Route::get('/materiais/criar/{turma}', [ProfessorController::class, 'criarMaterial'])->name('materiais.criar');
    Route::post('/materiais/salvar', [ProfessorController::class, 'salvarMaterial'])->name('materiais.salvar');
    Route::get('/materiais/download/{id}', [ProfessorController::class, 'downloadMaterial'])->name('materiais.download');
    Route::delete('/materiais/deletar/{id}', [ProfessorController::class, 'deletarMaterial'])->name('materiais.deletar');
    
    // Rotas de Avaliações
    Route::get('/avaliacoes/{turma}', [ProfessorController::class, 'avaliacoes'])->name('avaliacoes');
    Route::get('/avaliacao/criar/{turma}', [ProfessorController::class, 'criarAvaliacao'])->name('avaliacao.criar');
    Route::post('/avaliacao/salvar', [ProfessorController::class, 'salvarAvaliacao'])->name('avaliacao.salvar');
    Route::get('/avaliacao/editar/{id}', [ProfessorController::class, 'editarAvaliacao'])->name('avaliacao.editar');
    Route::put('/avaliacao/atualizar/{id}', [ProfessorController::class, 'atualizarAvaliacao'])->name('avaliacao.atualizar');
    Route::delete('/avaliacao/deletar/{id}', [ProfessorController::class, 'deletarAvaliacao'])->name('avaliacao.deletar');

    // Rotas de Questões
    Route::get('/questoes/{avaliacao}', [ProfessorController::class, 'questoes'])->name('questoes');
    Route::post('/questao/salvar', [ProfessorController::class, 'salvarQuestao'])->name('questao.salvar');
    Route::delete('/questao/deletar/{id}', [ProfessorController::class, 'deletarQuestao'])->name('questao.deletar');
    
    // Rotas de Tarefas
    Route::get('/tarefas/{turma}', [ProfessorController::class, 'tarefas'])->name('tarefas');
    Route::get('/tarefa/criar/{turma}', [ProfessorController::class, 'criarTarefa'])->name('tarefa.criar');
    Route::post('/tarefa/salvar', [ProfessorController::class, 'salvarTarefa'])->name('tarefa.salvar');
    Route::get('/tarefa/entregas/{tarefa}', [ProfessorController::class, 'entregas'])->name('tarefa.entregas');
    Route::get('/tarefa/editar/{id}', [ProfessorController::class, 'editarTarefa'])->name('tarefa.editar');
    Route::put('/tarefa/atualizar/{id}', [ProfessorController::class, 'atualizarTarefa'])->name('tarefa.atualizar');
    Route::delete('/tarefa/deletar/{id}', [ProfessorController::class, 'deletarTarefa'])->name('tarefa.deletar');
    Route::post('/tarefa/corrigir/{entrega}', [ProfessorController::class, 'corrigirEntrega'])->name('tarefa.corrigir');
    
    // Rotas de Alunos
    Route::get('/turma/alunos/{turma}', [ProfessorController::class, 'verAlunos'])->name('turma.alunos');
    Route::get('/turma/alunos/pdf/{turma}', [ProfessorController::class, 'downloadAlunosPDF'])->name('turma.alunos.pdf');
    
    // Rotas de Mensagens
    Route::get('/mensagens', [ProfessorController::class, 'mensagens'])->name('mensagens');
    Route::get('/mensagens/conversa/{id}', [ProfessorController::class, 'conversa'])->name('conversa');
    Route::post('/mensagens/enviar', [ProfessorController::class, 'enviarMensagem'])->name('enviar');
    Route::post('/nova-conversa', [ProfessorController::class, 'novaConversa'])->name('nova-conversa');
    
    // Rotas de Notificações
    Route::get('/notificacoes', [ProfessorController::class, 'notificacoesLista'])->name('notificacoes');
    Route::get('/mensagens/count', [ProfessorController::class, 'mensagensCount'])->name('mensagens.count');
    Route::get('/notificacoes/count', [ProfessorController::class, 'notificacoesCount'])->name('notificacoes.count');
    
    // Rotas de Busca
    Route::get('/buscar-alunos', [ProfessorController::class, 'buscarAlunosTurma'])->name('buscar-alunos');
});
// ============================================
// ROTAS DO ALUNO (SÓ ALUNOS)
// ============================================
Route::middleware(['auth', 'role:aluno'])->prefix('aluno')->name('aluno.')->group(function () {
    Route::get('/dashboard', [AlunoController::class, 'dashboard'])->name('dashboard');
    Route::get('/boletim', [AlunoController::class, 'boletim'])->name('boletim');
    Route::get('/boletim/pdf', [AlunoController::class, 'boletimPDF'])->name('boletim.pdf');
    Route::get('/notas', [AlunoController::class, 'notas'])->name('notas');
    
    //  NOVA ROTA - MINHAS DISCIPLINAS
    Route::get('/minhas-disciplinas', [AlunoController::class, 'minhasDisciplinas'])->name('minhas-disciplinas');
    
    Route::get('/materiais', [AlunoController::class, 'materiais'])->name('materiais');
    Route::get('/material/download/{id}', [AlunoController::class, 'downloadMaterial'])->name('material.download');
    
    Route::get('/tarefas', [AlunoController::class, 'tarefas'])->name('tarefas');
    Route::post('/tarefa/enviar', [AlunoController::class, 'enviarTarefa'])->name('tarefa.enviar');
    
    Route::get('/comunicados', [AlunoController::class, 'comunicados'])->name('comunicados');
    
    Route::get('/mensagens', [AlunoController::class, 'mensagens'])->name('mensagens');
    Route::get('/mensagens/conversa/{id}', [AlunoController::class, 'conversa'])->name('conversa');
    Route::post('/mensagens/enviar', [AlunoController::class, 'enviarMensagem'])->name('enviar');
    Route::get('/notificacoes', [AlunoController::class, 'notificacoesLista'])->name('notificacoes');
    Route::get('/mensagens/count', [AlunoController::class, 'mensagensCount'])->name('mensagens.count');
    Route::get('/notificacoes/count', [AlunoController::class, 'notificacoesCount'])->name('notificacoes.count');
    Route::post('/notificacao/marcar-lida/{id}', [AlunoController::class, 'marcarNotificacaoLida'])->name('notificacao.marcar-lida');
    Route::post('/notificacoes/marcar-todas', [AlunoController::class, 'marcarTodasNotificacoes'])->name('notificacoes.marcar-todas');
    Route::get('/buscar-professores', [AlunoController::class, 'buscarProfessores'])->name('buscar-professores');
    Route::post('/nova-conversa', [AlunoController::class, 'novaConversa'])->name('nova-conversa');
    
    Route::get('/historico', [AlunoController::class, 'historico'])->name('historico');

    Route::get('/livros', [AlunoController::class, 'livros'])->name('livros');
    Route::get('/livros/download/{id}', [AlunoController::class, 'downloadLivro'])->name('download-livro');

});


// ============================================
// ROTAS DE MENSAGENS GERAIS
// ============================================
Route::middleware(['auth'])->prefix('mensagens')->name('mensagens.')->group(function () {
    Route::get('/', [MensagemController::class, 'index'])->name('index');
    Route::get('/conversa/{id}', [MensagemController::class, 'conversa'])->name('conversa');
    Route::post('/enviar', [MensagemController::class, 'enviar'])->name('enviar');
    Route::post('/nova-conversa', [MensagemController::class, 'novaConversa'])->name('nova');
    Route::delete('/deletar/{id}', [MensagemController::class, 'deletar'])->name('deletar');
    Route::get('/notificacoes', [MensagemController::class, 'notificacoes'])->name('notificacoes');
    Route::post('/notificacao/marcar-lida/{id}', [MensagemController::class, 'marcarLida'])->name('notificacao.lida');
    Route::post('/notificacoes/marcar-todas', [MensagemController::class, 'marcarTodasLidas'])->name('notificacoes.marcar-todas');
    Route::get('/notificacoes/count', [MensagemController::class, 'notificacoesCount'])->name('notificacoes.count');
    Route::get('/notificacoes/latest', [MensagemController::class, 'notificacoesLatest'])->name('notificacoes.latest');
});

// ============================================
// ROTA DE BUSCA DE USUÁRIOS
// ============================================
Route::get('/usuarios/buscar', [MensagemController::class, 'buscarUsuarios'])->name('usuarios.buscar');

// ============================================
// ROTAS DA SECRETARIA (SÓ SECRETARIA)
// ============================================
Route::middleware(['auth', 'role:secretaria'])->prefix('secretaria')->name('secretaria.')->group(function () {
    Route::get('/dashboard', [SecretariaController::class, 'dashboard'])->name('dashboard');
    Route::get('/matriculas', [SecretariaController::class, 'matriculas'])->name('matriculas');
    Route::get('/matriculas/criar', [SecretariaController::class, 'criarMatricula'])->name('criar-matricula');
    Route::post('/matriculas/salvar', [SecretariaController::class, 'salvarMatricula'])->name('salvar-matricula');
    Route::get('/documentos', [SecretariaController::class, 'documentos'])->name('documentos');
    Route::get('/pagamentos', [SecretariaController::class, 'pagamentos'])->name('pagamentos');
    Route::get('/relatorios', [SecretariaController::class, 'relatorios'])->name('relatorios');
    Route::post('/relatorios/gerar', [SecretariaController::class, 'gerarRelatorio'])->name('gerar-relatorio');
});