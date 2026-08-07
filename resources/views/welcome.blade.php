@extends('layouts.app')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color: #ffffff !important;
    }
    .hero-section {
        background-color: #ffffff;
        position: relative;
        overflow: hidden;
        padding: 100px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        letter-spacing: -1.5px;
        color: #0f5132;
        line-height: 1.1;
        text-transform: uppercase;
    }
    .hero-subtitle {
        font-size: 1.1rem;
        color: #198754;
        font-weight: 500;
        max-width: 500px;
        line-height: 1.6;
    }
    .btn-hero {
        background-color: #0f5132;
        color: #fff;
        border-radius: 50px;
        padding: 14px 40px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
    }
    .btn-hero:hover {
        background-color: #198754;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(25, 135, 84, 0.2);
    }
    .hero-illustration {
        max-width: 100%;
        height: auto;
        animation: float 4s ease-in-out infinite;
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
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
    <!-- Split Layout Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Kolom Kiri: Teks -->
                <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                    <h1 class="hero-title mb-4">SIPESAT<br>MAGETAN</h1>
                    <p class="hero-subtitle mb-5 mx-auto mx-lg-0">
                        Sistem Pelaporan Sampah Terpadu wilayah Magetan, Jawa Timur. Mari bersama wujudkan lingkungan bersih dengan melaporkan tumpukan sampah atau pembuangan ilegal secara cepat dan mudah.
                    </p>
                    <a href="{{ route('masyarakat.laporan.create') }}" class="btn btn-hero text-uppercase">
                        Buat Laporan
                    </a>
                </div>
                
                <!-- Kolom Kanan: Ilustrasi -->
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/hero_illustration.jpg') }}" alt="Ilustrasi Petugas Kebersihan" class="hero-illustration img-fluid" style="border-radius: 20px;">
                </div>
            </div>
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
    <div class="py-5">
        <div class="container mb-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold section-title">Edukasi & Kesadaran Lingkungan</h2>
                <p class="text-muted mt-3">Mengenal jenis-jenis sampah adalah langkah awal menuju pengelolaan lingkungan yang lebih baik.</p>
            </div>
            <div class="card banner-card mb-5">
                <img src="{{ asset('images/edukasi_kategori_sampah.jpg') }}" alt="Edukasi Kategori Sampah" class="img-fluid w-100">
                <div class="card-body bg-white text-center p-4">
                    <h4 class="fw-bold text-success mb-3">Kenali Jenis Sampah di Lingkungan Kita</h4>
                    <p class="text-muted mb-0 mx-auto" style="max-width: 800px; line-height: 1.8;">
                        Mari bersama-sama menjaga kebersihan lingkungan dengan mengenali dan melaporkan berbagai jenis sampah. Pemilahan yang benar antara Sampah Rumah Tangga, Pembuangan Liar, Sampah Saluran Air, Sampah Pasar, hingga Limbah B3 Ringan akan sangat membantu proses daur ulang dan menjaga ekosistem Magetan.
                    </p>
                </div>
            </div>

            <!-- Daftar Berita Terkini -->
            <div class="text-start mb-4">
                <h4 class="fw-bold text-dark">Berita & Edukasi Terkini</h4>
            </div>
            <div class="row g-4">
                @forelse($beritas as $berita)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 banner-card">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="mb-3">
                                <span class="badge bg-primary rounded-pill px-3 py-2 me-2">{{ ucwords($berita->kategori) }}</span>
                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ $berita->created_at->format('d M Y') }}</small>
                            </div>
                            <h5 class="fw-bold text-dark mb-3">{{ $berita->judul }}</h5>
                            <p class="text-muted mb-4 flex-grow-1" style="font-size: 0.95rem;">
                                {{ \Illuminate\Support\Str::limit($berita->konten, 120) }}
                            </p>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="text-primary fw-bold text-decoration-none mt-auto">Baca Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted">
                    <p>Belum ada berita yang dipublikasikan.</p>
                </div>
                @endforelse
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
                
                @php
                    $fotoAwal = null;
                    if (!empty($laporan->foto_laporan)) {
                        $firstAwal = is_array($laporan->foto_laporan) ? ($laporan->foto_laporan[0] ?? null) : $laporan->foto_laporan;
                        if ($firstAwal) {
                            $fotoAwal = asset(str_starts_with($firstAwal, 'uploads/') ? $firstAwal : 'uploads/' . $firstAwal);
                        }
                    }

                    $fotoSesudah = null;
                    if ($laporan->dokumentasiPenanganan && !empty($laporan->dokumentasiPenanganan->foto_sesudah)) {
                        $firstSesudah = is_array($laporan->dokumentasiPenanganan->foto_sesudah) ? ($laporan->dokumentasiPenanganan->foto_sesudah[0] ?? null) : $laporan->dokumentasiPenanganan->foto_sesudah;
                        if ($firstSesudah) {
                            $fotoSesudah = asset(str_starts_with($firstSesudah, 'uploads/') ? $firstSesudah : 'uploads/' . $firstSesudah);
                        }
                    }
                @endphp

                var popupContent = `
                    <div style="min-width: 260px;">
                        <h6 class="fw-bold mb-1 text-primary">{{ $laporan->judul_laporan }}</h6>
                        <p class="text-muted small mb-2"><i class="fa-solid fa-hashtag"></i> {{ $laporan->kode_laporan }}</p>
                        
                        @if($fotoAwal || $fotoSesudah)
                        <div class="row g-1 mb-2">
                            @if($fotoAwal && $fotoSesudah)
                                <div class="col-6">
                                    <small class="d-block text-muted text-center mb-1" style="font-size:10px; font-weight:600;">Sebelum</small>
                                    <img src="{{ $fotoAwal }}" class="img-fluid rounded border" style="height: 90px; width: 100%; object-fit: cover;" alt="Foto Sebelum">
                                </div>
                                <div class="col-6">
                                    <small class="d-block text-success text-center mb-1" style="font-size:10px; font-weight:600;">Sesudah</small>
                                    <img src="{{ $fotoSesudah }}" class="img-fluid rounded border" style="height: 90px; width: 100%; object-fit: cover;" alt="Foto Sesudah">
                                </div>
                            @elseif($fotoSesudah)
                                <div class="col-12">
                                    <small class="d-block text-success mb-1" style="font-size:10px; font-weight:600;">Foto Penanganan</small>
                                    <img src="{{ $fotoSesudah }}" class="img-fluid rounded border" style="height: 120px; width: 100%; object-fit: cover;" alt="Foto Sesudah">
                                </div>
                            @elseif($fotoAwal)
                                <div class="col-12">
                                    <small class="d-block text-muted mb-1" style="font-size:10px; font-weight:600;">Foto Laporan</small>
                                    <img src="{{ $fotoAwal }}" class="img-fluid rounded border" style="height: 120px; width: 100%; object-fit: cover;" alt="Foto Laporan">
                                </div>
                            @endif
                        </div>
                        @endif

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
                    .bindPopup(popupContent, { maxWidth: 320 });
            @endif
        @endforeach

        // Jika ada marker, paskan ukuran peta (zoom/center) agar semua marker terlihat
        if (hasMarkers) {
            map.fitBounds(markersGroup.getBounds(), { padding: [50, 50] });
        }
    });
</script>
@endsection
