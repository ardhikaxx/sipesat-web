@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Edit Petugas</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.petugas.update', $petuga) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3"><label>Nama</label><input type="text" name="name" class="form-control" value="{{ $petuga->user->name ?? '' }}" required></div>
                <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $petuga->user->email ?? '' }}" required></div>
                <div class="mb-3"><label>Password (Kosongkan jika tidak diubah)</label><input type="password" name="password" class="form-control"></div>
                <div class="mb-3"><label>NIP</label><input type="text" name="nip" class="form-control" value="{{ $petuga->nip }}" required></div>
                <div class="mb-3"><label>Wilayah Tugas</label>
                    <select name="wilayah_tugas_kecamatan_id" class="form-control" required>
                        @foreach($kecamatans as $k)
                        <option value="{{ $k->id }}" {{ $petuga->wilayah_tugas_kecamatan_id == $k->id ? 'selected':'' }}>{{ $k->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3"><label>Status</label>
                    <select name="status_petugas" class="form-control">
                        <option value="aktif" {{ $petuga->status_petugas == 'aktif' ? 'selected':'' }}>Aktif</option>
                        <option value="nonaktif" {{ $petuga->status_petugas == 'nonaktif' ? 'selected':'' }}>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection