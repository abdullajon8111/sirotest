@extends('layouts.user')

@section('title', 'Test Natijasi')

@section('page-header')
<div class="text-center">
    <h1 class="h2 mb-2 text-gradient fw-bold">{{ $testResult->test->title }}</h1>
    <div class="score-display {{ $testResult->score >= 70 ? 'text-success' : ($testResult->score >= 50 ? 'text-warning' : 'text-danger') }}">
        {{ $testResult->score }}%
    </div>
    <p class="text-muted">{{ $testResult->score >= 70 ? 'Tabriklaymiz! A\'lo natija!' : ($testResult->score >= 50 ? 'Yaxshi natija!' : 'Keyinroq qayta urining!') }}</p>
</div>
@endsection

@section('content')
<style>
    .score-display {
        font-size: 4rem;
        font-weight: 700;
        margin: 1rem 0;
        line-height: 1;
    }
    .stat-item {
        text-align: center;
        padding: 1.5rem;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
    }

    .stat-item:hover {
        transform: translateY(-2px);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-muted);
        font-weight: 500;
        font-size: 0.875rem;
    }
    .question-result-item {
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--border-color);
        transition: all 0.2s ease;
        background: var(--surface-white);
    }

    .question-result-item.correct {
        border-left-color: var(--success-color);
        background: rgba(45, 206, 137, 0.1);
    }

    .question-result-item.incorrect {
        border-left-color: var(--danger-color);
        background: rgba(239, 68, 68, 0.1);
    }

    .question-result-item.unanswered {
        border-left-color: var(--warning-color);
        background: rgba(251, 99, 64, 0.1);
    }

    .question-result-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .question-number {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 1rem;
        font-size: 0.875rem;
    }
</style>
<!-- Statistics -->
<div class="row mb-4">
    <div class="col-12">
        <div class="user-card">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-chart-bar me-2"></i>Test statistikasi
                </h5>
            </div>
            <div class="user-card-body">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="user-card stat-item text-center">
                            <div class="stat-number text-success">{{ $testResult->correct_answers }}</div>
                            <div class="stat-label">To'g'ri javob</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user-card stat-item text-center">
                            <div class="stat-number text-danger">{{ $testResult->wrong_answers }}</div>
                            <div class="stat-label">Noto'g'ri javob</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user-card stat-item text-center">
                            <div class="stat-number text-warning">{{ $testResult->unanswered_questions }}</div>
                            <div class="stat-label">Javobsiz</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user-card stat-item text-center">
                            <div class="stat-number {{ $testResult->score >= 70 ? 'text-success' : ($testResult->score >= 50 ? 'text-warning' : 'text-danger') }}">
                                {{ $testResult->score }}%
                            </div>
                            <div class="stat-label">Umumiy ball</div>
                        </div>
                    </div>
                </div>

                <!-- Time Information -->
                <div class="row g-4 mt-3">
                    <div class="col-md-6">
                        <div class="user-card stat-item text-center">
                            <div class="stat-number text-info">{{ $testResult->started_at->format('H:i') }}</div>
                            <div class="stat-label">Boshlangan vaqt ({{ $testResult->started_at->format('d.m.Y') }})</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="user-card stat-item text-center">
                            @php
                                $totalSeconds = $testResult->started_at->diffInSeconds($testResult->finished_at);
                                $minutes = intval($totalSeconds / 60);
                                $seconds = $totalSeconds % 60;
                                $timeDisplay = sprintf('%d:%02d', $minutes, $seconds);
                            @endphp
                            <div class="stat-number text-info">{{ $timeDisplay }}</div>
                            <div class="stat-label">Sarflangan vaqt (minut:sekund)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mb-4">
    <div class="col-12 text-center">
        <a href="{{ route('user.dashboard') }}" class="user-btn user-btn-primary me-3">
            <i class="fas fa-arrow-left"></i>Dashboardga qaytish
        </a>
        <button class="user-btn user-btn-outline d-none" onclick="window.print()">
            <i class="fas fa-print"></i>Chop etish
        </button>
    </div>
</div>

<!-- Detailed Results -->
<div class="row">
    <div class="col-12">
        <div class="user-card">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-list-alt me-2"></i>Batafsil natijalar
                </h5>
            </div>
            <div class="user-card-body">
                @foreach($detailedResults as $index => $result)
                    <div class="question-result-item {{ $result['is_correct'] ? 'correct' : ($result['user_answer'] ? 'incorrect' : 'unanswered') }}">
                        <div class="question-result-header">
                            <div class="d-flex align-items-center">
                                <div class="question-number">{{ $index + 1 }}</div>
                                <h6 class="mb-0 flex-grow-1">
                                    {{ $result['question']['question'] }}
                                </h6>
                            </div>
                            <div class="user-badge {{ $result['is_correct'] ? 'user-badge-success' : ($result['user_answer'] ? 'user-badge-danger' : 'user-badge-warning') }}">
                                @if($result['is_correct'])
                                    <i class="fas fa-check me-1"></i>To'g'ri
                                @elseif($result['user_answer'])
                                    <i class="fas fa-times me-1"></i>Noto'g'ri
                                @else
                                    <i class="fas fa-minus me-1"></i>Javobsiz
                                @endif
                            </div>
                        </div>

                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong class="text-primary">Sizning javobingiz:</strong>
                                        <div class="mt-1">
                                            @if($result['user_answer'])
                                                <span class="{{ $result['is_correct'] ? 'text-success' : 'text-danger' }} fw-bold">
                                                    <i class="fas fa-arrow-right me-1"></i>
                                                    {{ strtoupper($result['user_answer']) }})
                                                    {{ $result['question']['option_' . $result['user_answer']] }}
                                                </span>
                                            @else
                                                <span class="text-muted fst-italic">
                                                    <i class="fas fa-question-circle me-1"></i>
                                                    Javob berilmagan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if(!$result['is_correct'])
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <strong class="text-success">To'g'ri javob:</strong>
                                            <div class="mt-1">
                                                <span class="text-success fw-bold">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    {{ strtoupper($result['correct_answer']) }})
                                                    {{ $result['question']['option_' . $result['correct_answer']] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
