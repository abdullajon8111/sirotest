@extends('layouts.app')

@section('title', 'Savol - #' . $question->id)
@section('page-title', 'Savol Ma\'lumotlari')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Savol #{{ $question->id }}</h5>
                <span class="badge bg-info">{{ $question->category->name }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3"><strong>Kategoriya:</strong></div>
                    <div class="col-md-9">{{ $question->category->name }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3"><strong>Holati:</strong></div>
                    <div class="col-md-9">
                        @if($question->is_active)
                            <span class="badge bg-success">Faol</span>
                        @else
                            <span class="badge bg-danger">Nofaol</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3"><strong>Yaratilgan:</strong></div>
                    <div class="col-md-9">{{ $question->created_at->format('d.m.Y H:i') }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3"><strong>Yangilangan:</strong></div>
                    <div class="col-md-9">{{ $question->updated_at->format('d.m.Y H:i') }}</div>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Savol</h6>
                    </div>
                    <div class="card-body">
                        <p class="fs-5">{{ $question->question }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="mb-3">Javob variantlari:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-2 {{ $question->correct_answer === 'a' ? 'border-success' : 'border-secondary' }}">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge {{ $question->correct_answer === 'a' ? 'bg-success' : 'bg-secondary' }} me-2">A</span>
                                        <span>{{ $question->option_a }}</span>
                                        @if($question->correct_answer === 'a')
                                            <i class="fas fa-check text-success ms-auto"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-2 {{ $question->correct_answer === 'b' ? 'border-success' : 'border-secondary' }}">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge {{ $question->correct_answer === 'b' ? 'bg-success' : 'bg-secondary' }} me-2">B</span>
                                        <span>{{ $question->option_b }}</span>
                                        @if($question->correct_answer === 'b')
                                            <i class="fas fa-check text-success ms-auto"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-2 {{ $question->correct_answer === 'c' ? 'border-success' : 'border-secondary' }}">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge {{ $question->correct_answer === 'c' ? 'bg-success' : 'bg-secondary' }} me-2">C</span>
                                        <span>{{ $question->option_c }}</span>
                                        @if($question->correct_answer === 'c')
                                            <i class="fas fa-check text-success ms-auto"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-2 {{ $question->correct_answer === 'd' ? 'border-success' : 'border-secondary' }}">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge {{ $question->correct_answer === 'd' ? 'bg-success' : 'bg-secondary' }} me-2">D</span>
                                        <span>{{ $question->option_d }}</span>
                                        @if($question->correct_answer === 'd')
                                            <i class="fas fa-check text-success ms-auto"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mt-3">
                        <strong><i class="fas fa-check-circle"></i> To'g'ri javob:</strong> 
                        {{ strtoupper($question->correct_answer) }} - {{ $question->{'option_' . $question->correct_answer} }}
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Tahrirlash
                    </a>
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Orqaga
                    </a>
                    <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" 
                          style="display: inline-block;" class="ms-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Rostdan ham bu savolni o\'chirmoqchimisiz?')">
                            <i class="fas fa-trash"></i> O'chirish
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
