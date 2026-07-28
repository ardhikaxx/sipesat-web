@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

<style>
    .timeline {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 2rem;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 0.25rem;
        top: 0.5rem;
        bottom: 0;
        width: 2px;
        background-color: var(--color-border);
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 0.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--color-surface);
        border: 2px solid var(--color-border);
        z-index: 1;
    }
    .timeline-item.active::before {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
    }
    .timeline-item.active.completed::before {
        background-color: var(--color-accent);
        border-color: var(--color-accent);
    }
    .timeline-item.active.rejected::before {
        background-color: var(--color-danger);
        border-color: var(--color-danger);
    }
    .timeline-date {
        font-family: var(--font-mono);
        font-size: var(--text-xs);
        color: var(--color-muted);
    }
</style>

<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('masyarakat.dashboard') }}" class="text-decoration-none text-muted mb-2 d-inline-block small"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard</a>
            <h3 class="fw-bold mb-0">Detail Laporan</h3>
        </div>
        
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
        
        <span class="badge {{ $badgeClass }} fs-6 px-3 py-2 rounded-pill shadow-sm"><i class="fa-solid {{ $icon }} me-2"></i> {{ $statusLabel }}</span>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Info Laporan -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-primary mb-1">{{ $laporan->judul_laporan }}</h4>
                    <p class="text-muted font-mono small mb-4"><i class="fa-solid fa-hashtag"></i> {{ $laporan->kode_laporan }} &bull; Dibuat pada {{ $laporan->created_at->format('d M Y, H:i') }}</p>
                    
                    <div class="row mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <small class="text-muted d-block mb-1">Kategori Sampah</small>
                            <span class="fw-semibold"><i class="fa-solid fa-tags text-primary me-1"></i> {{ $laporan->kategoriSampah->nama_kategori ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block mb-1">Prioritas (Pelapor)</small>
                            <span class="fw-semibold"><i class="fa-solid fa-flag text-warning me-1"></i> {{ ucfirst($laporan->prioritas_pelapor) }}</span>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-2">Deskripsi</h6>
                    <p class="mb-4" style="line-height: 1.7;">{{ $laporan->deskripsi }}</p>
                    
                    <h6 class="fw-bold mb-2">Alamat Lengkap</h6>
                    <p class="mb-4">{{ $laporan->alamat_lengkap }}, Desa {{ $laporan->desa->nama_desa ?? '-' }}, Kec. {{ $laporan->kecamatan->nama_kecamatan ?? '-' }}</p>
                    
                    <h6 class="fw-bold mb-3">Foto Laporan</h6>
                    <div class="row g-2 mb-4">
                        @if(!empty($laporan->foto_laporan))
                            @foreach($laporan->foto_laporan as $foto)
                                <div class="col-6 col-md-4">
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto Laporan" class="img-fluid rounded shadow-sm w-100" style="object-fit: cover; height: 150px;">
                                </div>
                            @endforeach
                        @else
                            <div class="col-12"><p class="text-muted fst-italic">Tidak ada foto.</p></div>
                        @endif
                    </div>
                    
                    <h6 class="fw-bold mb-3">Lokasi Peta</h6>
                    <div class="rounded overflow-hidden shadow-sm border" style="height: 300px;" id="mapDetail"></div>
                </div>
            </div>
            
            @if($laporan->status == 'selesai')
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-3">Beri Nilai Pekerjaan Ini</h5>
                        <p class="text-muted mb-4">Laporan Anda telah selesai ditangani. Berikan rating bintang untuk kinerja petugas kami.</p>
                        
                        <!-- Placeholder rating interaktif -->
                        <div class="fs-1 text-warning mb-3">
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <button class="btn btn-outline-primary px-4 rounded-pill">Kirim Penilaian</button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Kolom Kanan: Timeline -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 2rem;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Riwayat Status</h5>
                    
                    <div class="timeline">
                        @forelse($laporan->laporanStatusHistories()->orderBy('created_at', 'asc')->get() as $history)
                            @php
                                $histClass = 'active';
                                if($history->status == 'selesai') $histClass .= ' completed';
                                if($history->status == 'ditolak') $histClass .= ' rejected';
                            @endphp
                            <div class="timeline-item {{ $histClass }}">
                                <h6 class="fw-bold mb-1">{{ ucwords(str_replace('_', ' ', $history->status)) }}</h6>
                                <div class="timeline-date mb-1">{{ $history->created_at->format('d M Y, H:i') }} &bull; oleh {{ $history->user->name ?? 'Sistem' }}</div>
                                @if($history->keterangan)
                                    <p class="small text-muted mb-0 border-start ps-2 ms-1 mt-2">"{{ $history->keterangan }}"</p>
                                @endif
                            </div>
                        @empty
                            <div class="timeline-item active">
                                <h6 class="fw-bold mb-1">Menunggu Verifikasi</h6>
                                <div class="timeline-date mb-0">{{ $laporan->created_at->format('d M Y, H:i') }} &bull; oleh Sistem</div>
                            </div>
                        @endforelse
                        
                        @if(!in_array($laporan->status, ['selesai', 'ditolak']))
                            <div class="timeline-item">
                                <h6 class="text-muted mb-0">Selesai</h6>
                                <div class="timeline-date">Menunggu penanganan selesai</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lat = {{ $laporan->latitude ?? -7.6531 }};
        var lng = {{ $laporan->longitude ?? 111.3284 }};
        
        var map = L.map('mapDetail').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>Lokasi Laporan</b><br>{{ $laporan->alamat_lengkap }}").openPopup();
    });
</script>
@endsection
