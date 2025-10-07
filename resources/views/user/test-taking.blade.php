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
        border: 2px solid var(--border-color);
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        margin: 0.25rem;
        font-size: 0.875rem;
        position: relative;
    }

    .question-item:hover {
        border-color: var(--primary-color);
        background: var(--surface-gray-100);
        transform: scale(1.05);
    }

    /* Javobsiz savollar - oq fon, kulrang border */
    .question-item {
        background: white;
        border-color: #d1d5db;
        color: #6b7280;
    }

    /* Javob berilgan savollar - yashil */
    .question-item.answered {
        background: #10b981 !important;
        border-color: #10b981 !important;
        color: white !important;
    }

    /* Hozirgi savol - ko'k */
    .question-item.current {
        background: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: white !important;
        box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.3);
    }

    /* Hozirgi savol va javob berilgan bo'lsa - ko'k ustunlik qiladi */
    .question-item.current.answered {
        background: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        position: relative;
    }

    /* Javob berilgan holatni ko'rsatish uchun kichik belgi */
    .question-item.answered:not(.current)::after {
        content: '✓';
        position: absolute;
        bottom: -2px;
        right: -2px;
        background: #059669;
        color: white;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
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
                                // Get option values and shuffle them
                                $optionValues = array_values($options);
                                shuffle($optionValues);
                                // Keep fixed labels but assign shuffled values
                                $fixedLabels = ['a', 'b', 'c', 'd'];
                                $shuffledOptions = array_combine($fixedLabels, $optionValues);
                                // Find the correct key for selected answer based on original option text
                                $selectedKey = null;
                                if (isset($testResult->answers[$question['id']])) {
                                    $selectedOriginalKey = $testResult->answers[$question['id']];
                                    $selectedOptionText = $options[$selectedOriginalKey];
                                    foreach ($shuffledOptions as $displayKey => $displayText) {
                                        if ($displayText === $selectedOptionText) {
                                            $selectedKey = $displayKey;
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            @foreach($shuffledOptions as $displayKey => $optionText)
                                @php
                                    // Find the original key for this option text
                                    $originalKey = array_search($optionText, $options);
                                @endphp
                                <div class="option-btn {{ $selectedKey === $displayKey ? 'selected' : '' }}"
                                     data-value="{{ $originalKey }}" data-question-id="{{ $question['id'] }}">
                                    <strong>{{ strtoupper($displayKey) }})</strong> {{ $optionText }}
                                </div>
                            @endforeach
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="user-btn user-btn-outline" id="prev-btn" {{ $index === 0 ? 'disabled' : '' }}>
                                <i class="fas fa-chevron-left"></i>Oldingi
                            </button>
                            @if($index !== count($testResult->questions) - 1)
                                <button type="button" class="user-btn user-btn-primary" id="next-btn">
                                    Keyingi<i class="fas fa-chevron-right ms-2"></i>
                                </button>
                            @endif
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
let timeRemaining = Math.floor({{ ($testResult->test->duration_minutes * 60) - $testResult->started_at->diffInSeconds(now()) }});
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

    // Oxirgi savolda next tugmasi yo'q, shuning uchun hech narsa qilmaymiz
    // Faqat mavjud tugmani tekshiramiz va enabled qilamiz
    if (nextBtn) {
        nextBtn.disabled = false;
    }

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
    // Next button click handling
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
            const questionCard = document.querySelector(`[data-question-id="${questionId}"]`);
            if (questionCard) {
                const questionIndex = questionCard.dataset.questionIndex;
                const navigationItem = document.querySelector(`.question-item[data-question-index="${questionIndex}"]`);
                if (navigationItem && !navigationItem.classList.contains('answered')) {
                    navigationItem.classList.add('answered');
                    console.log(`Question ${parseInt(questionIndex) + 1} marked as answered`); // Debug log
                }
            }

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
        const currentCard = document.querySelector('.user-card.d-block[data-question-index]');
        if (currentCard) {
            const options = currentCard.querySelectorAll('.option-btn');
            if (options[optionIndex]) {
                options[optionIndex].click();
                e.preventDefault();
            }
        }
    }
});

// Sahifadan chiqishda ogohlantirish
window.addEventListener('beforeunload', function(e) {
    e.preventDefault();
    e.returnValue = 'Test jarayonida. Rostdan ham chiqmoqchimisiz?';
});

// Initialize question navigation states
function initializeNavigationStates() {
    // Mark already answered questions in navigation
    document.querySelectorAll('.question-item').forEach(item => {
        const questionIndex = parseInt(item.dataset.questionIndex);
        const questionCard = document.querySelector(`[data-question-index="${questionIndex}"]`);

        if (questionCard) {
            const hasSelectedOption = questionCard.querySelector('.option-btn.selected');
            if (hasSelectedOption && !item.classList.contains('answered')) {
                item.classList.add('answered');
                console.log(`Question ${questionIndex + 1} initialized as answered`); // Debug log
            }
        }
    });

    // Update initial progress
    updateProgress();
}

// Initial setup
initializeNavigationStates();
showQuestion(0);
</script>
@endsection
