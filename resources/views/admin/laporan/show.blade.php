@extends('layouts.app')
@section('title', 'Detail Laporan - ' . $laporan->kode_laporan)

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Informasi Laporan</h5>
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
                    <span class="badge {{ $statusClass }} px-3 py-2">{{ $statusLabel }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Judul Laporan</div>
                        <div class="col-md-8 fw-bold">{{ $laporan->judul_laporan }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Deskripsi</div>
                        <div class="col-md-8">{{ $laporan->deskripsi }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Pelapor</div>
                        <div class="col-md-8">{{ $laporan->user->name ?? 'Anonim' }} ({{ $laporan->created_at->format('d M Y H:i') }})</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Lokasi</div>
                        <div class="col-md-8">
                            {{ $laporan->alamat_lengkap }}<br>
                            <small class="text-muted">Kecamatan: {{ $laporan->kecamatan->nama ?? '-' }}, Desa: {{ $laporan->desa->nama ?? '-' }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Koordinat (Peta)</div>
                        <div class="col-md-8">
                            Lat: {{ $laporan->latitude }}, Lng: {{ $laporan->longitude }}
                            <div class="mt-2" id="mapDetailAdmin" style="height: 300px; border-radius: 8px; border: 1px solid var(--color-border); z-index: 1;"></div>
                        </div>
                    </div>

                    @if($laporan->status === 'ditolak')
                    <div class="row mb-3">
                        <div class="col-md-4 text-danger fw-bold">Alasan Penolakan</div>
                        <div class="col-md-8">
                            <div class="alert alert-danger mb-0 p-2">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $laporan->alasan_penolakan ?? 'Tidak ada alasan.' }}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($laporan->foto_laporan)
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Foto Laporan (Awal)</div>
                        <div class="col-md-8">
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach((array)$laporan->foto_laporan as $foto)
                                    <img src="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" 
                                         onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" 
                                         alt="Foto" class="img-thumbnail" style="max-width: 150px;">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($laporan->dokumentasiPenanganan)
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="m-0">Dokumentasi Penanganan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Foto Sebelum (Oleh Petugas)</h6>
                            @if($laporan->dokumentasiPenanganan->foto_sebelum)
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach((array)$laporan->dokumentasiPenanganan->foto_sebelum as $foto)
                                        <img src="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" 
                                             onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" 
                                             alt="Foto" class="img-thumbnail" style="max-width: 150px;">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted fst-italic">Belum ada foto</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Foto Sesudah (Oleh Petugas)</h6>
                            @if($laporan->dokumentasiPenanganan->foto_sesudah)
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach((array)$laporan->dokumentasiPenanganan->foto_sesudah as $foto)
                                        <img src="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" 
                                             onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" 
                                             alt="Foto" class="img-thumbnail" style="max-width: 150px;">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted fst-italic">Belum ada foto</span>
                            @endif
                        </div>
                    </div>
                    @if($laporan->dokumentasiPenanganan->catatan_pekerjaan)
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6 class="text-muted">Catatan Pekerjaan</h6>
                            <p>{{ $laporan->dokumentasiPenanganan->catatan_pekerjaan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="m-0">Aksi Admin</h5>
                </div>
                <div class="card-body">
                    @if($laporan->status === 'menunggu_verifikasi')
                        <form action="{{ route('admin.laporan.verifikasi', $laporan->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info text-white w-100 mb-2"><i class="fa-solid fa-check"></i> Verifikasi Laporan</button>
                        </form>
                        
                        <button type="button" class="btn btn-outline-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalTolak">
                            <i class="fa-solid fa-xmark"></i> Tolak Laporan
                        </button>

                        <!-- Modal Tolak -->
                        <div class="modal fade" id="modalTolak" tabindex="-1">
                          <div class="modal-dialog">
                            <form action="{{ route('admin.laporan.tolak', $laporan->id) }}" method="POST">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Tolak Laporan</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label class="form-label fw-bold">Alasan Penolakan</label>
                                    <textarea name="alasan_penolakan" class="form-control" rows="3" required placeholder="Tulis alasan laporan ini ditolak (misal: Alamat tidak jelas, Bukan kewenangan DLH, dll)..."></textarea>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-danger">Tolak Laporan</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                    @endif

                    @if(in_array($laporan->status, ['menunggu_verifikasi', 'diverifikasi']))
                        <hr>
                        <form action="{{ route('admin.laporan.tugaskan', $laporan->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tugaskan Petugas</label>
                                <select name="petugas_id" class="form-select" required>
                                    <option value="">-- Pilih Petugas --</option>
                                    @foreach($petugasList as $p)
                                        <option value="{{ $p->id }}" {{ ($laporan->penugasan && $laporan->penugasan->petugas_id == $p->id) ? 'selected' : '' }}>
                                            {{ $p->user?->name ?? 'Petugas' }} 
                                            @if($p->penugasans_count > 0)
                                                (Sedang menangani {{ $p->penugasans_count }} tugas)
                                            @else
                                                (Tersedia)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tenggat Waktu (Opsional)</label>
                                <input type="datetime-local" name="tenggat_waktu" class="form-control" value="{{ old('tenggat_waktu', $laporan->penugasan?->tenggat_waktu ? $laporan->penugasan->tenggat_waktu->format('Y-m-d\TH:i') : '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Admin</label>
                                <textarea name="catatan_admin" class="form-control" rows="2">{{ old('catatan_admin', $laporan->penugasan->catatan_admin ?? '') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-user-check"></i> Tugaskan</button>
                        </form>
                    @endif

                    @if($laporan->status === 'menunggu_validasi_akhir')
                        <form action="{{ route('admin.laporan.validasi-akhir', $laporan->id) }}" method="POST">
                            @csrf
                            <div class="alert alert-warning">
                                Laporan ini sudah ditangani. Silakan periksa foto dokumentasi. Jika sudah sesuai, klik tombol di bawah untuk menyelesaikan.
                            </div>
                            <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-check-double"></i> Validasi & Selesai</button>
                        </form>
                    @endif

                    @if(in_array($laporan->status, ['sedang_ditangani']))
                        <div class="alert alert-info">
                            Laporan sedang ditangani oleh petugas. Menunggu konfirmasi penyelesaian.
                        </div>
                    @endif
                    
                    @if($laporan->status === 'selesai')
                        <div class="alert alert-success">
                            Laporan ini telah selesai divalidasi.
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="m-0">Riwayat Status</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($laporan->laporanStatusHistories as $history)
                        <li class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong>{{ str_replace('_', ' ', strtoupper($history->status_baru ?? $history->status_sesudah ?? '')) }}</strong>
                                <small class="text-muted">{{ $history->created_at ? $history->created_at->format('d M Y H:i') : '-' }}</small>
                            </div>
                            <small class="d-block text-muted">{{ $history->keterangan }}</small>
                            <small class="d-block text-muted mt-1"><i class="fa-solid fa-user"></i> {{ $history->user?->name ?? 'Sistem' }}</small>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lat = {{ $laporan->latitude ?? -7.6531 }};
        var lng = {{ $laporan->longitude ?? 111.3284 }};
        
        var map = L.map('mapDetailAdmin').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>Lokasi Laporan</b><br>{{ $laporan->alamat_lengkap }}").openPopup();
    });
</script>
@endsection
