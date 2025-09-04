@extends('layouts.app')

@section('title', 'Test Natijasi')

@section('content')
<style>
    .result-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .result-header {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.9));
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
    }
    .score-display {
        font-size: 4rem;
        font-weight: 700;
        margin: 1rem 0;
        background: linear-gradient(135deg, #10b981, #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .score-display.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .score-display.danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .stats-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 1rem;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }
    .stat-item {
        text-align: center;
        padding: 1.5rem;
        border-radius: 1rem;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .stat-item.correct {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    }
    .stat-item.incorrect {
        background: linear-gradient(135deg, #fef2f2, #fecaca);
    }
    .stat-item.unanswered {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
    }
    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .action-buttons {
        padding: 2rem;
        text-align: center;
    }
    .action-btn {
        border-radius: 0.75rem;
        padding: 0.75rem 2rem;
        font-weight: 600;
        margin: 0.5rem;
        transition: all 0.3s ease;
    }
    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #553c9a 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
    .btn-secondary-custom {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        border: none;
        color: white;
    }
    .btn-secondary-custom:hover {
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
        transform: translateY(-2px);
        color: white;
    }
    .detailed-results {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    .question-item {
        background: #f8fafc;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .question-item.correct {
        border-left-color: #10b981;
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }
    .question-item.incorrect {
        border-left-color: #ef4444;
        background: linear-gradient(135deg, #fef2f2, #fecaca);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);
    }
    .question-item.unanswered {
        border-left-color: #f59e0b;
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.1);
    }
    .question-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .question-number {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 1rem;
    }
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.8rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .answer-section {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-top: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    @media print {
        .result-container {
            background: white !important;
            color: black !important;
        }
        .action-buttons {
            display: none;
        }
    }
</style>

<div class="result-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Result Header -->
                <div class="result-header">
                    <h1 class="mb-3" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        {{ $testResult->test->title }}
                    </h1>
                    <div class="score-display {{ $testResult->score >= 70 ? '' : ($testResult->score >= 50 ? 'warning' : 'danger') }}">
                        {{ $testResult->score }}%
                    </div>
                    <p class="text-muted mb-0 fs-5">
                        @if($testResult->score >= 90)
                            🎉 Ajoyib natija! Tabriklaymiz!
                        @elseif($testResult->score >= 70)
                            ✅ Yaxshi natija!
                        @elseif($testResult->score >= 50)
                            ⚠️ O'rtacha natija
                        @else
                            ❌ Yaxshiroq tayyorlanishga harakat qiling
                        @endif
                    </p>
                </div>
                
                <!-- Statistics -->
                <div class="stats-card">
                    <div class="p-4">
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="stat-item correct">
                                    <div class="stat-number text-success">{{ $testResult->correct_answers }}</div>
                                    <div class="stat-label">To'g'ri javob</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-item incorrect">
                                    <div class="stat-number text-danger">{{ $testResult->wrong_answers }}</div>
                                    <div class="stat-label">Noto'g'ri javob</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-item unanswered">
                                    <div class="stat-number text-warning">{{ $testResult->unanswered_questions }}</div>
                                    <div class="stat-label">Javobsiz</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-item">
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
                                <div class="stat-item">
                                    <div class="stat-number text-info">{{ $testResult->started_at->format('H:i') }}</div>
                                    <div class="stat-label">Boshlangan vaqt ({{ $testResult->started_at->format('d.m.Y') }})</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="stat-item">
                                    <div class="stat-number text-info">{{ $testResult->started_at->diffInMinutes($testResult->finished_at) }}</div>
                                    <div class="stat-label">Sarflangan vaqt (daqiqa)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('user.dashboard') }}" class="action-btn btn-primary-custom btn">
                        <i class="fas fa-arrow-left me-2"></i>Dashboardga qaytish
                    </a>
                    <button class="action-btn btn-secondary-custom btn" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Chop etish
                    </button>
                </div>
            </div>
        </div>

                <!-- Detailed Results -->
                <div class="detailed-results">
                    <div class="p-4">
                        <h4 class="mb-4" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">
                            <i class="fas fa-list-alt me-2"></i>Batafsil Natijalar
                        </h4>
                        
                        @foreach($detailedResults as $index => $result)
                            <div class="question-item {{ $result['is_correct'] ? 'correct' : ($result['user_answer'] ? 'incorrect' : 'unanswered') }}">
                                <div class="question-header">
                                    <div class="d-flex align-items-center">
                                        <div class="question-number">{{ $index + 1 }}</div>
                                        <h6 class="mb-0 flex-grow-1">
                                            {{ $result['question']['question'] }}
                                        </h6>
                                    </div>
                                    <div class="status-badge {{ $result['is_correct'] ? 'bg-success' : ($result['user_answer'] ? 'bg-danger' : 'bg-warning') }} text-white">
                                        @if($result['is_correct'])
                                            <i class="fas fa-check me-1"></i>To'g'ri
                                        @elseif($result['user_answer'])
                                            <i class="fas fa-times me-1"></i>Noto'g'ri
                                        @else
                                            <i class="fas fa-minus me-1"></i>Javobsiz
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="answer-section">
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
    </div>
</div>
@endsection
