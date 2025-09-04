@extends('layouts.app')

@section('title', 'Kirish')

@section('content')
<style>
    .login-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        max-width: 420px;
        width: 100%;
    }
    .login-header {
        text-align: center;
        padding: 2rem 2rem 1rem;
    }
    .login-logo {
        background: linear-gradient(135deg, #667eea, #764ba2);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    .login-title {
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    .login-form {
        padding: 0 2rem 2rem;
    }
    .form-floating {
        margin-bottom: 1.5rem;
    }
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        font-size: 0.95rem;
        padding: 1rem 1rem;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: white;
    }
    .form-label {
        color: #64748b;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .login-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        padding: 1rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .login-btn:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #553c9a 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    .form-check {
        margin-bottom: 1.5rem;
    }
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    .test-credentials {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-top: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    .credential-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .credential-item:last-child {
        border-bottom: none;
    }
    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
    }
    .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    .shape:nth-child(1) {
        width: 60px;
        height: 60px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }
    .shape:nth-child(2) {
        width: 40px;
        height: 40px;
        top: 20%;
        right: 10%;
        animation-delay: 2s;
    }
    .shape:nth-child(3) {
        width: 80px;
        height: 80px;
        bottom: 10%;
        left: 20%;
        animation-delay: 4s;
    }
</style>

<div class="login-container">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-graduation-cap fa-2x text-white"></i>
            </div>
            <h1 class="login-title">Test Tizimi</h1>
            <p class="text-muted mb-0">Hisobingizga kirish</p>
        </div>
        
        <div class="login-form">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2 text-muted"></i>Email manzil
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

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2 text-muted"></i>Parol
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
                    <label class="form-check-label text-muted" for="remember">
                        Meni eslab qol
                    </label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn login-btn text-white">
                        <i class="fas fa-sign-in-alt me-2"></i>Kirish
                    </button>
                </div>
            </form>

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
        </div>
    </div>
</div>
@endsection
