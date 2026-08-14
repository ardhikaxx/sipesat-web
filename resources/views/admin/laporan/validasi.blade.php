@extends('layouts.app')
@section('title', 'Validasi Pekerjaan Petugas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Validasi Pekerjaan</h3>
            <p class="text-muted mb-0">Pantau tugas yang sedang dikerjakan dan butuh validasi akhir.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Kode Laporan</th>
                            <th>Petugas Penanganan</th>
                            <th>Mulai Dikerjakan</th>
                            <th>Status Pekerjaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                        <tr>
                            <td class="py-3 px-4">
                                <span class="d-block font-mono fw-bold text-dark">{{ $laporan->kode_laporan }}</span>
                                <small class="text-muted">{{ Str::limit($laporan->judul_laporan, 30) }}</small>
                            </td>
                            <td>
                                @if($laporan->penugasan && $laporan->penugasan->petugas)
                                    <span class="d-block text-dark fw-semibold"><i class="fa-solid fa-hard-hat text-warning me-1"></i> {{ $laporan->penugasan->petugas->user->name }}</span>
                                    @if($laporan->penugasan->tenggat_waktu)
                                        <small class="text-danger"><i class="fa-regular fa-clock"></i> SLA: {{ $laporan->penugasan->tenggat_waktu->format('d M, H:i') }}</small>
                                    @endif
                                @else
                                    <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>
                            <td>
                                @if($laporan->dokumentasiPenanganan && $laporan->dokumentasiPenanganan->waktu_mulai)
                                    {{ $laporan->dokumentasiPenanganan->waktu_mulai->format('d M Y, H:i') }}
                                @else
                                    <span class="text-muted fst-italic">Belum Mulai</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = 'bg-secondary';
                                    if($laporan->status == 'diverifikasi') { $badgeClass = 'bg-info'; }
                                    elseif($laporan->status == 'sedang_ditangani') { $badgeClass = 'bg-primary'; }
                                    elseif($laporan->status == 'menunggu_validasi_akhir') { $badgeClass = 'bg-warning text-dark'; }
                                @endphp
                                <span class="badge {{ $badgeClass }} px-2 py-1">{{ ucwords(str_replace('_', ' ', $laporan->status)) }}</span>
                            </td>
                            <td class="text-center">
                                @if($laporan->status === 'menunggu_validasi_akhir')
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-sm btn-success rounded-pill px-3" title="Validasi Sekarang">
                                        <i class="fa-solid fa-check-double"></i> Validasi
                                    </a>
                                @else
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-check-circle fs-2 mb-3 d-block text-success"></i>
                                Tidak ada pekerjaan yang perlu divalidasi saat ini. Semua beres!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($laporans->hasPages())
        <div class="card-footer bg-white border-0 pt-4">
            {{ $laporans->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
