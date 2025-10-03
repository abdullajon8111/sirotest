@extends('layouts.admin')

@section('title', 'Savol Tahrirlash')
@section('description', 'Savol ma\'lumotlarini o\'zgartirish')

@section('content')
<div class="">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <div class="d-flex align-items-center">
                <i class="fas fa-edit me-3 fs-4"></i>
                <div>
                    <h4 class="mb-0">Savol Tahrirlash</h4>
                    <small class="opacity-75">Savol #{{ $question->id }} ma'lumotlarini o'zgartirish</small>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.questions.update', $question) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">
                                Kategoriya <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Kategoriyani tanlang</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $question->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="correct_answer" class="form-label">
                                To'g'ri javob <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('correct_answer') is-invalid @enderror" 
                                    id="correct_answer" name="correct_answer" required>
                                <option value="">To'g'ri javobni tanlang</option>
                                <option value="a" {{ old('correct_answer', $question->correct_answer) === 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('correct_answer', $question->correct_answer) === 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('correct_answer', $question->correct_answer) === 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('correct_answer', $question->correct_answer) === 'd' ? 'selected' : '' }}>D</option>
                            </select>
                            @error('correct_answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="question" class="form-label">
                        Savol matni <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('question') is-invalid @enderror" 
                              id="question" name="question" rows="4" required 
                              placeholder="Savol matnini kiriting...">{{ old('question', $question->question) }}</textarea>
                    @error('question')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Answer Options -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option_a" class="form-label d-flex align-items-center">
                                <span class="badge bg-primary me-2">A</span> Birinchi variant <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control answer-option @error('option_a') is-invalid @enderror" 
                                   id="option_a" name="option_a" value="{{ old('option_a', $question->option_a) }}" required 
                                   placeholder="A variantini kiriting">
                            @error('option_a')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option_b" class="form-label d-flex align-items-center">
                                <span class="badge bg-info me-2">B</span> Ikkinchi variant <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control answer-option @error('option_b') is-invalid @enderror" 
                                   id="option_b" name="option_b" value="{{ old('option_b', $question->option_b) }}" required 
                                   placeholder="B variantini kiriting">
                            @error('option_b')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option_c" class="form-label d-flex align-items-center">
                                <span class="badge bg-warning me-2">C</span> Uchinchi variant <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control answer-option @error('option_c') is-invalid @enderror" 
                                   id="option_c" name="option_c" value="{{ old('option_c', $question->option_c) }}" required 
                                   placeholder="C variantini kiriting">
                            @error('option_c')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option_d" class="form-label d-flex align-items-center">
                                <span class="badge bg-success me-2">D</span> To'rtinchi variant <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control answer-option @error('option_d') is-invalid @enderror" 
                                   id="option_d" name="option_d" value="{{ old('option_d', $question->option_d) }}" required 
                                   placeholder="D variantini kiriting">
                            @error('option_d')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', $question->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        <strong>Faol savol</strong>
                        <br><small class="text-muted">Bu savol testlarda ko'rsatilishi mumkin</small>
                    </label>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Orqaga
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i>
                        Yangilash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Sahifa yuklanganda to'g'ri javobni ko'rsatish
    const correctAnswer = $('#correct_answer').val();
    if (correctAnswer) {
        $('#option_' + correctAnswer).addClass('border-success');
    }
    
    // To'g'ri javob o'zgarganda
    $('#correct_answer').on('change', function() {
        const options = ['option_a', 'option_b', 'option_c', 'option_d'];
        const selectedAnswer = $(this).val();
        
        // Barcha optionlardan success classni olib tashlash
        options.forEach(option => {
            $('#' + option).removeClass('border-success');
        });
        
        // Tanlangan optionga success class qo'shish
        if (selectedAnswer) {
            $('#option_' + selectedAnswer).addClass('border-success');
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
        
        // Tekshirish
        if (!question || !options.a || !options.b || !options.c || !options.d || !correctAnswer) {
            e.preventDefault();
            alert('Iltimos, barcha maydonlarni to\'ldiring!');
            return false;
        }
        
        // Variantlarni tekshirish
        const optionValues = Object.values(options);
        const uniqueOptions = [...new Set(optionValues)];
        if (uniqueOptions.length !== optionValues.length) {
            e.preventDefault();
            alert('Barcha variantlar turlicha bo\'lishi kerak!');
            return false;
        }
    });
    
    // Auto-resize textarea
    $('#question').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Kategoriya o'zgarganda placeholder yangilash
    $('#category_id').on('change', function() {
        const categoryName = $(this).find('option:selected').text();
        if (categoryName && categoryName !== 'Kategoriyani tanlang') {
            $('#question').attr('placeholder', categoryName + ' bo\'yicha savol matnini kiriting...');
        }
    });
    
    // Initial textarea height
    const textarea = document.getElementById('question');
    if (textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }
});
</script>
@endsection
