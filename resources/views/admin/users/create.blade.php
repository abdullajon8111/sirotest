@extends('layouts.admin')

@section('title', 'Yangi foydalanuvchi yaratish')

@section('content')
<div class="">
    <div class="card shadow-sm">
        <div class="card-header bg-primary">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-plus me-3 fs-4"></i>
                <div>
                    <h4 class="mb-0">Yangi Foydalanuvchi Yaratish</h4>
                    <small class="opacity-75">Tizimga yangi foydalanuvchi qo'shish</small>
                </div>
            </div>
        </div>

        <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Ism <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
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
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Parol <span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Parolni tasdiqlang <span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rol <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                    id="role"
                                    name="role"
                                    required>
                                <option value="">Rolni tanlang...</option>
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Foydalanuvchi</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
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
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Aktiv foydalanuvchi</strong>
                                <br><small class="text-muted">Bu foydalanuvchi tizimga kirishi mumkin</small>
                            </label>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Orqaga
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Saqlash
                            </button>
                        </div>
                    </form>
        </div>
    </div>
</div>
@endsection
