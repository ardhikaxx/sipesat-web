@extends('layouts.app')
@section('title', 'Tugas Saya')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Laporan</th>
                            <th>Tanggal Penugasan</th>
                            <th>Lokasi</th>
                            <th>Status Laporan</th>
                            <th>Catatan Admin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penugasans as $tugas)
                        <tr>
                            <td>
                                <strong>{{ $tugas->laporanSampah->kode_laporan }}</strong><br>
                                <span class="badge bg-info">{{ $tugas->laporanSampah->kategoriSampah->nama ?? '-' }}</span>
                            </td>
                            <td>{{ $tugas->assigned_at ? $tugas->assigned_at->format('d M Y H:i') : '-' }}</td>
                            <td>{{ $tugas->laporanSampah->desa->nama ?? '-' }}</td>
                            <td>
                                @php
                                    $statusClass = match($tugas->laporanSampah->status) {
                                        'menunggu_verifikasi' => 'bg-warning text-dark',
                                        'diverifikasi' => 'bg-info',
                                        'sedang_ditangani' => 'bg-primary',
                                        'menunggu_validasi_akhir' => 'bg-secondary',
                                        'selesai' => 'bg-success',
                                        'ditolak' => 'bg-danger',
                                        default => 'bg-dark'
                                    };
                                    $statusLabel = str_replace('_', ' ', strtoupper($tugas->laporanSampah->status));
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td>{{ Str::limit($tugas->catatan_admin, 30) }}</td>
                            <td>
                                <a href="{{ route('petugas.tugas.show', $tugas->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-muted">Belum ada tugas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $penugasans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
