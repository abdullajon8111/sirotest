@extends('layouts.user')

@section('title', $test->title)

@section('page-header')
<div class="d-flex align-items-center">
    <a href="{{ route('user.dashboard') }}" class="user-btn user-btn-outline me-3">
        <i class="fas fa-arrow-left"></i>Orqaga
    </a>
    <div>
        <h1 class="h2 mb-1 text-gradient fw-bold">{{ $test->title }}</h1>
        <p class="text-muted mb-0">{{ $test->description }}</p>
    </div>
</div>
@endsection

@section('content')
<style>
    .test-info-card {
        text-align: center;
        padding: 1.5rem;
        transition: all 0.2s ease;
    }

    .test-info-card:hover {
        transform: translateY(-2px);
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
        margin-bottom: 0.5rem;
    }

    .info-label {
        font-weight: 500;
        color: var(--text-muted);
    }
</style>
<!-- Test Ma'lumotlari -->
<div class="row mb-4">
    <div class="col-12">
        <div class="user-card">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-info-circle me-2"></i>Test Ma'lumotlari
                </h5>
            </div>
            <div class="user-card-body">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="user-card test-info-card">
                            <div class="info-icon bg-primary bg-opacity-10">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <div class="info-number text-primary">{{ $test->duration_minutes }}</div>
                            <div class="info-label">Daqiqa</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user-card test-info-card">
                            <div class="info-icon bg-success bg-opacity-10">
                                <i class="fas fa-question-circle text-success"></i>
                            </div>
                            <div class="info-number text-success">{{ array_sum($test->categories_questions) }}</div>
                            <div class="info-label">Savol</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user-card test-info-card">
                            <div class="info-icon bg-warning bg-opacity-10">
                                <i class="fas fa-redo text-warning"></i>
                            </div>
                            <div class="info-number text-warning">{{ $test->max_attempts }}</div>
                            <div class="info-label">Maksimal urinish</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user-card test-info-card">
                            <div class="info-icon bg-info bg-opacity-10">
                                <i class="fas fa-calendar text-info"></i>
                            </div>
                            <div class="info-number text-info">{{ $test->end_time->format('d.m.Y') }}</div>
                            <div class="info-label">Tugash sanasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Instructions -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="user-card">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-clipboard-list me-2"></i>Muhim qoidalar
                </h5>
            </div>
            <div class="user-card-body">
                <div class="d-flex align-items-center mb-3 p-2 rounded" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(94, 114, 228, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-play text-primary"></i>
                    </div>
                    <span class="text-muted">Test boshlangandan keyin vaqt hisoblanadi</span>
                </div>

                <div class="d-flex align-items-center mb-3 p-2 rounded" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(45, 206, 137, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-random text-success"></i>
                    </div>
                    <span class="text-muted">Savollar tasodifiy tartibda chiqadi</span>
                </div>

                <div class="d-flex align-items-center mb-3 p-2 rounded" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(251, 99, 64, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-edit text-warning"></i>
                    </div>
                    <span class="text-muted">Javoblarni o'zgartirish va qaytib ko'rish mumkin</span>
                </div>

                <div class="d-flex align-items-center mb-0 p-2 rounded" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(17, 205, 239, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-stopwatch text-info"></i>
                    </div>
                    <span class="text-muted">Vaqt tugaganda test avtomatik yakunlanadi</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="user-card">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-rocket me-2"></i>Testni boshlash
                </h5>
            </div>
            <div class="user-card-body text-center">
                <p class="text-muted mb-3">Tayyor bo'lsangiz testni boshlang</p>

                <form method="POST" action="{{ route('user.test.start', $test) }}">
                    @csrf
                    <button type="submit" class="user-btn user-btn-primary w-100 mb-3" style="padding: 1rem;">
                        <i class="fas fa-rocket"></i>Testni Boshlash
                    </button>
                </form>

                <div class="alert alert-info border-0">
                    <small><i class="fas fa-lightbulb me-1"></i>Maslahat: Testni tinch muhitda topsiring</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
