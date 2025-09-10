@extends('layouts.purpose-admin')

@section('title', 'Kategoriya Tahrirlash')
@section('description', 'Kategoriyani tahrirlash')

@section('content')
<div class="modern-form-container">
    <div class="modern-form-card">
        <div class="modern-form-header">
            <i class="fas fa-edit fa-2x mb-3"></i>
            <h1 class="modern-form-title">Kategoriya Tahrirlash</h1>
            <p class="modern-form-subtitle mb-0">"{{ $category->name }}" kategoriyasini tahrirlash</p>
        </div>
        
        <div class="modern-form-body">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="modern-form-group">
                    <label for="name" class="modern-form-label">
                        Kategoriya nomi <span class="required-indicator">*</span>
                    </label>
                    <input type="text" class="form-control modern-form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $category->name) }}" required 
                           placeholder="Masalan: Matematika">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="modern-form-group">
                    <label for="description" class="modern-form-label">Tavsif</label>
                    <textarea class="form-control modern-form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" 
                              placeholder="Kategoriya haqida qisqacha ma'lumot">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="modern-check">
                    <div class="d-flex align-items-center">
                        <input class="modern-check-input form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <label class="modern-check-label" for="is_active">
                            <strong>Faol kategoriya</strong>
                            <br><small class="text-muted">Bu kategoriya testlarda ishlatilishi mumkin</small>
                        </label>
                    </div>
                </div>

                <div class="modern-form-actions">
                    <a href="{{ route('admin.categories.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Orqaga
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i>
                        Yangilash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
