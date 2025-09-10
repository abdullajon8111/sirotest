@extends('layouts.purpose-admin')

@section('title', 'Dashboard')
@section('description', 'Tizim statistikalari va tezkor ma\'lumotlar')

@section('content')
<style>
    .dashboard-stats {
        margin-bottom: 2rem;
    }
    .stat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9));
        backdrop-filter: blur(20px);
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        /* дефолтный градиент */
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    /* индивидуальные градиенты для полоски сверху */
    .stat-card.users::before { background: linear-gradient(135deg, #667eea, #764ba2); }
    .stat-card.categories::before { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-card.questions::before { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-card.tests::before { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .stat-card.users .stat-number { color: #667eea; }
    .stat-card.categories .stat-number { color: #10b981; }
    .stat-card.questions .stat-number { color: #f59e0b; }
    .stat-card.tests .stat-number { color: #3b82f6; }

    .stat-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    .stat-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    .stat-card.users .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
    .stat-card.categories .stat-icon { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-card.questions .stat-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-card.tests .stat-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }

    .modern-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }
    .modern-card-header {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.25rem 1.25rem 0 0;
        padding: 1.5rem;
    }
    .modern-card-title {
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .quick-action-btn {
        border-radius: 0.75rem;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
    }
    .quick-action-btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }
    .btn-gradient-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #5a67d8, #553c9a);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
    .btn-gradient-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    .btn-gradient-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        color: white;
    }
    .btn-gradient-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    .btn-gradient-warning:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
        color: white;
    }
    .btn-gradient-info {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }
    .btn-gradient-info:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        color: white;
    }
    .modern-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .table-modern {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .table-modern th {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        font-weight: 600;
        color: #374151;
        border: none;
        padding: 1rem;
    }
    .table-modern td {
        padding: 1rem;
        border: none;
        border-bottom: 1px solid #f3f4f6;
    }
    .list-group-modern .list-group-item {
        border: none;
        border-bottom: 1px solid #f3f4f6;
        padding: 1rem 1.5rem;
        background: transparent;
    }
    .list-group-modern .list-group-item:last-child {
        border-bottom: none;
    }
</style>
<div class="dashboard-stats">
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card users h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-number">{{ $stats['total_users'] }}</div>
                        <div class="stat-title">Foydalanuvchilar</div>
                        <div class="stat-subtitle">Jami ro'yxatdan o'tganlar</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card categories h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-number">{{ $stats['total_categories'] }}</div>
                        <div class="stat-title">Kategoriyalar</div>
                        <div class="stat-subtitle">Mavjud bo'limlar</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card questions h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-number">{{ $stats['total_questions'] }}</div>
                        <div class="stat-title">Savollar</div>
                        <div class="stat-subtitle">Jami test savollari</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card tests h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-number">{{ $stats['total_tests'] }}</div>
                        <div class="stat-title">Testlar</div>
                        <div class="stat-subtitle">Yaratilgan testlar</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="modern-card">
            <div class="modern-card-header">
                <h5 class="modern-card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>Tizim statistikasi
                </h5>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush list-group-modern">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-medium">Jami test natijalari</span>
                        <span class="modern-badge bg-primary text-white">{{ $stats['total_test_results'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-medium">Faol testlar</span>
                        <span class="modern-badge bg-success text-white">{{ $stats['active_tests'] }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="modern-card">
            <div class="modern-card-header">
                <h5 class="modern-card-title mb-0">
                    <i class="fas fa-clock me-2"></i>So'nggi test natijalari
                </h5>
            </div>
            <div class="card-body p-4">
                @if($recent_results->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Foydalanuvchi</th>
                                    <th>Test</th>
                                    <th>Ball</th>
                                    <th>Sana</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_results as $result)
                                    <tr>
                                        <td class="fw-medium">{{ $result->user->name }}</td>
                                        <td>{{ Str::limit($result->test->title, 30) }}</td>
                                        <td>
                                            <span class="modern-badge bg-{{ $result->score >= 70 ? 'success' : ($result->score >= 50 ? 'warning' : 'danger') }} text-white">
                                                {{ $result->score }}%
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $result->created_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-bar fa-3x text-muted mb-3" style="opacity: 0.5;"></i>
                        <p class="text-muted mb-0">Hali test natijalari yo'q</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="modern-card">
            <div class="modern-card-header">
                <h5 class="modern-card-title mb-0">
                    <i class="fas fa-rocket me-2"></i>Tezkor havolalar
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('admin.categories.create') }}" class="quick-action-btn btn-gradient-primary w-100 d-block text-center">
                            <i class="fas fa-plus me-2"></i>Yangi kategoriya
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.questions.create') }}" class="quick-action-btn btn-gradient-success w-100 d-block text-center">
                            <i class="fas fa-plus me-2"></i>Yangi savol
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.tests.create') }}" class="quick-action-btn btn-gradient-warning w-100 d-block text-center">
                            <i class="fas fa-plus me-2"></i>Yangi test
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.users.create') }}" class="quick-action-btn btn-gradient-info w-100 d-block text-center">
                            <i class="fas fa-plus me-2"></i>Yangi foydalanuvchi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
