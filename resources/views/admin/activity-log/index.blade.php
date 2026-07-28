@extends('layouts.app')
@section('title', 'Log Aktivitas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Log Aktivitas Sistem</h3>
        <button class="btn btn-outline-secondary" onclick="window.location.reload()"><i class="fa-solid fa-arrows-rotate me-2"></i>Refresh</button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Waktu</th>
                            <th>Pengguna</th>
                            <th>Aktivitas</th>
                            <th>Modul</th>
                            <th>Deskripsi / IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="py-3 px-4 font-mono text-muted small">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                            <td class="fw-bold text-dark"><i class="fa-solid fa-user-circle me-1 text-primary"></i> {{ $log->user->name ?? 'Sistem / Anonim' }}</td>
                            <td><span class="badge bg-secondary">{{ $log->aktivitas }}</span></td>
                            <td>{{ $log->modul }}</td>
                            <td>
                                <span class="d-block">{{ $log->deskripsi }}</span>
                                <small class="text-muted font-mono"><i class="fa-solid fa-network-wired me-1"></i> {{ $log->ip_address ?? '-' }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-clipboard-list fs-2 mb-3 d-block"></i>
                                Belum ada log aktivitas yang tercatat di sistem.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
        <div class="card-footer bg-white border-0 pt-4">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection