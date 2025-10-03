<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Test Tizimi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin-modern.css') }}" rel="stylesheet">

    @yield('styles')

    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #f1f5f9;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: #f8fafc;
            font-size: 14px;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0f172a 100%);
            box-shadow: 0 0 40px rgba(0,0,0,0.1);
            border-right: 1px solid #334155;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-weight: 500;
            border: none;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: var(--sidebar-hover);
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
        }

        .main-content {
            min-height: 100vh;
            background-color: #f8fafc;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 25px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }

        .card-header {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-bottom: 1px solid var(--border-color);
            border-radius: 1rem 1rem 0 0 !important;
            padding: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #3730a3 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .alert {
            border: none;
            border-radius: 0.75rem;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #dcfdf4 0%, #bbf7d0 100%);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .table {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #e2e8f0 100%);
            border: none;
            font-weight: 600;
            color: #374151;
            padding: 1rem;
        }

        .table tbody td {
            border: none;
            padding: 1rem;
            border-top: 1px solid #f1f5f9;
        }

        .badge {
            padding: 0.375rem 0.75rem;
            font-weight: 500;
            border-radius: 0.375rem;
        }

        .page-header {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .stats-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 1rem;
        }

        .stats-card-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stats-card-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stats-card-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .logout-btn {
            background: none;
            border: none;
            color: #cbd5e1;
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-weight: 500;
            width: calc(100% - 2rem);
            text-align: left;
        }

        .logout-btn:hover {
            color: #fff;
            background-color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Admin Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-4">
                    <div class="text-center py-4 border-bottom border-secondary">
                        <div class="navbar-brand mb-2">TEST TIZIMI</div>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="fas fa-user text-white" style="font-size: 0.875rem;"></i>
                            </div>
                            <small class="text-light fw-medium">{{ auth()->user()->name }}</small>
                        </div>
                    </div>

                    <ul class="nav flex-column py-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-chart-pie"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-folder"></i> Kategoriyalar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}" href="{{ route('admin.questions.index') }}">
                                <i class="fas fa-question-circle"></i> Savollar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.tests.*') ? 'active' : '' }}" href="{{ route('admin.tests.index') }}">
                                <i class="fas fa-clipboard-check"></i> Testlar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i> Foydalanuvchilar
                            </a>
                        </li>
                    </ul>

                    <div class="mt-auto pt-3" >
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Chiqish
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 p-4 main-content">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1 fw-bold text-dark">@yield('title', 'Dashboard')</h1>
                            <p class="text-muted mb-0">@yield('description', 'Boshqaruv paneli')</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-pill px-3 py-2 me-3">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="text-dark fw-medium" id="current-time">{{ now()->format('H:i') }}</span>
                            </div>
                            <div class="bg-light rounded-pill px-3 py-2">
                                <i class="fas fa-calendar text-primary me-2"></i>
                                <span class="text-dark fw-medium">{{ now()->format('d.m.Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // CSRF token setup for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Real-time clock
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('uz-UZ', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime(); // Initial call
    </script>

    @yield('scripts')
</body>
</html>
