@extends('layouts.admin')

@section('title', 'Yangi Kategoriya')
@section('description', 'Yangi kategoriya yaratish')

@section('content')
<div class="">
    <div class="card shadow-sm">
        <div class="card-header bg-primary">
            <div class="d-flex align-items-center">
                <i class="fas fa-folder-plus me-3 fs-4"></i>
                <div>
                    <h4 class="mb-0">Yangi Kategoriya Yaratish</h4>
                    <small class="opacity-75">Test kategoriyasi uchun ma'lumotlarni kiriting</small>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">
                        Kategoriya nomi <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name') }}" required
                           placeholder="Masalan: Matematika">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Tavsif</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4"
                              placeholder="Kategoriya haqida qisqacha ma'lumot">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        <strong>Faol kategoriya</strong>
                        <br><small class="text-muted">Bu kategoriya testlarda ishlatilishi mumkin</small>
                    </label>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Orqaga
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
