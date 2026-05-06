<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $livro->titulo }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .titulo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .autor {
            font-size: 16px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        .descricao {
            margin: 20px 0;
            text-align: justify;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #95a5a6;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="titulo">{{ $livro->titulo }}</div>
        <div class="autor">Por: {{ $livro->autor ?? 'Autor não informado' }}</div>
    </div>

    <div class="info">
        <strong>Informações:</strong><br>
        @if($livro->editora) Editora: {{ $livro->editora }}<br> @endif
        @if($livro->ano_publicacao) Ano: {{ $livro->ano_publicacao }}<br> @endif
        @if($livro->isbn) ISBN: {{ $livro->isbn }}<br> @endif
        @if($livro->idioma) Idioma: {{ $livro->idioma }}<br> @endif
    </div>

    @if($livro->descricao)
    <div class="descricao">
        <strong>Descrição:</strong><br>
        {{ $livro->descricao }}
    </div>
    @endif

    @if($livro->sinopse)
    <div class="descricao">
        <strong>Sinopse:</strong><br>
        {{ $livro->sinopse }}
    </div>
    @endif

    <div class="footer">
        Documento gerado em {{ now()->format('d/m/Y H:i:s') }} | {{ config('app.name') }}
    </div>
</body>
</html>