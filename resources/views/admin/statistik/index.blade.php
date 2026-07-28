@extends('layouts.app')
@section('title', 'Statistik Laporan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Statistik Analitik</h3>
        <button class="btn btn-primary" onclick="window.print()"><i class="fa-solid fa-print me-2"></i>Cetak Laporan</button>
    </div>

    <div class="row g-4">
        <!-- Tren Laporan (Line Chart) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold m-0"><i class="fa-solid fa-chart-line text-primary me-2"></i>Tren Laporan (6 Bulan Terakhir)</h6>
                </div>
                <div class="card-body">
                    <canvas id="trenChart" style="min-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Sebaran Status (Doughnut Chart) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold m-0"><i class="fa-solid fa-chart-pie text-info me-2"></i>Persentase Status Laporan</h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <canvas id="statusChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Wilayah Rawan (Bar Chart / List) -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold m-0"><i class="fa-solid fa-map-location-dot text-danger me-2"></i>Top 5 Kecamatan Rawan Sampah Liar</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                @forelse($kecamatanData as $index => $kec)
                                <tr>
                                    <td style="width: 50px;">
                                        <div class="rounded-circle bg-light text-dark d-flex justify-content-center align-items-center fw-bold" style="width: 35px; height: 35px;">
                                            #{{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td class="fw-bold">{{ $kec->nama_kecamatan }}</td>
                                    <td>
                                        <div class="progress" style="height: 10px;">
                                            @php $percentage = ($kec->total / max($kecamatanData->max('total'), 1)) * 100; @endphp
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold font-mono">{{ $kec->total }} Laporan</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data wilayah.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tren Laporan
        const ctxTren = document.getElementById('trenChart').getContext('2d');
        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelsTren) !!},
                datasets: [{
                    label: 'Jumlah Laporan Masuk',
                    data: {!! json_encode($dataTren) !!},
                    borderColor: '#1F6E43',
                    backgroundColor: 'rgba(31, 110, 67, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        // Status Laporan
        const statusDataRaw = {!! json_encode($statusData) !!};
        const statusLabels = statusDataRaw.map(item => item.status.replace(/_/g, ' ').toUpperCase());
        const statusValues = statusDataRaw.map(item => item.total);
        
        // Define colors based on standard status mapping
        const colorMap = {
            'MENUNGGU VERIFIKASI': '#E8A33D', 
            'DIVERIFIKASI': '#2E7DA3', 
            'SEDANG DITANGANI': '#1F6E43', 
            'MENUNGGU VALIDASI AKHIR': '#6B7280', 
            'SELESAI': '#7FB069', 
            'DITOLAK': '#C1443C'
        };
        const statusColors = statusLabels.map(label => colorMap[label] || '#999999');

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: statusLabels.length ? statusLabels : ['Tidak ada data'],
                datasets: [{
                    data: statusValues.length ? statusValues : [1],
                    backgroundColor: statusValues.length ? statusColors : ['#e0e0e0'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, usePointStyle: true } }
                }
            }
        });
    });
</script>
@endsection