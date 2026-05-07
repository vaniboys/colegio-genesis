<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $livro->titulo }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
        }
        .titulo {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
        }
        .info {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            text-align: center;
            font-size: 10px;
            color: #999;
            padding: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="titulo">{{ $livro->titulo }}</div>
    </div>
    
    <div class="info">
        <p><strong>Autor:</strong> {{ $livro->autor ?? 'Não informado' }}</p>
        <p><strong>Editora:</strong> {{ $livro->editora ?? 'Não informada' }}</p>
        <p><strong>Ano:</strong> {{ $livro->ano_publicacao ?? 'Não informado' }}</p>
    </div>
    
    <div>
        <strong>Descrição:</strong>
        <p>{{ $livro->descricao ?? 'Sem descrição disponível.' }}</p>
    </div>
    
    <div class="footer">
        Documento gerado por {{ config('app.name') }} em {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>