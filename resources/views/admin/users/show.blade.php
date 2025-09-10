@extends('layouts.purpose-admin')

@section('title', 'Foydalanuvchi ma\'lumotlari')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Foydalanuvchi ma'lumotlari</h4>
                    <div>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Tahrirlash
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Orqaga
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
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
                        
                        <div class="col-md-6">
                            <table class="table table-bordered">
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
                    
                    <hr>
                    
                    <h5>Test statistikalari</h5>
                    
                    @php
                        $testAttempts = $user->testAttempts()->count();
                        $completedTests = $user->testAttempts()->whereNotNull('completed_at')->count();
                        $averageScore = $user->testAttempts()->whereNotNull('completed_at')->avg('score');
                    @endphp
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $testAttempts }}</h4>
                                    <p class="mb-0">Jami urinishlar</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $completedTests }}</h4>
                                    <p class="mb-0">Yakunlangan testlar</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $averageScore ? number_format($averageScore, 1) : '0' }}%</h4>
                                    <p class="mb-0">O'rtacha natija</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $testAttempts - $completedTests }}</h4>
                                    <p class="mb-0">Yakunlanmagan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($user->testAttempts()->count() > 0)
                        <hr>
                        <h5>So'nggi test natijalari</h5>
                        
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Test</th>
                                        <th>Boshlanish</th>
                                        <th>Yakunlanish</th>
                                        <th>Natija</th>
                                        <th>Holati</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->testAttempts()->latest()->take(10)->get() as $attempt)
                                        <tr>
                                            <td>{{ $attempt->test->title }}</td>
                                            <td>{{ $attempt->started_at ? $attempt->started_at->format('d.m.Y H:i') : 'Boshlanmagan' }}</td>
                                            <td>{{ $attempt->completed_at ? $attempt->completed_at->format('d.m.Y H:i') : 'Jarayonda' }}</td>
                                            <td>
                                                @if($attempt->completed_at)
                                                    {{ number_format($attempt->score, 1) }}%
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($attempt->completed_at)
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
                    @endif
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                  method="POST" 
                                  style="display: inline-block;"
                                  onsubmit="return confirm('Rostdan ham bu foydalanuvchini o\'chirmoqchimisiz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> O'chirish
                                </button>
                            </form>
                        @else
                            <small class="text-muted">O'zingizni o'chira olmaysiz</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
