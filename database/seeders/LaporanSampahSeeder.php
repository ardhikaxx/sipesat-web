<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\LaporanSampah;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LaporanSampahSeeder extends Seeder
{
    public function run()
    {
        $roleMasyarakat = Role::where('name', 'masyarakat')->first();
        
        // Buat 10 akun masyarakat
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = User::create([
                'name' => 'Warga Magetan ' . $i,
                'email' => 'warga' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $roleMasyarakat->id,
                'phone' => '0812345600' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'is_active' => true,
            ]);
        }

        // List judul dan alamat realistis (acak)
        $judulList = [
            'Tumpukan Sampah Plastik', 'Sampah Sisa Acara', 'Sampah Sayuran Menggunung', 
            'Pembuangan Liar', 'Saluran Air Tersumbat Sampah', 'Sampah Popok Bayi di Pinggir Jalan',
            'Sisa Material Bangunan Menutupi Jalan', 'Tumpukan Daun Kering dan Plastik',
            'Sampah Rumah Tangga Menumpuk', 'Kantong Sampah Tidak Terangkut'
        ];
        $alamatList = [
            'Jalan Raya Magetan', 'Area Alun-Alun', 'Pasar Sayur Magetan', 'Kawasan Stadion Yosonegoro',
            'Jalan sekitar RSUD', 'Sekitar Taman Ria Manunggal', 'Area Pemukiman Ringinagung',
            'Dekat Terminal Baru', 'Jalan Tembus Sarangan', 'Kawasan Industri Kecil'
        ];

        // Generate 35 Laporan acak di sekitar Magetan
        // Magetan Center: Lat: -7.6531, Lng: 111.3284
        for ($i = 1; $i <= 35; $i++) {
            // Generate random coordinate nearby (radius ~3-5km)
            $lat = -7.6531 + (mt_rand(-300, 300) / 10000); // -7.6231 to -7.6831
            $lng = 111.3284 + (mt_rand(-300, 300) / 10000); // 111.2984 to 111.3584

            LaporanSampah::create([
                'kode_laporan' => 'SPT-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id' => $users[array_rand($users)]->id,
                'kategori_sampah_id' => rand(1, 3),
                'kecamatan_id' => 1, 
                'desa_id' => rand(1, 5), 
                'judul_laporan' => $judulList[array_rand($judulList)] . ' - Titik ' . $i,
                'deskripsi' => 'Ditemukan banyak tumpukan sampah yang belum dibersihkan dan menimbulkan bau tidak sedap.',
                'alamat_lengkap' => $alamatList[array_rand($alamatList)] . ' Blok ' . chr(rand(65, 90)),
                'latitude' => $lat,
                'longitude' => $lng,
                'foto_laporan' => json_encode(['dummy_laporan.jpg']),
                'prioritas_pelapor' => 'sedang',
                'prioritas_admin' => 'sedang',
                'status' => 'selesai',
                'verified_by' => 1,
                'verified_at' => Carbon::now()->subDays(rand(1, 10)),
                'completed_at' => Carbon::now()->subHours(rand(1, 48)),
            ]);
        }
    }
}
