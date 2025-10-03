@extends('layouts.admin')

@section('title', 'Foydalanuvchini tahrirlash')

@section('content')
<div class="">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-edit me-3 fs-4"></i>
                <div>
                    <h4 class="mb-0">Foydalanuvchini tahrirlash</h4>
                    <small class="opacity-75">{{ $user->name }} ning ma'lumotlarini o'zgartirish</small>
                </div>
            </div>
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
                            <select class="form-select @error('role') is-invalid @enderror"
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
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Aktiv foydalanuvchi</strong>
                                <br><small class="text-muted">Bu foydalanuvchi tizimga kirishi mumkin</small>
                            </label>
                        </div>
                        
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Orqaga
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Yangilash
                            </button>
                        </div>
                    </form>
        </div>
    </div>
</div>
@endsection
