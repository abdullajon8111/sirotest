@extends('layouts.purpose-admin')

@section('title', 'Savol - #' . $question->id)
@section('description', 'Savol ma\'lumotlarini ko\'rish')

@section('content')
<div class="purpose-card purpose-fade-in">
    <div class="purpose-card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="purpose-card-title">
                <i class="fas fa-question-circle"></i>
                Savol #{{ $question->id }}
            </h1>
            <span class="purpose-badge purpose-badge-info">{{ $question->category->name }}</span>
        </div>
    </div>
    <div class="purpose-card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="purpose-stats-card">
                    <div class="purpose-stats-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="purpose-stats-label">Kategoriya</div>
                    <div class="purpose-stats-number" style="font-size: 1.2rem;">{{ $question->category->name }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="purpose-stats-card {{ $question->is_active ? 'success' : 'danger' }}">
                    <div class="purpose-stats-icon">
                        <i class="fas {{ $question->is_active ? 'fa-check' : 'fa-times' }}"></i>
                    </div>
                    <div class="purpose-stats-label">Holati</div>
                    <div class="purpose-stats-number" style="font-size: 1.2rem;">{{ $question->is_active ? 'Faol' : 'Nofaol' }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="purpose-stats-card info">
                    <div class="purpose-stats-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="purpose-stats-label">Yaratilgan</div>
                    <div class="purpose-stats-number" style="font-size: 1.2rem;">{{ $question->created_at->format('d.m.Y') }}</div>
                </div>
            </div>
        </div>

        <div class="purpose-card mb-4">
            <div class="purpose-card-header">
                <h3 class="purpose-card-title">
                    <i class="fas fa-question"></i>
                    Savol matni
                </h3>
            </div>
            <div class="purpose-card-body">
                <p class="fs-5 mb-0">{{ $question->question }}</p>
            </div>
        </div>

        <div class="purpose-card">
            <div class="purpose-card-header">
                <h3 class="purpose-card-title">
                    <i class="fas fa-list-ul"></i>
                    Javob variantlari
                </h3>
            </div>
            <div class="purpose-card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="purpose-card {{ $question->correct_answer === 'a' ? 'purpose-shadow-lg' : '' }}" style="{{ $question->correct_answer === 'a' ? 'border: 2px solid #2dce89;' : 'border: 1px solid #e2e8f0;' }}">
                            <div class="purpose-card-body py-3">
                                <div class="d-flex align-items-center">
                                    <span class="purpose-badge purpose-badge-{{ $question->correct_answer === 'a' ? 'success' : 'secondary' }} me-3" style="min-width: 32px;">A</span>
                                    <span class="flex-grow-1">{{ $question->option_a }}</span>
                                    @if($question->correct_answer === 'a')
                                        <i class="fas fa-check purpose-text-success ms-2"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="purpose-card {{ $question->correct_answer === 'b' ? 'purpose-shadow-lg' : '' }}" style="{{ $question->correct_answer === 'b' ? 'border: 2px solid #2dce89;' : 'border: 1px solid #e2e8f0;' }}">
                            <div class="purpose-card-body py-3">
                                <div class="d-flex align-items-center">
                                    <span class="purpose-badge purpose-badge-{{ $question->correct_answer === 'b' ? 'success' : 'secondary' }} me-3" style="min-width: 32px;">B</span>
                                    <span class="flex-grow-1">{{ $question->option_b }}</span>
                                    @if($question->correct_answer === 'b')
                                        <i class="fas fa-check purpose-text-success ms-2"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="purpose-card {{ $question->correct_answer === 'c' ? 'purpose-shadow-lg' : '' }}" style="{{ $question->correct_answer === 'c' ? 'border: 2px solid #2dce89;' : 'border: 1px solid #e2e8f0;' }}">
                            <div class="purpose-card-body py-3">
                                <div class="d-flex align-items-center">
                                    <span class="purpose-badge purpose-badge-{{ $question->correct_answer === 'c' ? 'success' : 'secondary' }} me-3" style="min-width: 32px;">C</span>
                                    <span class="flex-grow-1">{{ $question->option_c }}</span>
                                    @if($question->correct_answer === 'c')
                                        <i class="fas fa-check purpose-text-success ms-2"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="purpose-card {{ $question->correct_answer === 'd' ? 'purpose-shadow-lg' : '' }}" style="{{ $question->correct_answer === 'd' ? 'border: 2px solid #2dce89;' : 'border: 1px solid #e2e8f0;' }}">
                            <div class="purpose-card-body py-3">
                                <div class="d-flex align-items-center">
                                    <span class="purpose-badge purpose-badge-{{ $question->correct_answer === 'd' ? 'success' : 'secondary' }} me-3" style="min-width: 32px;">D</span>
                                    <span class="flex-grow-1">{{ $question->option_d }}</span>
                                    @if($question->correct_answer === 'd')
                                        <i class="fas fa-check purpose-text-success ms-2"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="purpose-alert purpose-alert-success purpose-alert-icon mt-4">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>To'g'ri javob:</strong> 
                        {{ strtoupper($question->correct_answer) }} - {{ $question->{'option_' . $question->correct_answer} }}
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.questions.index') }}" class="purpose-btn purpose-btn-secondary">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
            <div>
                <a href="{{ route('admin.questions.edit', $question) }}" class="purpose-btn purpose-btn-primary me-2">
                    <i class="fas fa-edit"></i> Tahrirlash
                </a>
                <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" 
                      style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="purpose-btn purpose-btn-danger" 
                            onclick="return confirm('Rostdan ham bu savolni o\'chirmoqchimisiz?')">
                        <i class="fas fa-trash"></i> O'chirish
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
