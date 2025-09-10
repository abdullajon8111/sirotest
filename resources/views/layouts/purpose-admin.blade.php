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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Purpose Template CSS -->
    <link href="{{ asset('css/purpose-admin.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <nav class="purpose-sidebar" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="brand-text">
                <i class="fas fa-graduation-cap me-2"></i>
                TEST TIZIMI
            </a>
        </div>

        <!-- User Info -->
        <div class="user-info">
            <div class="user-avatar">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">Administrator</div>
        </div>

        <!-- Navigation -->
        <div class="purpose-nav">
            <a href="{{ route('admin.dashboard') }}" class="purpose-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                Dashboard
            </a>
            
            <a href="{{ route('admin.categories.index') }}" class="purpose-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                Kategoriyalar
            </a>
            
            <a href="{{ route('admin.questions.index') }}" class="purpose-nav-link {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i>
                Savollar
            </a>
            
            <a href="{{ route('admin.tests.index') }}" class="purpose-nav-link {{ request()->routeIs('admin.tests.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i>
                Testlar
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="purpose-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Foydalanuvchilar
            </a>
        </div>

        <!-- Logout -->
        <div class="purpose-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="purpose-nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Chiqish
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="purpose-main">
        <!-- Header -->
        <header class="purpose-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="purpose-header-title">@yield('title', 'Dashboard')</h1>
                    <p class="purpose-header-subtitle">@yield('description', 'Boshqaruv paneli')</p>
                </div>
                <div class="purpose-header-meta">
                    <div class="purpose-meta-item">
                        <i class="fas fa-clock"></i>
                        <span id="current-time">{{ now()->format('H:i') }}</span>
                    </div>
                    <div class="purpose-meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ now()->format('d.m.Y') }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="purpose-content">
            <!-- Alerts -->
            @if(session('success'))
                <div class="purpose-alert purpose-alert-success purpose-alert-icon purpose-fade-in">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Muvaffaqiyat!</strong> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="purpose-alert purpose-alert-danger purpose-alert-icon purpose-fade-in">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Xatolik!</strong> {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="purpose-alert purpose-alert-warning purpose-alert-icon purpose-fade-in">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Diqqat!</strong> Quyidagi xatoliklar mavjud:
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Mobile Menu Toggle -->
    <button class="btn btn-primary d-lg-none position-fixed" style="top: 1rem; left: 1rem; z-index: 1100;" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = event.target.closest('button');
            
            if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !toggle) {
                sidebar.classList.remove('show');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.purpose-alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);

        // Add animation classes to new elements
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.purpose-card, .purpose-stats-card, .purpose-form-card');
            cards.forEach(function(card, index) {
                setTimeout(function() {
                    card.classList.add('purpose-fade-in');
                }, index * 100);
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
