<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - Colégio Gênesis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            max-width: 400px;
            width: 90%;
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            text-align: center;
            padding: 30px;
        }
        .login-header i {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .login-header h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .login-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
        }
        .btn-login {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            color: white;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
        }
        .info-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
            margin-top: 20px;
            font-size: 12px;
        }
        .link-area {
            text-align: center;
            margin-top: 15px;
        }
        .link-area a {
            color: #1e3a8a;
            text-decoration: none;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-shield-alt"></i>
            <h2>Área Administrativa</h2>
            <p>Colégio Gênesis</p>
            <small>Acesso restrito a Administradores e Secretaria</small>
        </div>
        <div class="login-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('filament.administrador.auth.login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Lembrar-me</label>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Entrar
                </button>
            </form>

            <div class="info-box">
                <p><strong>Credenciais de teste:</strong></p>
                <p class="mb-0">Admin: admin@colegio.ao / password</p>
                <p>Secretaria: secretaria@colegio.ao / password</p>
            </div>

            <div class="link-area">
                <a href="{{ route('login') }}">
                    <i class="fas fa-user-graduate"></i> Área do Aluno/Professor
                </a>
            </div>
        </div>
    </div>
</body>
</html>