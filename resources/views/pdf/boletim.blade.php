<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Boletim Escolar</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 10px;
        }
        .header h1 { color: #1e3a8a; margin: 0; font-size: 20px; }
        .info { margin-bottom: 20px; padding: 10px; background: #f5f5f5; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #1e3a8a; color: white; padding: 8px; text-align: center; }
        td { border: 1px solid #ddd; padding: 6px; text-align: center; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
        .assinatura { margin-top: 40px; display: flex; justify-content: space-between; }
        .assinatura div { text-align: center; width: 200px; }
        .assinatura hr { margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Colégio Gênesis</h1>
        <p>Sistema de Gestão Escolar - Angola</p>
        <h3>Boletim Escolar - {{ $anoLectivo }}</h3>
    </div>

    <div class="info">
        <p><strong>Aluno:</strong> {{ $aluno->nome_completo }} | 
           <strong>Processo:</strong> {{ $aluno->processo }} |
           <strong>Turma:</strong> {{ $matricula->turma->nome ?? 'N/A' }}</p>
        <p><strong>Data Emissão:</strong> {{ $dataEmissao->format('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Disciplina</th>
                <th>MAC</th>
                <th>Prova</th>
                <th>Média</th>
                <th>Exame</th>
                <th>Média Final</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notas as $nota)
            <tr>
                <td><strong>{{ $nota->disciplina->nome }}</strong></td>
                {{-- ✅ Colunas reais da tabela notas --}}
                <td>{{ number_format($nota->avaliacao_continua ?? 0, 1) }}</td>
                <td>{{ number_format($nota->prova_trimestral ?? 0, 1) }}</td>
                <td>{{ number_format($nota->media_trimestral ?? 0, 1) }}</td>
                <td>{{ $nota->exame_final ? number_format($nota->exame_final, 1) : '-' }}</td>
                <td><strong>{{ number_format($nota->media_final ?? $nota->media_trimestral ?? 0, 1) }}</strong></td>
                <td>
                    {{ $nota->situacao ?? (($nota->media_final ?? $nota->media_trimestral ?? 0) >= 10 ? 'Aprovado' : 'Reprovado') }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #f0f0f0;">
                <th colspan="5">Média Geral</th>
                <th colspan="2">{{ number_format($mediaGeral, 1) }} - {{ $mediaGeral >= 10 ? 'Aprovado' : 'Reprovado' }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="info">
        <strong>Resumo:</strong><br>
        Melhor Nota: {{ number_format($melhorNota, 1) }} | 
        Pior Nota: {{ number_format($piorNota, 1) }} | 
        Total de Faltas: {{ $totalFaltas }}
    </div>

    <div class="assinatura">
        <div><hr><small>Secretaria Escolar</small></div>
        <div><hr><small>Direção Pedagógica</small></div>
        <div><hr><small>Encarregado de Educação</small></div>
    </div>

    <div class="footer">
        Documento gerado eletronicamente - Colégio Gênesis<br>
        Angola, {{ $dataEmissao->format('d/m/Y') }}
    </div>
</body>
</html>