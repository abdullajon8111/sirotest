@extends('layouts.admin')

@section('title', 'Yangi Kategoriya')
@section('description', 'Yangi kategoriya yaratish')

@section('content')
<div class="purpose-form-container purpose-fade-in">
    <div class="purpose-form-card">
        <div class="purpose-form-header">
            <div class="purpose-form-icon">
                <i class="fas fa-folder-plus"></i>
            </div>
            <h1 class="purpose-form-title">Yangi Kategoriya Yaratish</h1>
            <p class="purpose-form-subtitle">Test kategoriyasi uchun ma'lumotlarni kiriting</p>
        </div>
        
        <div class="purpose-form-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                <div class="purpose-form-group">
                    <label for="name" class="purpose-form-label">
                        Kategoriya nomi <span class="purpose-required">*</span>
                    </label>
                    <input type="text" class="purpose-form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required 
                           placeholder="Masalan: Matematika">
                    @error('name')
                        <div class="purpose-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="purpose-form-group">
                    <label for="description" class="purpose-form-label">Tavsif</label>
                    <textarea class="purpose-form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" 
                              placeholder="Kategoriya haqida qisqacha ma'lumot">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="purpose-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="purpose-checkbox">
                    <div class="d-flex align-items-center">
                        <input class="purpose-checkbox-input" type="checkbox" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="purpose-checkbox-label" for="is_active">
                            <strong>Faol kategoriya</strong>
                            <br><small class="purpose-text-muted">Bu kategoriya testlarda ishlatilishi mumkin</small>
                        </label>
                    </div>
                </div>

                <div class="purpose-form-actions">
                    <a href="{{ route('admin.categories.index') }}" class="purpose-btn purpose-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Orqaga
                    </a>
                    <button type="submit" class="purpose-btn purpose-btn-success">
                        <i class="fas fa-save"></i>
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
