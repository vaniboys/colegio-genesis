<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Colégio Gênesis - Sistema de Gestão Escolar</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb;
        }
        
        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 12px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .navbar-brand i {
            margin-right: 10px;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        
        /* Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 12px;
            margin-top: 10px;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s;
        }
        
        .dropdown-item:hover {
            background-color: #f0f2f5;
            padding-left: 25px;
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 70px);
            padding: 30px 0;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
            font-weight: 600;
            border-radius: 15px 15px 0 0 !important;
        }
        
        /* Botões */
        .btn-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30,58,138,0.3);
        }
        
        .btn-outline-primary {
            border-color: #1e3a8a;
            color: #1e3a8a;
        }
        
        .btn-outline-primary:hover {
            background: #1e3a8a;
            border-color: #1e3a8a;
        }
        
        /* Alertas */
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        /* Footer */
        footer {
            background: white;
            padding: 20px 0;
            margin-top: 30px;
            border-top: 1px solid #e9ecef;
        }
        
        /* Badges de notificação */
        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
        }
        
        /* Dropdown de notificações */
        .notifications-dropdown {
            width: 350px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .notification-item:hover {
            background-color: #f8f9fa;
        }
        
        .notification-item.unread {
            background-color: #e0e7ff;
        }
        
        .notification-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .notification-message {
            font-size: 12px;
            color: #6c757d;
        }
        
        .notification-time {
            font-size: 10px;
            color: #adb5bd;
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            .notifications-dropdown {
                width: 300px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-graduation-cap"></i>
                    Colégio Gênesis
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        <!-- Notificações -->
                        @auth
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell fa-lg"></i>
                                <span class="badge bg-danger rounded-pill badge-notification" id="notificacoesCount" style="display: none;">0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropdown">
                                <h6 class="dropdown-header">Notificações</h6>
                                <div id="listaNotificacoes">
                                    <div class="text-center py-3">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Carregando...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center" href="{{ route('mensagens.notificacoes') }}">
                                    Ver todas as notificações
                                </a>
                            </div>
                        </li>
                        @endauth
                        
                        <!-- Menu do Usuário -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i> Entrar
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle fa-2x me-2"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><span class="dropdown-item-text">
                                        <strong>{{ Auth::user()->name }}</strong><br>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                        <br>
                                        <span class="badge bg-primary mt-1">{{ ucfirst(Auth::user()->role) }}</span>
                                    </span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('mensagens.index') }}">
                                            <i class="fas fa-envelope me-2"></i> Mensagens
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('mensagens.notificacoes') }}">
                                            <i class="fas fa-bell me-2"></i> Notificações
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> Sair
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <div class="container">
                <!-- Mensagens Flash -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0 text-muted small">
                            &copy; {{ date('Y') }} Colégio Gênesis - Sistema de Gestão Escolar
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="mb-0 text-muted small">
                            Versão 2.0 | Angola
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Carregar contagem de notificações
        function carregarNotificacoesCount() {
            fetch('/mensagens/notificacoes/count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificacoesCount');
                    if(badge && data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline-block';
                    } else if(badge) {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Erro:', error));
        }
        
        // Carregar últimas notificações
        function carregarNotificacoes() {
            fetch('/mensagens/notificacoes/latest')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('listaNotificacoes');
                    if(container && data.notificacoes) {
                        if(data.notificacoes.length > 0) {
                            let html = '';
                            data.notificacoes.forEach(notificacao => {
                                const dataFormatada = new Date(notificacao.created_at).toLocaleDateString('pt-BR');
                                html += `
                                    <div class="notification-item ${!notificacao.lida ? 'unread' : ''}" onclick="marcarNotificacaoLida(${notificacao.id})">
                                        <div class="notification-title">${notificacao.titulo}</div>
                                        <div class="notification-message">${notificacao.mensagem.substring(0, 80)}${notificacao.mensagem.length > 80 ? '...' : ''}</div>
                                        <div class="notification-time">${dataFormatada}</div>
                                    </div>
                                `;
                            });
                            container.innerHTML = html;
                        } else {
                            container.innerHTML = '<div class="text-center py-3 text-muted">Nenhuma notificação</div>';
                        }
                    }
                })
                .catch(error => console.error('Erro:', error));
        }
        
        // Marcar notificação como lida
        function marcarNotificacaoLida(id) {
            fetch('/mensagens/notificacao/marcar-lida/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if(response.ok) {
                    location.reload();
                }
            })
            .catch(error => console.error('Erro:', error));
        }
        
        @auth
        // Carregar notificações ao iniciar
        document.addEventListener('DOMContentLoaded', function() {
            carregarNotificacoesCount();
            carregarNotificacoes();
            
            // Atualizar a cada 30 segundos
            setInterval(function() {
                carregarNotificacoesCount();
                carregarNotificacoes();
            }, 30000);
        });
        @endauth
    </script>
    
    @stack('scripts')
</body>
</html>