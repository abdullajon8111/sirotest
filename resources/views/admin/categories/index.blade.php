@extends('layouts.admin')

@section('title', 'Kategoriyalar')
@section('description', 'Test kategoriyalarini boshqarish')

@section('content')
<div class="modern-page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="modern-page-title">
            <i class="fas fa-folder me-3"></i>Kategoriyalar
        </h1>
        <a href="{{ route('admin.categories.create') }}" class="modern-btn modern-btn-primary">
            <i class="fas fa-plus me-2"></i>Yangi kategoriya
        </a>
    </div>
</div>

<div class="modern-card">
    <div class="card-body p-0">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table mb-0">
                    <thead>
                        <tr>
                            <th width="80">#</th>
                            <th>Nomi</th>
                            <th>Tavsif</th>
                            <th width="100">Holati</th>
                            <th width="120">Yaratilgan</th>
                            <th width="150">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary">#{{ $category->id }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $category->name }}</div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($category->description, 50) }}</span>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="modern-badge bg-success text-white">
                                            <i class="fas fa-check me-1"></i>Faol
                                        </span>
                                    @else
                                        <span class="modern-badge bg-danger text-white">
                                            <i class="fas fa-times me-1"></i>Nofaol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $category->created_at->format('d.m.Y') }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           class="action-btn btn-outline-info" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="action-btn btn-outline-warning" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-outline-danger" title="O'chirish"
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
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="empty-state-title">Hozircha kategoriyalar yo'q</h3>
                <p class="empty-state-description">Birinchi kategoriyani yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.categories.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi kategoriyani yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
