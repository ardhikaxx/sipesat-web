<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $beritas = [
            [
                'judul' => 'Sosialisasi Pemilahan Sampah dari Rumah',
                'konten' => 'Dinas Lingkungan Hidup Kabupaten Magetan mengajak seluruh warga untuk mulai memilah sampah dari rumah tangga. Pisahkan antara sampah organik, anorganik, dan B3 untuk memudahkan proses daur ulang dan mengurangi volume sampah yang masuk ke TPA. Mari bersama wujudkan Magetan Bersih dan Asri!',
                'kategori' => 'edukasi',
                'status' => 'published',
            ],
            [
                'judul' => 'Jadwal Pengangkutan Sampah Rutin Magetan Kota',
                'konten' => 'Berikut adalah jadwal pengangkutan sampah untuk area Magetan Kota selama bulan ini. Pengangkutan untuk sampah domestik dilakukan setiap hari Senin, Rabu, dan Jumat mulai pukul 06.00 WIB. Diharapkan warga meletakkan tempat sampah di depan rumah sebelum waktu tersebut.',
                'kategori' => 'pengumuman',
                'status' => 'published',
            ],
            [
                'judul' => 'Inovasi Bank Sampah Desa Milenial',
                'konten' => 'Desa Milenial di Kecamatan Maospati berhasil menyulap sampah anorganik menjadi produk kerajinan tangan bernilai ekonomis tinggi. Inovasi ini tidak hanya mengurangi timbunan sampah, tetapi juga meningkatkan pendapatan warga sekitar. Program ini akan diujicobakan di 5 desa lainnya tahun depan.',
                'kategori' => 'kegiatan',
                'status' => 'published',
            ],
            [
                'judul' => 'Bahaya Membakar Sampah Sembarangan',
                'konten' => 'Membakar sampah di pekarangan terbuka sangat berbahaya bagi kesehatan pernapasan karena menghasilkan gas beracun seperti karbon monoksida dan dioksin. Selain itu, asapnya mengganggu kenyamanan lingkungan sekitar. Hindari pembakaran sampah dan laporkan jika ada tumpukan sampah liar melalui SIPESAT.',
                'kategori' => 'edukasi',
                'status' => 'published',
            ],
            [
                'judul' => 'Peluncuran Aplikasi SIPESAT',
                'konten' => 'Sistem Pelaporan Sampah Terpadu (SIPESAT) resmi diluncurkan untuk memfasilitasi warga Kabupaten Magetan dalam melaporkan tumpukan sampah liar atau masalah kebersihan lainnya. Aplikasi ini terintegrasi dengan petugas lapangan sehingga penanganan bisa lebih cepat dan transparan.',
                'kategori' => 'pengumuman',
                'status' => 'published',
            ]
        ];

        foreach ($beritas as $berita) {
            Berita::create([
                'judul' => $berita['judul'],
                'slug' => Str::slug($berita['judul']),
                'konten' => $berita['konten'],
                'kategori' => $berita['kategori'],
                'status' => $berita['status'],
                'penulis_id' => 1,
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
