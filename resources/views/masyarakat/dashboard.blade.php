@extends('layouts.app')
@section('title', 'Dashboard Masyarakat')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Dashboard</h3>
        <a href="{{ route('masyarakat.laporan.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Buat Laporan Baru</a>
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