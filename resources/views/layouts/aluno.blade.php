<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Painel do Aluno - Colégio Gênesis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* ============================================ */
        /* SIDEBAR FIXA - NÃO ROLA COM A PÁGINA        */
        /* ============================================ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #1e3a8a;
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        /* Scrollbar da sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 5px;
        }

        /* Logo da sidebar */
        .sidebar-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 15px;
        }

        .sidebar-logo i {
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .sidebar-logo .small {
            font-size: 0.7rem;
            opacity: 0.7;
        }

        /* Links da sidebar */
        .sidebar a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 12px 20px;
            margin: 4px 8px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .sidebar a i {
            width: 25px;
            margin-right: 10px;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 25px;
        }

        .sidebar a.active {
            background: #3b82f6;
            color: white;
        }

        /* Badge do menu (notificações) */
        .menu-badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 10px;
        }

        /* Separador */
        .sidebar hr {
            margin: 15px 20px;
            border-color: rgba(255,255,255,0.1);
        }

        /* Botão Sair */
        .sidebar .logout-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.85);
            padding: 12px 20px;
            margin: 4px 8px;
            border-radius: 8px;
            width: calc(100% - 16px);
            text-align: left;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .sidebar .logout-btn:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar .logout-btn i {
            width: 25px;
            margin-right: 10px;
        }

        /* ============================================ */
        /* CONTEÚDO PRINCIPAL                          */
        /* ============================================ */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Topbar */
        .topbar {
            background: white;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* Botão menu toggle (aparece só em mobile) */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #1e3a8a;
            cursor: pointer;
            margin-right: 15px;
        }

        /* Ícones de notificação */
        .notification-icon {
            position: relative;
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            min-width: 18px;
            text-align: center;
        }

        /* Menu do usuário */
        .user-menu {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Cards de estatísticas */
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid rgba(0,0,0,0.05);
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1e3a8a;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        /* Cores dos ícones */
        .bg-primary-light { background: rgba(30,58,138,0.1); color: #1e3a8a; }
        .bg-success-light { background: rgba(16,185,129,0.1); color: #10b981; }
        .bg-warning-light { background: rgba(245,158,11,0.1); color: #f59e0b; }
        .bg-info-light { background: rgba(59,130,246,0.1); color: #3b82f6; }
        .bg-danger-light { background: rgba(220,38,38,0.1); color: #dc2626; }

        /* Comunicados */
        .comunicado-item {
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px;
            margin: 10px;
            transition: all 0.3s;
            border-left: 3px solid #1e3a8a;
        }

        .comunicado-item:hover {
            background: #f1f5f9;
            transform: translateX(5px);
        }

        /* Badges */
        .badge-success {
            background: #d1fae5;
            color: #065f46;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        /* Botão flutuante de imprimir */
        .btn-print-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-print-float:hover {
            background: #3b82f6;
            transform: scale(1.05);
        }

        @media print {
            .btn-print-float { display: none; }
            .sidebar { display: none; }
            .main-content { margin-left: 0; }
            .topbar { display: none; }
        }

        /* Overlay para mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        /* ============================================ */
        /* RESPONSIVIDADE (TELEMÓVEL)                  */
        /* ============================================ */
        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .stats-card {
                margin-bottom: 15px;
            }
            
            .stat-value {
                font-size: 24px;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Overlay para fechar sidebar no mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR FIXA -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <i class="fas fa-graduation-cap"></i>
        <div class="fw-bold mt-2">Colégio Gênesis</div>
        <div class="small">Painel do Aluno</div>
    </div>
    
    <nav>
        <a href="{{ route('aluno.dashboard') }}" class="{{ request()->routeIs('aluno.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        
        <a href="{{ route('aluno.boletim') }}" class="{{ request()->routeIs('aluno.boletim') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Boletim
        </a>
        
        <a href="{{ route('aluno.notas') }}" class="{{ request()->routeIs('aluno.notas') ? 'active' : '' }}">
            <i class="fas fa-edit"></i> Notas
        </a>
        
        <!-- ✅ MINHAS DISCIPLINAS - NOVO -->
        <a href="{{ route('aluno.minhas-disciplinas') }}" class="{{ request()->routeIs('aluno.minhas-disciplinas') ? 'active' : '' }}">
            <i class="fas fa-book-open"></i> Minhas Disciplinas
        </a>
        
        <a href="{{ route('aluno.materiais') }}" class="{{ request()->routeIs('aluno.materiais') ? 'active' : '' }}">
            <i class="fas fa-folder-open"></i> Materiais
        </a>
        
        <a href="{{ route('aluno.livros') }}" class="{{ request()->routeIs('aluno.livros') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Livros de Apoio
        </a>
        
        <a href="{{ route('aluno.tarefas') }}" class="{{ request()->routeIs('aluno.tarefas') ? 'active' : '' }}">
            <i class="fas fa-tasks"></i> Tarefas
        </a>

        <a href="{{ route('aluno.historico') }}" class="{{ request()->routeIs('aluno.historico') ? 'active' : '' }}">
            <i class="fas fa-history"></i> Histórico Escolar
        </a>
        
        <a href="{{ route('aluno.comunicados') }}" class="{{ request()->routeIs('aluno.comunicados') ? 'active' : '' }}">
            <i class="fas fa-bullhorn"></i> Comunicados
        </a>
        
        <hr>
        
        <a href="{{ route('aluno.mensagens') }}" class="{{ request()->routeIs('aluno.mensagens*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Mensagens
            <span class="menu-badge" id="menuMensagensBadge" style="display: none;">0</span>
        </a>
        
        <a href="{{ route('aluno.notificacoes') }}" class="{{ request()->routeIs('aluno.notificacoes*') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> Notificações
            <span class="menu-badge" id="menuNotificacoesBadge" style="display: none;">0</span>
        </a>
        
        <hr>
        
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Sair
            </button>
        </form>
    </nav>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main-content">
    <div class="container-fluid p-3">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h5 class="mb-0">Olá, {{ auth()->user()->name }}</h5>
                    <small class="text-muted">Bem-vindo ao seu painel</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <!-- Ícone de Mensagens -->
                <div class="notification-icon" onclick="window.location.href='{{ route('aluno.mensagens') }}'">
                    <i class="fas fa-envelope fa-lg text-secondary"></i>
                    <span class="notification-badge" id="topMensagensBadge" style="display: none;">0</span>
                </div>
                
                <!-- Ícone de Notificações -->
                <div class="notification-icon" onclick="window.location.href='{{ route('aluno.notificacoes') }}'">
                    <i class="fas fa-bell fa-lg text-secondary"></i>
                    <span class="notification-badge" id="topNotificacoesBadge" style="display: none;">0</span>
                </div>
                
                <!-- Menu do Usuário -->
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-2x text-secondary"></i>
                        <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down fa-sm d-none d-sm-inline"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text"><strong>{{ auth()->user()->name }}</strong></span></li>
                        <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Botão flutuante de impressão (aparece só no boletim) -->
        @if(request()->routeIs('aluno.boletim'))
            <button class="btn-print-float" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Imprimir / Salvar PDF
            </button>
        @endif

        <!-- Conteúdo da página -->
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ============================================
    // TOGGLE SIDEBAR NO MOBILE
    // ============================================
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }
    
    function openSidebar() {
        sidebar.classList.add('show');
        overlay.classList.add('show');
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', openSidebar);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
    
    // Fechar sidebar ao redimensionar para desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
    
    // ============================================
    // CONTAGEM DE NOTIFICAÇÕES E MENSAGENS
    // ============================================
    function carregarMensagensCount() {
        fetch('{{ route("aluno.mensagens.count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.count || 0;
                const menuBadge = document.getElementById('menuMensagensBadge');
                const topBadge = document.getElementById('topMensagensBadge');
                
                if (count > 0) {
                    if(menuBadge) { 
                        menuBadge.textContent = count; 
                        menuBadge.style.display = 'inline-block'; 
                    }
                    if(topBadge) { 
                        topBadge.textContent = count; 
                        topBadge.style.display = 'inline-block'; 
                    }
                } else {
                    if(menuBadge) menuBadge.style.display = 'none';
                    if(topBadge) topBadge.style.display = 'none';
                }
            })
            .catch(error => console.error('Erro ao buscar mensagens:', error));
    }
    
    function carregarNotificacoesCount() {
        fetch('{{ route("aluno.notificacoes.count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.count || 0;
                const menuBadge = document.getElementById('menuNotificacoesBadge');
                const topBadge = document.getElementById('topNotificacoesBadge');
                
                if (count > 0) {
                    if(menuBadge) { 
                        menuBadge.textContent = count; 
                        menuBadge.style.display = 'inline-block'; 
                    }
                    if(topBadge) { 
                        topBadge.textContent = count; 
                        topBadge.style.display = 'inline-block'; 
                    }
                } else {
                    if(menuBadge) menuBadge.style.display = 'none';
                    if(topBadge) topBadge.style.display = 'none';
                }
            })
            .catch(error => console.error('Erro ao buscar notificações:', error));
    }
    
    // Atualizar a cada 15 segundos
    carregarMensagensCount();
    carregarNotificacoesCount();
    setInterval(function() {
        carregarMensagensCount();
        carregarNotificacoesCount();
    }, 15000);
</script>
@stack('scripts')
</body>
</html>