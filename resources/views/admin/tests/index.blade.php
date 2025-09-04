@extends('layouts.admin')

@section('title', 'Testlar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Testlar</h4>
                    <a href="{{ route('admin.tests.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Yangi test
                    </a>
                </div>
                
                <div class="card-body">
                    @if($tests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Test nomi</th>
                                        <th>Davomiyligi</th>
                                        <th>Boshlanish vaqti</th>
                                        <th>Tugash vaqti</th>
                                        <th>Maksimal urinish</th>
                                        <th>Holati</th>
                                        <th>Test holati</th>
                                        <th>Amallar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tests as $test)
                                        <tr>
                                            <td>{{ $test->id }}</td>
                                            <td>{{ $test->title }}</td>
                                            <td>{{ $test->duration_minutes }} daqiqa</td>
                                            <td>{{ \Carbon\Carbon::parse($test->start_time)->format('d.m.Y H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($test->end_time)->format('d.m.Y H:i') }}</td>
                                            <td>{{ $test->max_attempts }} marta</td>
                                            <td>
                                                @if($test->is_active)
                                                    <span class="badge bg-success">Aktiv</span>
                                                @else
                                                    <span class="badge bg-secondary">Nofaol</span>
                                                @endif
                                            </td>
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
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.tests.show', $test) }}" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.tests.edit', $test) }}" 
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.tests.destroy', $test) }}" 
                                                          method="POST" 
                                                          style="display: inline-block;"
                                                          onsubmit="return confirm('Rostdan ham bu testni o\'chirmoqchimisiz?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $tests->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Hozircha testlar yo'q</h5>
                            <p class="text-muted">Birinchi testni yaratish uchun yuqoridagi tugmani bosing.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
