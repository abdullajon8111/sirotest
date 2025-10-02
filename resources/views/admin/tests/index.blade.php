@extends('layouts.purpose-admin')

@section('title', 'Testlar')
@section('description', 'Test yaratish va boshqarish')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="purpose-header-title mb-1">
            <i class="fas fa-clipboard-check me-3"></i>Testlar
        </h1>
        <p class="purpose-text-muted">Testlarni yaratish va boshqarish</p>
    </div>
    <a href="{{ route('admin.tests.create') }}" class="purpose-btn purpose-btn-primary">
        <i class="fas fa-plus me-2"></i>Yangi test
    </a>
</div>

<div class="purpose-card purpose-fade-in">
    <div class="purpose-card-body p-0">
        @if($tests->count() > 0)
            <div class="table-responsive">
                <table class="table purpose-table mb-0">
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
                                    <span class="purpose-badge purpose-badge-info">
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
                                    <span class="purpose-badge purpose-badge-warning">
                                        {{ $test->max_attempts }}x
                                    </span>
                                </td>
                                <td>
                                    @if($test->is_active)
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
                                    @php
                                        $now = now();
                                        $start = \Carbon\Carbon::parse($test->start_time);
                                        $end = \Carbon\Carbon::parse($test->end_time);
                                    @endphp
                                    
                                    @if($now < $start)
                                        <span class="purpose-badge purpose-badge-info text-white">
                                            <i class="fas fa-hourglass-start me-1"></i>Kutilmoqda
                                        </span>
                                    @elseif($now >= $start && $now <= $end && $test->is_active)
                                        <span class="purpose-badge purpose-badge-success text-white">
                                            <i class="fas fa-play me-1"></i>Faol
                                        </span>
                                    @elseif($now > $end)
                                        <span class="purpose-badge purpose-badge-secondary text-white">
                                            <i class="fas fa-stop me-1"></i>Tugagan
                                        </span>
                                    @else
                                        <span class="purpose-badge purpose-badge-warning text-white">
                                            <i class="fas fa-pause me-1"></i>Nofaol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="purpose-table-actions">
                                        <a href="{{ route('admin.tests.show', $test) }}" 
                                           class="purpose-action-btn purpose-action-btn-primary" title="Ko'rish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tests.edit', $test) }}" 
                                           class="purpose-action-btn purpose-action-btn-success" title="Tahrirlash">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.tests.destroy', $test) }}" 
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
            
            <!-- Pagination -->
            <div class="p-4">
                {{ $tests->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-clipboard-check" style="font-size: 4rem; color: #e5e7eb;"></i>
                </div>
                <h3 class="purpose-text-muted mb-3">Hozircha testlar yo'q</h3>
                <p class="purpose-text-muted mb-4">Birinchi testni yaratish uchun quyidagi tugmani bosing</p>
                <a href="{{ route('admin.tests.create') }}" class="purpose-btn purpose-btn-primary">
                    <i class="fas fa-plus me-2"></i>Birinchi testni yarating
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
