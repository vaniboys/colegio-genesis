<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Professor - Colégio Gênesis</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
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

        .sidebar-logo h6 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sidebar-logo small {
            font-size: 0.7rem;
            opacity: 0.7;
        }

        /* Navegação da sidebar */
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 10px 20px;
            margin: 4px 8px;
            border-radius: 8px;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link.active {
            background: #3b82f6;
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Separador da sidebar */
        .sidebar hr {
            margin: 15px 20px;
            border-color: rgba(255,255,255,0.1);
        }

        /* Botão Sair na sidebar */
        .sidebar .logout-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.85);
            padding: 10px 20px;
            margin: 4px 8px;
            border-radius: 8px;
            width: calc(100% - 16px);
            text-align: left;
            font-size: 14px;
            transition: all 0.3s;
        }

        .sidebar .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
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
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
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

        /* Botão Voltar */
        .btn-back {
            background: #1e3a8a;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-back:hover {
            background: #3b82f6;
            color: white;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            transition: all 0.2s;
            border: 1px solid #e5e7eb;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 13px;
        }

        /* Tabela */
        .table-card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #e5e7eb;
        }

        .table thead th {
            background: #f9fafb;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 13px;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody td {
            font-size: 13px;
            vertical-align: middle;
        }

        .btn-sm-custom {
            background: #1e3a8a;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-sm-custom:hover {
            background: #3b82f6;
            color: white;
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
        <i class="fas fa-school"></i>
        <h6>Colégio Gênesis</h6>
        <small>Painel do Professor</small>
    </div>
    
    <nav>
        <a class="nav-link {{ request()->routeIs('professor.dashboard') ? 'active' : '' }}" 
           href="{{ route('professor.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        
        <a class="nav-link {{ request()->routeIs('professor.turmas*') ? 'active' : '' }}" 
           href="{{ route('professor.turmas') }}">
            <i class="fas fa-chalkboard-user"></i> Minhas Turmas
        </a>
        
        <a class="nav-link {{ request()->routeIs('professor.avaliacoes*') ? 'active' : '' }}" 
           href="#" onclick="return false;">
            <i class="fas fa-tasks"></i> Avaliações
        </a>
        
        <a class="nav-link {{ request()->routeIs('professor.tarefas*') ? 'active' : '' }}" 
           href="#" onclick="return false;">
            <i class="fas fa-file-alt"></i> Tarefas
        </a>
        
        <a class="nav-link" href="#" onclick="return false;">
            <i class="fas fa-calendar-alt"></i> Calendário
        </a>
        
        <a class="nav-link" href="#" onclick="return false;">
            <i class="fas fa-chart-line"></i> Relatórios
        </a>
        
        <a class="nav-link {{ request()->routeIs('professor.mensagens*') ? 'active' : '' }}" 
           href="{{ route('professor.mensagens') }}">
            <i class="fas fa-envelope"></i> Mensagens
            <span class="badge bg-danger rounded-pill" id="menuMensagensBadge" style="display: none; float: right;">0</span>
        </a>
       
        <a class="nav-link {{ request()->routeIs('professor.notificacoes*') ? 'active' : '' }}" 
           href="{{ route('professor.notificacoes') }}">
            <i class="fas fa-bell"></i> Notificações
            <span class="badge bg-danger rounded-pill" id="menuNotificacoesBadge" style="display: none; float: right;">0</span>
        </a>

        <hr>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt me-2"></i> Sair
            </button>
        </form>
    </nav>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main-content">
    <div class="container-fluid p-3">
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h5 class="mb-0">Dashboard</h5>
                    <small class="text-muted">Bem-vindo, {{ auth()->user()->name }}</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3 mt-2 mt-sm-0">
                <!-- Ícone Mensagens -->
                <a href="{{ route('professor.mensagens') }}" class="text-decoration-none position-relative">
                    <i class="fas fa-envelope fa-lg text-secondary"></i>
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" 
                          id="topMensagensBadge" style="display: none; font-size: 10px;">0</span>
                </a>
                
                <!-- Ícone Notificações -->
                <a href="{{ route('professor.notificacoes') }}" class="text-decoration-none position-relative">
                    <i class="fas fa-bell fa-lg text-secondary"></i>
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" 
                          id="topNotificacoesBadge" style="display: none; font-size: 10px;">0</span>
                </a>
                
                <!-- Dropdown do Usuário -->
                <div class="dropdown">
                    <i class="fas fa-user-circle fa-2x text-secondary user-dropdown" 
                       data-bs-toggle="dropdown" 
                       style="cursor: pointer;"></i>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text"><strong>{{ auth()->user()->name }}</strong></span></li>
                        <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Botão Voltar (aparece só em páginas internas) -->
        @if(!request()->routeIs('professor.dashboard') && !request()->routeIs('professor.turmas'))
        <div class="mb-3">
            <button onclick="history.back()" class="btn-back">
                <i class="fas fa-arrow-left"></i> Voltar
            </button>
        </div>
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
    function atualizarContagens() {
        // Mensagens não lidas
        fetch('{{ route("professor.mensagens.count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.count || 0;
                const topBadge = document.getElementById('topMensagensBadge');
                const menuBadge = document.getElementById('menuMensagensBadge');
                
                if (topBadge) {
                    if (count > 0) {
                        topBadge.textContent = count;
                        topBadge.style.display = 'inline-block';
                    } else {
                        topBadge.style.display = 'none';
                    }
                }
                
                if (menuBadge) {
                    if (count > 0) {
                        menuBadge.textContent = count;
                        menuBadge.style.display = 'inline-block';
                    } else {
                        menuBadge.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Erro ao buscar mensagens:', error));
        
        // Notificações não lidas
        fetch('{{ route("professor.notificacoes.count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.count || 0;
                const topBadge = document.getElementById('topNotificacoesBadge');
                const menuBadge = document.getElementById('menuNotificacoesBadge');
                
                if (topBadge) {
                    if (count > 0) {
                        topBadge.textContent = count;
                        topBadge.style.display = 'inline-block';
                    } else {
                        topBadge.style.display = 'none';
                    }
                }
                
                if (menuBadge) {
                    if (count > 0) {
                        menuBadge.textContent = count;
                        menuBadge.style.display = 'inline-block';
                    } else {
                        menuBadge.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Erro ao buscar notificações:', error));
    }
    
    // Atualizar contagens a cada 30 segundos
    atualizarContagens();
    setInterval(atualizarContagens, 30000);
</script>
@stack('scripts')
</body>
</html>