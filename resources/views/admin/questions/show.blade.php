@extends('layouts.admin')

@section('title', 'Savol - #' . $question->id)

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-1">Savol #{{ $question->id }}</h1>
            <p class="text-muted mb-0">{{ $question->category->name }} kategoriyasida</p>
        </div>
        <div class="col-auto">
            <div class="btn-group">
                <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Tahrirlash
                </a>
                <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Orqaga
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Savol matni</h5>
            </div>
            <div class="card-body">
                <p class="fs-5 mb-0">{{ $question->question }}</p>
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
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Javob variantlari</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card {{ $question->correct_answer === 'a' ? 'border-success' : '' }}">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $question->correct_answer === 'a' ? 'bg-success' : 'bg-secondary' }} me-3" style="min-width: 32px;">A</span>
                                    <span class="flex-grow-1">{{ $question->option_a }}</span>
                                    @if($question->correct_answer === 'a')
                                        <i class="fas fa-check text-success ms-2"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card {{ $question->correct_answer === 'b' ? 'border-success' : '' }}">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $question->correct_answer === 'b' ? 'bg-success' : 'bg-secondary' }} me-3" style="min-width: 32px;">B</span>
                                    <span class="flex-grow-1">{{ $question->option_b }}</span>
                                    @if($question->correct_answer === 'b')
                                        <i class="fas fa-check text-success ms-2"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card {{ $question->correct_answer === 'c' ? 'border-success' : '' }}">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $question->correct_answer === 'c' ? 'bg-success' : 'bg-secondary' }} me-3" style="min-width: 32px;">C</span>
                                    <span class="flex-grow-1">{{ $question->option_c }}</span>
                                    @if($question->correct_answer === 'c')
                                        <i class="fas fa-check text-success ms-2"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card {{ $question->correct_answer === 'd' ? 'border-success' : '' }}">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $question->correct_answer === 'd' ? 'bg-success' : 'bg-secondary' }} me-3" style="min-width: 32px;">D</span>
                                    <span class="flex-grow-1">{{ $question->option_d }}</span>
                                    @if($question->correct_answer === 'd')
                                        <i class="fas fa-check text-success ms-2"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success d-flex align-items-center mt-4">
                    <i class="fas fa-check-circle me-3"></i>
                    <div>
                        <strong>To'g'ri javob:</strong> 
                        {{ strtoupper($question->correct_answer) }} - {{ $question->{'option_' . $question->correct_answer} }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" 
                      class="d-inline">
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
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Savol ma'lumotlari</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">ID:</th>
                            <td>#{{ $question->id }}</td>
                        </tr>
                        <tr>
                            <th>Kategoriya:</th>
                            <td>
                                <span class="badge bg-info">{{ $question->category->name }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Holati:</th>
                            <td>
                                @if($question->is_active)
                                    <span class="badge bg-success">Faol</span>
                                @else
                                    <span class="badge bg-danger">Nofaol</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Yaratilgan:</th>
                            <td>{{ $question->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Yangilangan:</th>
                            <td>{{ $question->updated_at->format('d.m.Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>To'g'ri javob:</th>
                            <td>
                                <span class="badge bg-success">{{ strtoupper($question->correct_answer) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
