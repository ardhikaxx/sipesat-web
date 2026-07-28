@extends('layouts.app')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet Geocoder CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<style>
    .upload-drop-zone {
        border: 2px dashed var(--color-border, #E2E5E1);
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background-color: var(--color-bg, #F6F7F5);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    .upload-drop-zone.dragover {
        border-color: var(--color-primary, #1F6E43);
        background-color: var(--color-primary-light, #E8F3EC);
    }
    .upload-drop-zone i {
        font-size: 3rem;
        color: var(--color-muted, #6B7280);
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }
    .upload-drop-zone.dragover i {
        color: var(--color-primary, #1F6E43);
    }
    .upload-drop-zone input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }
    #image-preview {
        display: none;
        margin-top: 15px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--color-border, #E2E5E1);
    }
    #image-preview img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 0, 0, 0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
    }
</style>

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
                    <div class="col-md-12 mb-3">
                        <div class="d-flex justify-content-between align-items-end mb-2">
                            <label class="form-label mb-0">Tentukan Titik Lokasi di Peta</label>
                            <button type="button" class="btn btn-sm btn-outline-success" id="btn-current-location">
                                <i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini
                            </button>
                        </div>
                        <div id="map-picker" style="height: 350px; width: 100%; z-index: 1;" class="border rounded shadow-sm"></div>
                        <p class="form-text text-muted">Geser marker, klik pada peta, gunakan fitur pencarian (kaca pembesar), atau deteksi lokasi otomatis.</p>
                        
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
                        <label class="form-label">Foto Laporan (Maks. 2MB)</label>
                        <div class="upload-drop-zone" id="drop-zone">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <h6 class="fw-bold text-dark">Seret & Lepas Foto di sini</h6>
                            <p class="text-muted small mb-0">atau klik untuk menelusuri (PNG, JPG, JPEG)</p>
                            <input type="file" id="foto_laporan" name="foto_laporan" accept="image/png, image/jpeg, image/jpg" required>
                        </div>
                        
                        <div id="image-preview" class="position-relative">
                            <button type="button" class="remove-image" id="remove-btn" title="Hapus Foto"><i class="fa-solid fa-xmark"></i></button>
                            <img src="" id="preview-img" alt="Preview">
                        </div>
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

<!-- Leaflet JS & Geocoder -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var latInput = document.getElementById('latitude');
        var lngInput = document.getElementById('longitude');
        
        // Default center ke Magetan
        var defaultLat = latInput.value ? parseFloat(latInput.value) : -7.6531;
        var defaultLng = lngInput.value ? parseFloat(lngInput.value) : 111.3284;

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

        // Fitur 1: Pencarian Alamat (Geocoder)
        L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: 'Cari nama tempat / jalan...'
        }).on('markgeocode', function(e) {
            var bbox = e.geocode.bbox;
            var poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]);
            map.fitBounds(poly.getBounds());
            
            var latlng = e.geocode.center;
            marker.setLatLng(latlng);
            latInput.value = latlng.lat;
            lngInput.value = latlng.lng;
            
            // Auto-fill alamat jika masih kosong
            var alamatInput = document.getElementById('alamat_lengkap');
            if (!alamatInput.value) {
                alamatInput.value = e.geocode.name;
            }
        }).addTo(map);

        // Fitur 2: Gunakan Lokasi Saat Ini (GPS)
        document.getElementById('btn-current-location').addEventListener('click', function() {
            var btn = this;
            if (navigator.geolocation) {
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mencari lokasi...';
                btn.disabled = true;
                
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    latInput.value = lat;
                    lngInput.value = lng;
                    
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Lokasi Ditemukan';
                    btn.classList.replace('btn-outline-success', 'btn-success');
                    
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';
                        btn.classList.replace('btn-success', 'btn-outline-success');
                        btn.disabled = false;
                    }, 3000);
                }, function(error) {
                    alert('Gagal mendapatkan lokasi. Pastikan izin lokasi (GPS) diaktifkan di browser/HP Anda.');
                    btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';
                    btn.disabled = false;
                });
            } else {
                alert('Browser Anda tidak mendukung fitur lokasi GPS.');
            }
        });
    });
    
    // JS for Drag and Drop Image Uploader
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('foto_laporan');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const removeBtn = document.getElementById('remove-btn');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('dragover');
    }

    function unhighlight(e) {
        dropZone.classList.remove('dragover');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            fileInput.files = files; // Assign files to input
            handleFiles(files[0]);
        }
    }
    
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFiles(this.files[0]);
        }
    });

    function handleFiles(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                previewImg.src = reader.result;
                imagePreview.style.display = 'block';
                dropZone.style.display = 'none';
            }
        } else {
            alert('Harap unggah file berupa gambar (PNG/JPG).');
            resetUpload();
        }
    }
    
    removeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        resetUpload();
    });
    
    function resetUpload() {
        fileInput.value = "";
        imagePreview.style.display = 'none';
        previewImg.src = "";
        dropZone.style.display = 'block';
    }
</script>
@endsection
