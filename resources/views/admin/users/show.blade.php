@extends('layouts.admin')

@section('title', 'Foydalanuvchi ma\'lumotlari')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-1">Foydalanuvchi ma'lumotlari</h1>
            <p class="text-muted mb-0">{{ $user->name }} ning batafsil ma'lumotlari</p>
        </div>
        <div class="col-auto">
            <div class="btn-group">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Tahrirlash
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Orqaga
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Asosiy ma'lumotlar</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th width="40%">ID:</th>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th>Ism:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Rol:</th>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge bg-danger">Admin</span>
                                        @else
                                            <span class="badge bg-primary">Foydalanuvchi</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Holati:</th>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success">Aktiv</span>
                                        @else
                                            <span class="badge bg-secondary">Nofaol</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th width="40%">Ro'yxatdan o'tgan:</th>
                                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Yangilangan:</th>
                                    <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Email tasdiqlangan:</th>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Tasdiqlangan</span>
                                            <br>
                                            <small class="text-muted">{{ $user->email_verified_at->format('d.m.Y H:i') }}</small>
                                        @else
                                            <span class="badge bg-warning">Tasdiqlanmagan</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Oxirgi faoliyat:</th>
                                    <td>
                                        @if($user->updated_at)
                                            {{ $user->updated_at->diffForHumans() }}
                                        @else
                                            Ma'lumot yo'q
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Test statistikalari</h5>
            </div>
            <div class="card-body">
                @php
                    $testResults = $user->testResults()->count();
                    $completedTests = $user->testResults()->whereNotNull('finished_at')->count();
                    $averageScore = $user->testResults()->whereNotNull('finished_at')->avg('score');
                @endphp
                
                <div class="mb-3">
                    <div class="stats-card stats-card-success p-3 text-center">
                        <h4 class="mb-1">{{ $testResults }}</h4>
                        <small>Jami test urinishlari</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="stats-card p-3 text-center">
                        <h4 class="mb-1">{{ $completedTests }}</h4>
                        <small>Yakunlangan testlar</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="stats-card stats-card-info p-3 text-center">
                        <h4 class="mb-1">{{ $averageScore ? number_format($averageScore, 1) : '0' }}%</h4>
                        <small>O'rtacha natija</small>
                    </div>
                </div>
                
                <div class="mb-0">
                    <div class="stats-card stats-card-warning p-3 text-center">
                        <h4 class="mb-1">{{ $testResults - $completedTests }}</h4>
                        <small>Yakunlanmagan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($user->testResults()->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">So'nggi test natijalari</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Test</th>
                                    <th>Boshlangan</th>
                                    <th>Yakunlangan</th>
                                    <th>Natija</th>
                                    <th>Holati</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->testResults()->latest()->take(10)->get() as $result)
                                    <tr>
                                        <td>{{ $result->test->title }}</td>
                                        <td>{{ $result->started_at ? $result->started_at->format('d.m.Y H:i') : 'Boshlanmagan' }}</td>
                                        <td>{{ $result->finished_at ? $result->finished_at->format('d.m.Y H:i') : 'Jarayonda' }}</td>
                                        <td>
                                            @if($result->finished_at)
                                                <span class="badge {{ $result->score >= 70 ? 'bg-success' : ($result->score >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ number_format($result->score, 1) }}%
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->finished_at)
                                                <span class="badge bg-success">Yakunlangan</span>
                                            @else
                                                <span class="badge bg-warning">Jarayonda</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($user->id !== auth()->id())
                    <div class="card-footer">
                        <form action="{{ route('admin.users.destroy', $user) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Rostdan ham bu foydalanuvchini o\'chirmoqchimisiz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> O'chirish
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                        <h5>Hech qanday test natijasi yo'q</h5>
                        <p>Bu foydalanuvchi hali hech qanday testni ishlamagan.</p>
                    </div>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" 
                              method="POST" 
                              class="d-inline mt-3"
                              onsubmit="return confirm('Rostdan ham bu foydalanuvchini o\'chirmoqchimisiz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> O'chirish
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
