@extends('layouts.aluno')

@section('content')
<div class="container-fluid px-4">
    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1" style="color: #1e3a8a;">
                <i class="fas fa-book me-2"></i> Livros de Apoio
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('aluno.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Livros de Apoio</li>
                </ol>
            </nav>
        </div>
        <div>
            <span class="badge bg-primary p-2">
                <i class="fas fa-calendar-alt me-1"></i> Ano Letivo: {{ date('Y') }}
            </span>
        </div>
    </div>

    @if($livros->count() > 0)
        {{-- Livros Organizados por Disciplina --}}
        @foreach($livrosPorDisciplina as $item)
            @if($item['livros']->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-book-open me-2 text-primary"></i>
                            <strong>{{ $item['disciplina']->nome }}</strong>
                            <span class="badge bg-secondary ms-2">{{ $item['disciplina']->codigo }}</span>
                        </div>
                        <span class="badge bg-info">{{ $item['livros']->count() }} livros</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($item['livros'] as $livro)
                        <div class="col-md-4 col-lg-3">
                            <div class="livro-card">
                                <div class="livro-cover">
                                    @if($livro->capa)
                                        <img src="{{ Storage::url($livro->capa) }}" alt="{{ $livro->titulo }}" class="livro-img">
                                    @else
                                        <div class="livro-placeholder">
                                            <i class="fas fa-book fa-4x text-primary"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="livro-info">
                                    <h6 class="livro-titulo">{{ Str::limit($livro->titulo, 40) }}</h6>
                                    <p class="livro-autor">
                                        <i class="fas fa-user-edit me-1"></i> {{ $livro->autor ?? 'Autor não informado' }}
                                    </p>
                                    <p class="livro-editora">
                                        <i class="fas fa-building me-1"></i> {{ $livro->editora ?? 'Editora não informada' }}
                                    </p>
                                    <div class="livro-actions">
                                        <a href="{{ route('aluno.download-livro', $livro->id) }}" class="btn btn-sm btn-primary w-100">
                                            <i class="fas fa-download me-1"></i> Baixar PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        @endforeach

        {{-- Livros Gerais (sem disciplina específica) --}}
        @php
            $livrosGerais = $livros->whereNull('disciplina_id');
        @endphp
        @if($livrosGerais->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-white">
                <i class="fas fa-folder-open me-2 text-primary"></i>
                <strong>Materiais Gerais de Apoio</strong>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($livrosGerais as $livro)
                    <div class="col-md-4 col-lg-3">
                        <div class="livro-card">
                            <div class="livro-cover">
                                @if($livro->capa)
                                    <img src="{{ Storage::url($livro->capa) }}" alt="{{ $livro->titulo }}" class="livro-img">
                                @else
                                    <div class="livro-placeholder">
                                        <i class="fas fa-book fa-4x text-primary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="livro-info">
                                <h6 class="livro-titulo">{{ Str::limit($livro->titulo, 40) }}</h6>
                                <p class="livro-autor">
                                    <i class="fas fa-user-edit me-1"></i> {{ $livro->autor ?? 'Autor não informado' }}
                                </p>
                                <div class="livro-actions">
                                    <a href="{{ route('aluno.download-livro', $livro->id) }}" class="btn btn-sm btn-primary w-100">
                                        <i class="fas fa-download me-1"></i> Baixar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3 d-block"></i>
                <h5 class="text-muted">Nenhum livro disponível</h5>
                <p class="text-muted small">Os livros de apoio serão disponibilizados em breve.</p>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .livro-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .livro-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .livro-cover {
        background: #f0f2f5;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .livro-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .livro-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
    }
    
    .livro-info {
        padding: 15px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .livro-titulo {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1e3a8a;
        line-height: 1.3;
    }
    
    .livro-autor, .livro-editora {
        font-size: 0.7rem;
        color: #6c757d;
        margin-bottom: 4px;
    }
    
    .livro-actions {
        margin-top: auto;
        padding-top: 12px;
    }
    
    @media (max-width: 768px) {
        .livro-cover {
            height: 150px;
        }
        
        .livro-titulo {
            font-size: 0.8rem;
        }
    }
</style>
@endpush