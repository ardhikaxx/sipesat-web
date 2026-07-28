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
            <div class="card p-3 text-center border-0 shadow-sm">
                <h2 class="font-mono m-0 fw-bold">{{ $totalLaporan }}</h2>
                <span class="text-muted small">Total Laporan</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-0 shadow-sm">
                <h2 class="font-mono m-0 text-warning fw-bold">{{ $menunggu }}</h2>
                <span class="text-muted small">Menunggu Verifikasi</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-0 shadow-sm">
                <h2 class="font-mono m-0 text-primary fw-bold">{{ $diproses }}</h2>
                <span class="text-muted small">Sedang Diproses</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-0 shadow-sm">
                <h2 class="font-mono m-0 text-success fw-bold">{{ $selesai }}</h2>
                <span class="text-muted small">Selesai</span>
            </div>
        </div>
    </div>
    
    <div class="card p-4 border-0 shadow-sm">
        <h5 class="fw-bold mb-4">Laporan Terbaru</h5>
        
        @if($laporans->count() > 0)
            <div class="list-group list-group-flush">
                @foreach($laporans as $laporan)
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $laporan->judul_laporan }}</h6>
                                <p class="mb-1 text-muted small"><i class="fa-solid fa-hashtag"></i> {{ $laporan->kode_laporan }} &bull; {{ $laporan->kategoriSampah->nama_kategori ?? 'Umum' }}</p>
                                
                                @php
                                    $badgeClass = 'bg-secondary';
                                    $icon = 'fa-circle-info';
                                    $statusLabel = ucwords(str_replace('_', ' ', $laporan->status));
                                    
                                    if($laporan->status == 'menunggu_verifikasi') { $badgeClass = 'bg-warning text-dark'; $icon = 'fa-clock'; }
                                    elseif($laporan->status == 'diverifikasi') { $badgeClass = 'bg-info'; $icon = 'fa-clipboard-check'; }
                                    elseif($laporan->status == 'sedang_ditangani') { $badgeClass = 'bg-primary'; $icon = 'fa-broom'; }
                                    elseif($laporan->status == 'selesai') { $badgeClass = 'bg-success'; $icon = 'fa-circle-check'; }
                                    elseif($laporan->status == 'ditolak') { $badgeClass = 'bg-danger'; $icon = 'fa-circle-xmark'; }
                                @endphp
                                
                                <span class="badge {{ $badgeClass }}"><i class="fa-solid {{ $icon }} me-1"></i> {{ $statusLabel }}</span>
                            </div>
                            <a href="{{ route('masyarakat.laporan.show', $laporan->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fa-solid fa-file-circle-xmark text-muted" style="font-size: 3rem;"></i>
                </div>
                <h6 class="fw-bold text-dark">Belum ada laporan</h6>
                <p class="text-muted mb-4">Yuk laporkan tumpukan sampah atau masalah kebersihan di sekitar Anda.</p>
                <a href="{{ route('masyarakat.laporan.create') }}" class="btn btn-outline-primary"><i class="fa-solid fa-plus me-1"></i> Buat Laporan Pertama</a>
            </div>
        @endif
    </div>
</div>
@endsection