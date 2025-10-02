@extends('layouts.user')

@section('title', 'Test - ' . $testResult->test->title)

@section('page-header')
<div class="row align-items-center">
    <div class="col-md-6">
        <h1 class="h3 mb-1 text-gradient fw-bold">{{ $testResult->test->title }}</h1>
        <p class="text-muted mb-0">Jami {{ count($testResult->questions) }} ta savol</p>
    </div>
    <div class="col-md-6">
        <div class="d-flex justify-content-md-end">
            <div class="timer-display">
                <i class="fas fa-clock me-2"></i>
                <span id="time-remaining">{{ $testResult->test->duration_minutes }}:00</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<style>
    .timer-display {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 1.125rem;
        font-weight: 600;
        text-align: center;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        display: inline-flex;
        align-items: center;
    }
    .question-item {
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        margin: 0.25rem;
        font-size: 0.875rem;
    }
    
    .question-item:hover {
        border-color: var(--primary-color);
        background: var(--surface-gray-100);
    }
    
    .question-item.answered {
        background: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }
    
    .question-item.current {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    
    .option-btn {
        background: var(--surface-gray-50);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: block;
        width: 100%;
        text-align: left;
        color: var(--text-primary);
        text-decoration: none;
    }
    
    .option-btn:hover {
        border-color: var(--primary-color);
        background: rgba(94, 114, 228, 0.1);
        color: var(--text-primary);
    }
    
    .option-btn.selected {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    
    .question-number {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .question-card-active {
        animation: fadeIn 0.3s ease;
    }
</style>
<div class="row">
    <!-- Questions Content -->
    <div class="col-lg-8">
        <div id="questions-container">
            @foreach($testResult->questions as $index => $question)
                <div class="user-card {{ $index === 0 ? 'd-block question-card-active' : 'd-none' }}" data-question-index="{{ $index }}" data-question-id="{{ $question['id'] }}">
                    <div class="user-card-body">
                        <div class="question-number">{{ $index + 1 }}</div>
                        
                        <h5 class="mb-4 fw-bold">{{ $question['question'] }}</h5>
                        
                        <div class="options">
                            @php
                                $options = [
                                    'a' => $question['option_a'],
                                    'b' => $question['option_b'],
                                    'c' => $question['option_c'],
                                    'd' => $question['option_d']
                                ];
                                $shuffledKeys = array_keys($options);
                                shuffle($shuffledKeys);
                            @endphp
                            
                            @foreach($shuffledKeys as $key)
                                <div class="option-btn {{ isset($testResult->answers[$question['id']]) && $testResult->answers[$question['id']] === $key ? 'selected' : '' }}" 
                                     data-value="{{ $key }}" data-question-id="{{ $question['id'] }}">
                                    <strong>{{ strtoupper($key) }})</strong> {{ $options[$key] }}
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="user-btn user-btn-outline" id="prev-btn" {{ $index === 0 ? 'disabled' : '' }}>
                                <i class="fas fa-chevron-left"></i>Oldingi
                            </button>
                            <button type="button" class="user-btn user-btn-primary" id="next-btn" {{ $index === count($testResult->questions) - 1 ? 'disabled' : '' }}>
                                Keyingi<i class="fas fa-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Sidebar Navigation -->
    <div class="col-lg-4">
        <div class="user-card mb-4 position-sticky" style="top: 2rem;">
            <div class="user-card-header">
                <h5 class="user-card-title">
                    <i class="fas fa-list me-2"></i>Savollar Navigatsiyasi
                </h5>
            </div>
            <div class="user-card-body">
                <div class="d-flex flex-wrap mb-3">
                    @foreach($testResult->questions as $index => $question)
                        <div class="question-item {{ $index === 0 ? 'current' : '' }} {{ isset($testResult->answers[$question['id']]) ? 'answered' : '' }}" 
                             data-question-index="{{ $index }}">
                            {{ $index + 1 }}
                        </div>
                    @endforeach
                </div>
                
                <!-- Progress -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Jarayon:</span>
                        <span id="progress-text" class="fw-bold">{{ $testResult->answers ? count($testResult->answers) : 0 }}/{{ count($testResult->questions) }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             id="progress-bar"
                             style="width: {{ $testResult->answers ? round(count($testResult->answers) / count($testResult->questions) * 100) : 0 }}%;">
                        </div>
                    </div>
                </div>
                
                <!-- Legend -->
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="question-item" style="width: 16px; height: 16px; margin: 0; font-size: 0.75rem;"></div>
                        <small class="ms-2 text-muted">Javobsiz</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="question-item answered" style="width: 16px; height: 16px; margin: 0; font-size: 0.75rem;"></div>
                        <small class="ms-2 text-muted">Javobli</small>
                    </div>
                </div>
                
                <!-- Finish Button -->
                <form method="POST" action="{{ route('user.test.finish', $testResult) }}" id="finish-form">
                    @csrf
                    <button type="button" class="user-btn user-btn-primary w-100" id="finish-btn" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-check"></i>Testni Yakunlash
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let timeRemaining = {{ ($testResult->test->duration_minutes * 60) - $testResult->started_at->diffInSeconds(now()) }};
let timerInterval;
let currentQuestion = 0;
const totalQuestions = {{ count($testResult->questions) }};
const testResultId = '{{ $testResult->id }}';

// Timer fonksiyasi
function updateTimer() {
    if (timeRemaining <= 0) {
        document.getElementById('time-remaining').textContent = 'Vaqt tugadi!';
        clearInterval(timerInterval);
        document.getElementById('finish-form').submit();
        return;
    }
    
    let minutes = Math.floor(timeRemaining / 60);
    let seconds = timeRemaining % 60;
    document.getElementById('time-remaining').textContent = 
        minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
    
    timeRemaining--;
}

// Timer'ni boshlash
timerInterval = setInterval(updateTimer, 1000);
updateTimer();

// Savolni ko'rsatish
function showQuestion(index) {
    // Barcha savollarni yashirish
    document.querySelectorAll('.user-card[data-question-index]').forEach(card => {
        card.classList.remove('d-block', 'question-card-active');
        card.classList.add('d-none');
    });
    
    // Tanlangan savolni ko'rsatish
    const targetCard = document.querySelector(`[data-question-index="${index}"]`);
    if (targetCard) {
        targetCard.classList.remove('d-none');
        targetCard.classList.add('d-block', 'question-card-active');
    }
    
    // Navigation tugmalarini yangilash
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    
    if (prevBtn) prevBtn.disabled = index === 0;
    if (nextBtn) nextBtn.disabled = index === totalQuestions - 1;
    
    // Question navigation'dagi current holatini yangilash
    document.querySelectorAll('.question-item').forEach(item => {
        item.classList.remove('current');
    });
    const currentNavItem = document.querySelector(`.question-item[data-question-index="${index}"]`);
    if (currentNavItem) {
        currentNavItem.classList.add('current');
    }
    
    currentQuestion = index;
}

// Navigation tugmalari
document.addEventListener('click', function(e) {
    if (e.target.id === 'next-btn' || e.target.closest('#next-btn')) {
        if (currentQuestion < totalQuestions - 1) {
            showQuestion(currentQuestion + 1);
        }
    }
    
    if (e.target.id === 'prev-btn' || e.target.closest('#prev-btn')) {
        if (currentQuestion > 0) {
            showQuestion(currentQuestion - 1);
        }
    }
    
    // Question navigation items
    if (e.target.classList.contains('question-item')) {
        const questionIndex = parseInt(e.target.dataset.questionIndex);
        showQuestion(questionIndex);
    }
    
    // Option tugmalari
    if (e.target.classList.contains('option-btn')) {
        const questionId = e.target.dataset.questionId;
        const answer = e.target.dataset.value;
        
        // Boshqa optionlardan selected klassini olib tashlash
        e.target.parentNode.querySelectorAll('.option-btn').forEach(btn => {
            btn.classList.remove('selected');
        });
        
        // Tanlangan optionga selected klassini qo'shish
        e.target.classList.add('selected');
        
        // Javobni saqlash
        saveAnswer(questionId, answer);
    }
    
    // Finish tugmasi
    if (e.target.id === 'finish-btn' || e.target.closest('#finish-btn')) {
        if (confirm('Testni yakunlamoqchimisiz? Barcha javoblar saqlanadi.')) {
            document.getElementById('finish-form').submit();
        }
    }
});

// Javobni saqlash funksiyasi
function saveAnswer(questionId, answer) {
    fetch(`{{ route('user.test.answer', $testResult) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            question_id: questionId,
            answer: answer
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Question navigation'da javob berilganini ko'rsatish
            const questionIndex = document.querySelector(`[data-question-id="${questionId}"]`).dataset.questionIndex;
            const navigationItem = document.querySelector(`[data-question-index="${questionIndex}"]`);
            navigationItem.classList.add('answered');
            
            // Progress'ni yangilash
            updateProgress();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Javob saqlashda xatolik yuz berdi!');
    });
}

// Progress'ni yangilash
function updateProgress() {
    const answeredCount = document.querySelectorAll('.question-item.answered').length;
    const percentage = Math.round(answeredCount / totalQuestions * 100);
    
    document.getElementById('progress-text').textContent = `${answeredCount}/${totalQuestions}`;
    document.getElementById('progress-bar').style.width = `${percentage}%`;
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowRight' && currentQuestion < totalQuestions - 1) {
        showQuestion(currentQuestion + 1);
        e.preventDefault();
    }
    
    if (e.key === 'ArrowLeft' && currentQuestion > 0) {
        showQuestion(currentQuestion - 1);
        e.preventDefault();
    }
    
    // 1-4 raqamlar bilan javob tanlash
    if (['1', '2', '3', '4'].includes(e.key)) {
        const optionIndex = parseInt(e.key) - 1;
        const currentCard = document.querySelector('.question-card-modern.active');
        const options = currentCard.querySelectorAll('.option-btn');
        if (options[optionIndex]) {
            options[optionIndex].click();
        }
    }
});

// Sahifadan chiqishda ogohlantirish
window.addEventListener('beforeunload', function(e) {
    e.preventDefault();
    e.returnValue = 'Test jarayonida. Rostdan ham chiqmoqchimisiz?';
});

// Initial setup
showQuestion(0);
</script>
@endsection
