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
        
        // Buat beberapa akun masyarakat tambahan
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $users[] = User::create([
                'name' => 'Warga Magetan ' . $i,
                'email' => 'warga' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role_id' => $roleMasyarakat->id,
                'phone' => '0812345600' . $i,
                'is_active' => true,
            ]);
        }

        // Kordinat Magetan yang realistis
        $locations = [
            ['lat' => -7.6685, 'lng' => 111.2181, 'judul' => 'Tumpukan Sampah Plastik di Jalur Telaga Sarangan', 'alamat' => 'Jl. Raya Telaga Sarangan'],
            ['lat' => -7.6531, 'lng' => 111.3284, 'judul' => 'Sampah Sisa Acara di Alun-Alun', 'alamat' => 'Alun-Alun Kabupaten Magetan'],
            ['lat' => -7.6582, 'lng' => 111.3256, 'judul' => 'Sampah Sayuran Menggunung di Belakang Pasar', 'alamat' => 'Pasar Baru Magetan'],
            ['lat' => -7.5857, 'lng' => 111.4442, 'judul' => 'Pembuangan Liar Dekat Terminal', 'alamat' => 'Kawasan Terminal Maospati'],
            ['lat' => -7.7123, 'lng' => 111.4058, 'judul' => 'Saluran Air Tersumbat Sampah', 'alamat' => 'Kecamatan Kawedanan'],
        ];

        foreach ($locations as $index => $loc) {
            LaporanSampah::create([
                'kode_laporan' => 'SPT-20260728-900' . $index,
                'user_id' => $users[$index]->id,
                'kategori_sampah_id' => rand(1, 3), // Asumsi ID 1-3 valid
                'kecamatan_id' => 1, // Magetan
                'desa_id' => 1, 
                'judul_laporan' => $loc['judul'],
                'deskripsi' => 'Ditemukan banyak tumpukan sampah yang belum dibersihkan dan menimbulkan bau tidak sedap.',
                'alamat_lengkap' => $loc['alamat'],
                'latitude' => $loc['lat'],
                'longitude' => $loc['lng'],
                'foto_laporan' => json_encode(['dummy_laporan.jpg']),
                'prioritas_pelapor' => 'sedang',
                'prioritas_admin' => 'sedang',
                'status' => 'selesai',
                'verified_by' => 1, // admin
                'verified_at' => Carbon::now()->subDays(2),
                'completed_at' => Carbon::now()->subHours(5),
            ]);
        }
    }
}
