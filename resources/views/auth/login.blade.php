@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h2 class="text-primary"><i class="fa-solid fa-leaf"></i> SIPESAT</h2>
            <p class="text-muted">Masuk ke Akun Anda</p>
        </div>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
            <div class="text-center">
                <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun? Daftar di sini &rarr;</a>
            </div>
        </form>
    </div>
</div>
@endsection