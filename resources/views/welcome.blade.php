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
                L.marker([{{ $laporan->latitude }}, {{ $laporan->longitude }}]).addTo(markersGroup)
                    .bindPopup("<b>{{ $laporan->judul_laporan }}</b><br>{{ $laporan->alamat_lengkap }}<br><span class='badge bg-success mt-1'>Selesai</span>");
            @endif
        @endforeach

        // Jika ada marker, paskan ukuran peta (zoom/center) agar semua marker terlihat
        if (hasMarkers) {
            map.fitBounds(markersGroup.getBounds(), { padding: [50, 50] });
        }
    });
</script>
@endsection
