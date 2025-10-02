@extends('layouts.admin')

@section('title', 'Foydalanuvchini tahrirlash')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-1">Foydalanuvchini tahrirlash</h1>
            <p class="text-muted mb-0">{{ $user->name }} ning ma'lumotlarini o'zgartirish</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Foydalanuvchi ma'lumotlari</h5>
            </div>
            <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Ism <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Yangi parol</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password">
                            <small class="form-text text-muted">Parolni o'zgartirmaslik uchun bo'sh qoldiring</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Yangi parolni tasdiqlang</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation">
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Rol <span class="text-danger">*</span></label>
                            <select class="form-control @error('role') is-invalid @enderror" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Rolni tanlang...</option>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Foydalanuvchi</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktiv
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Bekor qilish</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Yangilash
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
