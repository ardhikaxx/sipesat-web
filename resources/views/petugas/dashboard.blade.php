@extends('layouts.app')
@section('title', 'Dashboard Petugas')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-info">{{ $tugasBaru }}</h2>
            <span class="text-muted small">Tugas Baru</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-primary">{{ $sedangDikerjakan }}</h2>
            <span class="text-muted small">Sedang Dikerjakan</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-success">{{ $selesai }}</h2>
            <span class="text-muted small">Selesai</span>
        </div>
    </div>
</div>
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Tugas Terbaru</h5>
        <a href="{{ route('petugas.tugas.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
    </div>
    @if($tugasTerbaru->count() > 0)
        <div class="list-group list-group-flush">
            @foreach($tugasTerbaru as $tugas)
                <a href="{{ route('petugas.tugas.show', $tugas->id) }}" class="list-group-item list-group-item-action px-0">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{ $tugas->laporanSampah->judul_laporan }}</h6>
                        <small class="text-muted">{{ $tugas->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1 small text-muted">{{ Str::limit($tugas->laporanSampah->deskripsi, 100) }}</p>
                    <small>
                        @if($tugas->laporanSampah->status == 'diverifikasi')
                            <span class="badge bg-info">Tugas Baru</span>
                        @elseif($tugas->laporanSampah->status == 'sedang_ditangani')
                            <span class="badge bg-primary">Sedang Dikerjakan</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </small>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-muted">Tidak ada tugas baru saat ini.</p>
    @endif
</div>
@endsection