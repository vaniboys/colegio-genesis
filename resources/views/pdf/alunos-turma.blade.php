<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Alunos - {{ $turma->nome }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #1e3a8a;
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #1e3a8a;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 10px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .total {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Colégio Gênesis</h1>
        <p>Lista de Alunos - Turma {{ $turma->nome }}</p>
        <p>Turno: {{ ucfirst($turma->turno) }} | Data: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Processo</th>
                <th>Nome Completo</th>
                <th>BI</th>
                <th>Data Nasc.</th>
                <th>Contacto</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alunos as $index => $aluno)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $aluno->processo ?? '-' }}</td>
                <td>{{ $aluno->nome_completo }}</td>
                <td>{{ $aluno->bi ?? '-' }}</td>
                <td>{{ $aluno->data_nascimento ? date('d/m/Y', strtotime($aluno->data_nascimento)) : '-' }}</td>
                {{-- ✅ Colunas que existem --}}
                <td>{{ $aluno->telefone ?? $aluno->contacto_principal ?? '-' }}</td>
                <td>{{ $aluno->email ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total de Alunos: {{ $alunos->count() }}
    </div>

    <div class="footer">
        Documento gerado pelo sistema de gestão escolar - Colégio Gênesis
    </div>
</body>
</html>