<div style="background: white; border-radius: 12px; padding: 16px; border: 1px solid #e2e8f0;">
    <h3 style="font-weight: 700; margin-bottom: 12px;">Alertas</h3>
    
    @if($turmasSemProfessor > 0)
        <div style="background: #fef2f2; padding: 12px; border-radius: 8px; margin-bottom: 8px;">
            <p style="color: #dc2626; font-weight: 600; margin: 0;">{{ $turmasSemProfessor }} turma(s) sem professor</p>
        </div>
    @endif

    @if($alunosInadimplentes > 0)
        <div style="background: #fffbeb; padding: 12px; border-radius: 8px;">
            <p style="color: #d97706; font-weight: 600; margin: 0;">{{ $alunosInadimplentes }} aluno(s) inadimplentes</p>
        </div>
    @endif

    @if($turmasSemProfessor == 0 && $alunosInadimplentes == 0)
        <div style="background: #f0fdf4; padding: 12px; border-radius: 8px;">
            <p style="color: #16a34a; font-weight: 600; margin: 0;">✅ Tudo em ordem!</p>
        </div>
    @endif
</div>