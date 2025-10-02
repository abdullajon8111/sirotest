@extends('layouts.admin')

@section('title', 'Testlar')
@section('description', 'Test yaratish va boshqarish')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-1">Testlar</h1>
            <p class="text-muted mb-0">Testlarni yaratish va boshqarish</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.tests.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Yangi test
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($tests->count() > 0)
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th width="80">#</th>
                            <th>Test nomi</th>
                            <th width="120">Davomiyligi</th>
                            <th width="140">Boshlanish</th>
                            <th width="140">Tugash</th>
                            <th width="100">Urinish</th>
                            <th width="100">Holati</th>
                            <th width="120">Test holati</th>
                            <th width="150">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tests as $test)
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary">#{{ $test->id }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $test->title }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-clock me-1"></i>{{ $test->duration_minutes }}d
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($test->start_time)->format('d.m.Y H:i') }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($test->end_time)->format('d.m.Y H:i') }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">
                                        {{ $test->max_attempts }}x
                                    </span>
                                </td>
                                <td>
                                    @if($test->is_active)
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
                                    @php
                                        $now = now();
                                        $start = \Carbon\Carbon::parse($test->start_time);
                                        $end = \Carbon\Carbon::parse($test->end_time);
                                    @endphp
                                    
                                    @if($now < $start)
                                        <span class="badge bg-info">
                                            <i class="fas fa-hourglass-start me-1"></i>Kutilmoqda
                                        </span>
                                    @elseif($now >= $start && $now <= $end && $test->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-play me-1"></i>Faol
                                        </span>
                                    @elseif($now > $end)
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-stop me-1"></i>Tugagan
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-pause me-1"></i>Nofaol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.tests.show', $test) }}" 
                                           class="btn btn-outline-primary" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tests.edit', $test) }}" 
                                           class="btn btn-outline-warning" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.tests.destroy', $test) }}" 
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
            
            <!-- Pagination -->
            <div class="p-4">
                {{ $tests->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-clipboard-check fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">Hozircha testlar yo'q</h3>
                <p class="text-muted mb-4">Birinchi testni yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.tests.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi testni yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
