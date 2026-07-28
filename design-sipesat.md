# DESIGN-SIPESAT.md
## Spesifikasi UI/UX & Design System
## SIPESAT — Sistem Informasi Pengelolaan Sampah Kabupaten Magetan

> Dokumen pasangan dari `rule-sipesat.md`. Memuat arah desain, design token, komponen UI, wireframe seluruh halaman per role, serta panduan microcopy. Menjadi acuan visual sebelum implementasi Blade + Bootstrap 5 dimulai.

---

## 1. Filosofi & Arah Desain

SIPESAT adalah aplikasi **layanan publik pemerintah daerah**, bukan produk konsumen komersial — desainnya harus terasa **tepercaya, bersih, dan tenang**, bukan mencolok. Namun tetap harus punya identitas yang jelas, bukan template admin-panel generik.

Dua hal dijadikan jangkar identitas visual:

1. **Isu lingkungan/kebersihan** — sistem ini soal sampah dan kebersihan lingkungan, sehingga hijau adalah pilihan yang jujur, bukan hijau generik "eco startup", melainkan hijau yang tenang seperti hutan/perbukitan.
2. **Konteks lokal Magetan** — Magetan dikenal dengan Telaga Sarangan (danau vulkanik di lereng Gunung Lawu) dan udara pegunungan yang sejuk. Palet warna diberi nama dari elemen lokal ini (Hijau Sarangan, Biru Telaga) agar terasa spesifik milik Magetan, bukan template yang bisa dipakai kabupaten mana pun.

**Elemen signature:** peta sebaran laporan dengan marker berwarna status (Bab 10.3 pada `rule-sipesat.md`) adalah elemen visual yang paling diingat — bukan dekorasi, tapi benar-benar merepresentasikan kondisi kebersihan wilayah secara real-time. Seluruh elemen dekoratif lain dibuat tenang dan disiplin agar peta ini yang menonjol.

**Yang dihindari secara sadar:** gradient hijau-ke-biru generik ala "eco app", ilustrasi flat generic (orang membuang sampah dengan gaya stok ilustrasi), dan tampilan admin-panel gelap bergaya SaaS modern yang terasa asing untuk konteks pelayanan publik desa/kecamatan.

---

## 2. Design Tokens

### 2.1 Palet Warna

| Nama | Hex | Penggunaan |
|---|---|---|
| Hijau Sarangan (Primary) | `#1F6E43` | Warna identitas utama — navbar, tombol utama, header aktif |
| Hijau Sarangan Gelap | `#16502F` | Hover/active state tombol primary |
| Hijau Sarangan Muda | `#E8F3EC` | Background elemen ringan (badge, highlight baris tabel) |
| Hijau Tunas (Accent/Success) | `#7FB069` | Status *Selesai*, indikator positif, konfirmasi berhasil |
| Biru Telaga (Info) | `#2E7DA3` | Status *Diverifikasi*, tautan, marker peta info, elemen peta |
| Kuning Kunyit (Warning) | `#E8A33D` | Status *Menunggu Verifikasi*, badge peringatan |
| Merah Bata (Danger) | `#C1443C` | Status *Ditolak*, pesan error, aksi hapus |
| Gelap Netral (Teks Utama) | `#1F2A24` | Teks judul & body utama (hijau sangat gelap, bukan hitam pekat) |
| Abu Netral (Teks Sekunder) | `#6B7280` | Teks pendukung, placeholder, caption |
| Latar Netral | `#F6F7F5` | Background halaman (netral hangat, bukan putih/krem polos) |
| Permukaan (Surface) | `#FFFFFF` | Card, modal, form |
| Border | `#E2E5E1` | Garis pemisah, border input |

**Aturan pemakaian warna status** (dipakai konsisten di badge, timeline, marker peta, grafik):

| Status Laporan | Warna | Ikon Font Awesome |
|---|---|---|
| Menunggu Verifikasi | Kuning Kunyit `#E8A33D` | `fa-clock` |
| Ditolak | Merah Bata `#C1443C` | `fa-circle-xmark` |
| Diverifikasi | Biru Telaga `#2E7DA3` | `fa-clipboard-check` |
| Sedang Ditangani | Hijau Sarangan `#1F6E43` | `fa-broom` |
| Selesai | Hijau Tunas `#7FB069` | `fa-circle-check` |

### 2.2 Tipografi

| Peran | Font | Pemakaian |
|---|---|---|
| Display/Judul | **Plus Jakarta Sans** (600–700) | H1–H3, judul kartu dashboard, nama sistem di navbar |
| Body/UI | **Plus Jakarta Sans** (400–500) | Paragraf, label form, isi tabel, tombol |
| Data/Angka | **JetBrains Mono** (400–500) | Kode laporan (`SPT-20260728-0001`), koordinat lat/lng, angka statistik besar di dashboard, timestamp |

Skala tipografi (rem, basis 16px):

```css
--text-xs: 0.75rem;    /* caption, label kecil */
--text-sm: 0.875rem;   /* body sekunder, tabel */
--text-base: 1rem;     /* body utama */
--text-lg: 1.125rem;   /* subjudul */
--text-xl: 1.5rem;     /* judul kartu/section */
--text-2xl: 2rem;      /* judul halaman */
--text-3xl: 2.5rem;    /* angka besar dashboard (pakai --font-mono) */
```

### 2.3 Spacing, Radius & Shadow

```css
:root {
  /* Warna */
  --color-primary: #1F6E43;
  --color-primary-dark: #16502F;
  --color-primary-light: #E8F3EC;
  --color-accent: #7FB069;
  --color-info: #2E7DA3;
  --color-warning: #E8A33D;
  --color-danger: #C1443C;
  --color-dark: #1F2A24;
  --color-muted: #6B7280;
  --color-bg: #F6F7F5;
  --color-surface: #FFFFFF;
  --color-border: #E2E5E1;

  /* Font */
  --font-display: 'Plus Jakarta Sans', sans-serif;
  --font-body: 'Plus Jakarta Sans', sans-serif;
  --font-mono: 'JetBrains Mono', monospace;

  /* Spacing (basis 4px) */
  --space-1: 4px;  --space-2: 8px;  --space-3: 12px; --space-4: 16px;
  --space-5: 24px; --space-6: 32px; --space-7: 48px; --space-8: 64px;

  /* Radius — sedikit membulat, terasa ramah tapi tetap formal */
  --radius-sm: 6px;
  --radius-md: 10px;
  --radius-lg: 16px;
  --radius-pill: 999px; /* badge status */

  /* Shadow — sangat tipis, bukan drop shadow tebal ala SaaS */
  --shadow-card: 0 2px 8px rgba(31, 42, 36, 0.06);
  --shadow-hover: 0 4px 14px rgba(31, 42, 36, 0.10);
}
```

**Prinsip layout:** border-radius sedang (10px pada card, bukan 24px penuh ala mobile-app), shadow sangat halus, banyak whitespace di sekitar tabel data agar tidak terasa sesak — mengingat pengguna masyarakat umum lintas usia yang mengakses dari HP dengan koneksi bervariasi.

---

## 3. Komponen UI

### 3.1 Navbar & Sidebar

- **Masyarakat & halaman publik:** navbar horizontal atas, latar putih, logo + nama sistem kiri, menu kanan (Beranda, Berita, Cara Melapor, Login/Daftar atau avatar+nama bila sudah login). Warna aktif memakai underline tipis Hijau Sarangan, bukan background block.
- **Admin & Petugas:** sidebar kiri tetap (collapsible di mobile menjadi off-canvas Bootstrap), latar Hijau Sarangan gelap (`--color-primary-dark`) dengan teks putih, item aktif memakai background `rgba(255,255,255,0.12)` + border kiri 3px putih. Ikon Font Awesome di setiap item menu.
- Header atas (dalam layout admin/petugas) berisi: judul halaman, bell notifikasi (badge merah bata jumlah belum dibaca), avatar + nama + role, tombol logout.

### 3.2 Status Badge

Pill kecil (`--radius-pill`), padding `4px 12px`, teks `--text-xs` semibold, latar warna status versi 15% opacity, teks warna status versi solid, ikon Font Awesome kecil di kiri teks. Contoh: badge "Sedang Ditangani" → latar `rgba(31,110,67,0.12)`, teks `#1F6E43`, ikon `fa-broom`.

### 3.3 Timeline Riwayat Status (Signature Component)

Komponen vertikal di halaman detail laporan (dipakai masyarakat & admin), merepresentasikan isi tabel `laporan_status_histories`. **Ini memakai penanda bernomor/berurutan karena kontennya memang benar-benar sekuensial** (riwayat status laporan berjalan satu arah) — bukan dekorasi.

```
●─ Menunggu Verifikasi
│  28 Jul 2026, 09.12 · oleh Sistem
│
●─ Diverifikasi
│  28 Jul 2026, 10.40 · oleh Admin Diskominfo
│  "Ditugaskan kepada Budi Santoso, prioritas: Tinggi"
│
●─ Sedang Ditangani
│  28 Jul 2026, 13.05 · oleh Budi Santoso (Petugas)
│  [foto sebelum]
│
○─ Selesai
   Menunggu petugas menyelesaikan penanganan
```

Titik (`●`) terisi penuh warna status untuk langkah yang sudah terjadi, titik kosong (`○`) untuk langkah yang belum terjadi, garis penghubung tipis `--color-border`.

### 3.4 Kartu Statistik Dashboard

Card putih, radius `--radius-md`, shadow `--shadow-card`, isi: label kecil (`--text-sm`, `--color-muted`) di atas, angka besar (`--font-mono`, `--text-3xl`, `--color-dark`) di tengah, ikon Font Awesome berwarna status di pojok kanan atas dalam lingkaran latar `--color-primary-light`.

### 3.5 Form & Upload Foto

- Input Bootstrap standar dengan border `--color-border`, focus ring Hijau Sarangan (`box-shadow: 0 0 0 3px rgba(31,110,67,0.15)`), label di atas input (bukan floating label, demi keterbacaan pengguna awam).
- Komponen upload foto: drag-drop area bordered-dashed dengan ikon `fa-camera` + teks "Seret foto ke sini atau klik untuk pilih", preview thumbnail grid setelah dipilih dengan tombol hapus (×) per foto, indikator jumlah "3/5 foto".
- Peta picker (Leaflet): tinggi 320px pada desktop / 240px pada mobile, marker dapat digeser, tombol overlay "📍 Gunakan Lokasi Saya" di pojok kanan bawah peta, koordinat terpilih ditampilkan di bawah peta dengan `--font-mono` kecil.

### 3.6 Rating Bintang

5 ikon `fa-star` (outline → solid saat dipilih/hover), warna Kuning Kunyit saat aktif, ukuran besar (32px) agar mudah disentuh di mobile, di bawahnya textarea komentar opsional.

### 3.7 Tabel Data (DataTables)

Header tabel latar `--color-primary-light`, teks `--color-primary-dark` semibold. Baris zebra sangat halus (`--color-bg` selang-seling). Tombol export (PDF/Excel) di kanan atas tabel bergaya outline Hijau Sarangan dengan ikon `fa-file-pdf` / `fa-file-excel`. Search box & pagination bawaan DataTables ditata ulang mengikuti radius & warna token di atas (override CSS DataTables default).

### 3.8 Grafik (Chart.js)

Palet grafik mengikuti warna status agar konsisten dengan badge (bar chart kategori sampah memakai gradasi Hijau Sarangan → Hijau Tunas; grafik status pakai warna status masing-masing). Grid line sangat tipis (`--color-border`), tanpa border chart, legend di bawah.

---

## 4. Wireframe per Halaman

### 4.1 Landing Page (Publik)

```
┌────────────────────────────────────────────────────┐
│ [Logo] SIPESAT Magetan     Beranda Berita  [Masuk]  │  ← navbar putih
├────────────────────────────────────────────────────┤
│                                                      │
│   Laporkan sampah, kami yang tangani.               │  ← H1, Plus Jakarta Sans 700
│   Layanan pengaduan sampah Kabupaten Magetan.        │
│   [ Buat Laporan Sekarang → ]                        │  ← tombol primary
│                                                      │
│   ┌─────────┐ ┌─────────┐ ┌─────────┐               │
│   │ 1.240   │ │  1.180  │ │  32     │  ← angka mono  │
│   │ Laporan │ │ Selesai │ │ Petugas │                │
│   └─────────┘ └─────────┘ └─────────┘               │
│                                                      │
│   Peta Sebaran Penanganan Sampah (live)              │  ← elemen signature
│   ┌──────────────────────────────────────┐          │
│   │        [peta Leaflet + marker]        │          │
│   └──────────────────────────────────────┘          │
│                                                      │
│   Bagaimana Cara Melapor?                            │  ← 3 langkah (sekuensial → boleh nomor)
│   1) Daftar/Masuk  2) Isi Laporan  3) Pantau Status   │
│                                                      │
│   Berita & Edukasi Pengelolaan Sampah                │
│   [card] [card] [card]                               │
└────────────────────────────────────────────────────┘
```

### 4.2 Login / Registrasi

```
┌───────────────────┐
│   [Logo SIPESAT]  │
│                    │
│  Masuk ke Akun     │
│  Email    [______] │
│  Password [______] │
│  [   Masuk    ]     │  ← tombol primary full-width
│  Belum punya akun?  │
│  Daftar di sini →   │
└───────────────────┘
```
Layout split-panel pada desktop (kiri: form, kanan: ilustrasi peta/statistik ringkas dengan latar `--color-primary`); pada mobile hanya form terpusat.

### 4.3 Dashboard Masyarakat

```
┌──────────────────────────────────────────────┐
│ Halo, Yanuar 👋                    🔔 [avatar] │
├──────────────────────────────────────────────┤
│ [Total: 8] [Menunggu: 2] [Ditangani: 1] [Selesai: 5] │ ← kartu statistik
│                                                │
│ [ + Buat Laporan Baru ]                        │
│                                                │
│ Laporan Terbaru                                │
│ ┌────────────────────────────────────────┐   │
│ │ SPT-20260728-0004 · Sampah Rumah Tangga │   │
│ │ 🟡 Menunggu Verifikasi     [Lihat detail]│   │
│ ├────────────────────────────────────────┤   │
│ │ SPT-20260720-0003 · Sampah Liar         │   │
│ │ 🟢 Selesai                 [Lihat detail]│   │
│ └────────────────────────────────────────┘   │
└──────────────────────────────────────────────┘
```

### 4.4 Form Buat Laporan

```
Buat Laporan Sampah
────────────────────
Judul Laporan        [_______________________]
Kategori Sampah      [ dropdown ▾ ]
Kecamatan / Desa      [ dropdown ▾ ] [ dropdown ▾ ]
Deskripsi             [ textarea               ]
Alamat Lengkap         [ textarea               ]

Titik Lokasi
┌──────────────────────────────────────┐
│         [peta interaktif Leaflet]      │  📍 Gunakan Lokasi Saya
└──────────────────────────────────────┘
Koordinat: -7.6428310, 111.3387420        ← font-mono

Foto Kondisi Sampah (1–5 foto)
┌───────┐┌───────┐┌───────┐
│ +foto ││ [img] ││ [img] │
└───────┘└───────┘└───────┘  2/5 foto

Prioritas Menurut Anda   ( ) Rendah  (•) Sedang  ( ) Tinggi

           [ Kirim Laporan ]
```

### 4.5 Detail Laporan (Masyarakat & Admin)

```
SPT-20260720-0003                         🟢 Selesai
Sampah Liar · Kec. Magetan, Ds. Selosari

┌───────────────┬────────────────────────┐
│ [foto laporan]│ Riwayat Status          │
│ [peta lokasi]  │ ●─ Menunggu Verifikasi  │
│                │ ●─ Diverifikasi         │
│ Deskripsi ...  │ ●─ Sedang Ditangani     │
│                │ ●─ Selesai              │
│                │   [foto sebelum/sesudah]│
│                │   Catatan: "..."        │
└───────────────┴────────────────────────┘

[ Beri Rating & Komentar ]   ← hanya tampil jika status Selesai & belum dinilai
```

### 4.6 Dashboard Admin

```
┌───────────────────────────────────────────────────┐
│ Sidebar │  Dashboard Admin                🔔 [avatar]│
│  📊 Dash│ ─────────────────────────────────────────│
│  📋 Verif│ [Hari ini:12][Menunggu:8][Ditangani:5][Selesai:120][Ditolak:3]
│  🧑 Tugas│                                          │
│  📈 Statis│ Grafik Laporan Bulanan   Grafik Kategori │
│  🗂 Master│ [bar chart]              [pie chart]    │
│  📰 Berita│                                          │
│  🕒 Log   │ Peta Sebaran Seluruh Laporan (live)      │
│           │ ┌──────────────────────────────────┐   │
│           │ │   [peta + marker warna status]     │   │
│           │ └──────────────────────────────────┘   │
└───────────────────────────────────────────────────┘
```

### 4.7 Verifikasi Laporan (Detail, Admin)

```
SPT-20260728-0004 · Menunggu Verifikasi
[foto] [peta lokasi]
Pelapor: Yanuar · 0812xxxxxxx
Deskripsi lengkap ...

Prioritas    [ dropdown: Rendah/Sedang/Tinggi/Darurat ]
Pilih Petugas [ dropdown, difilter wilayah & aktif  ]

[ ✕ Tolak Laporan ]        [ ✓ Verifikasi & Tugaskan ]
   ↳ modal alasan             (warna primary, tombol utama)
   (warna danger outline)
```

### 4.8 Monitoring Laporan (Admin — DataTables)

```
Filter: [Status ▾] [Kategori ▾] [Kecamatan ▾] [Petugas ▾] [Tgl mulai][Tgl akhir]  [Export PDF][Export Excel]
┌───────────────────────────────────────────────────────────────┐
│ Kode        │ Judul        │ Kategori │ Kecamatan │ Status │ Aksi │
│ SPT-2026...  │ ...          │ ...      │ ...       │ 🟡     │ 👁️   │
└───────────────────────────────────────────────────────────────┘
                                          ⟨ 1 2 3 ... 12 ⟩
```

### 4.9 Dashboard Petugas

```
Halo, Budi 👋
[Tugas Baru: 3] [Sedang Dikerjakan: 1] [Selesai: 47]

Tugas Terbaru
┌────────────────────────────────────────┐
│ SPT-20260728-0004 · Prioritas Tinggi 🔴  │
│ Ds. Selosari, Kec. Magetan               │
│ [ Lihat Detail → ]                       │
└────────────────────────────────────────┘
```

### 4.10 Detail Tugas (Petugas)

```
SPT-20260728-0004                      🔵 Diverifikasi
[peta lokasi] [ Buka di Google Maps ↗ ]
Deskripsi laporan ... Prioritas: Tinggi

── Belum dimulai ──
Upload Foto Sebelum (1–3 foto)  [+ ][+ ][+ ]
[ Mulai Penanganan → status: Sedang Ditangani ]

── (setelah dimulai) ──
Upload Foto Sesudah (1–3 foto)  [+ ][+ ][+ ]
Catatan Pekerjaan  [ textarea ]
[ Selesaikan Penanganan → status: Selesai ]
```

---

## 5. Layout & Responsivitas

| Breakpoint | Perilaku |
|---|---|
| `< 576px` (mobile) | Sidebar admin/petugas menjadi off-canvas (toggle hamburger), kartu statistik ditumpuk 2 kolom, peta tinggi 240px, tabel DataTables mode *responsive* (kolom disembunyikan otomatis dengan tombol expand `+`) |
| `576–991px` (tablet) | Kartu statistik 2–3 kolom, sidebar tetap collapsible |
| `≥ 992px` (desktop) | Sidebar tetap terbuka, kartu statistik 4–5 kolom, layout dua kolom pada halaman detail laporan |

Seluruh halaman memakai container Bootstrap standar (`container-fluid` pada dashboard, `container` pada halaman publik/form) — grid 12 kolom bawaan Bootstrap 5, tidak perlu sistem grid kustom.

---

## 6. Aksesibilitas

- Kontras warna teks-atas-latar seluruh kombinasi token di Bab 2.1 memenuhi rasio minimal **4.5:1** (WCAG AA) untuk teks body; dicek khusus pada teks putih di atas `--color-primary` dan teks `--color-dark` di atas `--color-bg`.
- Setiap elemen interaktif (tombol, link, input) memiliki *visible focus state* (`outline`/`box-shadow` Hijau Sarangan), tidak dihilangkan dengan `outline: none` tanpa pengganti.
- Target sentuh minimum 44×44px untuk seluruh tombol aksi di tampilan mobile (tombol rating, tombol upload, tombol status).
- Atribut `alt` wajib pada seluruh foto laporan & dokumentasi penanganan, mis. `alt="Foto kondisi sampah sebelum penanganan"`.
- Warna status tidak menjadi satu-satunya penanda — selalu disertai ikon & label teks (mis. badge tidak hanya warna kuning, tapi juga ikon jam + teks "Menunggu Verifikasi") agar tetap jelas bagi pengguna buta warna.

---

## 7. Panduan Microcopy (Bahasa Indonesia)

Prinsip: **bahasa aktif, jelas, dari sudut pandang pengguna**, bukan istilah teknis sistem.

| Konteks | Contoh Baik | Hindari |
|---|---|---|
| Tombol kirim laporan | "Kirim Laporan" | "Submit" |
| Tombol simpan perubahan | "Simpan Perubahan" | "Update Data" |
| Konfirmasi hapus (SweetAlert2) | "Hapus kategori ini? Data yang sudah dihapus tidak dapat dikembalikan." | "Are you sure?" |
| Sukses kirim laporan | "Laporan berhasil dikirim. Kami akan segera memeriksanya." | "Data berhasil disimpan." |
| Laporan ditolak (ke masyarakat) | "Laporan Anda belum dapat diproses: {alasan_penolakan}" | "Laporan ditolak." |
| Status kosong (belum ada laporan) | "Belum ada laporan. Yuk laporkan sampah di sekitar Anda." + tombol aksi | "Data tidak ditemukan." |
| Error validasi foto | "Foto belum dipilih. Unggah minimal 1 foto kondisi sampah." | "The photo field is required." |
| Notifikasi status berubah | "Laporan SPT-20260728-0004 kini Sedang Ditangani oleh Budi Santoso." | "Status diperbarui." |

Nama tombol konsisten dengan pesan hasil aksinya (mis. tombol "Verifikasi & Tugaskan" → notifikasi sukses "Laporan berhasil diverifikasi dan ditugaskan").

---

## 8. Ikonografi (Font Awesome 6)

| Modul/Aksi | Ikon |
|---|---|
| Dashboard | `fa-gauge-high` |
| Laporan | `fa-file-lines` |
| Verifikasi | `fa-clipboard-check` |
| Penugasan | `fa-user-check` |
| Monitoring | `fa-table-list` |
| Statistik | `fa-chart-column` |
| Data Master | `fa-database` |
| Berita | `fa-newspaper` |
| Log Aktivitas | `fa-clock-rotate-left` |
| Notifikasi | `fa-bell` |
| Peta/Lokasi | `fa-location-dot` |
| Upload Foto | `fa-camera` |
| Rating | `fa-star` |
| Export PDF | `fa-file-pdf` |
| Export Excel | `fa-file-excel` |
| Logout | `fa-right-from-bracket` |

---

## 9. Aset & Branding

- **Logo:** belum tersedia — disarankan logogram sederhana berbentuk daun/tetesan yang membentuk simbol lokasi (`fa-location-dot`) sebagai placeholder awal sebelum ada logo resmi dari Diskominfo/DLH Kabupaten Magetan.
- **Favicon:** turunan logo di atas, latar Hijau Sarangan.
- **Header dokumen ekspor PDF:** memuat nama instansi (Diskominfo/DLH Kabupaten Magetan), logo, dan judul laporan sesuai filter aktif, memakai warna `--color-primary` untuk garis header.

---

## 10. Dokumen Terkait

Dokumen ini melengkapi `rule-sipesat.md` (arsitektur & database). Implementasi CSS aktual disarankan disusun sebagai `public/css/app.css` dengan seluruh custom properties pada Bab 2.3 didefinisikan di `:root`, dipanggil dari `layouts/app.blade.php` dan `layouts/guest.blade.php` — tanpa proses build, langsung sebagai file statis sesuai prinsip *no NPM/Vite* pada `rule-sipesat.md`.
