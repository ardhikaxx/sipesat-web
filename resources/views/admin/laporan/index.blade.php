@extends('layouts.app')
@section('title', 'Manajemen Laporan')

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
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Pelapor</th>
                            <th>Lokasi (Kecamatan)</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                        <tr>
                            <td class="font-mono text-primary fw-bold">{{ $laporan->kode_laporan }}</td>
                            <td>{{ $laporan->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $laporan->user->name ?? 'Anonim' }}</td>
                            <td>{{ $laporan->kecamatan->nama ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $laporan->kategoriSampah->nama ?? '-' }}</span></td>
                            <td>
                                @php
                                    $statusClass = match($laporan->status) {
                                        'menunggu_verifikasi' => 'bg-warning text-dark',
                                        'diverifikasi' => 'bg-info',
                                        'sedang_ditangani' => 'bg-primary',
                                        'menunggu_validasi_akhir' => 'bg-secondary',
                                        'selesai' => 'bg-success',
                                        'ditolak' => 'bg-danger',
                                        default => 'bg-dark'
                                    };
                                    $statusLabel = str_replace('_', ' ', strtoupper($laporan->status));
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-3 text-muted">Belum ada laporan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $laporans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
