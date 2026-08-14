@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0 min-vh-100 flex-lg-row-reverse">
        <!-- Right Side: Typography & Branding -->
        <div class="col-lg-6 bg-primary d-none d-lg-flex flex-column align-items-center justify-content-center p-5 text-white" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%; blur: 20px;"></div>
            <div style="position: absolute; bottom: -100px; left: -50px; width: 400px; height: 400px; background: rgba(0,0,0,0.1); border-radius: 50%;"></div>
            
            <div class="text-center z-3" style="max-width: 500px;">
                <h1 class="display-4 fw-bold mb-4" style="font-family: var(--font-display);"><i class="fa-solid fa-leaf text-accent"></i> SIPESAT</h1>
                <p class="lead mb-5 opacity-75">Bergabunglah bersama kami untuk menciptakan lingkungan yang lebih bersih dan sehat.</p>
                <div class="p-4" style="background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-users-rectangle" style="font-size: 6rem; color: rgba(255,255,255,0.9);"></i>
                </div>
            </div>
        </div>

        <!-- Left Side: Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 p-sm-5" style="background-color: var(--color-bg);">
            <div class="card border-0 shadow-sm w-100" style="max-width: 480px; border-radius: 24px;">
                <div class="card-body p-4 p-sm-5">
                    <div class="d-lg-none mb-4 text-center">
                        <h2 class="text-primary fw-bold"><i class="fa-solid fa-leaf"></i> SIPESAT</h2>
                    </div>

                    <div class="mb-4 text-center text-lg-start">
                        <h3 class="fw-bold text-dark">Buat Akun Baru 🚀</h3>
                        <p class="text-muted">Daftar sebagai masyarakat untuk mulai melaporkan.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap">
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-dark">Email Address</label>
                            <input id="email" type="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-dark">Password</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" name="password" required placeholder="Minimal 8 karakter">
                                <button class="btn bg-light border-0 text-muted px-3 toggle-password" type="button" data-target="#password">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold text-dark">Konfirmasi Password</label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control form-control-lg bg-light border-0" name="password_confirmation" required placeholder="Ulangi password">
                                <button class="btn bg-light border-0 text-muted px-3 toggle-password" type="button" data-target="#password-confirm">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Captcha</label>
                            <div class="d-flex mb-2">
                                <span>{!! captcha_img('flat') !!}</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="document.querySelector('img').src = '/captcha/flat?' + Math.random()">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>
                            </div>
                            <input type="text" name="captcha" class="form-control form-control-lg bg-light border-0 @error('captcha') is-invalid @enderror" required placeholder="Masukkan kode captcha">
                            @error('captcha') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 mb-4 fw-bold shadow-sm" style="border-radius: 12px; font-size: 1.1rem;">Daftar Sekarang</button>
                        
                        <div class="text-center">
                            <p class="text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Masuk di sini</a></p>
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
