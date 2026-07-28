@extends('layouts.app')
@section('title', 'Detail Tugas - ' . $penugasan->laporanSampah->kode_laporan)

@section('content')
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
                        $laporan = $penugasan->laporanSampah;
                        $statusClass = match($laporan->status) {
                            'diverifikasi' => 'bg-info',
                            'sedang_ditangani' => 'bg-primary',
                            'menunggu_validasi_akhir' => 'bg-secondary',
                            'selesai' => 'bg-success',
                            default => 'bg-dark'
                        };
                        $statusLabel = str_replace('_', ' ', strtoupper($laporan->status));
                    @endphp
                    <span class="badge {{ $statusClass }} px-3 py-2">{{ $statusLabel }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Kategori</div>
                        <div class="col-md-8 fw-bold">{{ $laporan->kategoriSampah->nama ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Deskripsi Laporan</div>
                        <div class="col-md-8">{{ $laporan->deskripsi }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Lokasi</div>
                        <div class="col-md-8">
                            {{ $laporan->alamat_lengkap }}<br>
                            <small class="text-muted">Kecamatan: {{ $laporan->kecamatan->nama ?? '-' }}, Desa: {{ $laporan->desa->nama ?? '-' }}</small>
                        </div>
                    </div>
                    @if($laporan->foto_laporan)
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Foto dari Pelapor</div>
                        <div class="col-md-8">
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach((array)$laporan->foto_laporan as $foto)
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto Pelapor" class="img-thumbnail" style="max-width: 150px;">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Catatan Admin Penugas</div>
                        <div class="col-md-8 fw-bold text-danger">{{ $penugasan->catatan_admin ?? 'Tidak ada catatan.' }}</div>
                    </div>
                </div>
            </div>
            
            @if($laporan->dokumentasiPenanganan)
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="m-0">Dokumentasi Saya</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Foto Sebelum</h6>
                            @if($laporan->dokumentasiPenanganan->foto_sebelum)
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach((array)$laporan->dokumentasiPenanganan->foto_sebelum as $foto)
                                        <img src="{{ asset('storage/' . $foto) }}" alt="Foto Sebelum" class="img-thumbnail" style="max-width: 150px;">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted fst-italic">Belum diunggah</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Foto Sesudah</h6>
                            @if($laporan->dokumentasiPenanganan->foto_sesudah)
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach((array)$laporan->dokumentasiPenanganan->foto_sesudah as $foto)
                                        <img src="{{ asset('storage/' . $foto) }}" alt="Foto Sesudah" class="img-thumbnail" style="max-width: 150px;">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted fst-italic">Belum diunggah</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6 class="text-muted">Catatan Pekerjaan</h6>
                            <p>{{ $laporan->dokumentasiPenanganan->catatan_pekerjaan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="m-0">Update Pekerjaan</h5>
                </div>
                <div class="card-body">
                    @if(in_array($laporan->status, ['diverifikasi']))
                        <form action="{{ route('petugas.tugas.updateStatus', $penugasan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="action" value="mulai">
                            <div class="mb-3">
                                <label class="form-label">Foto Kondisi Sebelum (Opsional/Wajib)</label>
                                <input type="file" name="foto_sebelum[]" class="form-control" multiple accept="image/*" required>
                                <small class="text-muted">Unggah foto sebelum mulai bekerja.</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-play"></i> Mulai Kerjakan</button>
                        </form>
                    @elseif($laporan->status === 'sedang_ditangani')
                        <form action="{{ route('petugas.tugas.updateStatus', $penugasan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="action" value="selesai">
                            <div class="mb-3">
                                <label class="form-label">Foto Kondisi Sesudah</label>
                                <input type="file" name="foto_sesudah[]" class="form-control" multiple accept="image/*" required>
                                <small class="text-muted">Unggah foto setelah selesai bekerja.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Pekerjaan</label>
                                <textarea name="catatan_pekerjaan" class="form-control" rows="3" placeholder="Deskripsikan pekerjaan yang telah dilakukan..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-check"></i> Selesai Pekerjaan</button>
                        </form>
                    @elseif(in_array($laporan->status, ['menunggu_validasi_akhir', 'selesai']))
                        <div class="alert alert-info">
                            Pekerjaan telah selesai dan sedang/sudah divalidasi oleh Admin.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
