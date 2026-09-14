@extends('layouts.app')
@section('title', 'Log Aktivitas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Log Aktivitas Sistem</h3>
        <button class="btn btn-outline-secondary" onclick="window.location.reload()"><i class="fa-solid fa-arrows-rotate me-2"></i>Refresh</button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 10px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-activity-log">
                    <thead>
                        <tr>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-3">Pengguna</th>
                            <th class="py-3 px-3">Aktivitas</th>
                            <th class="py-3 px-3">Modul</th>
                            <th class="py-3 px-3">Deskripsi</th>
                            <th class="py-3 px-4">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="py-3 px-4 text-nowrap text-secondary" style="font-size: 0.88rem;">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3 px-3">
                                <div class="fw-bold text-dark" style="font-size: 0.88rem; line-height: 1.3;">
                                    {{ $log->user->name ?? 'Sistem / Anonim' }}
                                </div>
                                @if($log->user && $log->user->email)
                                <div class="text-muted small" style="font-size: 0.78rem; line-height: 1.3;">
                                    {{ $log->user->email }}
                                </div>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                <span class="badge rounded-pill fw-medium badge-activity">
                                    {{ $log->aktivitas }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <span class="badge fw-medium badge-module">
                                    {{ $log->modul }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-dark" style="font-size: 0.88rem; line-height: 1.4;">
                                {{ $log->deskripsi }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="badge font-mono fw-normal badge-ip">
                                    {{ $log->ip_address ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-clipboard-list fs-2 mb-3 d-block text-muted"></i>
                                Belum ada log aktivitas yang tercatat di sistem.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
        <div class="card-footer bg-white border-0 pt-3 pb-3">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<style>
    .table-activity-log thead th {
        background-color: #1D5F39 !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 0.2px;
        border: none !important;
        box-shadow: none !important;
    }
    .table-activity-log tbody td {
        border-bottom: 1px solid #EDEDED;
        border-top: none;
        vertical-align: middle;
        background-color: #ffffff;
    }
    .table-activity-log tbody tr:last-child td {
        border-bottom: none;
    }
    .table-activity-log tbody tr:hover td {
        background-color: #F9FAF8;
    }
    .badge-activity {
        background-color: #D4F4DD !important;
        color: #166534 !important;
        font-size: 0.8rem;
        font-weight: 500;
        padding: 6px 14px;
        letter-spacing: 0.2px;
    }
    .badge-module {
        background-color: #F1F3F5 !important;
        color: #374151 !important;
        font-size: 0.8rem;
        font-weight: 500;
        border-radius: 6px;
        padding: 6px 12px;
        letter-spacing: 0.2px;
    }
    .badge-ip {
        background-color: #F3F4F6 !important;
        color: #4B5563 !important;
        font-size: 0.8rem;
        border-radius: 6px;
        padding: 5px 10px;
        letter-spacing: 0.5px;
    }
</style>
@endsection