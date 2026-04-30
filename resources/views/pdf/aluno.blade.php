<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ficha do Aluno</title>
    <style>
        body { font-family: Arial; font-size: 12px; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; }
        h1 { color: #1e3a8a; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #1e3a8a; color: white; padding: 8px; text-align: left; }
        td { border: 1px solid #ddd; padding: 6px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Colégio Gênesis</h1>
        <p>Ficha do Aluno</p>
    </div>

    <table>
        <tr><td><strong>Processo:</strong></td><td>{{ $aluno->processo }}</td></tr>
        <tr><td><strong>Nome:</strong></td><td>{{ $aluno->nome_completo }}</td></tr>
        <tr><td><strong>Data Nasc.:</strong></td><td>{{ $aluno->data_nascimento ? date('d/m/Y', strtotime($aluno->data_nascimento)) : '-' }}</td></tr>
        <tr><td><strong>Sexo:</strong></td><td>{{ $aluno->sexo == 'M' ? 'Masculino' : 'Feminino' }}</td></tr>
        <tr><td><strong>BI:</strong></td><td>{{ $aluno->bi }}</td></tr>
        <tr><td><strong>Telefone:</strong></td><td>{{ $aluno->telefone ?? '-' }}</td></tr>
        <tr><td><strong>Email:</strong></td><td>{{ $aluno->email ?? '-' }}</td></tr>
        <tr><td><strong>Endereço:</strong></td><td>{{ $aluno->endereco ?? '-' }}</td></tr>
        <tr><td><strong>Situação:</strong></td><td>{{ ucfirst($aluno->situacao) }}</td></tr>
    </table>

    <p style="text-align: center; font-size: 10px; color: #666;">
        Documento gerado em {{ date('d/m/Y H:i:s') }}
    </p>
</body>
</html>