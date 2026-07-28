@extends('layouts.app')
@section('title', 'Dashboard Petugas')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-info">0</h2>
            <span class="text-muted small">Tugas Baru</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-primary">0</h2>
            <span class="text-muted small">Sedang Dikerjakan</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-success">0</h2>
            <span class="text-muted small">Selesai</span>
        </div>
    </div>
</div>
<div class="card p-4">
    <h5>Tugas Terbaru</h5>
    <p class="text-muted">Tidak ada tugas baru saat ini.</p>
</div>
@endsection