# RULE-SIPESAT.md
## Dokumen Arsitektur & Business Logic
## SIPESAT — Sistem Informasi Pengelolaan Sampah Kabupaten Magetan

> Dokumen ini adalah *single source of truth* untuk arsitektur backend, struktur database, business logic, dan alur sistem SIPESAT. Dokumen pasangannya, `design-sipesat.md`, akan memuat spesifikasi UI/UX, wireframe halaman, dan design system secara detail. Seluruh keputusan teknis pada dokumen ini menjadi acuan sebelum proses coding dimulai.

---

## 1. Informasi Umum Proyek

| Item | Keterangan |
|---|---|
| Nama Sistem | SIPESAT — Sistem Informasi Pengelolaan Sampah Kabupaten Magetan |
| Instansi Target | Diskominfo Kabupaten Magetan / Dinas Lingkungan Hidup Kabupaten Magetan |
| Jenis Aplikasi | Aplikasi pelayanan publik berbasis web (public service web app) |
| Framework | Laravel 12 (arsitektur MVC) |
| Database | MySQL |
| Frontend | Bootstrap 5 (CDN) + CSS kustom terpisah, tanpa build step (no NPM/Vite) |
| Bahasa Aplikasi | Bahasa Indonesia (seluruh UI, validasi, notifikasi, label) |
| Bahasa Kode | Nama variabel/kelas/kolom teknis dalam Bahasa Inggris, komentar boleh campuran |
| Tujuan Utama | Menjembatani pelaporan sampah oleh masyarakat, verifikasi oleh admin, dan penanganan oleh petugas lapangan secara terstruktur dan transparan |

---

## 2. Tujuan & Ruang Lingkup

SIPESAT dirancang **tidak kompleks secara teknis**, namun **lengkap secara proses bisnis**, sehingga realistis dikerjakan dalam skala proyek magang/skripsi namun tetap layak diimplementasikan secara nyata. Ruang lingkup mencakup:

1. Pelaporan sampah oleh masyarakat (dengan foto & titik koordinat).
2. Verifikasi/penolakan laporan oleh admin.
3. Penugasan petugas lapangan oleh admin.
4. Penanganan sampah oleh petugas beserta dokumentasi before/after.
5. Riwayat aktivitas penuh per laporan (audit trail transparan ke masyarakat).
6. Rating & evaluasi pelayanan oleh masyarakat.
7. Dashboard statistik & pemetaan sebaran laporan untuk admin.
8. Publikasi berita/edukasi pengelolaan sampah.

Di luar ruang lingkup versi ini (dicatat sebagai catatan pengembangan lanjutan di Bab 21): integrasi pembayaran/retribusi sampah, integrasi IoT tempat sampah pintar, aplikasi mobile native, dan multi-kabupaten/multi-tenant.

---

## 3. Tech Stack

| Layer | Teknologi | Metode Instalasi |
|---|---|---|
| Backend Framework | Laravel 12 | Composer |
| Database | MySQL 8.x | — |
| UI Framework | Bootstrap 5 | CDN |
| Icon | Font Awesome 6 | CDN |
| Notifikasi/Alert | SweetAlert2 | CDN |
| Tabel Data | DataTables (+ Buttons, Responsive extension) | CDN |
| Grafik/Chart | Chart.js | CDN |
| Peta Digital | Leaflet.js + OpenStreetMap tile | CDN |
| Font | Plus Jakarta Sans (teks UI), JetBrains Mono (kode laporan/angka) | Google Fonts CDN |
| Export PDF | `barryvdh/laravel-dompdf` | Composer |
| Export Excel | `maatwebsite/excel` | Composer |
| Upload/Image | Laravel Filesystem (`storage` disk `public`) + `intervention/image` (kompresi & watermark opsional) | Composer |
| Auth | Laravel bawaan (session-based, `auth` middleware) | — |
| Autorisasi Role | Middleware kustom `role:` (tanpa package eksternal, sederhana sesuai skala sistem) | — |

**Prinsip penting:** tidak ada proses build frontend (tidak ada `npm run build`, tidak ada Vite bundling untuk asset utama). Seluruh library frontend dipanggil langsung via tag `<script>`/`<link>` CDN di layout utama. CSS kustom disimpan sebagai file statis di `public/css/` dan dipanggil langsung tanpa compiler.

---

## 4. Role Sistem & Hak Akses

Sistem memiliki **3 role**: `masyarakat`, `admin`, `petugas`. Role disimpan sebagai tabel lookup (`roles`) yang direferensikan oleh `users.role_id`, bukan multi-role per user (satu user = satu role, sesuai kesederhanaan yang diinginkan).

| Fitur | Masyarakat | Admin | Petugas |
|---|:---:|:---:|:---:|
| Registrasi & login mandiri | ✅ | ❌ (dibuat oleh sistem/seeder) | ❌ (dibuat oleh admin) |
| Buat laporan sampah | ✅ | ❌ | ❌ |
| Lihat laporan milik sendiri | ✅ | — | — |
| Lihat seluruh laporan | ❌ | ✅ | ❌ (hanya yang ditugaskan) |
| Verifikasi/tolak laporan | ❌ | ✅ | ❌ |
| Tentukan prioritas & pilih petugas | ❌ | ✅ | ❌ |
| Ubah status penanganan lapangan | ❌ | ❌ | ✅ (hanya tugas miliknya) |
| Upload dokumentasi before/after | ❌ | ❌ | ✅ |
| Kelola data master (kategori, wilayah, petugas, berita) | ❌ | ✅ | ❌ |
| Lihat statistik & peta sebaran | ❌ | ✅ | ❌ (hanya rekap tugas sendiri) |
| Export laporan (PDF/Excel) | ❌ | ✅ | ❌ |
| Beri rating & komentar | ✅ (khusus laporan status Selesai miliknya) | ❌ | ❌ |
| Lihat log aktivitas sistem | ❌ | ✅ | ❌ |

---

## 5. Alur Bisnis End-to-End

```
[Masyarakat]                [Admin]                      [Petugas]
     │                          │                              │
Registrasi & Login              │                              │
     │                          │                              │
Buat Laporan (foto+lokasi) ─────▶ Notifikasi laporan baru        │
     │                     Cek kelengkapan data                 │
     │                          │                                │
     │                 ┌────────┴────────┐                     │
     │            Tidak Valid        Valid                     │
     │                 │                │                       │
     │◀── Status: Ditolak        Set prioritas + pilih petugas   │
     │    (+alasan)               │                             │
     │                     Status: Diverifikasi ─────────────────▶ Notifikasi tugas baru
     │                          │                          Buka detail & lokasi (peta)
     │                          │                          Menuju lokasi
     │                          │                          Status: Sedang Ditangani
     │                          │                          + Upload foto SEBELUM
     │                          │                          Bersihkan sampah
     │                          │                          + Upload foto SESUDAH
     │                          │                          + Catatan pekerjaan
     │◀─────────────────────────┼──────────────────────── Status: Selesai
Notifikasi laporan selesai      │                              │
Lihat histori & dokumentasi     │                              │
Beri Rating & Komentar ─────────▶ (tersimpan untuk evaluasi)     │
```

Setiap perpindahan status **wajib** menulis 1 baris baru ke tabel `laporan_status_histories` (lihat Bab 7.6) agar riwayat aktivitas laporan selalu lengkap dan dapat ditelusuri oleh masyarakat maupun admin.

---

## 6. State Machine Status Laporan

Kolom `laporan_sampah.status` menggunakan enum dengan transisi yang **dibatasi ketat** (tidak boleh loncat status):

| Status | Kode Enum | Dipicu Oleh | Bisa Menuju |
|---|---|---|---|
| Menunggu Verifikasi | `menunggu_verifikasi` | Sistem, otomatis saat laporan dibuat masyarakat | `ditolak`, `diverifikasi` |
| Ditolak | `ditolak` | Admin | *(status akhir, tidak bisa berubah lagi)* |
| Diverifikasi | `diverifikasi` | Admin (setelah pilih petugas & prioritas) | `sedang_ditangani` |
| Sedang Ditangani | `sedang_ditangani` | Petugas (saat tiba di lokasi) | `selesai` |
| Selesai | `selesai` | Petugas (setelah upload dokumentasi akhir) | *(status akhir, membuka form rating untuk masyarakat)* |

Aturan validasi transisi status **wajib divalidasi di level Service/Controller**, bukan hanya di database, contoh (`app/Services/LaporanStatusService.php`):

```php
private array $allowedTransitions = [
    'menunggu_verifikasi' => ['ditolak', 'diverifikasi'],
    'diverifikasi'        => ['sedang_ditangani'],
    'sedang_ditangani'    => ['selesai'],
    'ditolak'             => [],
    'selesai'             => [],
];
```

Setiap kali status berubah lewat service ini: (1) update `laporan_sampah.status`, (2) insert `laporan_status_histories`, (3) insert `notifikasi` untuk pihak terkait, (4) tulis `activity_logs` bila dipicu admin/petugas.

---

## 7. Struktur Database (ERD Lengkap)

### 7.1 `roles`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| name | string(20) unique | `masyarakat`, `admin`, `petugas` |
| label | string(50) | Label tampilan, mis. "Petugas Lapangan" |
| timestamps | | |

### 7.2 `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| role_id | bigint FK → roles | |
| name | string(150) | |
| nik | string(16) nullable unique | Opsional sesuai kebutuhan verifikasi |
| email | string unique | |
| phone | string(15) | |
| password | string (hashed) | |
| address | text | Alamat tempat tinggal (khusus masyarakat) |
| kecamatan_id | bigint FK → kecamatan, nullable | |
| desa_id | bigint FK → desa, nullable | |
| photo | string nullable | Path foto profil |
| is_active | boolean default true | Nonaktifkan tanpa hapus akun |
| email_verified_at | timestamp nullable | |
| remember_token | string nullable | |
| timestamps | | |

### 7.3 `kecamatan`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| kode_kecamatan | string(10) | Kode wilayah Kemendagri, mis. `35.20.06` |
| nama_kecamatan | string(100) | |
| timestamps | | |

### 7.4 `desa`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| kecamatan_id | bigint FK → kecamatan | |
| nama_desa | string(100) | |
| timestamps | | |

### 7.5 `kategori_sampah`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| nama_kategori | string(100) | mis. Sampah Rumah Tangga, Sampah Liar/Ilegal, Sampah Sungai, Limbah B3 Ringan, Sampah Pasar |
| deskripsi | text nullable | |
| icon | string(50) nullable | Class Font Awesome |
| is_active | boolean default true | |
| timestamps | | |

### 7.6 `laporan_sampah`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| kode_laporan | string(20) unique | Format `SPT-YYYYMMDD-XXXX`, generate via Service |
| user_id | bigint FK → users | Pelapor |
| kategori_sampah_id | bigint FK → kategori_sampah | |
| kecamatan_id | bigint FK → kecamatan | |
| desa_id | bigint FK → desa | |
| judul_laporan | string(150) | |
| deskripsi | text | |
| alamat_lengkap | text | |
| latitude | decimal(10,7) | Dari peta digital (Leaflet) |
| longitude | decimal(10,7) | |
| foto_laporan | json | Array path foto (1–5 foto) |
| prioritas_pelapor | enum | `rendah`, `sedang`, `tinggi` |
| prioritas_admin | enum nullable | `rendah`, `sedang`, `tinggi`, `darurat` — diisi admin saat verifikasi |
| status | enum | `menunggu_verifikasi`, `ditolak`, `diverifikasi`, `sedang_ditangani`, `selesai` (default `menunggu_verifikasi`) |
| alasan_penolakan | text nullable | |
| verified_by | bigint FK → users nullable | Admin yang memverifikasi |
| verified_at | timestamp nullable | |
| completed_at | timestamp nullable | Waktu status menjadi Selesai |
| timestamps | | |

### 7.7 `petugas`
Data tambahan spesifik untuk user berrole `petugas` (relasi 1-ke-1 dengan `users`).

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| user_id | bigint FK → users unique | |
| nip | string(30) nullable | |
| wilayah_tugas_kecamatan_id | bigint FK → kecamatan, nullable | Wilayah default penugasan |
| status_petugas | enum | `aktif`, `nonaktif`, default `aktif` |
| timestamps | | |

### 7.8 `penugasan`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| laporan_sampah_id | bigint FK → laporan_sampah unique | Satu laporan = satu penugasan aktif |
| petugas_id | bigint FK → petugas | |
| assigned_by | bigint FK → users | Admin yang menugaskan |
| catatan_admin | text nullable | Instruksi tambahan dari admin |
| assigned_at | timestamp | |
| timestamps | | |

### 7.9 `dokumentasi_penanganan`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| laporan_sampah_id | bigint FK → laporan_sampah | |
| petugas_id | bigint FK → petugas | |
| foto_sebelum | json | Array path foto kondisi awal |
| foto_sesudah | json nullable | Array path foto kondisi akhir (diisi saat selesai) |
| catatan_pekerjaan | text nullable | |
| waktu_mulai | timestamp nullable | Saat status → Sedang Ditangani |
| waktu_selesai | timestamp nullable | Saat status → Selesai |
| timestamps | | |

### 7.10 `laporan_status_histories`
Tabel inti untuk **riwayat aktivitas transparan** yang dilihat masyarakat pada halaman detail laporan.

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| laporan_sampah_id | bigint FK → laporan_sampah | |
| status_sebelum | string(30) nullable | |
| status_sesudah | string(30) | |
| keterangan | text nullable | Catatan otomatis/manual, mis. "Ditugaskan kepada Budi Santoso" |
| changed_by | bigint FK → users | |
| changed_at | timestamp | |
| timestamps | | |

### 7.11 `rating`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| laporan_sampah_id | bigint FK → laporan_sampah unique | Hanya bisa rating 1x per laporan |
| user_id | bigint FK → users | Pelapor |
| rating | tinyint | 1–5 |
| komentar | text nullable | |
| timestamps | | |

### 7.12 `berita`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| judul | string(200) | |
| slug | string(220) unique | |
| thumbnail | string nullable | |
| konten | longtext | |
| kategori | enum | `edukasi`, `pengumuman`, `kegiatan` |
| penulis_id | bigint FK → users | Admin |
| status | enum | `draft`, `published` |
| tanggal_publish | timestamp nullable | |
| views | int default 0 | |
| timestamps | | |

### 7.13 `notifikasi`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| user_id | bigint FK → users | Penerima |
| laporan_sampah_id | bigint FK → laporan_sampah nullable | |
| judul | string(150) | |
| pesan | text | |
| tipe | enum | `laporan_baru`, `verifikasi`, `penolakan`, `penugasan`, `status_update`, `rating_masuk` |
| is_read | boolean default false | |
| read_at | timestamp nullable | |
| timestamps | | |

### 7.14 `activity_logs`
Log audit **tindakan admin & petugas** terhadap data sistem (berbeda dengan `laporan_status_histories` yang khusus riwayat status laporan untuk konsumsi publik).

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| user_id | bigint FK → users | Pelaku |
| aktivitas | string(150) | mis. "Menghapus kategori sampah" |
| modul | string(50) | mis. `kategori_sampah`, `petugas`, `berita` |
| deskripsi | text nullable | |
| ip_address | string(45) nullable | |
| user_agent | string nullable | |
| created_at | timestamp | |

### 7.15 Diagram Relasi (ringkas)

```
roles 1──n users
users n──1 kecamatan / desa (alamat masyarakat)
kecamatan 1──n desa
users 1──1 petugas
petugas n──1 kecamatan (wilayah_tugas)

users 1──n laporan_sampah (sebagai pelapor)
kategori_sampah 1──n laporan_sampah
kecamatan/desa 1──n laporan_sampah

laporan_sampah 1──1 penugasan ──n──1 petugas
laporan_sampah 1──1 dokumentasi_penanganan
laporan_sampah 1──n laporan_status_histories
laporan_sampah 1──1 rating
laporan_sampah 1──n notifikasi (opsional relasi)

users 1──n berita (sebagai penulis)
users 1──n notifikasi (sebagai penerima)
users 1──n activity_logs (sebagai pelaku)
```

---

## 8. Struktur Folder Aplikasi Laravel

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                       # Login, Register, Logout
│   │   ├── Masyarakat/
│   │   │   ├── DashboardController.php
│   │   │   ├── LaporanController.php
│   │   │   ├── RatingController.php
│   │   │   └── ProfilController.php
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── VerifikasiLaporanController.php
│   │   │   ├── PenugasanController.php
│   │   │   ├── MonitoringController.php
│   │   │   ├── StatistikController.php
│   │   │   ├── ExportController.php
│   │   │   ├── KategoriSampahController.php
│   │   │   ├── WilayahController.php       # kecamatan & desa
│   │   │   ├── PetugasController.php
│   │   │   ├── MasyarakatController.php
│   │   │   ├── BeritaController.php
│   │   │   └── ActivityLogController.php
│   │   └── Petugas/
│   │       ├── DashboardController.php
│   │       ├── TugasController.php
│   │       └── RiwayatController.php
│   ├── Middleware/
│   │   ├── RoleMiddleware.php           # role:admin|petugas|masyarakat
│   │   └── EnsureAccountActive.php      # cek is_active
│   └── Requests/
│       ├── StoreLaporanRequest.php
│       ├── VerifikasiLaporanRequest.php
│       ├── PenugasanRequest.php
│       ├── UpdatePenangananRequest.php
│       └── RatingRequest.php
├── Models/
│   ├── User.php
│   ├── Role.php
│   ├── Kecamatan.php
│   ├── Desa.php
│   ├── KategoriSampah.php
│   ├── LaporanSampah.php
│   ├── Petugas.php
│   ├── Penugasan.php
│   ├── DokumentasiPenanganan.php
│   ├── LaporanStatusHistory.php
│   ├── Rating.php
│   ├── Berita.php
│   ├── Notifikasi.php
│   └── ActivityLog.php
├── Services/
│   ├── LaporanStatusService.php         # state machine + histori + notifikasi
│   ├── KodeLaporanGenerator.php
│   ├── NotifikasiService.php
│   └── ActivityLogService.php
└── Exports/
    └── LaporanExport.php                # maatwebsite/excel

resources/views/
├── layouts/
│   ├── app.blade.php                    # layout master (navbar, sidebar per role)
│   ├── guest.blade.php                  # layout login/register/landing
│   └── partials/ (navbar, sidebar, footer, alerts)
├── auth/
├── masyarakat/ (dashboard, laporan/{index,create,show}, rating, profil)
├── admin/ (dashboard, verifikasi, penugasan, monitoring, statistik, master/*, berita, log)
├── petugas/ (dashboard, tugas/{index,show}, riwayat)
└── components/ (peta-picker, upload-foto, status-badge, timeline-riwayat)

public/
├── css/ (app.css, style kustom per modul bila perlu)
├── js/ (app.js, peta.js, chart-dashboard.js)
└── storage → symlink ke storage/app/public

storage/app/public/
├── laporan/          # foto laporan masyarakat
├── penanganan/       # foto sebelum & sesudah petugas
├── berita/           # thumbnail berita
└── profil/           # foto profil user
```

---

## 9. Routing & Middleware

Seluruh route dikelompokkan per-role dengan prefix dan middleware konsisten:

```php
// routes/web.php

Route::middleware('guest')->group(function () {
    // login, register, landing page publik (berita, alur pelaporan)
});

Route::middleware(['auth', 'active'])->group(function () {

    Route::prefix('masyarakat')->middleware('role:masyarakat')->name('masyarakat.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('laporan', LaporanController::class)->only(['index','create','store','show']);
        Route::post('laporan/{laporan}/rating', [RatingController::class, 'store'])->name('rating.store');
        Route::get('profil', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('profil', [ProfilController::class, 'update'])->name('profil.update');
    });

    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('laporan', [VerifikasiLaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/{laporan}', [VerifikasiLaporanController::class, 'show'])->name('laporan.show');
        Route::post('laporan/{laporan}/verifikasi', [VerifikasiLaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
        Route::post('laporan/{laporan}/tolak', [VerifikasiLaporanController::class, 'tolak'])->name('laporan.tolak');
        Route::post('laporan/{laporan}/tugaskan', [PenugasanController::class, 'store'])->name('laporan.tugaskan');
        Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('statistik', [StatistikController::class, 'index'])->name('statistik.index');
        Route::get('export/{type}', [ExportController::class, 'export'])->name('export');
        Route::resource('kategori-sampah', KategoriSampahController::class);
        Route::resource('kecamatan', WilayahController::class); // + nested desa
        Route::resource('petugas', PetugasController::class);
        Route::resource('masyarakat', MasyarakatController::class)->only(['index','show','update']);
        Route::resource('berita', BeritaController::class);
        Route::get('log-aktivitas', [ActivityLogController::class, 'index'])->name('log.index');
    });

    Route::prefix('petugas')->middleware('role:petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('tugas', [TugasController::class, 'index'])->name('tugas.index');
        Route::get('tugas/{laporan}', [TugasController::class, 'show'])->name('tugas.show');
        Route::post('tugas/{laporan}/mulai', [TugasController::class, 'mulai'])->name('tugas.mulai');
        Route::post('tugas/{laporan}/selesai', [TugasController::class, 'selesai'])->name('tugas.selesai');
        Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    });

    Route::get('notifikasi/{id}/baca', [NotifikasiController::class, 'markRead'])->name('notifikasi.baca');
});
```

`RoleMiddleware` menolak akses dengan `abort(403)` jika `auth()->user()->role->name` tidak sesuai daftar role yang diizinkan pada parameter middleware. Setiap controller wajib memverifikasi kepemilikan data (mis. petugas hanya bisa membuka `tugas/{laporan}` yang memang ditugaskan padanya — dicek via query `whereHas('penugasan', fn($q) => $q->where('petugas_id', ...))`, bukan hanya via route model binding polos).

---

## 10. Modul Sistem (Detail per Role)

### 10.1 Modul Autentikasi
- Registrasi masyarakat: nama, NIK (opsional), email, no. telepon, password (+konfirmasi), alamat, kecamatan, desa.
- Validasi email & NIK unik, password minimal 8 karakter dengan konfirmasi.
- Login berbasis email + password, redirect otomatis sesuai role setelah login (`masyarakat.dashboard` / `admin.dashboard` / `petugas.dashboard`).
- Akun admin & petugas **tidak melalui registrasi publik** — dibuat oleh admin lewat modul Manajemen Petugas atau seeder awal.
- Lupa password via reset link email (fitur standar Laravel).

### 10.2 Modul Dashboard (berbeda per role)
**Masyarakat:** ringkasan jumlah laporan (total, menunggu, diproses, selesai), daftar 5 laporan terbaru, notifikasi terbaru.
**Admin:** kartu ringkasan (laporan masuk hari ini, menunggu verifikasi, sedang ditangani, selesai, ditolak, total masyarakat, total petugas aktif), grafik laporan bulanan, grafik kategori sampah, grafik wilayah terbanyak, peta sebaran seluruh laporan (marker berwarna sesuai status).
**Petugas:** jumlah tugas baru, sedang dikerjakan, selesai; daftar tugas terbaru dengan tombol aksi cepat.

### 10.3 Modul Pelaporan Sampah (Masyarakat)
Form input: judul, kategori sampah (dropdown), deskripsi, alamat lengkap, kecamatan & desa (dropdown berjenjang via AJAX), titik koordinat (klik pada peta Leaflet, lat/lng otomatis terisi + tombol "gunakan lokasi saya" via Geolocation API browser), upload 1–5 foto (validasi tipe jpg/png, maks 2MB per foto), prioritas menurut pelapor. Setelah submit → status `menunggu_verifikasi`, insert histori status pertama, insert notifikasi ke semua admin aktif.

### 10.4 Modul Verifikasi Laporan (Admin)
Daftar laporan masuk (DataTables, filter status). Halaman detail menampilkan seluruh data laporan + foto + peta lokasi. Dua aksi utama:
- **Tolak**: wajib isi alasan penolakan (textarea, min. 10 karakter) → status `ditolak`, notifikasi ke pelapor.
- **Verifikasi**: pilih prioritas_admin (`rendah`/`sedang`/`tinggi`/`darurat`) dan pilih petugas dari dropdown (difilter berdasarkan wilayah tugas & status_petugas `aktif`) → status `diverifikasi`, insert `penugasan`, notifikasi ke petugas terpilih.

### 10.5 Modul Penugasan Petugas (Admin)
Bagian dari alur verifikasi (Bab 10.4), namun juga tersedia halaman terpisah untuk melihat beban kerja tiap petugas (jumlah tugas aktif) sebagai bantuan keputusan sebelum memilih petugas, guna menghindari penumpukan tugas pada satu petugas saja.

### 10.6 Modul Penanganan Lapangan (Petugas)
Daftar tugas (DataTables sederhana, filter status). Detail tugas menampilkan info laporan + tombol buka lokasi di Google Maps/Leaflet (link `geo:` atau embed peta). Dua aksi bertahap:
- **Mulai Penanganan**: upload foto sebelum (1–3 foto) → status `sedang_ditangani`, catat `waktu_mulai`.
- **Selesaikan Penanganan**: upload foto sesudah (1–3 foto), isi catatan pekerjaan → status `selesai`, catat `waktu_selesai` & `completed_at`, notifikasi ke pelapor (memicu form rating muncul di sisi masyarakat).

### 10.7 Modul Monitoring Laporan (Admin)
Tabel DataTables seluruh laporan dengan filter kombinasi: status, kategori, kecamatan, desa, petugas, rentang tanggal. Kolom aksi: lihat detail, lihat riwayat status. Mendukung pencarian bebas, sorting semua kolom, pagination, dan export langsung dari hasil filter aktif.

### 10.8 Modul Manajemen Data Master (Admin)
CRUD lengkap untuk: Kategori Sampah, Kecamatan & Desa (nested, desa mengikuti kecamatan terpilih), Petugas (buat akun user role `petugas` + data tambahan tabel `petugas` dalam satu form), Masyarakat (lihat & nonaktifkan akun bila perlu — tanpa hapus data demi integrasi histori laporan), Berita/Edukasi.

### 10.9 Modul Berita & Edukasi
CRUD berita dengan editor teks (bisa pakai textarea + sedikit formatting, tanpa WYSIWYG berat agar tetap CDN-only — gunakan Quill.js via CDN sebagai opsi ringan bila diperlukan). Status draft/published, tampil di halaman publik/landing page dan dashboard masyarakat sebagai bahan edukasi pengelolaan sampah.

### 10.10 Modul Profil Pengguna
Setiap role dapat mengubah data profil dasar (nama, telepon, foto, alamat/wilayah untuk masyarakat) dan ganti password (wajib isi password lama untuk validasi).

### 10.11 Modul Notifikasi
Notifikasi in-app (bell icon di navbar, badge jumlah belum dibaca, dropdown daftar notifikasi terbaru, halaman "semua notifikasi"). Trigger otomatis pada: laporan baru (ke admin), laporan ditolak (ke pelapor), laporan diverifikasi/ditugaskan (ke pelapor & petugas), status berubah (ke pelapor), rating masuk (ke admin, opsional untuk evaluasi).

### 10.12 Modul Rating Pelayanan
Form rating (1–5 bintang via komponen Bootstrap/Font Awesome star icon) + komentar, hanya muncul pada laporan berstatus `selesai` milik masyarakat yang bersangkutan dan belum pernah dinilai (dicek unique constraint `laporan_sampah_id` pada tabel `rating`).

### 10.13 Modul Statistik Dashboard (Admin)
Chart.js: (1) bar chart laporan masuk per bulan (12 bulan terakhir), (2) line chart tren penyelesaian laporan, (3) pie/doughnut chart proporsi kategori sampah, (4) bar chart horizontal wilayah (kecamatan) dengan laporan terbanyak, (5) bar chart petugas paling aktif menyelesaikan tugas, (6) angka rata-rata waktu penyelesaian (dari `diverifikasi` hingga `selesai`, dihitung dalam jam/hari).

### 10.14 Modul Export Laporan (Admin)
Export ke PDF (`barryvdh/laravel-dompdf`, layout tabel rapi dengan header instansi) dan Excel (`maatwebsite/excel`) berdasarkan filter aktif dari Modul Monitoring: rentang tanggal, kecamatan, kategori, status, petugas.

### 10.15 Modul Log Aktivitas (Admin)
Tabel `activity_logs` ditampilkan read-only dengan DataTables, filter per user & per modul, untuk transparansi siapa mengubah data master/keputusan verifikasi dan kapan.

---

## 11. Spesifikasi Fitur Peta

- Library: **Leaflet.js** (CDN) + tile OpenStreetMap (gratis, tanpa API key) sebagai default. Google Maps dapat menjadi opsi tambahan bila instansi memiliki API key sendiri (tautan "buka di Google Maps" cukup memakai URL `https://www.google.com/maps?q={lat},{lng}`).
- **Form Laporan (Masyarakat):** peta interaktif, klik untuk menandai titik lokasi, marker dapat digeser, tombol "Gunakan Lokasi Saya" memakai `navigator.geolocation`, koordinat otomatis mengisi input `latitude`/`longitude` (hidden input, readonly, tervalidasi server-side agar tidak dapat dimanipulasi lewat DevTools tanpa batas wajar wilayah Magetan).
- **Dashboard Admin:** peta sebaran seluruh laporan aktif dengan marker berwarna sesuai status (kuning = menunggu, biru = diverifikasi, oranye = sedang ditangani, hijau = selesai, abu-abu = ditolak), popup info singkat saat marker diklik.
- **Detail Tugas Petugas:** peta kecil menampilkan titik lokasi laporan + tombol buka rute navigasi eksternal.

---

## 12. Sistem Notifikasi (Ringkasan Teknis)

`NotifikasiService::kirim(User $user, string $tipe, string $judul, string $pesan, ?LaporanSampah $laporan = null)` dipanggil dari dalam `LaporanStatusService` setiap kali terjadi perubahan status atau aksi terkait (verifikasi, penolakan, penugasan). Notifikasi bersifat in-app (disimpan di tabel `notifikasi`, dibaca via badge navbar + polling/refresh sederhana). Pengiriman email sebagai *nice-to-have* opsional (queue Laravel `Mail`), tidak wajib pada versi awal agar scope tetap realistis.

---

## 13. Validasi Form (Aturan Penting per Modul)

| Form | Aturan Kunci |
|---|---|
| Registrasi | email unik, NIK unik jika diisi (16 digit numerik), password min 8 + confirmed |
| Buat Laporan | kategori/kecamatan/desa wajib ada di database (exists rule), foto wajib min. 1 maks. 5 (mimes:jpg,jpeg,png, max:2048 KB), latitude/longitude wajib numerik dalam rentang wilayah Jawa Timur sebagai sanity check |
| Tolak Laporan | alasan_penolakan wajib, min 10 karakter |
| Verifikasi Laporan | prioritas_admin wajib salah satu enum, petugas_id wajib exists & status_petugas aktif |
| Mulai Penanganan | foto_sebelum wajib min. 1 |
| Selesai Penanganan | foto_sesudah wajib min. 1, catatan_pekerjaan wajib diisi |
| Rating | rating wajib 1–5, hanya boleh sekali per laporan (validasi unique + cek status selesai & kepemilikan) |
| CRUD Data Master | nama unik per tabel relevan (mis. nama_kategori unik), validasi relasi kecamatan-desa berjenjang |

Seluruh validasi menggunakan Laravel Form Request class terpisah (lihat struktur folder Bab 8) agar controller tetap ramping, dengan pesan error kustom berbahasa Indonesia.

---

## 14. Keamanan Sistem

- Middleware `auth` + `role:` pada seluruh route non-publik; setiap controller memvalidasi kepemilikan data (bukan hanya route model binding) sebelum mengizinkan aksi, khususnya pada modul Petugas (tugas milik sendiri) dan Masyarakat (laporan & rating milik sendiri).
- CSRF protection bawaan Laravel (`@csrf` di semua form).
- Validasi tipe & ukuran file upload di server-side (bukan hanya JS) untuk mencegah upload file berbahaya.
- Password di-hash dengan bcrypt (default Laravel), tidak pernah disimpan/ditampilkan plain text.
- Rate limiting pada route login/registrasi (`throttle` middleware) untuk mencegah brute force.
- Log aktivitas mencatat IP & user agent setiap aksi sensitif admin (hapus/ubah data master, tolak laporan).
- Akun masyarakat/petugas yang dinonaktifkan (`is_active = false`) otomatis ditolak saat login via middleware `EnsureAccountActive`.

---

## 15. Seeder & Data Awal

- **RoleSeeder**: `masyarakat`, `admin`, `petugas`.
- **KecamatanSeeder**: 18 kecamatan riil Kabupaten Magetan — Poncol, Parang, Lembeyan, Takeran, Kawedanan, Magetan, Plaosan, Panekan, Sukomoro, Bendo, Barat, Karangrejo, Karas, Kartoharjo, Ngariboyo, Nguntoronadi, Maospati, Sidorejo (beserta kode wilayah Kemendagri, mis. `35.20.06` untuk Magetan).
- **DesaSeeder**: minimal beberapa desa/kelurahan representatif per kecamatan untuk kebutuhan development/demo (data lengkap 207 desa + 28 kelurahan dapat ditambahkan bertahap dari data resmi BPS/Pemkab Magetan saat implementasi produksi).
- **KategoriSampahSeeder**: Sampah Rumah Tangga, Sampah Liar/Pembuangan Ilegal, Sampah Sungai/Saluran Air, Sampah Pasar, Limbah B3 Ringan (mis. baterai, elektronik kecil).
- **AdminSeeder**: 1 akun admin default untuk akses awal sistem.
- **PetugasSeeder**: beberapa akun petugas contoh tersebar di beberapa wilayah untuk kebutuhan testing alur penugasan.

---

## 16. Environment & Konfigurasi Tambahan

```
APP_NAME="SIPESAT - Kabupaten Magetan"
APP_LOCALE=id
DB_CONNECTION=mysql
FILESYSTEM_DISK=public
MAIL_MAILER=log   # cukup log di tahap awal, upgrade ke smtp bila notifikasi email diaktifkan
```

`config/sipesat.php` (file konfigurasi kustom) menyimpan konstanta aplikasi: daftar status laporan, daftar prioritas, batas ukuran/format upload foto, agar tidak hardcode berulang di banyak tempat.

---

## 17. Checklist Acceptance Criteria (Ringkas)

- [ ] Masyarakat dapat registrasi, login, dan membuat laporan lengkap dengan foto + titik peta.
- [ ] Laporan baru otomatis berstatus Menunggu Verifikasi dan admin menerima notifikasi.
- [ ] Admin dapat menolak (dengan alasan) atau memverifikasi (dengan prioritas + pilih petugas) setiap laporan.
- [ ] Petugas hanya melihat & dapat mengubah status tugas yang ditugaskan kepadanya.
- [ ] Setiap perubahan status tercatat di `laporan_status_histories` dan tampil sebagai timeline di halaman detail laporan milik masyarakat.
- [ ] Masyarakat dapat memberi rating & komentar hanya pada laporan berstatus Selesai miliknya, maksimal satu kali.
- [ ] Dashboard admin menampilkan kartu ringkasan, minimal 4 jenis grafik Chart.js, dan peta sebaran laporan.
- [ ] Seluruh tabel data (monitoring, master data) memakai DataTables dengan search, sort, pagination, export.
- [ ] Admin dapat export laporan ke PDF & Excel sesuai filter aktif.
- [ ] Seluruh notifikasi berhasil/gagal/konfirmasi memakai SweetAlert2.
- [ ] Log aktivitas mencatat seluruh aksi sensitif admin.

---

## 18. Catatan Pengembangan Lanjutan (Di Luar Scope Awal)

- Integrasi retribusi/pembayaran layanan sampah.
- Integrasi sensor IoT tempat sampah pintar (level kapasitas otomatis).
- Aplikasi mobile native untuk petugas lapangan (saat ini cukup web responsif).
- Notifikasi push/WhatsApp Gateway selain in-app & email.
- Multi-kabupaten/multi-tenant bila direplikasi ke daerah lain.
- Data desa/kelurahan lengkap (207 desa + 28 kelurahan) dari sumber resmi BPS/Permendagri untuk produksi.

---

## 19. Dokumen Terkait

Dokumen pasangan `design-sipesat.md` (belum dibuat) akan mencakup: design system lengkap (palet warna — disarankan hijau/teal sebagai identitas lingkungan hidup, tipografi Plus Jakarta Sans + JetBrains Mono, komponen UI), wireframe seluruh halaman per role, spesifikasi komponen peta & upload foto, serta style panduan status badge (warna per status laporan).
