<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user admin
        $admin = User::whereHas('role', function ($q) {
            $q->where('name', 'admin');
        })->first() ?? User::first();

        if (!$admin) {
            return;
        }

        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
        $ip = '127.0.0.1';

        $logs = [
            [
                'user_id'    => $admin->id,
                'aktivitas'  => 'Login berhasil',
                'modul'      => 'Autentikasi',
                'deskripsi'  => 'Pengguna berhasil login ke dalam sistem.',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'created_at' => Carbon::now()->subHours(6)->subMinutes(45),
            ],
            [
                'user_id'    => $admin->id,
                'aktivitas'  => 'Menambah data',
                'modul'      => 'Kategori Sampah',
                'deskripsi'  => 'Pengguna menambahkan kategori sampah "Sampah Elektronik (E-Waste)".',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'created_at' => Carbon::now()->subHours(5)->subMinutes(30),
            ],
            [
                'user_id'    => $admin->id,
                'aktivitas'  => 'Mengubah data',
                'modul'      => 'Kategori Sampah',
                'deskripsi'  => 'Pengguna mengubah kategori sampah menjadi "Organik Daun & Ranting Kering".',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'created_at' => Carbon::now()->subHours(4)->subMinutes(15),
            ],
            [
                'user_id'    => $admin->id,
                'aktivitas'  => 'Mengubah data',
                'modul'      => 'Validasi Pekerjaan',
                'deskripsi'  => 'Pengguna memvalidasi penyelesaian laporan sampah #SPT-202609-0005 di Kec. Magetan.',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'created_at' => Carbon::now()->subHours(3)->subMinutes(10),
            ],
            [
                'user_id'    => $admin->id,
                'aktivitas'  => 'Menambah data',
                'modul'      => 'Berita & Edukasi',
                'deskripsi'  => 'Pengguna mempublikasikan artikel edukasi "Gerakan Pilah Sampah dari Rumah".',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'created_at' => Carbon::now()->subHours(2)->subMinutes(20),
            ],
            [
                'user_id'    => $admin->id,
                'aktivitas'  => 'Menghapus data',
                'modul'      => 'Kategori Sampah',
                'deskripsi'  => 'Pengguna menghapus kategori sampah "Sampah Residu Uji Coba".',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'created_at' => Carbon::now()->subHours(1)->subMinutes(5),
            ],
            [
                'user_id'    => $admin->id,
                'aktivitas'  => 'Logout',
                'modul'      => 'Autentikasi',
                'deskripsi'  => 'Pengguna keluar dari sistem.',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'created_at' => Carbon::now()->subMinutes(15),
            ],
        ];

        foreach ($logs as $log) {
            ActivityLog::create($log);
        }
    }
}
