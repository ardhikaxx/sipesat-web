@extends('layouts.app')
@section('title', 'Dashboard Masyarakat')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Dashboard</h3>
        <a href="{{ route('masyarakat.laporan.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Buat Laporan Baru</a>
    </div>

    <!-- Banner Edukasi Sampah -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden rounded-4">
        <img src="{{ asset('images/edukasi_kategori_sampah.jpg') }}" alt="Edukasi Kategori Sampah" class="img-fluid w-100" style="object-fit: cover; max-height: 400px;">
        <div class="card-body bg-light text-center">
            <h5 class="fw-bold text-success mb-1">Kenali Jenis Sampah di Lingkungan Kita</h5>
            <p class="text-muted small mb-0">Mari bersama-sama menjaga kebersihan lingkungan dengan mengenali dan melaporkan berbagai jenis sampah: Sampah Rumah Tangga, Pembuangan Liar, Sampah Saluran Air, Sampah Pasar, hingga Limbah B3.</p>
        </div>
    </div>
    
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h2 class="font-mono m-0">0</h2>
                <span class="text-muted small">Total Laporan</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h2 class="font-mono m-0 text-warning">0</h2>
                <span class="text-muted small">Menunggu</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h2 class="font-mono m-0 text-primary">0</h2>
                <span class="text-muted small">Diproses</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h2 class="font-mono m-0 text-success">0</h2>
                <span class="text-muted small">Selesai</span>
            </div>
        </div>
    </div>
    
    <div class="card p-3">
        <h5>Laporan Terbaru</h5>
        <p class="text-muted mb-0">Belum ada laporan. Yuk laporkan sampah di sekitar Anda.</p>
    </div>
</div>
@endsection