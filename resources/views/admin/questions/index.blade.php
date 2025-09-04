@extends('layouts.admin')

@section('title', 'Savollar')
@section('description', 'Test savollarini boshqarish')

@section('content')
<div class="modern-page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="modern-page-title">
            <i class="fas fa-question-circle me-3"></i>Savollar
        </h1>
        <a href="{{ route('admin.questions.create') }}" class="modern-btn modern-btn-primary">
            <i class="fas fa-plus me-2"></i>Yangi savol
        </a>
    </div>
</div>

<div class="modern-card">
    <div class="card-body p-0">
        @if($questions->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table mb-0">
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
                                    <span class="modern-badge bg-info text-white">
                                        <i class="fas fa-folder me-1"></i>{{ $question->category->name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="modern-badge bg-success text-white">
                                        {{ strtoupper($question->correct_answer) }}
                                    </span>
                                </td>
                                <td>
                                    @if($question->is_active)
                                        <span class="modern-badge bg-success text-white">
                                            <i class="fas fa-check me-1"></i>Faol
                                        </span>
                                    @else
                                        <span class="modern-badge bg-danger text-white">
                                            <i class="fas fa-times me-1"></i>Nofaol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $question->created_at->format('d.m.Y') }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('admin.questions.show', $question) }}" 
                                           class="action-btn btn-outline-info" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.questions.edit', $question) }}" 
                                           class="action-btn btn-outline-warning" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-outline-danger" title="O'chirish"
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
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3 class="empty-state-title">Hozircha savollar yo'q</h3>
                <p class="empty-state-description">Birinchi savolni yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.questions.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi savolni yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
