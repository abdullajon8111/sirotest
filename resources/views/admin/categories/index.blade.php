@extends('layouts.purpose-admin')

@section('title', 'Kategoriyalar')
@section('description', 'Test kategoriyalarini boshqarish')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="purpose-header-title mb-1">
            <i class="fas fa-folder me-3"></i>Kategoriyalar
        </h1>
        <p class="purpose-text-muted">Test kategoriyalarini boshqarish va tahrirlash</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="purpose-btn purpose-btn-primary">
        <i class="fas fa-plus me-2"></i>Yangi kategoriya
    </a>
</div>

<div class="purpose-card purpose-fade-in">
    <div class="purpose-card-body p-0">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table purpose-table mb-0">
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
                                    <span class="text-muted">{{ $category->created_at->format('d.m.Y') }}</span>
                                </td>
                                <td>
                                    <div class="purpose-table-actions">
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           class="purpose-action-btn purpose-action-btn-primary" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="purpose-action-btn purpose-action-btn-success" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="purpose-action-btn purpose-action-btn-danger" title="O'chirish"
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
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-folder-open" style="font-size: 4rem; color: #e5e7eb;"></i>
                </div>
                <h3 class="purpose-text-muted mb-3">Hozircha kategoriyalar yo'q</h3>
                <p class="purpose-text-muted mb-4">Birinchi kategoriyani yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.categories.create') }}" class="purpose-btn purpose-btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi kategoriyani yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
