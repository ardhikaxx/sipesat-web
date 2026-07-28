@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">
        <!-- Left Side: Typography & Branding -->
        <div class="col-lg-6 bg-primary d-none d-lg-flex flex-column align-items-center justify-content-center p-5 text-white" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; left: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%; blur: 20px;"></div>
            <div style="position: absolute; bottom: -100px; right: -50px; width: 400px; height: 400px; background: rgba(0,0,0,0.1); border-radius: 50%;"></div>
            
            <div class="text-center z-3" style="max-width: 500px;">
                <h1 class="display-4 fw-bold mb-4" style="font-family: var(--font-display);"><i class="fa-solid fa-leaf text-accent"></i> SIPESAT</h1>
                <p class="lead mb-5 opacity-75">Sistem Pengelolaan Sampah Terpadu yang memudahkan masyarakat dan petugas dalam menjaga kebersihan lingkungan bersama.</p>
                <div class="p-4" style="background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-recycle" style="font-size: 6rem; color: rgba(255,255,255,0.9);"></i>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 p-sm-5" style="background-color: var(--color-bg);">
            <div class="card border-0 shadow-sm w-100" style="max-width: 480px; border-radius: 24px;">
                <div class="card-body p-4 p-sm-5">
                    <div class="d-lg-none mb-4 text-center">
                        <h2 class="text-primary fw-bold"><i class="fa-solid fa-leaf"></i> SIPESAT</h2>
                    </div>
                    
                    <div class="mb-4 text-center text-lg-start">
                        <h3 class="fw-bold text-dark">Selamat Datang 👋</h3>
                        <p class="text-muted">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4"><i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}</div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold text-dark mb-0">Password</label>
                                <a href="#" class="text-decoration-none text-primary small fw-semibold">Lupa password?</a>
                            </div>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control form-control-lg bg-light border-0" required placeholder="••••••••">
                                <button class="btn bg-light border-0 text-muted px-3 toggle-password" type="button" data-target="#password">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted" for="remember">Ingat saya</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 mb-4 fw-bold shadow-sm" style="border-radius: 12px; font-size: 1.1rem;">Masuk Sekarang</button>
                        
                        <div class="text-center">
                            <p class="text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Daftar di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.querySelector(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });
    });
</script>
@endsection