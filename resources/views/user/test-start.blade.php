@extends('layouts.app')

@section('title', $test->title)

@section('content')
<style>
    .test-start-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .test-start-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .test-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .test-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(255,255,255,0.05) 10px,
            rgba(255,255,255,0.05) 20px
        );
        animation: slide 20s linear infinite;
        pointer-events: none;
    }
    @keyframes slide {
        0% { transform: translateX(-50%) translateY(-50%) rotate(0deg); }
        100% { transform: translateX(-50%) translateY(-50%) rotate(360deg); }
    }
    .test-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }
    .test-description {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }
    .test-info-grid {
        padding: 2.5rem;
    }
    .info-card {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #fff, #f8fafc);
    }
    .info-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }
    .info-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .info-label {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .instructions {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border: 1px solid #bfdbfe;
        border-radius: 1rem;
        padding: 1.5rem;
        margin: 2rem 2.5rem;
    }
    .instruction-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        color: #1e40af;
    }
    .instruction-item:last-child {
        margin-bottom: 0;
    }
    .instruction-icon {
        width: 30px;
        height: 30px;
        background: #3b82f6;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 0.8rem;
    }
    .start-section {
        padding: 2.5rem;
        text-align: center;
        background: linear-gradient(135deg, #f8fafc, #fff);
    }
    .start-btn {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        border-radius: 1rem;
        padding: 1rem 3rem;
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    .start-btn:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }
    .back-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        text-decoration: none;
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 2;
        transition: all 0.2s ease;
    }
    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
    }
</style>

<div class="test-start-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="test-start-card">
                    <!-- Test Header -->
                    <div class="test-header">
                        <a href="{{ route('user.dashboard') }}" class="back-btn">
                            <i class="fas fa-arrow-left me-2"></i>Orqaga
                        </a>
                        <h1 class="test-title">{{ $test->title }}</h1>
                        <p class="test-description mb-0">{{ $test->description }}</p>
                    </div>
                    
                    <!-- Test Info Grid -->
                    <div class="test-info-grid">
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="info-card">
                                    <div class="info-icon bg-primary bg-opacity-10">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    <div class="info-number">{{ $test->duration_minutes }}</div>
                                    <div class="info-label">Daqiqa</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-card">
                                    <div class="info-icon bg-success bg-opacity-10">
                                        <i class="fas fa-question-circle text-success"></i>
                                    </div>
                                    <div class="info-number">{{ array_sum($test->categories_questions) }}</div>
                                    <div class="info-label">Savol</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-card">
                                    <div class="info-icon bg-warning bg-opacity-10">
                                        <i class="fas fa-redo text-warning"></i>
                                    </div>
                                    <div class="info-number">{{ $test->max_attempts }}</div>
                                    <div class="info-label">Maksimal urinish</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-card">
                                    <div class="info-icon bg-info bg-opacity-10">
                                        <i class="fas fa-calendar text-info"></i>
                                    </div>
                                    <div class="info-number">{{ $test->end_time->format('d.m') }}</div>
                                    <div class="info-label">Tugash sanasi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Instructions -->
                    <div class="instructions">
                        <h6 class="mb-3 fw-bold text-center">
                            <i class="fas fa-info-circle me-2"></i>Muhim ma'lumotlar
                        </h6>
                        
                        <div class="instruction-item">
                            <div class="instruction-icon">
                                <i class="fas fa-play"></i>
                            </div>
                            <span>Test boshlangandan keyin vaqt hisoblanadi</span>
                        </div>
                        
                        <div class="instruction-item">
                            <div class="instruction-icon">
                                <i class="fas fa-random"></i>
                            </div>
                            <span>Savollar tasodifiy tartibda chiqadi</span>
                        </div>
                        
                        <div class="instruction-item">
                            <div class="instruction-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <span>Javoblarni o'zgartirish va qaytib ko'rish mumkin</span>
                        </div>
                        
                        <div class="instruction-item">
                            <div class="instruction-icon">
                                <i class="fas fa-stopwatch"></i>
                            </div>
                            <span>Vaqt tugaganda test avtomatik yakunlanadi</span>
                        </div>
                    </div>
                    
                    <!-- Start Section -->
                    <div class="start-section">
                        <h5 class="mb-3 text-muted">Tayyor bo'lsangiz testni boshlang</h5>
                        <form method="POST" action="{{ route('user.test.start', $test) }}">
                            @csrf
                            <button type="submit" class="start-btn">
                                <i class="fas fa-rocket me-2"></i>Testni Boshlash
                            </button>
                        </form>
                        <p class="text-muted mt-3 mb-0">
                            <small><i class="fas fa-lightbulb me-1"></i>Maslahat: Testni tinch muhitda topsiring</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
