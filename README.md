# 🍃 SIPESAT (Sistem Pengelolaan Sampah Terpadu)

SIPESAT adalah aplikasi berbasis web yang bertujuan untuk memudahkan masyarakat dan petugas dalam pengelolaan sampah terpadu serta menjaga kebersihan lingkungan bersama. Aplikasi ini menghubungkan partisipasi masyarakat dalam melaporkan masalah persampahan dengan petugas kebersihan secara real-time.

## 🚀 Fitur Utama

Aplikasi SIPESAT memiliki 3 hak akses utama (Role) dengan fitur masing-masing:

### 1. 🧑‍🤝‍🧑 Masyarakat
- **Autentikasi**: Login dan Pendaftaran akun (Register).
- **Pelaporan**: Melaporkan tumpukan sampah atau masalah kebersihan lingkungan.
- **Edukasi**: Membaca berita dan artikel edukasi terkait lingkungan dan pengelolaan sampah.

### 2. 👷 Petugas
- **Dashboard Petugas**: Menampilkan ringkasan tugas hari ini.
- **Tugas Saya**: Menerima, mengelola, dan menyelesaikan laporan persampahan yang ditugaskan oleh Admin.
- **Update Status**: Memberikan laporan penyelesaian tugas langsung dari lapangan.

### 3. 👨‍💻 Admin
- **Dashboard Admin**: Ringkasan data secara menyeluruh (laporan, petugas, monitoring).
- **Manajemen Laporan**: Mengelola laporan dari masyarakat dan meneruskannya ke petugas.
- **Monitoring & Statistik**: Melacak kinerja pengelolaan sampah dan data statistik kebersihan.
- **Data Master**: 
  - Kategori Sampah
  - Manajemen Wilayah
  - Manajemen Petugas
- **Berita & Edukasi**: Mengelola konten artikel untuk masyarakat.
- **Log Aktivitas**: Memantau seluruh aktivitas yang terjadi di sistem.

## 🛠️ Teknologi yang Digunakan

- **Framework**: [Laravel](https://laravel.com/) (PHP)
- **Frontend**: HTML5, Vanilla CSS, dan [Bootstrap 5](https://getbootstrap.com/)
- **Ikonografi**: [FontAwesome 6](https://fontawesome.com/)
- **Database**: MySQL

## ⚙️ Cara Instalasi & Menjalankan Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan project SIPESAT di mesin lokal Anda.

1. **Clone repositori ini**
   ```bash
   git clone https://github.com/ardhikaxx/sipesat-web.git
   cd sipesat
   ```

2. **Install dependensi PHP (Composer)**
   ```bash
   composer install
   ```

3. **Install dependensi Node (NPM)**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   - Salin file `.env.example` menjadi `.env`
     ```bash
     cp .env.example .env
     ```
   - Buka file `.env` dan sesuaikan konfigurasi database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migrasi Database dan Seeder (jika ada)**
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan Server Lokal**
   - Jalankan server Laravel:
     ```bash
     php artisan serve
     ```
   - (Opsional) Jalankan Vite untuk asset frontend:
     ```bash
     npm run dev
     ```

8. Buka browser dan akses: `http://localhost:8000`

## 🎨 Desain dan Antarmuka

SIPESAT didesain dengan mengedepankan **UI/UX yang modern, premium, dan responsif**. Beberapa aspek desain meliputi:
- Konsep layout yang bersih (clean layout) dengan **Split/Two-Column Design** pada halaman otentikasi.
- Gaya **Glassmorphism** dan penggunaan warna *primary* yang senada.
- Elemen interaktif seperti tombol visibilitas (toggle show/hide) pada field password.

## 📄 Lisensi

Project ini bersifat open-source. Anda dapat menggunakannya sebagai bahan referensi atau pengembangan lebih lanjut.
