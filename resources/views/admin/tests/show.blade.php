@extends('layouts.admin')

@section('title', 'Test ma\'lumotlari')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-1">{{ $test->title }}</h1>
            <p class="text-muted mb-0">Test ning batafsil ma'lumotlari</p>
        </div>
        <div class="col-auto">
            <div class="btn-group">
                <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Tahrirlash
                </a>
                <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Orqaga
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Asosiy ma'lumotlar</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th width="40%">Test nomi:</th>
                                    <td>{{ $test->title }}</td>
                                </tr>
                                <tr>
                                    <th>Tavsif:</th>
                                    <td>{{ $test->description ?? 'Tavsif yo\'q' }}</td>
                                </tr>
                                <tr>
                                    <th>Davomiyligi:</th>
                                    <td><span class="badge bg-info">{{ $test->duration_minutes }} daqiqa</span></td>
                                </tr>
                                <tr>
                                    <th>Maksimal urinish:</th>
                                    <td><span class="badge bg-secondary">{{ $test->max_attempts }} marta</span></td>
                                </tr>
                                <tr>
                                    <th>Holati:</th>
                                    <td>
                                        @if($test->is_active)
                                            <span class="badge bg-success">Aktiv</span>
                                        @else
                                            <span class="badge bg-danger">Nofaol</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th width="40%">Boshlanish vaqti:</th>
                                    <td>{{ \Carbon\Carbon::parse($test->start_time)->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tugash vaqti:</th>
                                    <td>{{ \Carbon\Carbon::parse($test->end_time)->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Yaratilgan:</th>
                                    <td>{{ $test->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Yangilangan:</th>
                                    <td>{{ $test->updated_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Test holati:</th>
                                    <td>
                                        @php
                                            $now = now();
                                            $start = \Carbon\Carbon::parse($test->start_time);
                                            $end = \Carbon\Carbon::parse($test->end_time);
                                        @endphp
                                        
                                        @if($now < $start)
                                            <span class="badge bg-info">Kutilmoqda</span>
                                        @elseif($now >= $start && $now <= $end && $test->is_active)
                                            <span class="badge bg-success">Faol</span>
                                        @elseif($now > $end)
                                            <span class="badge bg-secondary">Tugagan</span>
                                        @else
                                            <span class="badge bg-warning">Nofaol</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        @php
            $totalQuestions = is_array($test->categories_questions) ? array_sum($test->categories_questions) : 0;
        @endphp
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Test statistikalari</h5>
            </div>
            <div class="card-body">
                <div class="stats-card p-3 text-center mb-3">
                    <h4 class="mb-1">{{ $totalQuestions }}</h4>
                    <small>Jami savollar</small>
                </div>
                
                <div class="stats-card stats-card-success p-3 text-center mb-3">
                    <h4 class="mb-1">{{ $test->testResults()->count() }}</h4>
                    <small>Ishtirok etganlar</small>
                </div>
                
                <div class="stats-card stats-card-info p-3 text-center mb-0">
                    <h4 class="mb-1">{{ $test->testResults()->whereNotNull('finished_at')->count() }}</h4>
                    <small>Yakunlaganlar</small>
                </div>
            </div>
        </div>
    </div>
</div>

@if($test->categories_questions && count($test->categories_questions) > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Kategoriyalar va savollar taqsimoti</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($test->categories_questions as $categoryId => $questionCount)
                            @php
                                $category = \App\Models\Category::find($categoryId);
                            @endphp
                            @if($category)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">{{ $category->name }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Tanlangan:</span>
                                                <strong class="text-primary">{{ $questionCount }} ta</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Umumiy:</span>
                                                <span>{{ $category->questions()->where('is_active', true)->count() }} ta</span>
                                            </div>
                                            @php
                                                $totalInCategory = $category->questions()->where('is_active', true)->count();
                                                $percentage = $totalInCategory > 0 ? ($questionCount / $totalInCategory) * 100 : 0;
                                            @endphp
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-primary" 
                                                     role="progressbar" 
                                                     style="width: {{ $percentage }}%"
                                                     title="{{ number_format($percentage, 1) }}%">
                                                </div>
                                            </div>
                                            <small class="text-muted mt-1">{{ number_format($percentage, 1) }}% ishlatilgan</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.tests.destroy', $test) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Rostdan ham bu testni o\'chirmoqchimisiz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> O'chirish
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Kategoriyalar belgilanmagan</h5>
                        <p>Bu test uchun kategoriyalar va savollar taqsimoti belgilanmagan.</p>
                        <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Kategoriyalar qo'shish
                        </a>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.tests.destroy', $test) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Rostdan ham bu testni o\'chirmoqchimisiz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> O'chirish
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
