@extends('layouts.purpose-admin')

@section('title', 'Yangi Savol')
@section('description', 'Test savoli yaratish')

@section('content')
<div class="purpose-form-container purpose-fade-in">
    <div class="purpose-form-card">
        <div class="purpose-form-header">
            <div class="purpose-form-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h1 class="purpose-form-title">Yangi Savol Yaratish</h1>
            <p class="purpose-form-subtitle">Test savoli uchun ma'lumotlarni kiriting</p>
        </div>
        
        <div class="purpose-form-body">
            <form method="POST" action="{{ route('admin.questions.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="purpose-form-group">
                            <label for="category_id" class="purpose-form-label">
                                Kategoriya <span class="purpose-required">*</span>
                            </label>
                            <select class="purpose-form-control @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Kategoriyani tanlang</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', request('category')) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="purpose-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="purpose-form-group">
                            <label for="correct_answer" class="purpose-form-label">
                                To'g'ri javob <span class="purpose-required">*</span>
                            </label>
                            <select class="purpose-form-control @error('correct_answer') is-invalid @enderror" 
                                    id="correct_answer" name="correct_answer" required>
                                <option value="">To'g'ri javobni tanlang</option>
                                <option value="a" {{ old('correct_answer') === 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('correct_answer') === 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('correct_answer') === 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('correct_answer') === 'd' ? 'selected' : '' }}>D</option>
                            </select>
                            @error('correct_answer')
                                <div class="purpose-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="purpose-form-group">
                    <label for="question" class="purpose-form-label">
                        Savol matni <span class="purpose-required">*</span>
                    </label>
                    <textarea class="purpose-form-control @error('question') is-invalid @enderror" 
                              id="question" name="question" rows="4" required 
                              placeholder="Savol matnini kiriting...">{{ old('question') }}</textarea>
                    @error('question')
                        <div class="purpose-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Answer Options -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="purpose-form-group">
                            <label for="option_a" class="purpose-form-label d-flex align-items-center">
                                <span class="purpose-badge purpose-badge-primary me-2">A</span> 
                                Birinchi variant <span class="purpose-required">*</span>
                            </label>
                            <input type="text" class="purpose-form-control answer-option @error('option_a') is-invalid @enderror" 
                                   id="option_a" name="option_a" value="{{ old('option_a') }}" required 
                                   placeholder="A variantini kiriting">
                            @error('option_a')
                                <div class="purpose-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="purpose-form-group">
                            <label for="option_b" class="purpose-form-label d-flex align-items-center">
                                <span class="purpose-badge purpose-badge-info me-2">B</span> 
                                Ikkinchi variant <span class="purpose-required">*</span>
                            </label>
                            <input type="text" class="purpose-form-control answer-option @error('option_b') is-invalid @enderror" 
                                   id="option_b" name="option_b" value="{{ old('option_b') }}" required 
                                   placeholder="B variantini kiriting">
                            @error('option_b')
                                <div class="purpose-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="purpose-form-group">
                            <label for="option_c" class="purpose-form-label d-flex align-items-center">
                                <span class="purpose-badge purpose-badge-warning me-2">C</span> 
                                Uchinchi variant <span class="purpose-required">*</span>
                            </label>
                            <input type="text" class="purpose-form-control answer-option @error('option_c') is-invalid @enderror" 
                                   id="option_c" name="option_c" value="{{ old('option_c') }}" required 
                                   placeholder="C variantini kiriting">
                            @error('option_c')
                                <div class="purpose-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="purpose-form-group">
                            <label for="option_d" class="purpose-form-label d-flex align-items-center">
                                <span class="purpose-badge purpose-badge-success me-2">D</span> 
                                To'rtinchi variant <span class="purpose-required">*</span>
                            </label>
                            <input type="text" class="purpose-form-control answer-option @error('option_d') is-invalid @enderror" 
                                   id="option_d" name="option_d" value="{{ old('option_d') }}" required 
                                   placeholder="D variantini kiriting">
                            @error('option_d')
                                <div class="purpose-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="purpose-checkbox">
                    <div class="d-flex align-items-center">
                        <input class="purpose-checkbox-input" type="checkbox" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="purpose-checkbox-label" for="is_active">
                            <strong>Faol savol</strong>
                            <br><small class="purpose-text-muted">Bu savol testlarda ko'rsatilishi mumkin</small>
                        </label>
                    </div>
                </div>

                <div class="purpose-form-actions">
                    <a href="{{ route('admin.questions.index') }}" class="purpose-btn purpose-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Orqaga
                    </a>
                    <button type="submit" class="purpose-btn purpose-btn-success">
                        <i class="fas fa-save"></i>
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
/* Custom styles for answer options */
.answer-option {
    position: relative;
    transition: all 0.3s ease;
}

.answer-option.correct-answer {
    border-color: #2dce89 !important;
    background: rgba(45, 206, 137, 0.05);
    box-shadow: 0 0 0 3px rgba(45, 206, 137, 0.1);
}

.answer-option.correct-answer::after {
    content: '\f00c';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #2dce89;
    font-size: 1rem;
    animation: checkmarkBounce 0.4s ease-out;
}

@keyframes checkmarkBounce {
    0% { transform: translateY(-50%) scale(0); }
    50% { transform: translateY(-50%) scale(1.2); }
    100% { transform: translateY(-50%) scale(1); }
}

.purpose-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-weight: 600;
    min-width: 24px;
    text-align: center;
}

.purpose-badge-info {
    background: rgba(17, 205, 239, 0.1);
    color: #11cdef;
}
</style>

<script>
$(document).ready(function() {
    // To'g'ri javob ko'rsatkich
    $('#correct_answer').on('change', function() {
        const options = ['option_a', 'option_b', 'option_c', 'option_d'];
        const selectedAnswer = $(this).val();
        
        // Barcha optionlardan correct-answer classini olib tashlash
        options.forEach(option => {
            $('#' + option).removeClass('correct-answer');
        });
        
        // Tanlangan optionga correct-answer class qo'shish
        if (selectedAnswer) {
            $('#option_' + selectedAnswer).addClass('correct-answer');
            
            // Success notification
            showNotification('To\'g\'ri javob ' + selectedAnswer.toUpperCase() + ' variant sifatida belgilandi', 'success');
        }
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        const question = $('#question').val().trim();
        const options = {
            a: $('#option_a').val().trim(),
            b: $('#option_b').val().trim(),
            c: $('#option_c').val().trim(),
            d: $('#option_d').val().trim()
        };
        const correctAnswer = $('#correct_answer').val();
        
        // Basic validation
        if (!question || !options.a || !options.b || !options.c || !options.d || !correctAnswer) {
            e.preventDefault();
            showNotification('Iltimos, barcha majburiy maydonlarni to\'ldiring!', 'danger');
            return false;
        }
        
        // Check for duplicate options
        const optionValues = Object.values(options);
        const uniqueOptions = [...new Set(optionValues)];
        if (uniqueOptions.length !== optionValues.length) {
            e.preventDefault();
            showNotification('Barcha variantlar turlicha bo\'lishi kerak!', 'warning');
            return false;
        }
        
        // Success feedback
        showNotification('Savol saqlanmoqda...', 'info');
    });
    
    // Auto-resize textarea
    $('#question').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Dynamic placeholder for category
    $('#category_id').on('change', function() {
        const categoryName = $(this).find('option:selected').text();
        if (categoryName && categoryName !== 'Kategoriyani tanlang') {
            $('#question').attr('placeholder', categoryName + ' bo\'yicha savol matnini kiriting...');
        }
    });
    
    // Character counters
    addCharacterCounter('#question', 500);
    addCharacterCounter('#option_a', 100);
    addCharacterCounter('#option_b', 100);
    addCharacterCounter('#option_c', 100);
    addCharacterCounter('#option_d', 100);
});

// Helper functions
function showNotification(message, type) {
    // Create notification element
    const notification = $(`
        <div class="purpose-alert purpose-alert-${type} purpose-alert-icon position-fixed" 
             style="top: 2rem; right: 2rem; z-index: 9999; max-width: 350px; animation: slideInRight 0.3s ease-out;">
            <i class="fas fa-${getAlertIcon(type)}"></i>
            <div>${message}</div>
        </div>
    `);
    
    // Add to page
    $('body').append(notification);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-in';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function getAlertIcon(type) {
    const icons = {
        success: 'check-circle',
        danger: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

function addCharacterCounter(selector, maxLength) {
    const element = $(selector);
    const counter = $(`<small class="purpose-text-muted d-block mt-1">0 / ${maxLength} belgi</small>`);
    element.parent().append(counter);
    
    element.on('input', function() {
        const length = this.value.length;
        counter.text(`${length} / ${maxLength} belgi`);
        counter.removeClass('purpose-text-danger purpose-text-warning');
        
        if (length > maxLength * 0.9) {
            counter.addClass('purpose-text-warning');
        }
        if (length >= maxLength) {
            counter.addClass('purpose-text-danger');
        }
    });
}

// Add slide animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endsection
