@extends('layouts.app')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    .hero-gradient {
        background: linear-gradient(135deg, #198754 0%, #0f5132 100%);
        position: relative;
        overflow: hidden;
    }
    .hero-gradient::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="30" r="3" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="2.5" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
        background-size: 150px;
        opacity: 0.6;
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
    }
    .btn-custom {
        transition: all 0.3s ease;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .btn-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .banner-card {
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    }
    .banner-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
    .section-title {
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    .section-title::after {
        content: '';
        position: absolute;
        width: 50px;
        height: 4px;
        background: #198754;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    .footer-custom {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }
</style>

<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="hero-gradient text-white text-center py-5">
        <div class="container hero-content py-5">
            <h1 class="display-3 fw-bolder mb-3" style="letter-spacing: -1px;">SIPESAT</h1>
            <h3 class="fw-normal mb-4 text-light">Sistem Pelaporan Sampah Terpadu <br> <small class="text-white-50">Magetan, Jawa Timur</small></h3>
            <p class="lead mb-5 mx-auto" style="max-width: 700px; font-weight: 300;">
                Wujudkan Magetan yang bersih dan asri. Laporkan tumpukan sampah atau pembuangan ilegal di sekitar Anda dengan cepat dan mudah.
            </p>
            <a href="{{ route('masyarakat.laporan.create') }}" class="btn btn-light btn-lg btn-custom fw-bold text-success px-5 py-3">
                <i class="fa-solid fa-camera-retro me-2"></i> Buat Laporan Sekarang
            </a>
        </div>
    </div>

    <!-- Map Section -->
    <div class="container my-5 pt-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title">Peta Persebaran Laporan Selesai</h2>
            <p class="text-muted mt-3">Pantau secara langsung titik-titik tumpukan sampah yang telah berhasil ditangani oleh petugas kebersihan kami di seluruh wilayah Magetan.</p>
        </div>
        <div class="map-container mb-5">
            <div id="map" style="height: 550px; width: 100%;"></div>
        </div>
    </div>

    <!-- Banner Edukasi Sampah -->
    <div class="bg-light py-5">
        <div class="container mb-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold section-title">Edukasi & Kesadaran Lingkungan</h2>
                <p class="text-muted mt-3">Mengenal jenis-jenis sampah adalah langkah awal menuju pengelolaan lingkungan yang lebih baik.</p>
            </div>
            <div class="card banner-card">
                <img src="{{ asset('images/edukasi_kategori_sampah.jpg') }}" alt="Edukasi Kategori Sampah" class="img-fluid w-100">
                <div class="card-body bg-white text-center p-4">
                    <h4 class="fw-bold text-success mb-3">Kenali Jenis Sampah di Lingkungan Kita</h4>
                    <p class="text-muted mb-0 mx-auto" style="max-width: 800px; line-height: 1.8;">
                        Mari bersama-sama menjaga kebersihan lingkungan dengan mengenali dan melaporkan berbagai jenis sampah. Pemilahan yang benar antara Sampah Rumah Tangga, Pembuangan Liar, Sampah Saluran Air, Sampah Pasar, hingga Limbah B3 Ringan akan sangat membantu proses daur ulang dan menjaga ekosistem Magetan.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer-custom py-4 mt-auto">
        <div class="container text-center text-muted">
            <p class="mb-0">&copy; {{ date('Y') }} SIPESAT Magetan. Hak Cipta Dilindungi.</p>
            <small>Dikelola oleh Dinas Lingkungan Hidup Kabupaten Magetan</small>
        </div>
    </footer>
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
