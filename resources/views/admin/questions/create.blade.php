@extends('layouts.app')

@section('title', 'Yangi Savol')
@section('page-title', 'Yangi Savol Yaratish')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Yangi Savol Yaratish</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.questions.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategoriya <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
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
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="correct_answer" class="form-label">To'g'ri javob <span class="text-danger">*</span></label>
                                <select class="form-select @error('correct_answer') is-invalid @enderror" 
                                        id="correct_answer" name="correct_answer" required>
                                    <option value="">To'g'ri javobni tanlang</option>
                                    <option value="a" {{ old('correct_answer') === 'a' ? 'selected' : '' }}>A</option>
                                    <option value="b" {{ old('correct_answer') === 'b' ? 'selected' : '' }}>B</option>
                                    <option value="c" {{ old('correct_answer') === 'c' ? 'selected' : '' }}>C</option>
                                    <option value="d" {{ old('correct_answer') === 'd' ? 'selected' : '' }}>D</option>
                                </select>
                                @error('correct_answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="question" class="form-label">Savol matni <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('question') is-invalid @enderror" 
                                  id="question" name="question" rows="3" required>{{ old('question') }}</textarea>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option_a" class="form-label">A variant <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('option_a') is-invalid @enderror" 
                                       id="option_a" name="option_a" value="{{ old('option_a') }}" required>
                                @error('option_a')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option_b" class="form-label">B variant <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('option_b') is-invalid @enderror" 
                                       id="option_b" name="option_b" value="{{ old('option_b') }}" required>
                                @error('option_b')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option_c" class="form-label">C variant <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('option_c') is-invalid @enderror" 
                                       id="option_c" name="option_c" value="{{ old('option_c') }}" required>
                                @error('option_c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option_d" class="form-label">D variant <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('option_d') is-invalid @enderror" 
                                       id="option_d" name="option_d" value="{{ old('option_d') }}" required>
                                @error('option_d')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Faol savol
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Orqaga
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Saqlash
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// To'g'ri javob rangini o'zgartirish
document.getElementById('correct_answer').addEventListener('change', function() {
    const options = ['option_a', 'option_b', 'option_c', 'option_d'];
    const selectedAnswer = this.value;
    
    options.forEach(option => {
        const input = document.getElementById(option);
        input.classList.remove('border-success');
    });
    
    if (selectedAnswer) {
        const selectedInput = document.getElementById('option_' + selectedAnswer);
        selectedInput.classList.add('border-success');
    }
});
</script>
@endsection
