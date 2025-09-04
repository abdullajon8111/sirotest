@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .welcome-header {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.9));
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .test-card {
        background: white;
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }
    .test-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
    .test-card .card-body {
        padding: 1.5rem;
    }
    .test-info-item {
        background: #f8fafc;
        border-radius: 0.5rem;
        padding: 0.75rem;
        text-align: center;
        margin-bottom: 0.5rem;
    }
    .test-start-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .test-start-btn:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #553c9a 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .stats-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.9));
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        border: none;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .result-item {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
    }
    .result-item:hover {
        background: #e2e8f0;
    }
    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }
    .info-item:hover {
        background: rgba(102, 126, 234, 0.1);
        padding-left: 1rem;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }
    .section-title {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
</style>

<div class="dashboard-container">
    <div class="container-fluid">
        <!-- Welcome Header -->
        <div class="welcome-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        Xush kelibsiz, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-muted mb-0 fs-5">Bu yerda siz mavjud testlarni topishingiz va o'z natijalaringizni ko'rishingiz mumkin.</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-primary">{{ now()->format('H:i') }}</div>
                            <small class="text-muted">{{ now()->format('d.m.Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="stats-card">
                    <div class="card-body p-4">
                        <h5 class="section-title">
                            <i class="fas fa-clipboard-check me-2"></i> Mavjud testlar
                        </h5>
                        
                        @if($availableTests->count() > 0)
                            <div class="row">
                                @foreach($availableTests as $test)
                                    <div class="col-md-6 mb-4">
                                        <div class="test-card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h6 class="card-title mb-0 fw-bold">{{ $test->title }}</h6>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                                        <i class="fas fa-clock me-1"></i>{{ $test->duration_minutes }}min
                                                    </span>
                                                </div>
                                                
                                                <p class="card-text text-muted mb-3">{{ Str::limit($test->description, 80) }}</p>
                                                
                                                <div class="row g-2 mb-3">
                                                    <div class="col-4">
                                                        <div class="test-info-item">
                                                            <div class="fw-bold text-primary">{{ $test->duration_minutes }}</div>
                                                            <small class="text-muted">Daqiqa</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="test-info-item">
                                                            <div class="fw-bold text-success">{{ $test->max_attempts }}</div>
                                                            <small class="text-muted">Urinish</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="test-info-item">
                                                            <div class="fw-bold text-warning">{{ $test->end_time->format('d.m') }}</div>
                                                            <small class="text-muted">Tugaydi</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <a href="{{ route('user.test.show', $test) }}" class="btn test-start-btn w-100 text-white">
                                                    <i class="fas fa-play me-2"></i>Testni boshlash
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list fa-4x mb-3 text-muted"></i>
                                <h5 class="text-muted">Hozircha mavjud testlar yo'q</h5>
                                <p class="text-muted">Testlar qo'shilganda bu yerda ko'rsatiladi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- So'nggi natijalar -->
                <div class="stats-card mb-4">
                    <div class="card-body p-4">
                        <h5 class="section-title">
                            <i class="fas fa-chart-line me-2"></i> So'nggi natijalar
                        </h5>
                        
                        @if($completedTests->count() > 0)
                            @foreach($completedTests as $result)
                                <div class="result-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ Str::limit($result->test->title, 25) }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>{{ $result->created_at->format('d.m.Y H:i') }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold fs-5 {{ $result->score >= 70 ? 'text-success' : ($result->score >= 50 ? 'text-warning' : 'text-danger') }}">
                                                {{ $result->score }}%
                                            </div>
                                            <small class="text-muted">{{ $result->correct_answers }}/{{ count($result->questions) }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <button class="btn btn-outline-primary w-100 mt-2" onclick="alert('Bu funksiya keyingi versiyada qo\'shiladi')">
                                <i class="fas fa-chart-bar me-2"></i>Batafsil statistika
                            </button>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-chart-bar fa-3x mb-3 text-muted"></i>
                                <h6 class="text-muted">Hali test topshirmadingiz</h6>
                                <p class="text-muted mb-0">Birinchi testni topsiring</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Ma'lumot -->
                <div class="stats-card">
                    <div class="card-body p-4">
                        <h5 class="section-title">
                            <i class="fas fa-info-circle me-2"></i> Ma'lumot
                        </h5>
                        
                        <div class="info-item">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <small>Test davomida vaqt chegaralanadi</small>
                        </div>
                        
                        <div class="info-item">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-random text-success"></i>
                            </div>
                            <small>Savollar tasodifiy tartibda chiqadi</small>
                        </div>
                        
                        <div class="info-item">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-redo text-warning"></i>
                            </div>
                            <small>Testni belgilangan miqdorda takrorlash mumkin</small>
                        </div>
                        
                        <div class="info-item">
                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-chart-pie text-info"></i>
                            </div>
                            <small>Test yakunida batafsil natija ko'rsatiladi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
