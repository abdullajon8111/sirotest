@extends('layouts.admin')

@section('title', 'Savollar')
@section('description', 'Test savollarini boshqarish')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-1">Savollar</h1>
            <p class="text-muted mb-0">Test savollarini boshqarish va tahrirlash</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Yangi savol
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($questions->count() > 0)
            <div class="table-responsive">
                <table class="table mb-0">
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
                                    <span class="badge bg-info">
                                        <i class="fas fa-folder me-1"></i>{{ $question->category->name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">
                                        {{ strtoupper($question->correct_answer) }}
                                    </span>
                                </td>
                                <td>
                                    @if($question->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Faol
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times me-1"></i>Nofaol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $question->created_at->format('d.m.Y') }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.questions.show', $question) }}" 
                                           class="btn btn-outline-primary" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.questions.edit', $question) }}" 
                                           class="btn btn-outline-warning" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="O'chirish"
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
                    <i class="fas fa-question-circle fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">Hozircha savollar yo'q</h3>
                <p class="text-muted mb-4">Birinchi savolni yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi savolni yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
