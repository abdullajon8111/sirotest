@extends('layouts.purpose-admin')

@section('title', 'Savollar')
@section('description', 'Test savollarini boshqarish')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="purpose-header-title mb-1">
            <i class="fas fa-question-circle me-3"></i>Savollar
        </h1>
        <p class="purpose-text-muted">Test savollarini boshqarish va tahrirlash</p>
    </div>
    <a href="{{ route('admin.questions.create') }}" class="purpose-btn purpose-btn-primary">
        <i class="fas fa-plus me-2"></i>Yangi savol
    </a>
</div>

<div class="purpose-card purpose-fade-in">
    <div class="purpose-card-body p-0">
        @if($questions->count() > 0)
            <div class="table-responsive">
                <table class="table purpose-table mb-0">
                    <thead>
                        <tr>
                            <th width="80">#</th>
                            <th>Savol</th>
                            <th width="150">Kategoriya</th>
                            <th width="120">To'g'ri javob</th>
                            <th width="100">Holati</th>
                            <th width="120">Yaratilgan</th>
                            <th width="150">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary">#{{ $question->id }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ Str::limit($question->question, 60) }}</div>
                                </td>
                                <td>
                                    <span class="purpose-badge purpose-badge-info">
                                        <i class="fas fa-folder me-1"></i>{{ $question->category->name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="purpose-badge purpose-badge-success">
                                        {{ strtoupper($question->correct_answer) }}
                                    </span>
                                </td>
                                <td>
                                    @if($question->is_active)
                                        <span class="purpose-badge purpose-badge-success">
                                            <i class="fas fa-check me-1"></i>Faol
                                        </span>
                                    @else
                                        <span class="purpose-badge purpose-badge-danger">
                                            <i class="fas fa-times me-1"></i>Nofaol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $question->created_at->format('d.m.Y') }}</span>
                                </td>
                                <td>
                                    <div class="purpose-table-actions">
                                        <a href="{{ route('admin.questions.show', $question) }}" 
                                           class="purpose-action-btn purpose-action-btn-primary" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.questions.edit', $question) }}" 
                                           class="purpose-action-btn purpose-action-btn-success" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="purpose-action-btn purpose-action-btn-danger" title="O'chirish"
                                                    onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                {{ $questions->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-question-circle" style="font-size: 4rem; color: #e5e7eb;"></i>
                </div>
                <h3 class="purpose-text-muted mb-3">Hozircha savollar yo'q</h3>
                <p class="purpose-text-muted mb-4">Birinchi savolni yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.questions.create') }}" class="purpose-btn purpose-btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi savolni yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
