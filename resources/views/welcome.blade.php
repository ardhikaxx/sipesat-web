@extends('layouts.app')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .hero-section {
        background-color: #f8f9fa;
        position: relative;
        overflow: hidden;
        padding: 100px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .hero-badge {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        padding: 8px 16px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 1.5rem;
    }
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        letter-spacing: -1.5px;
        color: #212529;
        line-height: 1.2;
    }
    .hero-title span {
        color: #198754;
    }
    .hero-subtitle {
        font-size: 1.25rem;
        color: #6c757d;
        font-weight: 400;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .btn-custom {
        transition: all 0.2s ease;
        border-radius: 8px;
        font-weight: 600;
        padding: 14px 32px;
    }
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(25, 135, 84, 0.2);
    }
    .map-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
    }
    .banner-card {
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 24px rgba(0,0,0,0.04);
    }
    .banner-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.08);
    }
    .section-title {
        font-weight: 700;
        letter-spacing: -0.5px;
        color: #212529;
    }
    .footer-custom {
        background-color: #fff;
        border-top: 1px solid #eaeaea;
    }
</style>

<div class="container-fluid p-0">
    <!-- Minimalist Modern Hero Section -->
    <div class="hero-section text-center">
        <div class="container relative z-index-2">
            <div class="hero-badge">Magetan, Jawa Timur</div>
            <h1 class="hero-title mb-4">Sistem Pelaporan<br><span>Sampah Terpadu</span></h1>
            <p class="hero-subtitle mb-5">
                Wujudkan Magetan yang bersih dan asri. Laporkan tumpukan sampah atau pembuangan ilegal di sekitar Anda dengan cepat dan mudah.
            </p>
            <a href="{{ route('masyarakat.laporan.create') }}" class="btn btn-success btn-lg btn-custom">
                Buat Laporan Sekarang
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
