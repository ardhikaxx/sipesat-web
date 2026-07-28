@extends('layouts.app')
@section('title', 'Edit Petugas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Edit Petugas</h3>
        <a href="{{ route('admin.petugas.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.petugas.update', $petuga->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-user me-2"></i>Informasi Akun</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $petuga->user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $petuga->user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Password Baru (Opsional)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isi jika ingin mengubah password">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr>
                        <h6 class="fw-bold text-primary mb-3 mt-4"><i class="fa-solid fa-id-badge me-2"></i>Data Penugasan</h6>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIP Petugas <span class="text-danger">*</span></label>
                                <input type="text" name="nip" class="form-control font-mono @error('nip') is-invalid @enderror" value="{{ old('nip', $petuga->nip) }}" required>
                                @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Wilayah Tugas Utama <span class="text-danger">*</span></label>
                                <select name="wilayah_tugas_kecamatan_id" class="form-select @error('wilayah_tugas_kecamatan_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}" {{ old('wilayah_tugas_kecamatan_id', $petuga->wilayah_tugas_kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                @error('wilayah_tugas_kecamatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Aktif</label>
                            <select name="status_petugas" class="form-select">
                                <option value="aktif" {{ old('status_petugas', $petuga->status_petugas) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status_petugas', $petuga->status_petugas) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-warning text-dark fw-bold w-100"><i class="fa-solid fa-save me-2"></i>Update Data Petugas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection