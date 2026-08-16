@extends('layouts.app')
@section('title', 'Lupa Password')
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
                        <a href="{{ route('login') }}" class="text-decoration-none text-muted mb-3 d-inline-block small fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Login
                        </a>
                        <h3 class="fw-bold text-dark">Lupa Password? 🔒</h3>
                        <p class="text-muted">Masukkan alamat email Anda yang terdaftar. Kami akan memverifikasi email tersebut.</p>
                    </div>

                    <form action="{{ route('password.verify') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 mb-4 fw-bold shadow-sm" style="border-radius: 12px; font-size: 1.1rem;">Verifikasi Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('sweet_error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('sweet_error') }}',
                confirmButtonColor: '#3085d6',
            });
        @endif
        
        @if(session('sweet_success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('sweet_success') }}',
                confirmButtonColor: '#3085d6',
            }).then((result) => {
                window.location.href = "{{ route('password.reset') }}";
            });
        @endif
    });
</script>
@endsection
