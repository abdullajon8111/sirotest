@extends('layouts.admin')

@section('title', 'Yangi test yaratish')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Yangi test yaratish</h4>
                    <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Orqaga
                    </a>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('admin.tests.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Test nomi <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Tavsif</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration_minutes" class="form-label">Davomiyligi (daqiqa) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('duration_minutes') is-invalid @enderror" 
                                           id="duration_minutes" 
                                           name="duration_minutes" 
                                           value="{{ old('duration_minutes', 30) }}" 
                                           min="1" 
                                           required>
                                    @error('duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="max_attempts" class="form-label">Maksimal urinish <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('max_attempts') is-invalid @enderror" 
                                           id="max_attempts" 
                                           name="max_attempts" 
                                           value="{{ old('max_attempts', 3) }}" 
                                           min="1" 
                                           required>
                                    @error('max_attempts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Boshlanish vaqti <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                           class="form-control @error('start_time') is-invalid @enderror" 
                                           id="start_time" 
                                           name="start_time" 
                                           value="{{ old('start_time', now()->format('Y-m-d\TH:i')) }}" 
                                           required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">Tugash vaqti <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                           class="form-control @error('end_time') is-invalid @enderror" 
                                           id="end_time" 
                                           name="end_time" 
                                           value="{{ old('end_time', now()->addDays(7)->format('Y-m-d\TH:i')) }}" 
                                           required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Kategoriyalar va savollar soni <span class="text-danger">*</span></label>
                            <div class="row">
                                @foreach($categories as $category)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">{{ $category->name }}</h6>
                                                <small class="text-muted">Umumiy: {{ $category->activeQuestions->count() }} ta savol</small>
                                            </div>
                                            <div class="card-body">
                                                <label for="categories_{{ $category->id }}" class="form-label">Savollar soni</label>
                                                <input type="number" 
                                                       class="form-control @error('categories.' . $category->id) is-invalid @enderror" 
                                                       id="categories_{{ $category->id }}" 
                                                       name="categories[{{ $category->id }}]" 
                                                       value="{{ old('categories.' . $category->id, 0) }}" 
                                                       min="0" 
                                                       max="{{ $category->activeQuestions->count() }}">
                                                @error('categories.' . $category->id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktiv
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary me-2">Bekor qilish</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Saqlash
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
