<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversa;
use App\Models\Mensagem;
use App\Models\Notificacao;
use App\Models\User;

class MensagemController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $conversas = Conversa::where('user_1_id', $user->id)
                            ->orWhere('user_2_id', $user->id)
                            ->orderBy('ultima_mensagem', 'desc')
                            ->get();
        
        $notificacoesNaoLidas = Notificacao::where('user_id', $user->id)
                                           ->where('lida', false)
                                           ->count();
        
        return view('mensagens.index', compact('conversas', 'notificacoesNaoLidas'));
    }
    
    public function conversa($id)
    {
        $user = Auth::user();
        $conversa = Conversa::findOrFail($id);
        
        // Verificar se o usuário pertence à conversa
        if ($conversa->user_1_id != $user->id && $conversa->user_2_id != $user->id) {
            abort(403);
        }
        
        // Marcar mensagens como lidas
        Mensagem::where('conversa_id', $id)
                ->where('user_id', '!=', $user->id)
                ->where('lida', false)
                ->update(['lida' => true, 'lida_em' => now()]);
        
        $mensagens = Mensagem::where('conversa_id', $id)
                            ->orderBy('created_at', 'asc')
                            ->get();
        
        $outroUser = $conversa->user_1_id == $user->id ? $conversa->user2 : $conversa->user1;
        
        return view('mensagens.conversa', compact('conversa', 'mensagens', 'outroUser'));
    }
    
    public function enviar(Request $request)
    {
        $request->validate([
            'conversa_id' => 'required',
            'mensagem' => 'required|max:1000'
        ]);
        
        $user = Auth::user();
        
        $mensagem = Mensagem::create([
            'conversa_id' => $request->conversa_id,
            'user_id' => $user->id,
            'mensagem' => $request->mensagem,
            'lida' => false
        ]);
        
        // Atualizar última mensagem da conversa
        Conversa::where('id', $request->conversa_id)->update([
            'ultima_mensagem' => now()
        ]);
        
        // Criar notificação para o outro usuário
        $conversa = Conversa::find($request->conversa_id);
        $outroUserId = $conversa->user_1_id == $user->id ? $conversa->user_2_id : $conversa->user_1_id;
        
        Notificacao::create([
            'user_id' => $outroUserId,
            'titulo' => 'Nova mensagem de ' . $user->name,
            'mensagem' => substr($request->mensagem, 0, 100),
            'tipo' => 'info',
            'link' => '/mensagens/conversa/' . $request->conversa_id
        ]);
        
        return response()->json(['success' => true, 'mensagem' => $mensagem]);
    }
    
    public function novaConversa(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = Auth::user();
        $outroUserId = $request->user_id;
        
        // Verificar se já existe conversa
        $conversa = Conversa::where(function($q) use ($user, $outroUserId) {
            $q->where('user_1_id', $user->id)->where('user_2_id', $outroUserId);
        })->orWhere(function($q) use ($user, $outroUserId) {
            $q->where('user_1_id', $outroUserId)->where('user_2_id', $user->id);
        })->first();
        
        if (!$conversa) {
            $conversa = Conversa::create([
                'user_1_id' => $user->id,
                'user_2_id' => $outroUserId,
                'titulo' => 'Conversa entre ' . $user->name . ' e ' . User::find($outroUserId)->name
            ]);
        }
        
        return redirect()->route('mensagens.conversa', $conversa->id);
    }
    
    public function notificacoes()
    {
        $user = Auth::user();
        $notificacoes = Notificacao::where('user_id', $user->id)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        
        return view('mensagens.notificacoes', compact('notificacoes'));
    }
    
    public function marcarLida($id)
    {
        $notificacao = Notificacao::findOrFail($id);
        
        if ($notificacao->user_id != Auth::id()) {
            abort(403);
        }
        
        $notificacao->update(['lida' => true]);
        
        return response()->json(['success' => true]);
    }

    public function marcarTodasLidas()
    {
        $user = Auth::user();
        Notificacao::where('user_id', $user->id)
                ->where('lida', false)
                ->update(['lida' => true]);
        
        return response()->json(['success' => true]);
    }
        
    public function deletar($id)
    {
        $mensagem = Mensagem::findOrFail($id);
        
        if ($mensagem->user_id != Auth::id()) {
            abort(403);
        }
        
        $mensagem->delete();
        
        return redirect()->back()->with('success', 'Mensagem deletada');
    }

    public function buscarUsuarios(Request $request)
    {
        $query = $request->get('q');
        $users = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->where('id', '!=', Auth::id())
                    ->limit(10)
                    ->get(['id', 'name', 'email', 'role']);
        
        return response()->json($users);
    }

    public function notificacoesApi()
{
    $user = Auth::user();
    $notificacoes = Notificacao::where('user_id', $user->id)
                               ->orderBy('created_at', 'desc')
                               ->limit(10)
                               ->get();
    
    $naoLidas = Notificacao::where('user_id', $user->id)
                           ->where('lida', false)
                           ->count();
    
    return response()->json([
        'notificacoes' => $notificacoes,
        'naoLidas' => $naoLidas
    ]);
}

    public function mensagensNaoLidas()
    {
        $user = Auth::user();
        $total = Mensagem::whereHas('conversa', function($q) use ($user) {
            $q->where('user_1_id', $user->id)
            ->orWhere('user_2_id', $user->id);
        })->where('user_id', '!=', $user->id)
        ->where('lida', false)
        ->count();
        
        return response()->json(['total' => $total]);
    }

    public function notificacoesCount()
    {
        $user = Auth::user();
        $count = Notificacao::where('user_id', $user->id)
                            ->where('lida', false)
                            ->count();
        
        return response()->json(['count' => $count]);
    }

    public function notificacoesLatest()
    {
        $user = Auth::user();
        $notificacoes = Notificacao::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
        
        return response()->json(['notificacoes' => $notificacoes]);
    }
}