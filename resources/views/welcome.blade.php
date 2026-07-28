@extends('layouts.app')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="bg-primary text-white text-center py-5">
        <h1 class="display-4 fw-bold">Selamat Datang di Sipesat</h1>
        <p class="lead">Sistem Pelaporan Sampah Terpadu</p>
        <a href="{{ route('masyarakat.laporan.create') }}" class="btn btn-light btn-lg mt-3 fw-semibold text-primary">Buat Laporan Sekarang</a>
    </div>

    <!-- Map Section -->
    <div class="my-5">
        <div class="container mb-3 text-center">
            <h2 class="fw-bold">Peta Laporan Sampah Selesai</h2>
            <p class="text-muted">Lihat titik-titik laporan sampah yang telah berhasil diselesaikan oleh petugas.</p>
        </div>
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>

    <!-- Banner Edukasi Sampah -->
    <div class="container my-5">
        <div class="card border-0 shadow-sm overflow-hidden rounded-4">
            <img src="{{ asset('images/edukasi_kategori_sampah.jpg') }}" alt="Edukasi Kategori Sampah" class="img-fluid w-100" style="object-fit: cover; max-height: 400px;">
            <div class="card-body bg-light text-center">
                <h4 class="fw-bold text-success mb-2">Kenali Jenis Sampah di Lingkungan Kita</h4>
                <p class="text-muted mb-0">Mari bersama-sama menjaga kebersihan lingkungan dengan mengenali dan melaporkan berbagai jenis sampah: Sampah Rumah Tangga, Pembuangan Liar, Sampah Saluran Air, Sampah Pasar, hingga Limbah B3.</p>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Default ke wilayah Magetan
        var map = L.map('map').setView([-7.6531, 111.3284], 12);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var markersGroup = L.featureGroup().addTo(map);
        var hasMarkers = false;

        // Add markers for each laporan
        @foreach($laporans as $laporan)
            @if($laporan->latitude && $laporan->longitude)
                hasMarkers = true;
                
                var popupContent = `
                    <div style="min-width: 250px;">
                        <h6 class="fw-bold mb-1 text-primary">{{ $laporan->judul_laporan }}</h6>
                        <p class="text-muted small mb-2"><i class="fa-solid fa-hashtag"></i> {{ $laporan->kode_laporan }}</p>
                        
                        <div class="mb-2">
                            <small class="d-block text-secondary">Pelapor:</small>
                            <span class="fw-semibold"><i class="fa-solid fa-user me-1"></i>{{ $laporan->user->name ?? 'Anonim' }}</span>
                        </div>
                        
                        <div class="mb-2">
                            <small class="d-block text-secondary">Kategori:</small>
                            <span class="badge bg-secondary">{{ $laporan->kategoriSampah->nama_kategori ?? '-' }}</span>
                        </div>

                        <div class="mb-2">
                            <small class="d-block text-secondary">Lokasi:</small>
                            <span>{{ $laporan->alamat_lengkap }}</span>
                        </div>

                        <div class="mb-2">
                            <small class="d-block text-secondary">Diselesaikan Pada:</small>
                            <span><i class="fa-solid fa-calendar-check me-1"></i>{{ $laporan->completed_at ? \Carbon\Carbon::parse($laporan->completed_at)->translatedFormat('d F Y H:i') : '-' }}</span>
                        </div>
                        
                        <div class="mt-2 border-top pt-2 text-center">
                            <span class="badge bg-success w-100 py-2"><i class="fa-solid fa-check-circle me-1"></i> Laporan Selesai</span>
                        </div>
                    </div>
                `;

                L.marker([{{ $laporan->latitude }}, {{ $laporan->longitude }}]).addTo(markersGroup)
                    .bindPopup(popupContent, { maxWidth: 300 });
            @endif
        @endforeach

        // Jika ada marker, paskan ukuran peta (zoom/center) agar semua marker terlihat
        if (hasMarkers) {
            map.fitBounds(markersGroup.getBounds(), { padding: [50, 50] });
        }
    });
</script>
@endsection
