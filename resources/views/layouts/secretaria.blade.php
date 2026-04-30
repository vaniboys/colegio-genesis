<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Secretaria - Colégio Gênesis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .sidebar { background: #1e3a8a; min-height: 100vh; }
        .sidebar a { color: rgba(255,255,255,0.85); text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #3b82f6; color: white; padding-left: 28px; }
        .sidebar a i { width: 25px; margin-right: 10px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .card-header { background: white; border-bottom: 1px solid #e5e7eb; font-weight: 600; }
        .btn-sm-custom { background: #1e3a8a; color: white; border: none; padding: 5px 12px; border-radius: 6px; font-size: 12px; transition: 0.3s; }
        .btn-sm-custom:hover { background: #3b82f6; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-0">
                <div class="text-center py-3"><i class="fas fa-graduation-cap fa-2x"></i><div class="small">Colégio Gênesis<br>Secretaria</div></div>
                <nav>
                    <a href="{{ route('secretaria.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                    <a href="{{ route('secretaria.matriculas') }}"><i class="fas fa-file-alt"></i> Matrículas</a>
                    <a href="{{ route('secretaria.documentos') }}"><i class="fas fa-folder"></i> Documentos</a>
                    <a href="{{ route('secretaria.pagamentos') }}"><i class="fas fa-credit-card"></i> Pagamentos</a>
                    <a href="{{ route('secretaria.relatorios') }}"><i class="fas fa-chart-bar"></i> Relatórios</a>
                    <hr>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn w-100 text-start" style="color:white; background:transparent; border:none;"><i class="fas fa-sign-out-alt"></i> Sair</button></form>
                </nav>
            </div>
            <div class="col-md-10 p-3">
                <div class="d-flex justify-content-end mb-3">
                    <div class="dropdown">
                        <i class="fas fa-user-circle fa-2x text-secondary" data-bs-toggle="dropdown" style="cursor:pointer"></i>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text">{{ auth()->user()->name }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><form method="POST" action="{{ route('logout') }}">@csrf<button class="dropdown-item">Sair</button></form></li>
                        </ul>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>