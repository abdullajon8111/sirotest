@extends('layouts.app')

@section('title', 'Test - ' . $testResult->test->title)

@section('content')
<style>
    .test-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .test-header {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .timer-display {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        font-size: 1.25rem;
        font-weight: 600;
        text-align: center;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    }
    .question-navigation {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        position: sticky;
        top: 2rem;
    }
    .question-item {
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        border: 2px solid #e2e8f0;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        margin: 0.25rem;
    }
    .question-item:hover {
        border-color: #667eea;
        background: #f1f5f9;
    }
    .question-item.answered {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    .question-item.current {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }
    .question-card-modern {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        display: none;
    }
    .question-card-modern.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .option-btn {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: block;
        width: 100%;
        text-align: left;
    }
    .option-btn:hover {
        border-color: #667eea;
        background: #f1f5f9;
    }
    .option-btn.selected {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }
    .question-number {
        background: linear-gradient(135deg, #667eea, #764ba2);
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
    .nav-btn {
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .nav-btn:hover {
        transform: translateY(-2px);
    }
</style>

<div class="test-container">
    <div class="container-fluid">
        <!-- Test Header -->
        <div class="test-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-1 fw-bold">{{ $testResult->test->title }}</h4>
                    <p class="text-muted mb-0">Jami {{ count($testResult->questions) }} ta savol</p>
                </div>
                <div class="col-md-6">
                    <div class="timer-display">
                        <i class="fas fa-clock me-2"></i>
                        <span id="time-remaining">{{ $testResult->test->duration_minutes }}:00</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Questions Content -->
            <div class="col-lg-8">
                <div id="questions-container">
                    @foreach($testResult->questions as $index => $question)
                        <div class="question-card-modern {{ $index === 0 ? 'active' : '' }}" data-question-index="{{ $index }}" data-question-id="{{ $question['id'] }}">
                            <div class="question-number">{{ $index + 1 }}</div>
                            
                            <h5 class="mb-3 fw-bold">{{ $question['question'] }}</h5>
                            
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
                                        <strong>{{ $key }})</strong> {{ $options[$key] }}
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Navigation Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-primary nav-btn" id="prev-btn" {{ $index === 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-chevron-left me-2"></i> Oldingi
                                </button>
                                <button type="button" class="btn btn-primary nav-btn" id="next-btn" {{ $index === count($testResult->questions) - 1 ? 'disabled' : '' }}>
                                    Keyingi <i class="fas fa-chevron-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Sidebar Navigation -->
            <div class="col-lg-4">
                <div class="question-navigation">
                    <h6 class="mb-3 fw-bold">Savollar Navigatsiyasi</h6>
                    
                    <div class="d-flex flex-wrap mb-3">
                        @foreach($testResult->questions as $index => $question)
                            <div class="question-item {{ $index === 0 ? 'current' : '' }} {{ isset($testResult->answers[$question['id']]) ? 'answered' : '' }}" 
                                 data-question-index="{{ $index }}">
                                {{ $index + 1 }}
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Progress:</span>
                            <span id="progress-text">{{ $testResult->answers ? count($testResult->answers) : 0 }}/{{ count($testResult->questions) }}</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 id="progress-bar"
                                 style="width: {{ $testResult->answers ? round(count($testResult->answers) / count($testResult->questions) * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="question-item" style="width: 20px; height: 20px; margin: 0;"></div>
                            <small class="ms-2 text-muted">Javobsiz</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="question-item answered" style="width: 20px; height: 20px; margin: 0;"></div>
                            <small class="ms-2 text-muted">Javob berilgan</small>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('user.test.finish', $testResult) }}" id="finish-form">
                        @csrf
                        <button type="button" class="btn btn-success w-100 nav-btn" id="finish-btn">
                            <i class="fas fa-check me-2"></i> Testni Yakunlash
                        </button>
                    </form>
                </div>
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
    document.querySelectorAll('.question-card-modern').forEach(card => {
        card.classList.remove('active');
    });
    
    // Tanlangan savolni ko'rsatish
    document.querySelector(`[data-question-index="${index}"]`).classList.add('active');
    
    // Navigation tugmalarini yangilash
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    
    prevBtn.disabled = index === 0;
    nextBtn.disabled = index === totalQuestions - 1;
    
    // Question navigation'dagi current holatini yangilash
    document.querySelectorAll('.question-item').forEach(item => {
        item.classList.remove('current');
    });
    document.querySelector(`[data-question-index="${index}"]`).classList.add('current');
    
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
