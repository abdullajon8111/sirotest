@extends('layouts.app')

@section('title', 'Kirish')

@section('content')
<style>
    body {
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
        height: 100vh;
    }

    .container, .container-fluid, .row {
        margin: 0 !important;
        padding: 0 !important;
        max-width: none !important;
        width: 100% !important;
    }
    .login-container {
        min-height: 100vh;
        display: flex;
        margin: 0;
        padding: 0;
    }

    /* Chap tomon - Branding qismi */
    .login-brand-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        padding: 2rem;
    }

    /* O'ng tomon - Login forma qismi */
    .login-form-section {
        flex: 1;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        min-height: 100vh;
    }

    .brand-content {
        text-align: center;
        color: white;
        z-index: 2;
        max-width: 400px;
    }

    .brand-logo {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        backdrop-filter: blur(20px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .brand-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .brand-subtitle {
        font-size: 1.25rem;
        font-weight: 300;
        opacity: 0.9;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .brand-features {
        text-align: left;
        margin-top: 2rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .feature-item i {
        width: 24px;
        height: 24px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 0.875rem;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        background: white;
        border-radius: 0;
        box-shadow: none;
        border: none;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-welcome {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        color: #6b7280;
        margin-bottom: 0;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background: #f9fafb;
        font-size: 1rem;
        padding: 0.875rem 1rem;
        transition: all 0.2s ease;
        width: 100%;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }

    .login-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
        color: white;
    }

    .login-btn:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #553c9a 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .form-check {
        margin-bottom: 1.5rem;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    .test-credentials {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .credential-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .credential-item:last-child {
        border-bottom: none;
    }

    /* Floating shapes chap tomonda */
    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
        z-index: 1;
    }

    .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.1; }
        50% { transform: translateY(-30px) rotate(180deg); opacity: 0.2; }
    }

    .shape:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 15%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 60%;
        right: 15%;
        animation-delay: 3s;
    }

    .shape:nth-child(3) {
        width: 60px;
        height: 60px;
        bottom: 20%;
        left: 30%;
        animation-delay: 6s;
    }

    .shape:nth-child(4) {
        width: 40px;
        height: 40px;
        top: 35%;
        left: 70%;
        animation-delay: 2s;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .login-container {
            flex-direction: column;
        }

        .login-brand-section {
            min-height: 40vh;
            padding: 1.5rem;
        }

        .login-form-section {
            min-height: 60vh;
            padding: 1.5rem;
        }

        .brand-title {
            font-size: 2rem;
        }

        .brand-subtitle {
            font-size: 1rem;
        }

        .brand-features {
            display: none;
        }
    }
</style>

<div class="login-container">
    <!-- Chap tomon - Branding qismi -->
    <div class="login-brand-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="brand-content">
            <div class="brand-logo">
                <i class="fas fa-graduation-cap fa-3x"></i>
            </div>

            <h1 class="brand-title">Test Tizimi</h1>
            <p class="brand-subtitle">Zamonaviy test va baholash platformasi. Bilimlaringizni sinab ko'ring va o'z darajangizni aniqlang.</p>

            <div class="brand-features">
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Interaktiv testlar</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Natijalarni tahlil qilish</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-clock"></i>
                    <span>Vaqt bilan cheklanish</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-trophy"></i>
                    <span>Yutuqlar tizimi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- O'ng tomon - Login forma qismi -->
    <div class="login-form-section">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-welcome">Xush kelibsiz</h1>
                <p class="login-subtitle">Hisobingizga kirish uchun ma'lumotlaringizni kiriting</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>Email manzil
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}"
                           placeholder="emailingizni kiriting" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>Parol
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" placeholder="parolingizni kiriting" required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Meni eslab qol
                    </label>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt me-2"></i>Kirish
                </button>
            </form>

            @if(! app()->isProduction())
                <div class="test-credentials">
                    <div class="text-center mb-3">
                        <h6 class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2"></i>Test ma'lumotlari
                        </h6>
                    </div>

                    <div class="credential-item">
                        <div>
                            <div class="fw-bold text-danger">Admin</div>
                            <small class="text-muted">admin@test.uz</small>
                        </div>
                        <code class="bg-light px-2 py-1 rounded">12345678</code>
                    </div>

                    <div class="credential-item">
                        <div>
                            <div class="fw-bold text-primary">User</div>
                            <small class="text-muted">user@test.uz</small>
                        </div>
                        <code class="bg-light px-2 py-1 rounded">12345678</code>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
