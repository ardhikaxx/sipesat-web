@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 d-flex flex-row justify-content-between align-items-center border-0 shadow-sm">
            <div>
                <span class="text-muted small d-block">Menunggu Verifikasi</span>
                <h3 class="font-mono m-0 fw-bold">{{ $menunggu }}</h3>
            </div>
            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center shadow-sm" style="width:45px;height:45px;">
                <i class="fa-solid fa-clock fs-5"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 d-flex flex-row justify-content-between align-items-center border-0 shadow-sm">
            <div>
                <span class="text-muted small d-block">Sedang Ditangani</span>
                <h3 class="font-mono m-0 fw-bold text-primary">{{ $diproses }}</h3>
            </div>
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width:45px;height:45px;">
                <i class="fa-solid fa-broom fs-5"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 d-flex flex-row justify-content-between align-items-center border-0 shadow-sm">
            <div>
                <span class="text-muted small d-block">Selesai</span>
                <h3 class="font-mono m-0 fw-bold text-success">{{ $selesai }}</h3>
            </div>
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center shadow-sm" style="width:45px;height:45px;">
                <i class="fa-solid fa-circle-check fs-5"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 d-flex flex-row justify-content-between align-items-center border-0 shadow-sm">
            <div>
                <span class="text-muted small d-block">Ditolak</span>
                <h3 class="font-mono m-0 fw-bold text-danger">{{ $ditolak }}</h3>
            </div>
            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center shadow-sm" style="width:45px;height:45px;">
                <i class="fa-solid fa-circle-xmark fs-5"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Chart Kategori Sampah -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold m-0"><i class="fa-solid fa-chart-column me-2 text-primary"></i>Statistik Kategori Sampah</h6>
            </div>
            <div class="card-body">
                <canvas id="kategoriChart" style="min-height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Statistik Tambahan -->
    <div class="col-lg-7">
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="card border-0 shadow-sm text-center p-4 h-100 bg-primary text-white" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);">
                    <i class="fa-solid fa-file-lines fs-1 mb-3 opacity-75"></i>
                    <h2 class="font-mono fw-bold mb-1">{{ $totalLaporan }}</h2>
                    <p class="mb-0">Total Laporan Masuk</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card border-0 shadow-sm text-center p-4 h-100 bg-info text-white" style="background: linear-gradient(135deg, var(--color-info) 0%, #1e5a77 100%);">
                    <i class="fa-solid fa-users-gear fs-1 mb-3 opacity-75"></i>
                    <h2 class="font-mono fw-bold mb-1">{{ $totalPetugas }}</h2>
                    <p class="mb-0">Petugas Aktif</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Peta Live -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold m-0"><i class="fa-solid fa-map-location-dot me-2 text-primary"></i>Peta Sebaran Laporan (Live Map)</h6>
        <div class="small">
            <span class="badge bg-danger me-1">Belum Diatasi</span>
            <span class="badge bg-warning text-dark me-1">Masih Diproses</span>
            <span class="badge bg-success">Sudah Diatasi</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div id="adminMap" style="height: 500px; width: 100%; border-bottom-left-radius: var(--radius-md); border-bottom-right-radius: var(--radius-md);"></div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- Inisialisasi Chart.js ---
        const ctx = document.getElementById('kategoriChart').getContext('2d');
        
        const chartLabels = {!! json_encode($chartLabels) !!};
        const chartValues = {!! json_encode($chartValues) !!};
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels.length > 0 ? chartLabels : ['Belum ada data'],
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: chartValues.length > 0 ? chartValues : [0],
                    backgroundColor: 'rgba(31, 110, 67, 0.7)',
                    borderColor: 'rgba(31, 110, 67, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // --- Inisialisasi Leaflet Map ---
        const laporans = {!! json_encode($laporansMap) !!};
        
        // Setup Map Default ke Magetan
        const map = L.map('adminMap').setView([-7.6531, 111.3284], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const markersGroup = L.featureGroup().addTo(map);
        let hasMarkers = false;

        // Custom Icons based on status
        const colorMap = {
            'menunggu_verifikasi': '#dc3545', // merah (belum diatasi)
            'diverifikasi': '#ffc107', // kuning (masih diproses)
            'sedang_ditangani': '#ffc107', // kuning (masih diproses)
            'menunggu_validasi_akhir': '#198754', // hijau (sudah diatasi)
            'selesai': '#198754', // hijau (sudah diatasi)
            'ditolak': '#dc3545' // merah (ditolak/belum diatasi)
        };

        laporans.forEach(laporan => {
            if(laporan.latitude && laporan.longitude) {
                hasMarkers = true;
                
                // Buat custom marker icon menggunakan warna
                const markerColor = colorMap[laporan.status] || '#1F2A24';
                const customIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="background-color: ${markerColor}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5);"></div>`,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                });

                const detailUrl = `/admin/laporan/${laporan.id}`;
                const namaKategori = laporan.kategori_sampah ? laporan.kategori_sampah.nama_kategori : '-';
                const pelapor = laporan.user ? laporan.user.name : 'Anonim';
                const formattedStatus = laporan.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                
                const popupHtml = `
                    <div style="min-width: 200px;">
                        <div class="mb-1 d-flex justify-content-between align-items-start">
                            <h6 class="fw-bold m-0 pe-2">${laporan.judul_laporan}</h6>
                            <span class="badge" style="background-color: ${markerColor}; font-size: 0.65rem;">${formattedStatus}</span>
                        </div>
                        <small class="text-muted d-block mb-2">${laporan.kode_laporan}</small>
                        <p class="mb-1 small"><b>Pelapor:</b> ${pelapor}</p>
                        <p class="mb-2 small"><b>Kategori:</b> ${namaKategori}</p>
                        <a href="${detailUrl}" class="btn btn-sm btn-outline-primary w-100 rounded-pill mt-1">Lihat Detail</a>
                    </div>
                `;

                L.marker([laporan.latitude, laporan.longitude], {icon: customIcon})
                    .bindPopup(popupHtml)
                    .addTo(markersGroup);
            }
        });

        if(hasMarkers) {
            map.fitBounds(markersGroup.getBounds(), { padding: [30, 30] });
        }
    });
</script>
@endsection