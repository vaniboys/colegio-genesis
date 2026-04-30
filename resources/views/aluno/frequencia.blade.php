@extends('layouts.aluno')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Minha Frequência</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-check me-2"></i> Frequência Escolar
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Consulte aqui o seu registo de faltas por disciplina.
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Disciplina</th>
                                <th class="text-center">Total de Aulas</th>
                                <th class="text-center">Faltas</th>
                                <th class="text-center">Presenças</th>
                                <th class="text-center">Percentagem</th>
                                <th class="text-center">Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Nenhum registo de frequência disponível.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i> Resumo de Frequência
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-muted">Total de Faltas no Ano</h6>
                            <h3 class="text-warning">0</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-muted">Percentagem de Presença</h6>
                            <h3 class="text-success">100%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection