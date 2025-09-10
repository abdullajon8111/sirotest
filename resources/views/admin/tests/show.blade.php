@extends('layouts.purpose-admin')

@section('title', 'Test ma\'lumotlari')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Test ma'lumotlari</h4>
                    <div>
                        <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Tahrirlash
                        </a>
                        <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Orqaga
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Test nomi:</th>
                                    <td>{{ $test->title }}</td>
                                </tr>
                                <tr>
                                    <th>Tavsif:</th>
                                    <td>{{ $test->description ?? 'Tavsif yo\'q' }}</td>
                                </tr>
                                <tr>
                                    <th>Davomiyligi:</th>
                                    <td>{{ $test->duration_minutes }} daqiqa</td>
                                </tr>
                                <tr>
                                    <th>Maksimal urinish:</th>
                                    <td>{{ $test->max_attempts }} marta</td>
                                </tr>
                                <tr>
                                    <th>Holati:</th>
                                    <td>
                                        @if($test->is_active)
                                            <span class="badge bg-success">Aktiv</span>
                                        @else
                                            <span class="badge bg-danger">Nofaol</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Boshlanish vaqti:</th>
                                    <td>{{ \Carbon\Carbon::parse($test->start_time)->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tugash vaqti:</th>
                                    <td>{{ \Carbon\Carbon::parse($test->end_time)->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Yaratilgan:</th>
                                    <td>{{ $test->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Yangilangan:</th>
                                    <td>{{ $test->updated_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Test holati:</th>
                                    <td>
                                        @php
                                            $now = now();
                                            $start = \Carbon\Carbon::parse($test->start_time);
                                            $end = \Carbon\Carbon::parse($test->end_time);
                                        @endphp
                                        
                                        @if($now < $start)
                                            <span class="badge bg-info">Kutilmoqda</span>
                                        @elseif($now >= $start && $now <= $end && $test->is_active)
                                            <span class="badge bg-success">Faol</span>
                                        @elseif($now > $end)
                                            <span class="badge bg-secondary">Tugagan</span>
                                        @else
                                            <span class="badge bg-warning">Nofaol</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>Kategoriyalar va savollar taqsimoti</h5>
                    
                    @if($test->categories_questions && count($test->categories_questions) > 0)
                        <div class="row">
                            @php
                                $totalQuestions = array_sum($test->categories_questions);
                            @endphp
                            
                            <div class="col-md-12 mb-3">
                                <div class="alert alert-info">
                                    <strong>Jami savollar soni:</strong> {{ $totalQuestions }} ta
                                </div>
                            </div>
                            
                            @foreach($test->categories_questions as $categoryId => $questionCount)
                                @php
                                    $category = \App\Models\Category::find($categoryId);
                                @endphp
                                @if($category)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">{{ $category->name }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <span>Tanlangan savollar:</span>
                                                    <strong>{{ $questionCount }} ta</strong>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Umumiy savollar:</span>
                                                    <span>{{ $category->questions()->where('is_active', true)->count() }} ta</span>
                                                </div>
                                                <div class="progress mt-2">
                                                    @php
                                                        $totalInCategory = $category->questions()->where('is_active', true)->count();
                                                        $percentage = $totalInCategory > 0 ? ($questionCount / $totalInCategory) * 100 : 0;
                                                    @endphp
                                                    <div class="progress-bar" 
                                                         role="progressbar" 
                                                         style="width: {{ $percentage }}%"
                                                         aria-valuenow="{{ $percentage }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                        {{ number_format($percentage, 1) }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Bu test uchun kategoriyalar va savollar taqsimoti belgilanmagan.
                        </div>
                    @endif
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <form action="{{ route('admin.tests.destroy', $test) }}" 
                              method="POST" 
                              style="display: inline-block;"
                              onsubmit="return confirm('Rostdan ham bu testni o\'chirmoqchimisiz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> O'chirish
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
