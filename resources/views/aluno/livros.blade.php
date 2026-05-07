@extends('layouts.aluno')

@section('content')
<div class="container-fluid px-4">
    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-primary">
                <i class="fas fa-book me-2"></i> Meus Livros
            </h4>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('aluno.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Livros</li>
                </ol>
            </nav>
        </div>
        <span class="badge bg-primary px-3 py-2">
            <i class="fas fa-graduation-cap me-1"></i> {{ $classe->nome ?? 'Minha Turma' }}
        </span>
    </div>

    @if(isset($error))
        <div class="alert alert-warning">{{ $error }}</div>
    @elseif($livros->count() > 0)
        @foreach($livrosPorDisciplina as $disciplinaNome => $livrosDisciplina)
        <div class="card mb-4">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-book-open text-primary fs-5"></i>
                    <strong class="fs-5">{{ $disciplinaNome }}</strong>
                    <span class="badge bg-secondary rounded-pill">{{ $livrosDisciplina->count() }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($livrosDisciplina as $livro)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card livro-card h-100">
                            <div class="row g-0 h-100">
                                <div class="col-4">
                                    @php
                                        $capaUrl = $livro->capa && Storage::disk('public')->exists($livro->capa) 
                                            ? Storage::url($livro->capa) 
                                            : 'https://ui-avatars.com/api/?background=1e3a8a&color=fff&size=120&length=2&name=' . urlencode(substr($livro->titulo, 0, 2));
                                    @endphp
                                    <div class="livro-capa">
                                        <img src="{{ $capaUrl }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Capa">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-2 p-md-3">
                                        <h6 class="card-title fw-bold mb-1">{{ Str::limit($livro->titulo, 40) }}</h6>
                                        <p class="small text-muted mb-1">
                                            <i class="fas fa-user-edit me-1"></i> {{ $livro->autor ?? 'Autor' }}
                                        </p>
                                        <p class="small text-muted mb-2">
                                            <i class="fas fa-download me-1"></i> {{ $livro->downloads ?? 0 }}
                                        </p>
                                        <a href="{{ route('aluno.download-livro', $livro->id) }}" class="btn btn-sm btn-primary w-100">
                                            <i class="fas fa-download me-1"></i> Baixar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Nenhum livro disponível</h5>
                <p class="text-muted small">Os livros serão disponibilizados em breve.</p>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .livro-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }
    .livro-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .livro-capa {
        height: 140px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        overflow: hidden;
    }
    @media (max-width: 768px) {
        .livro-capa { height: 110px; }
        .card-title { font-size: 0.8rem; }
    }
</style>
@endpush