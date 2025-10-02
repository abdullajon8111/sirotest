@extends('layouts.admin')

@section('title', 'Kategoriyalar')
@section('description', 'Test kategoriyalarini boshqarish')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-1">Kategoriyalar</h1>
            <p class="text-muted mb-0">Test kategoriyalarini boshqarish va tahrirlash</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Yangi kategoriya
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table mb-0">
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
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Faol
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times me-1"></i>Nofaol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $category->created_at->format('d.m.Y') }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           class="btn btn-outline-primary" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="btn btn-outline-warning" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="O'chirish"
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
                    <i class="fas fa-folder-open fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">Hozircha kategoriyalar yo'q</h3>
                <p class="text-muted mb-4">Birinchi kategoriyani yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi kategoriyani yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
