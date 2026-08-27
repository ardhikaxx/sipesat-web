@extends('layouts.app')
@section('title', 'Detail Laporan - ' . $laporan->kode_laporan)

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

<style>
    /* Stepper Styling */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 1.5rem;
    }
    .stepper-wrapper::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 30px;
        right: 30px;
        height: 4px;
        background-color: var(--color-border);
        z-index: 0;
    }
    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        flex: 1;
        z-index: 1;
    }
    .step-counter {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid var(--color-border);
        font-weight: 700;
        font-size: 1rem;
        color: var(--color-muted);
        margin-bottom: 8px;
        transition: all 0.2s ease;
    }
    .stepper-item.active .step-counter {
        border-color: var(--color-primary);
        background-color: var(--color-primary);
        color: #fff;
        box-shadow: 0 0 0 4px var(--color-primary-light);
    }
    .stepper-item.completed .step-counter {
        border-color: var(--color-primary);
        background-color: var(--color-primary);
        color: #fff;
    }
    .stepper-item.rejected .step-counter {
        border-color: var(--color-danger);
        background-color: var(--color-danger);
        color: #fff;
    }
    .step-name {
        font-size: 0.825rem;
        font-weight: 600;
        color: var(--color-muted);
    }
    .stepper-item.active .step-name {
        color: var(--color-primary-dark);
        font-weight: 700;
    }
    .stepper-item.completed .step-name {
        color: var(--color-dark);
    }
    .stepper-item.rejected .step-name {
        color: var(--color-danger);
    }
    .step-subtext {
        font-size: 0.725rem;
        color: var(--color-muted);
    }
    .petugas-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: var(--color-primary-light);
        color: var(--color-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: bold;
    }
</style>

<div class="container-fluid">
    <!-- Breadcrumb & Back -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Laporan
            </a>
            <h4 class="fw-bold mb-0">
                Detail Laporan <span class="font-mono text-primary">{{ $laporan->kode_laporan }}</span>
            </h4>
        </div>
        <div>
            @php
                $hasPetugas = ($laporan->penugasan && $laporan->penugasan->petugas);
                $statusClass = match($laporan->status) {
                    'menunggu_verifikasi' => 'bg-warning text-dark',
                    'diverifikasi' => $hasPetugas ? 'bg-primary text-white' : 'bg-info text-white',
                    'sedang_ditangani' => 'bg-primary text-white',
                    'menunggu_validasi_akhir' => 'bg-secondary text-white',
                    'selesai' => 'bg-success text-white',
                    'ditolak' => 'bg-danger text-white',
                    default => 'bg-dark text-white'
                };
                
                $statusBadgeText = match($laporan->status) {
                    'menunggu_verifikasi' => 'MENUNGGU VERIFIKASI',
                    'diverifikasi' => $hasPetugas ? 'DIVERIFIKASI & DITUGASKAN' : 'DIVERIFIKASI (BELUM DITUGASKAN)',
                    'sedang_ditangani' => 'SEDANG DITANGANI',
                    'menunggu_validasi_akhir' => 'MENUNGGU VALIDASI AKHIR',
                    'selesai' => 'SELESAI',
                    'ditolak' => 'DITOLAK',
                    default => str_replace('_', ' ', strtoupper($laporan->status))
                };
            @endphp
            <span class="badge {{ $statusClass }} px-3 py-2 fs-6 shadow-sm">
                @if($laporan->status === 'menunggu_verifikasi')
                    <i class="fa-solid fa-clock me-1"></i>
                @elseif($laporan->status === 'diverifikasi')
                    <i class="fa-solid {{ $hasPetugas ? 'fa-user-check' : 'fa-clipboard-check' }} me-1"></i>
                @elseif($laporan->status === 'sedang_ditangani')
                    <i class="fa-solid fa-person-digging me-1"></i>
                @elseif($laporan->status === 'menunggu_validasi_akhir')
                    <i class="fa-solid fa-hourglass-half me-1"></i>
                @elseif($laporan->status === 'selesai')
                    <i class="fa-solid fa-circle-check me-1"></i>
                @elseif($laporan->status === 'ditolak')
                    <i class="fa-solid fa-circle-xmark me-1"></i>
                @endif
                {{ $statusBadgeText }}
            </span>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Progress Stepper Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-4 px-3">
            @php
                $isDitolak = ($laporan->status === 'ditolak');
                $isStep1Done = true;
                $isStep2Done = in_array($laporan->status, ['diverifikasi', 'sedang_ditangani', 'menunggu_validasi_akhir', 'selesai']);
                $isStep3Done = ($hasPetugas && in_array($laporan->status, ['diverifikasi', 'sedang_ditangani', 'menunggu_validasi_akhir', 'selesai']));
                $isStep4Done = in_array($laporan->status, ['sedang_ditangani', 'menunggu_validasi_akhir', 'selesai']);
                $isStep5Done = ($laporan->status === 'selesai');
            @endphp

            @if($isDitolak)
                <div class="stepper-wrapper">
                    <div class="stepper-item completed">
                        <div class="step-counter"><i class="fa-solid fa-file-lines"></i></div>
                        <div class="step-name">Laporan Masuk</div>
                        <div class="step-subtext">{{ $laporan->created_at->format('d M, H:i') }}</div>
                    </div>
                    <div class="stepper-item rejected">
                        <div class="step-counter"><i class="fa-solid fa-xmark"></i></div>
                        <div class="step-name">Laporan Ditolak</div>
                        <div class="step-subtext">{{ $laporan->verified_at ? $laporan->verified_at->format('d M, H:i') : '-' }}</div>
                    </div>
                </div>
            @else
                <div class="stepper-wrapper">
                    <!-- Step 1 -->
                    <div class="stepper-item {{ $isStep1Done ? 'completed' : 'active' }}">
                        <div class="step-counter"><i class="fa-solid fa-file-lines"></i></div>
                        <div class="step-name">1. Laporan Masuk</div>
                        <div class="step-subtext">{{ $laporan->created_at->format('d M, H:i') }}</div>
                    </div>
                    <!-- Step 2 -->
                    <div class="stepper-item {{ $isStep2Done ? 'completed' : ($laporan->status === 'menunggu_verifikasi' ? 'active' : '') }}">
                        <div class="step-counter"><i class="fa-solid fa-clipboard-check"></i></div>
                        <div class="step-name">2. Verifikasi</div>
                        <div class="step-subtext">
                            {{ $laporan->verified_at ? $laporan->verified_at->format('d M, H:i') : ($laporan->status === 'menunggu_verifikasi' ? 'Perlu diverifikasi' : 'Menunggu') }}
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="stepper-item {{ $isStep3Done ? 'completed' : ($laporan->status === 'diverifikasi' && !$hasPetugas ? 'active' : '') }}">
                        <div class="step-counter"><i class="fa-solid fa-user-check"></i></div>
                        <div class="step-name">3. Penugasan</div>
                        <div class="step-subtext">
                            @if($hasPetugas)
                                {{ $laporan->penugasan->petugas->user->name }}
                            @else
                                {{ $laporan->status === 'diverifikasi' ? 'Belum ditugaskan' : 'Menunggu' }}
                            @endif
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="stepper-item {{ in_array($laporan->status, ['menunggu_validasi_akhir', 'selesai']) ? 'completed' : ($laporan->status === 'sedang_ditangani' ? 'active' : '') }}">
                        <div class="step-counter"><i class="fa-solid fa-person-digging"></i></div>
                        <div class="step-name">4. Penanganan</div>
                        <div class="step-subtext">
                            @if($laporan->status === 'sedang_ditangani')
                                Sedang dikerjakan
                            @elseif(in_array($laporan->status, ['menunggu_validasi_akhir', 'selesai']))
                                Selesai dikerjakan
                            @else
                                Menunggu petugas
                            @endif
                        </div>
                    </div>
                    <!-- Step 5 -->
                    <div class="stepper-item {{ $isStep5Done ? 'completed' : ($laporan->status === 'menunggu_validasi_akhir' ? 'active' : '') }}">
                        <div class="step-counter"><i class="fa-solid fa-circle-check"></i></div>
                        <div class="step-name">5. Selesai</div>
                        <div class="step-subtext">
                            @if($laporan->status === 'selesai')
                                {{ $laporan->completed_at ? $laporan->completed_at->format('d M, H:i') : 'Divalidasi' }}
                            @elseif($laporan->status === 'menunggu_validasi_akhir')
                                Menunggu validasi admin
                            @else
                                Menunggu selesai
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Info Laporan & Penugasan & Dokumentasi -->
        <div class="col-lg-8">
            <!-- Card Informasi Laporan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold"><i class="fa-solid fa-circle-info text-primary me-2"></i>Informasi Laporan</h5>
                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                        Kategori: {{ $laporan->kategoriSampah->nama_kategori ?? '-' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Judul Laporan</div>
                        <div class="col-md-8 fw-bold fs-6">{{ $laporan->judul_laporan }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Deskripsi</div>
                        <div class="col-md-8 text-break" style="line-height: 1.6;">{{ $laporan->deskripsi }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Pelapor</div>
                        <div class="col-md-8">
                            <i class="fa-solid fa-user text-muted me-1"></i> {{ $laporan->user->name ?? 'Anonim' }}
                            @if($laporan->user && $laporan->user->phone)
                                &bull; <i class="fa-solid fa-phone text-muted me-1"></i> {{ $laporan->user->phone }}
                            @endif
                            <small class="text-muted d-block mt-1">
                                <i class="fa-regular fa-calendar text-muted me-1"></i> Dilaporkan pada {{ $laporan->created_at->format('d M Y, H:i') }} WIB
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Status Penugasan</div>
                        <div class="col-md-8">
                            @if($hasPetugas)
                                <span class="badge bg-success-subtle text-success border border-success px-2 py-1">
                                    <i class="fa-solid fa-user-check me-1"></i> Ditugaskan ke: <strong>{{ $laporan->penugasan->petugas->user->name }}</strong>
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning px-2 py-1">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Belum Ditugaskan
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Lokasi & Alamat</div>
                        <div class="col-md-8">
                            <div class="fw-semibold">{{ $laporan->alamat_lengkap }}</div>
                            <small class="text-muted">
                                Desa: <strong>{{ $laporan->desa->nama_desa ?? '-' }}</strong>, 
                                Kecamatan: <strong>{{ $laporan->kecamatan->nama_kecamatan ?? '-' }}</strong>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Peta Koordinat</div>
                        <div class="col-md-8">
                            <div class="small font-mono text-muted mb-2">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i> Lat: {{ $laporan->latitude }}, Lng: {{ $laporan->longitude }}
                            </div>
                            <div id="mapDetailAdmin" style="height: 260px; border-radius: 8px; border: 1px solid var(--color-border); z-index: 1;"></div>
                        </div>
                    </div>

                    @if($laporan->status === 'ditolak')
                    <div class="row mb-3">
                        <div class="col-md-4 text-danger fw-bold">Alasan Penolakan</div>
                        <div class="col-md-8">
                            <div class="alert alert-danger mb-0 p-3">
                                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $laporan->alasan_penolakan ?? 'Tidak ada alasan penolakan.' }}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($laporan->foto_laporan && count((array)$laporan->foto_laporan) > 0)
                    <div class="row mb-2">
                        <div class="col-md-4 text-muted">Foto Laporan (Awal)</div>
                        <div class="col-md-8">
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach((array)$laporan->foto_laporan as $foto)
                                    <a href="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" target="_blank">
                                        <img src="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" 
                                             onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" 
                                             alt="Foto Laporan" class="img-thumbnail rounded shadow-sm" style="max-width: 140px; height: 100px; object-fit: cover;">
                                    </a>
                                @endforeach
                            </div>
                            <small class="text-muted d-block mt-1">Klik foto untuk melihat ukuran penuh.</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Card Informasi Penugasan Petugas (Tampil jika sudah ditugaskan) -->
            @if($hasPetugas)
            <div class="card border-0 shadow-sm mb-4 border-start border-4 border-primary">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-primary">
                        <i class="fa-solid fa-hard-hat me-2"></i>Petugas Penanganan Lapangan
                    </h5>
                    <span class="badge bg-primary px-3 py-1">Ditugaskan</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="petugas-avatar">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold mb-1">{{ $laporan->penugasan->petugas->user->name }}</h5>
                            <div class="text-muted small mb-2">
                                <span class="me-3"><i class="fa-solid fa-id-card me-1"></i> NIP: {{ $laporan->penugasan->petugas->nip ?? '-' }}</span>
                                @if($laporan->penugasan->petugas->user->phone)
                                    <span>
                                        <i class="fa-solid fa-phone me-1"></i> {{ $laporan->penugasan->petugas->user->phone }}
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $laporan->penugasan->petugas->user->phone) }}" target="_blank" class="btn btn-xs btn-outline-success ms-2 py-0 px-2 rounded-pill small">
                                            <i class="fa-brands fa-whatsapp"></i> Hubungi
                                        </a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Ditugaskan Oleh</small>
                            <span class="fw-semibold">
                                <i class="fa-solid fa-user-tie text-muted me-1"></i> {{ $laporan->penugasan->assignedBy->name ?? 'Admin Diskominfo' }}
                            </span>
                            <small class="text-muted d-block">
                                {{ $laporan->penugasan->assigned_at ? $laporan->penugasan->assigned_at->format('d M Y, H:i') : '-' }} WIB
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Tenggat Waktu (Deadline)</small>
                            @if($laporan->penugasan->tenggat_waktu)
                                <span class="fw-bold text-warning-emphasis">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $laporan->penugasan->tenggat_waktu->format('d M Y, H:i') }} WIB
                                </span>
                            @else
                                <span class="text-muted fst-italic">Tidak ditentukan</span>
                            @endif
                        </div>
                        @if($laporan->penugasan->catatan_admin)
                        <div class="col-12">
                            <small class="text-muted d-block">Catatan / Instruksi Admin</small>
                            <div class="p-2 bg-light rounded border text-muted small mt-1">
                                <i class="fa-solid fa-quote-left text-muted me-1"></i> {{ $laporan->penugasan->catatan_admin }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Card Dokumentasi Penanganan Petugas (Before / After) -->
            @if($laporan->dokumentasiPenanganan)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="m-0 fw-bold"><i class="fa-solid fa-camera-retro text-primary me-2"></i>Dokumentasi Penanganan Lapangan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold text-muted mb-2"><i class="fa-solid fa-clock-rotate-left me-1"></i> Foto SEBELUM Penanganan</h6>
                            @if($laporan->dokumentasiPenanganan->foto_sebelum && count((array)$laporan->dokumentasiPenanganan->foto_sebelum) > 0)
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach((array)$laporan->dokumentasiPenanganan->foto_sebelum as $foto)
                                        <a href="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" target="_blank">
                                            <img src="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" 
                                                 onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" 
                                                 alt="Foto Sebelum" class="img-thumbnail rounded shadow-sm" style="max-width: 140px; height: 100px; object-fit: cover;">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-light border py-2 px-3 small text-muted fst-italic">Belum ada foto sebelum penanganan.</div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold text-muted mb-2"><i class="fa-solid fa-check-double me-1"></i> Foto SESUDAH Penanganan</h6>
                            @if($laporan->dokumentasiPenanganan->foto_sesudah && count((array)$laporan->dokumentasiPenanganan->foto_sesudah) > 0)
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach((array)$laporan->dokumentasiPenanganan->foto_sesudah as $foto)
                                        <a href="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" target="_blank">
                                            <img src="{{ asset(str_starts_with($foto, 'uploads/') ? $foto : 'uploads/' . $foto) }}" 
                                                 onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" 
                                                 alt="Foto Sesudah" class="img-thumbnail rounded shadow-sm" style="max-width: 140px; height: 100px; object-fit: cover;">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-light border py-2 px-3 small text-muted fst-italic">Belum ada foto sesudah penanganan.</div>
                            @endif
                        </div>
                    </div>
                    @if($laporan->dokumentasiPenanganan->catatan_pekerjaan)
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold text-muted mb-1">Catatan Pekerjaan Petugas:</h6>
                            <p class="p-2 bg-light rounded border mb-0">{{ $laporan->dokumentasiPenanganan->catatan_pekerjaan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Kolom Kanan: Panel Aksi & Riwayat Status -->
        <div class="col-lg-4">
            <!-- Card Panel Aksi Admin -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="m-0 fw-bold"><i class="fa-solid fa-sliders text-primary me-2"></i>Panel Aksi Admin</h5>
                </div>
                <div class="card-body">
                    <!-- Kasus 1: Status Menunggu Verifikasi -->
                    @if($laporan->status === 'menunggu_verifikasi')
                        <div class="alert alert-warning small mb-3">
                            <i class="fa-solid fa-info-circle me-1"></i> Laporan baru masuk. Anda dapat langsung memverifikasi atau menolaknya.
                        </div>

                        <form action="{{ route('admin.laporan.verifikasi', $laporan->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-info text-white w-100 py-2">
                                <i class="fa-solid fa-check me-1"></i> Verifikasi Laporan
                            </button>
                        </form>
                        
                        <button type="button" class="btn btn-outline-danger w-100 mb-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTolak">
                            <i class="fa-solid fa-xmark me-1"></i> Tolak Laporan
                        </button>

                        <hr class="my-3">
                        <div class="fw-bold small mb-2 text-muted">Atau Verifikasi & Langsung Tugaskan Petugas:</div>
                    @endif

                    <!-- Kasus 2: Status Menunggu Verifikasi atau Diverifikasi (Form Penugasan) -->
                    @if(in_array($laporan->status, ['menunggu_verifikasi', 'diverifikasi']))
                        @if($hasPetugas)
                            <!-- Jika sudah ditugaskan -->
                            <div class="p-3 mb-3 bg-success-subtle border border-success rounded">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa-solid fa-circle-check text-success fs-5 me-2"></i>
                                    <strong class="text-success-emphasis">Petugas Telah Ditugaskan</strong>
                                </div>
                                <div class="small text-muted mb-2">
                                    Ditugaskan kepada <strong>{{ $laporan->penugasan->petugas->user->name }}</strong>. Menunggu petugas memulai pengerjaan di lapangan.
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFormPenugasan" aria-expanded="false">
                                    <i class="fa-solid fa-user-pen me-1"></i> Ubah / Ganti Petugas
                                </button>
                            </div>

                            <div class="collapse" id="collapseFormPenugasan">
                                <div class="card card-body bg-light border mb-3">
                                    <h6 class="fw-bold mb-3 text-primary">Form Perubahan Penugasan</h6>
                                    <form action="{{ route('admin.laporan.tugaskan', $laporan->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Pilih Petugas Baru</label>
                                            <select name="petugas_id" class="form-select form-select-sm" required>
                                                @foreach($petugasList as $p)
                                                    <option value="{{ $p->id }}" {{ ($laporan->penugasan && $laporan->penugasan->petugas_id == $p->id) ? 'selected' : '' }}>
                                                        {{ $p->user?->name ?? 'Petugas' }} 
                                                        @if($p->penugasans_count > 0)
                                                            (Menangani {{ $p->penugasans_count }} tugas)
                                                        @else
                                                            (Tersedia)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Tenggat Waktu</label>
                                            <input type="datetime-local" name="tenggat_waktu" class="form-control form-control-sm" 
                                                   value="{{ old('tenggat_waktu', $laporan->penugasan?->tenggat_waktu ? $laporan->penugasan->tenggat_waktu->format('Y-m-d\TH:i') : '') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Catatan Admin</label>
                                            <textarea name="catatan_admin" class="form-control form-control-sm" rows="2" placeholder="Tulis instruksi untuk petugas...">{{ old('catatan_admin', $laporan->penugasan->catatan_admin ?? '') }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Jika belum ditugaskan -->
                            <div class="alert alert-info small mb-3">
                                <i class="fa-solid fa-hand-point-right me-1"></i> Silakan pilih petugas kebersihan yang akan menangani sampah di lokasi ini.
                            </div>
                            <form action="{{ route('admin.laporan.tugaskan', $laporan->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Pilih Petugas Lapangan <span class="text-danger">*</span></label>
                                    <select name="petugas_id" class="form-select" required>
                                        <option value="">-- Pilih Petugas --</option>
                                        @foreach($petugasList as $p)
                                            <option value="{{ $p->id }}">
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
                                    <label class="form-label fw-bold small">Tenggat Waktu (Opsional)</label>
                                    <input type="datetime-local" name="tenggat_waktu" class="form-control" value="{{ old('tenggat_waktu') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Catatan Admin</label>
                                    <textarea name="catatan_admin" class="form-control" rows="2" placeholder="Misal: Harap bawa truk pengangkut dan sapu..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="fa-solid fa-user-check me-1"></i> Tugaskan Petugas Lapangan
                                </button>
                            </form>
                        @endif
                    @endif

                    <!-- Kasus 3: Status Sedang Ditangani -->
                    @if($laporan->status === 'sedang_ditangani')
                        <div class="alert alert-primary mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-solid fa-person-digging fs-4 me-2"></i>
                                <strong>Sedang Ditangani</strong>
                            </div>
                            <div class="small">
                                Petugas <strong>{{ $laporan->penugasan->petugas->user->name ?? 'Petugas' }}</strong> sedang melakukan penanganan sampah di lokasi. Menunggu petugas menyelesaikan pekerjaan.
                            </div>
                        </div>
                    @endif

                    <!-- Kasus 4: Status Menunggu Validasi Akhir -->
                    @if($laporan->status === 'menunggu_validasi_akhir')
                        <div class="alert alert-warning mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-solid fa-bell fs-5 me-2"></i>
                                <strong>Menunggu Validasi</strong>
                            </div>
                            <div class="small">
                                Petugas telah menyelesaikan penanganan dan mengunggah foto sesudah. Silakan periksa hasil kerja sebelum menyelesaikan laporan.
                            </div>
                        </div>
                        <form action="{{ route('admin.laporan.validasi-akhir', $laporan->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                                <i class="fa-solid fa-check-double me-1"></i> Validasi & Selesaikan Laporan
                            </button>
                        </form>
                    @endif

                    <!-- Kasus 5: Status Selesai -->
                    @if($laporan->status === 'selesai')
                        <div class="alert alert-success mb-0">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-solid fa-circle-check fs-4 me-2"></i>
                                <strong>Laporan Telah Selesai</strong>
                            </div>
                            <div class="small text-muted">
                                Laporan ini telah divalidasi selesai oleh admin pada {{ $laporan->completed_at ? $laporan->completed_at->format('d M Y, H:i') : '-' }} WIB.
                            </div>
                        </div>
                    @endif

                    <!-- Kasus 6: Status Ditolak -->
                    @if($laporan->status === 'ditolak')
                        <div class="alert alert-danger mb-0">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-solid fa-ban fs-4 me-2"></i>
                                <strong>Laporan Ditolak</strong>
                            </div>
                            <div class="small">
                                {{ $laporan->alasan_penolakan ?? 'Laporan ini tidak memenuhi syarat untuk ditindaklanjuti.' }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Card Riwayat Status (Audit Trail) -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="m-0 fw-bold"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Riwayat Status</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($laporan->laporanStatusHistories as $history)
                        <li class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                @php
                                    $st = $history->status_sesudah ?? $history->status_baru ?? '';
                                    $badgeH = match($st) {
                                        'menunggu_verifikasi' => 'bg-warning text-dark',
                                        'diverifikasi' => 'bg-info text-white',
                                        'sedang_ditangani' => 'bg-primary text-white',
                                        'menunggu_validasi_akhir' => 'bg-secondary text-white',
                                        'selesai' => 'bg-success text-white',
                                        'ditolak' => 'bg-danger text-white',
                                        default => 'bg-dark text-white'
                                    };
                                @endphp
                                <span class="badge {{ $badgeH }} px-2 py-1 small">
                                    {{ ucwords(str_replace('_', ' ', $st)) }}
                                </span>
                                <small class="text-muted font-mono" style="font-size: 0.75rem;">
                                    {{ $history->created_at ? $history->created_at->format('d M Y, H:i') : ($history->changed_at ? $history->changed_at->format('d M Y, H:i') : '-') }}
                                </small>
                            </div>
                            <div class="small text-dark mt-1">{{ $history->keterangan }}</div>
                            <small class="d-block text-muted mt-1" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-user-pen me-1"></i> Oleh: <strong>{{ $history->user?->name ?? 'Sistem' }}</strong>
                            </small>
                        </li>
                        @empty
                        <li class="list-group-item p-3 text-center text-muted">
                            Belum ada riwayat aktivitas.
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak Laporan -->
<div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.laporan.tolak', $laporan->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="modalTolakLabel">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Tolak Laporan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="alasan_penolakan" class="form-control" rows="3" required placeholder="Tulis alasan laporan ini ditolak (misal: Alamat tidak jelas, Bukan kewenangan DLH, Foto tidak sesuai, dll)..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-ban me-1"></i> Tolak Laporan</button>
                </div>
            </div>
        </form>
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

