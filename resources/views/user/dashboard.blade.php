@extends('layouts.user')

@section('title', 'Dashboard')

@section('page-header')
<div class="row align-items-center">
    <div class="col-md-8">
        <h1 class="h2 mb-2 text-gradient fw-bold">
            Xush kelibsiz, {{ auth()->user()->name }}!
        </h1>
        <p class="text-muted mb-0">Bu yerda siz mavjud testlarni topishingiz va o'z natijalaringizni ko'rishingiz mumkin.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <div class="d-flex justify-content-md-end align-items-center mt-3 mt-md-0">
            <div class="user-avatar me-3" style="width: 50px; height: 50px;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="text-md-end">
                <div class="fw-bold text-primary">{{ now()->format('H:i') }}</div>
                <small class="text-muted">{{ now()->format('d.m.Y') }}</small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="user-card">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-clipboard-check me-2"></i>Mavjud testlar
                </h5>
            </div>
            <div class="user-card-body">
@if($availableTests->count() > 0)
                    <div class="row">
                        @foreach($availableTests as $test)
                            <div class="col-md-6 mb-4">
                                <div class="user-card h-100">
                                    <div class="user-card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h6 class="fw-bold mb-0">{{ $test->title }}</h6>
                                            <span class="user-badge user-badge-primary">
                                                <i class="fas fa-clock me-1"></i>{{ $test->duration_minutes }}m
                                            </span>
                                        </div>
                                        
                                        <p class="text-muted mb-3 small">{{ Str::limit($test->description, 80) }}</p>
                                        
                                        <div class="row g-2 mb-3">
                                            <div class="col-4">
                                                <div class="text-center p-2 bg-light rounded">
                                                    <div class="fw-bold text-primary">{{ $test->duration_minutes }}</div>
                                                    <small class="text-muted">Daqiqa</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-center p-2 bg-light rounded">
                                                    <div class="fw-bold text-success">{{ $test->max_attempts }}</div>
                                                    <small class="text-muted">Urinish</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-center p-2 bg-light rounded">
                                                    <div class="fw-bold text-warning">{{ $test->end_time->format('d.m') }}</div>
                                                    <small class="text-muted">Tugaydi</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('user.test.show', $test) }}" class="user-btn user-btn-primary w-100">
                                            <i class="fas fa-play"></i>Testni boshlash
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-4x mb-3 text-muted" style="opacity: 0.5;"></i>
                        <h5 class="text-muted">Hozircha mavjud testlar yo'q</h5>
                        <p class="text-muted">Testlar qo'shilganda bu yerda ko'rsatiladi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- So'nggi natijalar -->
        <div class="user-card mb-4">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-chart-line me-2"></i>So'nggi natijalar
                </h5>
            </div>
            <div class="user-card-body">
@if($completedTests->count() > 0)
                    @foreach($completedTests as $result)
                        <div class="p-3 bg-light rounded mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ Str::limit($result->test->title, 25) }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $result->created_at->format('d.m.Y H:i') }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold {{ $result->score >= 70 ? 'text-success' : ($result->score >= 50 ? 'text-warning' : 'text-danger') }}">
                                        {{ $result->score }}%
                                    </div>
                                    <small class="text-muted">{{ $result->correct_answers }}/{{ count($result->questions) }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <button class="user-btn user-btn-outline w-100 mt-2" onclick="alert('Bu funksiya keyingi versiyada qo\'shiladi')">
                        <i class="fas fa-chart-bar"></i>Batafsil statistika
                    </button>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-bar fa-3x mb-3 text-muted" style="opacity: 0.5;"></i>
                        <h6 class="text-muted">Hali test topshirmadingiz</h6>
                        <p class="text-muted mb-0">Birinchi testni topsiring</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Ma'lumot -->
        <div class="user-card">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-info-circle me-2"></i>Ma'lumot
                </h5>
            </div>
            <div class="user-card-body">
<div class="d-flex align-items-center mb-3 p-2 rounded" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(94, 114, 228, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-clock text-primary"></i>
                    </div>
                    <span class="text-muted">Test davomida vaqt chegaralanadi</span>
                </div>
                
                <div class="d-flex align-items-center mb-3 p-2 rounded" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(45, 206, 137, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-random text-success"></i>
                    </div>
                    <span class="text-muted">Savollar tasodifiy tartibda chiqadi</span>
                </div>
                
                <div class="d-flex align-items-center mb-3 p-2 rounded" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(251, 99, 64, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-redo text-warning"></i>
                    </div>
                    <span class="text-muted">Testni belgilangan miqdorda takrorlash mumkin</span>
                </div>
                
                <div class="d-flex align-items-center mb-0 p-2 rounded" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(17, 205, 239, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-chart-pie text-info"></i>
                    </div>
                    <span class="text-muted">Test yakunida batafsil natija ko'rsatiladi</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
