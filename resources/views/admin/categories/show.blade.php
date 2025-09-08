@extends('layouts.admin')

@section('title', 'Kategoriya - ' . $category->name)
@section('page-title', 'Kategoriya Ma\'lumotlari')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        @if(session('import_details'))
            <div class="mt-2">
                <strong>Import natijalari:</strong>
                <ul class="mb-0 mt-1">
                    <li>Muvaffaqiyatli import qilindi: {{ session('import_details.imported') }} ta</li>
                    @if(count(session('import_details.errors', [])) > 0)
                        <li class="text-warning">Xatoliklar:
                            <ul>
                                @foreach(session('import_details.errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        @if(session('import_errors'))
            <div class="mt-2">
                <strong>Xatoliklar:</strong>
                <ul class="mb-0 mt-1">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $category->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Nomi:</strong></div>
                    <div class="col-md-9">{{ $category->name }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Tavsif:</strong></div>
                    <div class="col-md-9">{{ $category->description ?: 'Tavsif yo\'q' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Holati:</strong></div>
                    <div class="col-md-9">
                        @if($category->is_active)
                            <span class="badge bg-success">Faol</span>
                        @else
                            <span class="badge bg-danger">Nofaol</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Savollar soni:</strong></div>
                    <div class="col-md-9">{{ $category->questions->count() }} ta</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Yaratilgan:</strong></div>
                    <div class="col-md-9">{{ $category->created_at->format('d.m.Y H:i') }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Yangilangan:</strong></div>
                    <div class="col-md-9">{{ $category->updated_at->format('d.m.Y H:i') }}</div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Tahrirlash
                    </a>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fas fa-upload"></i> Savollar Import
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Orqaga
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Kategoriya Savollari</h6>
            </div>
            <div class="card-body">
                @if($category->questions->count() > 0)
                    @foreach($category->questions->take(5) as $question)
                        <div class="mb-2 p-2 border rounded">
                            <small class="text-muted">#{{ $question->id }}</small>
                            <div>{{ Str::limit($question->text, 50) }}</div>
                            <small class="text-muted">
                                To'g'ri javob: {{ strtoupper($question->correct_option) }}
                            </small>
                        </div>
                    @endforeach
                    
                    @if($category->questions->count() > 5)
                        <div class="text-center">
                            <small class="text-muted">
                                va yana {{ $category->questions->count() - 5 }} ta savol...
                            </small>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('admin.questions.index') }}?category={{ $category->id }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Barcha savollar
                        </a>
                    </div>
                @else
                    <p class="text-muted">Bu kategoriyada hali savollar yo'q.</p>
                    <a href="{{ route('admin.questions.create') }}?category={{ $category->id }}" 
                       class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Birinchi savolni qo'shing
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Savollarni Import Qilish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.import', $category) }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="docx_file" class="form-label">DOCX Fayl</label>
                        <input type="file" class="form-control" id="docx_file" name="docx_file" accept=".docx" required>
                        <div class="form-text">Faqat .docx formatdagi fayllar qabul qilinadi</div>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Fayl formati:</h6>
                        <ul class="mb-0">
                            <li><code>++++</code> - Savol boshlanadi</li>
                            <li><code>====</code> - Javob varianti boshlanadi</li>
                            <li><code>#</code> - To'g'ri javob belgisi</li>
                            <li>Bo'sh <code>++++</code> - Savollar tugaydi</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="btn btn-success" id="importBtn">
                        <i class="fas fa-upload"></i> Import qilish
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('importForm').addEventListener('submit', function() {
    document.getElementById('importBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Import qilinmoqda...';
    document.getElementById('importBtn').disabled = true;
});
</script>
@endpush

@endsection
