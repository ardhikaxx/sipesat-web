@extends('layouts.app')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Buat Laporan Sampah Baru</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('masyarakat.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="judul_laporan" class="form-label">Judul Laporan</label>
                        <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" value="{{ old('judul_laporan') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kategori_sampah_id" class="form-label">Kategori Sampah</label>
                        <select class="form-select" id="kategori_sampah_id" name="kategori_sampah_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_sampah_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kecamatan_id" class="form-label">Kecamatan</label>
                        <select class="form-select" id="kecamatan_id" name="kecamatan_id" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="desa_id" class="form-label">Desa / Kelurahan</label>
                        <input type="number" class="form-control" id="desa_id" name="desa_id" value="{{ old('desa_id') ?? 1 }}" required placeholder="ID Desa (sementara manual)">
                        <!-- Ideally this would be dynamic via AJAX based on Kecamatan -->
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Laporan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="2" required>{{ old('alamat_lengkap') }}</textarea>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Tentukan Titik Lokasi di Peta</label>
                        <div id="map-picker" style="height: 300px; width: 100%;" class="border rounded"></div>
                        <p class="form-text text-muted">Geser marker atau klik pada peta untuk menentukan lokasi.</p>
                        
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control bg-light" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control bg-light" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="prioritas_pelapor" class="form-label">Tingkat Prioritas</label>
                        <select class="form-select" id="prioritas_pelapor" name="prioritas_pelapor" required>
                            <option value="rendah" {{ old('prioritas_pelapor') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ old('prioritas_pelapor') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ old('prioritas_pelapor') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="foto_laporan" class="form-label">Foto Laporan (Maks. 2MB)</label>
                        <input class="form-control" type="file" id="foto_laporan" name="foto_laporan" accept="image/*" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Kirim Laporan</button>
                    <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-outline-secondary px-4 ms-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var latInput = document.getElementById('latitude');
        var lngInput = document.getElementById('longitude');
        
        // Default center
        var defaultLat = latInput.value ? parseFloat(latInput.value) : -6.200000;
        var defaultLng = lngInput.value ? parseFloat(lngInput.value) : 106.816666;

        var map = L.map('map-picker').setView([defaultLat, defaultLng], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        // Update inputs on marker drag
        marker.on('dragend', function (e) {
            var position = marker.getLatLng();
            latInput.value = position.lat;
            lngInput.value = position.lng;
        });

        // Update inputs and marker on map click
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat;
            lngInput.value = e.latlng.lng;
        });
        
        // If not set yet, set them to default
        if(!latInput.value || !lngInput.value) {
            latInput.value = defaultLat;
            lngInput.value = defaultLng;
        }
    });
</script>
@endsection
