<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colégio Gênesis</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a7431 0%, #0d4a1f 100%);
            min-height: 100vh;
        }
        .welcome-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .btn-login {
            background-color: #1a7431;
            border: none;
            padding: 12px 30px;
        }
        .btn-login:hover {
            background-color: #0d4a1f;
        }
        .btn-admin {
            background-color: #6c757d;
            border: none;
            padding: 12px 30px;
        }
        .btn-admin:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6">
                <div class="card welcome-card">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="fas fa-graduation-cap fa-4x text-success"></i>
                        </div>
                        <h1 class="display-5 fw-bold mb-3">Colégio Gênesis</h1>
                        <p class="lead text-muted mb-4">Sistema de Gestão Escolar de Angola</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <a href="/login" class="btn btn-login btn-primary w-100">
                                    <i class="fas fa-user-graduate"></i> Área do Aluno/Professor
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="/admin/login" class="btn btn-admin btn-secondary w-100">
                                    <i class="fas fa-shield-alt"></i> Área Administrativa
                                </a>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <div class="text-muted small">
                            <p class="mb-0">© 2024 Colégio Gênesis - Angola</p>
                            <p class="mb-0">Sistema desenvolvido para gestão escolar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>