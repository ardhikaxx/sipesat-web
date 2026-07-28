@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 d-flex flex-row justify-content-between align-items-center">
            <div>
                <span class="text-muted small d-block">Menunggu Verifikasi</span>
                <h3 class="font-mono m-0">0</h3>
            </div>
            <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 d-flex flex-row justify-content-between align-items-center">
            <div>
                <span class="text-muted small d-block">Sedang Ditangani</span>
                <h3 class="font-mono m-0">0</h3>
            </div>
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                <i class="fa-solid fa-broom"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 d-flex flex-row justify-content-between align-items-center">
            <div>
                <span class="text-muted small d-block">Selesai</span>
                <h3 class="font-mono m-0">0</h3>
            </div>
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 d-flex flex-row justify-content-between align-items-center">
            <div>
                <span class="text-muted small d-block">Ditolak</span>
                <h3 class="font-mono m-0">0</h3>
            </div>
            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>
    </div>
</div>
<div class="card p-4">
    <h5>Peta Sebaran Seluruh Laporan (Live)</h5>
    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="height: 300px; border: 1px dashed var(--color-border);">
        [Peta Leaflet akan dimuat di sini]
    </div>
</div>
@endsection