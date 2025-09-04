@extends('layouts.app')

@section('title', 'Kategoriya - ' . $category->name)
@section('page-title', 'Kategoriya Ma\'lumotlari')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $category->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Nomi:</strong></div>
                    <div class="col-md-9">{{ $category->name }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Tavsif:</strong></div>
                    <div class="col-md-9">{{ $category->description ?: 'Tavsif yo\'q' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Holati:</strong></div>
                    <div class="col-md-9">
                        @if($category->is_active)
                            <span class="badge bg-success">Faol</span>
                        @else
                            <span class="badge bg-danger">Nofaol</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Savollar soni:</strong></div>
                    <div class="col-md-9">{{ $category->questions->count() }} ta</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Yaratilgan:</strong></div>
                    <div class="col-md-9">{{ $category->created_at->format('d.m.Y H:i') }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Yangilangan:</strong></div>
                    <div class="col-md-9">{{ $category->updated_at->format('d.m.Y H:i') }}</div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Tahrirlash
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Orqaga
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Kategoriya Savollari</h6>
            </div>
            <div class="card-body">
                @if($category->questions->count() > 0)
                    @foreach($category->questions->take(5) as $question)
                        <div class="mb-2 p-2 border rounded">
                            <small class="text-muted">#{{ $question->id }}</small>
                            <div>{{ Str::limit($question->question, 50) }}</div>
                            <small class="text-muted">
                                To'g'ri javob: {{ strtoupper($question->correct_answer) }}
                            </small>
                        </div>
                    @endforeach
                    
                    @if($category->questions->count() > 5)
                        <div class="text-center">
                            <small class="text-muted">
                                va yana {{ $category->questions->count() - 5 }} ta savol...
                            </small>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('admin.questions.index') }}?category={{ $category->id }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Barcha savollar
                        </a>
                    </div>
                @else
                    <p class="text-muted">Bu kategoriyada hali savollar yo'q.</p>
                    <a href="{{ route('admin.questions.create') }}?category={{ $category->id }}" 
                       class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Birinchi savolni qo'shing
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
