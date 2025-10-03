@extends('layouts.admin')

@section('title', 'Testni tahrirlash')

@section('content')
<div class="">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <div class="d-flex align-items-center">
                <i class="fas fa-edit me-3 fs-4"></i>
                <div>
                    <h4 class="mb-0">Testni tahrirlash</h4>
                    <small class="opacity-75">{{ $test->title }} testini o'zgartirish</small>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.tests.update', $test) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Test nomi <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title', $test->title) }}"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Tavsif</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="3">{{ old('description', $test->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration_minutes" class="form-label">Davomiyligi (daqiqa) <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('duration_minutes') is-invalid @enderror"
                                           id="duration_minutes"
                                           name="duration_minutes"
                                           value="{{ old('duration_minutes', $test->duration_minutes) }}"
                                           min="1"
                                           required>
                                    @error('duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="max_attempts" class="form-label">Maksimal urinish <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('max_attempts') is-invalid @enderror"
                                           id="max_attempts"
                                           name="max_attempts"
                                           value="{{ old('max_attempts', $test->max_attempts) }}"
                                           min="1"
                                           required>
                                    @error('max_attempts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Boshlanish vaqti <span class="text-danger">*</span></label>
                                    <input type="datetime-local"
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           id="start_time"
                                           name="start_time"
                                           value="{{ old('start_time', date('Y-m-d\TH:i', strtotime($test->start_time))) }}"
                                           required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">Tugash vaqti <span class="text-danger">*</span></label>
                                    <input type="datetime-local"
                                           class="form-control @error('end_time') is-invalid @enderror"
                                           id="end_time"
                                           name="end_time"
                                           value="{{ old('end_time', date('Y-m-d\TH:i', strtotime($test->end_time))) }}"
                                           required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Kategoriyalar va savollar soni <span class="text-danger">*</span></label>
                            <div class="">
                                <div id="category-repeater">
                                    @php
                                        $selectedCategories = $test->categories_questions ?? [];
                                        $index = 0;
                                    @endphp
                                    @if(!empty($selectedCategories))
                                        @foreach($selectedCategories as $categoryId => $questionCount)
                                            @php
                                                $category = $categories->firstWhere('id', $categoryId);
                                            @endphp
                                            @if($category)
                                                <div class="category-row mb-3" id="category-row-{{ $index }}">
                                                    <div class="row align-items-end">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Kategoriya</label>
                                                            <select class="form-select category-select" name="categories[{{ $index }}][category_id]" required>
                                                                <option value="">Kategoriyani tanlang</option>
                                                                @foreach($categories as $cat)
                                                                    <option value="{{ $cat->id }}" data-max-questions="{{ $cat->activeQuestions->count() }}" {{ $cat->id == $categoryId ? 'selected' : '' }}>
                                                                        {{ $cat->name }} ({{ $cat->activeQuestions->count() }} ta savol)
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Savollar soni</label>
                                                            <input type="number" class="form-control question-count"
                                                                   name="categories[{{ $index }}][question_count]"
                                                                   min="1" max="{{ $category->activeQuestions->count() }}"
                                                                   placeholder="Maksimal: {{ $category->activeQuestions->count() }}"
                                                                   value="{{ old('categories.'.$index.'.question_count', $questionCount) }}"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            @if($loop->first && count($selectedCategories) == 1)
                                                                <!-- Empty space for first row when only one exists -->
                                                            @else
                                                                <button type="button" class="btn btn-danger remove-category">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $index++; @endphp
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="category-row mb-3" id="category-row-0">
                                            <div class="row align-items-end">
                                                <div class="col-md-6">
                                                    <label class="form-label">Kategoriya</label>
                                                    <select class="form-select category-select" name="categories[0][category_id]" required>
                                                        <option value="">Kategoriyani tanlang</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" data-max-questions="{{ $category->activeQuestions->count() }}">
                                                                {{ $category->name }} ({{ $category->activeQuestions->count() }} ta savol)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Savollar soni</label>
                                                    <input type="number" class="form-control question-count"
                                                           name="categories[0][question_count]"
                                                           min="1" max="" placeholder="Son kiriting" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- Empty space for first row -->
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn w-100 btn-success add-category">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <small class="text-muted">Har bir kategoriyadan nechtadan savol tanlanishini belgilang</small>
                            </div>
                            @error('categories')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $test->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Aktiv test</strong>
                                <br><small class="text-muted">Bu test foydalanuvchilarga ko'rsatiladi</small>
                            </label>
                        </div>
                        
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Orqaga
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Yangilash
                            </button>
                        </div>
                    </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
.category-row {
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 15px;
    background-color: #f8f9fa;
}

.category-row:hover {
    background-color: #f1f3f4;
    border-color: #6c757d;
}

.remove-category {
    border: none;
    padding: 8px 12px;
}

.add-category {
    border: none;
    padding: 8px 12px;
}
</style>
@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    let categoryRowIndex = {{ count($test->categories_questions ?? []) }};
    
    // Initialize Select2 for existing rows
    initializeSelect2($('.category-select'));
    
    // Function to initialize Select2
    function initializeSelect2(element) {
        element.select2({
            theme: 'bootstrap-5',
            placeholder: 'Kategoriyani qidiring...',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return 'Hech narsa topilmadi';
                },
                searching: function() {
                    return 'Qidirilmoqda...';
                }
            }
        });
    }
    
    // Add new category row
    $(document).on('click', '.add-category', function() {
        categoryRowIndex++;
        
        const newRow = `
            <div class="category-row mb-3" id="category-row-${categoryRowIndex}">
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Kategoriya</label>
                        <select class="form-select category-select" name="categories[${categoryRowIndex}][category_id]" required>
                            <option value="">Kategoriyani tanlang</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-max-questions="{{ $category->activeQuestions->count() }}">
                                    {{ $category->name }} ({{ $category->activeQuestions->count() }} ta savol)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Savollar soni</label>
                        <input type="number" class="form-control question-count"
                               name="categories[${categoryRowIndex}][question_count]"
                               min="1" max="" placeholder="Son kiriting" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('#category-repeater').append(newRow);
        
        // Initialize Select2 for the new row
        const newSelect = $(`#category-row-${categoryRowIndex} .category-select`);
        initializeSelect2(newSelect);
        
        // Update first row button to remove if more than one row
        updateButtons();
    });
    
    // Remove category row
    $(document).on('click', '.remove-category', function() {
        $(this).closest('.category-row').remove();
        updateButtons();
        validateUniqueCategories();
    });
    
    // Update question count max value when category is selected
    $(document).on('change', '.category-select', function() {
        const maxQuestions = $(this).find('option:selected').data('max-questions');
        const questionInput = $(this).closest('.category-row').find('.question-count');
        
        if (maxQuestions) {
            questionInput.attr('max', maxQuestions);
            questionInput.attr('placeholder', `Maksimal: ${maxQuestions}`);
            
            // Reset value if it exceeds the maximum
            if (parseInt(questionInput.val()) > maxQuestions) {
                questionInput.val(maxQuestions);
            }
        }
        
        validateUniqueCategories();
    });
    
    // Function to update buttons based on row count
    function updateButtons() {
        const rowCount = $('.category-row').length;
        
        if (rowCount === 1) {
            $('.category-row:first .col-md-2').html('');
        } else {
            $('.category-row:first .col-md-2').html(`
                <button type="button" class="btn btn-danger remove-category">
                    <i class="fas fa-trash"></i>
                </button>
            `);
        }
    }
    
    // Function to validate unique categories
    function validateUniqueCategories() {
        const selectedCategories = [];
        let hasError = false;
        
        $('.category-select').each(function() {
            const value = $(this).val();
            const row = $(this).closest('.category-row');
            
            // Remove previous error styling
            $(this).removeClass('is-invalid');
            row.find('.invalid-feedback').remove();
            
            if (value && selectedCategories.includes(value)) {
                $(this).addClass('is-invalid');
                $(this).after('<div class="invalid-feedback">Bu kategoriya allaqachon tanlangan</div>');
                hasError = true;
            } else if (value) {
                selectedCategories.push(value);
            }
        });
        
        return !hasError;
    }
    
    // Initial button state
    updateButtons();
    
    // Form validation before submit
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Check if at least one category is selected
        const selectedCategories = $('.category-select').filter(function() {
            return $(this).val() !== '';
        });
        
        if (selectedCategories.length === 0) {
            e.preventDefault();
            alert('Kamida bitta kategoriya tanlash kerak!');
            isValid = false;
        }
        
        // Validate unique categories
        if (!validateUniqueCategories()) {
            e.preventDefault();
            alert('Har bir kategoriya faqat bir marta tanlanishi kerak!');
            isValid = false;
        }
        
        // Validate question counts
        $('.question-count').each(function() {
            const row = $(this).closest('.category-row');
            const categorySelect = row.find('.category-select');
            
            if (categorySelect.val() && !$(this).val()) {
                e.preventDefault();
                $(this).addClass('is-invalid');
                alert('Barcha tanlangan kategoriyalar uchun savollar sonini kiriting!');
                isValid = false;
            }
        });
        
        return isValid;
    });
});
</script>
@endsection
