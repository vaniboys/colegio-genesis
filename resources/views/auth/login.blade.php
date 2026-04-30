<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Colégio Gênesis</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a8a 0%, #0a3185 100%);
        }

        .login-container {
            display: flex;
            width: 900px;
            max-width: 90%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Lado esquerdo - Banner */
        .login-banner {
            flex: 1;
            padding: 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
           
        }

        .login-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('/images/1.jpg');
            background-size: cover;
            background-position: center;
            opacity: 1;
            z-index: 0;
        }

        .logo, .banner-content, .banner-footer {
            position: relative;
            z-index: 1;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            font-size: 28px;
        }

        .logo h2 {
            font-size: 18px;
            font-weight: 600;
        }

        .banner-content {
            text-align: center;
            margin: 40px 0;
        }

        .banner-content i {
            font-size: 55px;
            margin-bottom: 20px;
        }

        .banner-content h3 {
            font-size: 22px;
            margin-bottom: 12px;
        }

        .banner-content p {
            font-size: 13px;
            line-height: 1.5;
            opacity: 0.9;
        }

        .banner-footer {
            font-size: 11px;
            text-align: center;
            opacity: 0.8;
        }

        /* Lado direito - Formulário */
        .login-form {
            flex: 1;
            padding: 45px 40px;
            background: white;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h1 {
            font-size: 26px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 13px;
            color: #666;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 14px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            background: none;
            border: none;
            font-size: 14px;
        }

        .toggle-password:hover {
            color: #3b82f6;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #e5e9f0;
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .alert {
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert i {
            font-size: 16px;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert li {
            font-size: 12px;
        }

        .test-credentials {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .test-credentials p {
            text-align: center;
            font-size: 11px;
            color: #999;
            margin-bottom: 8px;
        }

        .cred-box {
            display: flex;
            gap: 8px;
            justify-content: center;
            font-size: 11px;
            color: #666;
        }

        .cred-box div {
            background: #f5f5f5;
            padding: 5px 10px;
            border-radius: 6px;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 95%;
            }
            .login-banner {
                padding: 25px;
            }
            .banner-content i {
                font-size: 40px;
            }
            .banner-content h3 {
                font-size: 20px;
            }
            .login-form {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Lado esquerdo - Banner -->
        <div class="login-banner">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
                <h2>Colégio Gênesis</h2>
            </div>
            <div class="banner-content">
                <i class="fas fa-user-graduate"></i>
                <h3>Bem-vindo!</h3>
                <p>Acesse o sistema escolar<br>para consultar suas notas,<br>boletim e frequência.</p>
            </div>
            <div class="banner-footer">
                <p>© 2024 Colégio Gênesis - Angola</p>
            </div>
        </div>

        <!-- Lado direito - Formulário de login -->
        <div class="login-form">
            <div class="form-header">
                <h1>Login</h1>
                <p>Entre com suas credenciais</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="input-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" 
                               value="{{ old('email') }}" 
                               placeholder="seu@email.com"
                               required autofocus>
                    </div>
                </div>

                <div class="input-group">
                    <label>Senha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password"
                               placeholder="********"
                               required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                           
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="submitBtn">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </form>

            <div class="test-credentials">
                <p>Credenciais de teste:</p>
                <div class="cred-box">
                    <div><strong>Professor:</strong> professor@colegio.ao / prof123</div>
                    <div><strong>Aluno:</strong> aluno@colegio.ao / aluno123</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Entrando...';
        });
    </script>
</body>
</html>