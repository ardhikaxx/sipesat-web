@extends('layouts.app')
@section('title', 'Monitoring Laporan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Monitoring Laporan</h3>
        <div>
            <button class="btn btn-outline-danger me-2" onclick="window.print()"><i class="fa-solid fa-file-pdf me-1"></i> Export PDF</button>
            <button class="btn btn-outline-success"><i class="fa-solid fa-file-excel me-1"></i> Export Excel</button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.monitoring.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small text-muted">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                        <option value="sedang_ditangani" {{ request('status') == 'sedang_ditangani' ? 'selected' : '' }}>Sedang Ditangani</option>
                        <option value="menunggu_validasi_akhir" {{ request('status') == 'menunggu_validasi_akhir' ? 'selected' : '' }}>Menunggu Validasi Akhir</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Kategori</label>
                    <select name="kategori_sampah_id" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ request('kategori_sampah_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Kecamatan</label>
                    <select name="kecamatan_id" class="form-select form-select-sm">
                        <option value="">Semua Kecamatan</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}" {{ request('kecamatan_id') == $kec->id ? 'selected' : '' }}>{{ $kec->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Petugas</label>
                    <select name="petugas_id" class="form-select form-select-sm">
                        <option value="">Semua Petugas</option>
                        @foreach($petugasList as $p)
                            <option value="{{ $p->id }}" {{ request('petugas_id') == $p->id ? 'selected' : '' }}>{{ $p->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Rentang Tanggal</label>
                    <div class="input-group input-group-sm">
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                        <span class="input-group-text">-</span>
                        <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fa-solid fa-filter"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Kode / Tanggal</th>
                            <th>Judul Laporan</th>
                            <th>Kategori</th>
                            <th>Kecamatan</th>
                            <th>Petugas Penanganan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                        <tr>
                            <td class="py-3 px-4">
                                <span class="d-block font-mono fw-bold text-dark">{{ $laporan->kode_laporan }}</span>
                                <small class="text-muted">{{ $laporan->created_at->format('d M Y, H:i') }}</small>
                            </td>
                            <td>
                                <span class="d-block fw-semibold">{{ Str::limit($laporan->judul_laporan, 30) }}</span>
                                <small class="text-muted"><i class="fa-solid fa-user me-1"></i> {{ $laporan->user->name ?? 'Anonim' }}</small>
                            </td>
                            <td><span class="badge bg-secondary rounded-pill fw-normal">{{ $laporan->kategoriSampah->nama_kategori ?? '-' }}</span></td>
                            <td>{{ $laporan->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td>
                                @if($laporan->penugasan && $laporan->penugasan->petugas)
                                    <span class="text-dark"><i class="fa-solid fa-hard-hat text-warning me-1"></i> {{ $laporan->penugasan->petugas->user->name }}</span>
                                @else
                                    <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = 'bg-secondary';
                                    if($laporan->status == 'menunggu_verifikasi') { $badgeClass = 'bg-warning text-dark'; }
                                    elseif($laporan->status == 'diverifikasi') { $badgeClass = 'bg-info'; }
                                    elseif($laporan->status == 'sedang_ditangani') { $badgeClass = 'bg-primary'; }
                                    elseif($laporan->status == 'selesai') { $badgeClass = 'bg-success'; }
                                    elseif($laporan->status == 'ditolak') { $badgeClass = 'bg-danger'; }
                                @endphp
                                <span class="badge {{ $badgeClass }} px-2 py-1">{{ ucwords(str_replace('_', ' ', $laporan->status)) }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-folder-open fs-2 mb-3 d-block"></i>
                                Tidak ada data laporan yang cocok dengan filter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-4">
            {{ $laporans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection