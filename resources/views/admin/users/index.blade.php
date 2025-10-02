@extends('layouts.purpose-admin')

@section('title', 'Foydalanuvchilar')
@section('description', 'Tizim foydalanuvchilarini boshqarish')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="purpose-header-title mb-1">
            <i class="fas fa-users me-3"></i>Foydalanuvchilar
        </h1>
        <p class="purpose-text-muted">Tizim foydalanuvchilarini boshqarish va tahrirlash</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="purpose-btn purpose-btn-primary">
        <i class="fas fa-plus me-2"></i>Yangi foydalanuvchi
    </a>
</div>

<div class="purpose-card purpose-fade-in">
    <div class="purpose-card-body p-0">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table purpose-table mb-0">
                    <thead>
                        <tr>
                            <th width="80">#</th>
                            <th>Ism</th>
                            <th>Email</th>
                            <th width="100">Rol</th>
                            <th width="100">Holati</th>
                            <th width="120">Yaratilgan</th>
                            <th width="150">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary">#{{ $user->id }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $user->email }}</span>
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="purpose-badge purpose-badge-danger">
                                            <i class="fas fa-crown me-1"></i>Admin
                                        </span>
                                    @else
                                        <span class="purpose-badge purpose-badge-primary">
                                            <i class="fas fa-user me-1"></i>Foydalanuvchi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="purpose-badge purpose-badge-success">
                                            <i class="fas fa-check me-1"></i>Faol
                                        </span>
                                    @else
                                        <span class="purpose-badge purpose-badge-danger">
                                            <i class="fas fa-times me-1"></i>Nofaol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $user->created_at->format('d.m.Y') }}</span>
                                </td>
                                <td>
                                    <div class="purpose-table-actions">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="purpose-action-btn purpose-action-btn-primary" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="purpose-action-btn purpose-action-btn-success" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="purpose-action-btn purpose-action-btn-danger" title="O'chirish"
                                                        onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-4">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-users" style="font-size: 4rem; color: #e5e7eb;"></i>
                </div>
                <h3 class="purpose-text-muted mb-3">Hozircha foydalanuvchilar yo'q</h3>
                <p class="purpose-text-muted mb-4">Birinchi foydalanuvchini yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.users.create') }}" class="purpose-btn purpose-btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi foydalanuvchini yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
