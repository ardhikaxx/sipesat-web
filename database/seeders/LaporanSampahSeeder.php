<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Petugas;
use App\Models\LaporanSampah;
use App\Models\Penugasan;
use App\Models\DokumentasiPenanganan;
use App\Models\LaporanStatusHistory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class LaporanSampahSeeder extends Seeder
{
    public function run()
    {


        $roleMasyarakat = Role::where('name', 'masyarakat')->first();
        $faker = \Faker\Factory::create('id_ID');

        // Buat 10 akun masyarakat dengan nama nyata
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $name = $faker->name;
            $emailName = strtolower(preg_replace('/[^a-zA-Z]/', '', $name));
            
            $users[] = User::create([
                'name' => $name,
                'email' => $emailName . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $roleMasyarakat->id,
                'phone' => '08' . $faker->numerify('##########'),
                'is_active' => true,
            ]);
        }

        // Ambil daftar petugas yang ada
        $petugasList = Petugas::all();

        // List judul dan alamat realistis
        $judulList = [
            'Tumpukan Sampah Plastik di Pinggir Jalan',
            'Sampah Sisa Acara Syukuran Warga',
            'Sampah Sayuran Menggunung Dekat Pasar', 
            'Pembuangan Liar di Lahan Kosong',
            'Saluran Air Tersumbat Sampah Plastik',
            'Sampah Popok Bayi Menumpuk',
            'Sisa Material Bangunan Menutupi Trotoar',
            'Tumpukan Daun Kering dan Kantong Plastik',
            'Sampah Rumah Tangga Belum Diangkut',
            'Kantung Sampah Liar Menggantung di Pagar'
        ];

        $alamatList = [
            'Jalan Raya Magetan No. ',
            'Area Alun-Alun Magetan Blok ',
            'Pasar Sayur Magetan Kios ',
            'Kawasan Stadion Yosonegoro Gg. ',
            'Jalan sekitar RSUD Dr. Sayidiman No. ',
            'Sekitar Taman Ria Manunggal RT 0',
            'Area Pemukiman Ringinagung No. ',
            'Dekat Terminal Baru Magetan Gg. ',
            'Jalan Tembus Sarangan KM ',
            'Kawasan Industri Kecil Sentra '
        ];

        // Total 35 laporan dengan variasi status:
        // 8: menunggu_verifikasi
        // 8: diverifikasi (4 belum ditugaskan, 4 sudah ditugaskan)
        // 7: sedang_ditangani (ditugaskan + foto_sebelum)
        // 5: menunggu_validasi_akhir (petugas selesai + foto_sebelum & foto_sesudah)
        // 5: selesai (sudah divalidasi admin)
        // 2: ditolak (ditolak admin)

        $statuses = array_merge(
            array_fill(0, 8, 'menunggu_verifikasi'),
            array_fill(0, 8, 'diverifikasi'),
            array_fill(0, 7, 'sedang_ditangani'),
            array_fill(0, 5, 'menunggu_validasi_akhir'),
            array_fill(0, 5, 'selesai'),
            array_fill(0, 2, 'ditolak')
        );

        shuffle($statuses);

        foreach ($statuses as $i => $status) {
            $reportNum = $i + 1;
            // Magetan Center: Lat: -7.6531, Lng: 111.3284
            $lat = -7.6531 + (mt_rand(-350, 350) / 10000);
            $lng = 111.3284 + (mt_rand(-350, 350) / 10000);

            $pelapor = $users[array_rand($users)];

            $prioritasOptions = ['rendah', 'sedang', 'tinggi'];
            $prioritasPelapor = $prioritasOptions[array_rand($prioritasOptions)];
            $prioritasAdmin = in_array($status, ['menunggu_verifikasi']) ? null : $prioritasPelapor;

            $laporan = LaporanSampah::create([
                'kode_laporan' => 'SPT-' . date('Ymd') . '-' . str_pad($reportNum, 4, '0', STR_PAD_LEFT),
                'user_id' => $pelapor->id,
                'kategori_sampah_id' => rand(1, 3),
                'kecamatan_id' => 1, 
                'desa_id' => rand(1, 5), 
                'judul_laporan' => $judulList[array_rand($judulList)],
                'deskripsi' => 'Ditemukan tumpukan sampah yang cukup banyak dan perlu segera ditangani agar tidak menimbulkan bau dan sumber penyakit.',
                'alamat_lengkap' => $alamatList[array_rand($alamatList)] . rand(1, 45),
                'latitude' => $lat,
                'longitude' => $lng,
                'foto_laporan' => [],
                'prioritas_pelapor' => $prioritasPelapor,
                'prioritas_admin' => $prioritasAdmin,
                'status' => $status,
                'alasan_penolakan' => ($status === 'ditolak') ? 'Laporan tidak sesuai dengan foto / lokasi bukan fasilitas publik.' : null,
                'verified_by' => in_array($status, ['menunggu_verifikasi']) ? null : 1,
                'verified_at' => in_array($status, ['menunggu_verifikasi']) ? null : Carbon::now()->subDays(rand(2, 5)),
                'completed_at' => ($status === 'selesai') ? Carbon::now()->subHours(rand(1, 24)) : null,
                'created_at' => Carbon::now()->subDays(rand(5, 12)),
            ]);

            // History Awal: Dibuat masyarakat
            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'status_sebelum' => null,
                'status_sesudah' => 'menunggu_verifikasi',
                'keterangan' => 'Laporan berhasil dibuat oleh masyarakat.',
                'changed_by' => $pelapor->id,
                'changed_at' => $laporan->created_at,
            ]);

            // Jika status ditolak
            if ($status === 'ditolak') {
                LaporanStatusHistory::create([
                    'laporan_sampah_id' => $laporan->id,
                    'status_sebelum' => 'menunggu_verifikasi',
                    'status_sesudah' => 'ditolak',
                    'keterangan' => 'Laporan ditolak: ' . $laporan->alasan_penolakan,
                    'changed_by' => 1, // Admin
                    'changed_at' => Carbon::now()->subDays(rand(1, 3)),
                ]);
                continue;
            }

            // Jika status diverifikasi, sedang_ditangani, menunggu_validasi_akhir, atau selesai
            if (in_array($status, ['diverifikasi', 'sedang_ditangani', 'menunggu_validasi_akhir', 'selesai'])) {
                LaporanStatusHistory::create([
                    'laporan_sampah_id' => $laporan->id,
                    'status_sebelum' => 'menunggu_verifikasi',
                    'status_sesudah' => 'diverifikasi',
                    'keterangan' => 'Laporan telah diverifikasi oleh Admin.',
                    'changed_by' => 1,
                    'changed_at' => Carbon::now()->subDays(rand(2, 4)),
                ]);

                // 50% dari laporan diverifikasi atau semua laporan berstatus lanjut disetkan Penugasan
                $shouldAssign = ($status !== 'diverifikasi') || ($reportNum % 2 === 0);

                if ($shouldAssign && $petugasList->count() > 0) {
                    $assignedPetugas = $petugasList->random();

                    Penugasan::create([
                        'laporan_sampah_id' => $laporan->id,
                        'petugas_id' => $assignedPetugas->id,
                        'assigned_by' => 1,
                        'catatan_admin' => 'Mohon segera dibersihkan dan diangkut ke TPA.',
                        'assigned_at' => Carbon::now()->subDays(rand(1, 3))
                    ]);

                    LaporanStatusHistory::create([
                        'laporan_sampah_id' => $laporan->id,
                        'status_sebelum' => 'diverifikasi',
                        'status_sesudah' => 'diverifikasi',
                        'keterangan' => 'Petugas ' . $assignedPetugas->user->name . ' telah ditugaskan.',
                        'changed_by' => 1,
                        'changed_at' => Carbon::now()->subDays(rand(1, 2)),
                    ]);

                    // Jika sedang_ditangani, menunggu_validasi_akhir, atau selesai
                    if (in_array($status, ['sedang_ditangani', 'menunggu_validasi_akhir', 'selesai'])) {
                        DokumentasiPenanganan::create([
                            'laporan_sampah_id' => $laporan->id,
                            'petugas_id' => $assignedPetugas->id,
                            'foto_sebelum' => [],
                            'foto_sesudah' => [],
                            'catatan_pekerjaan' => 'Pembersihan area telah dilaksanakan dengan armada pengangkut.',
                            'waktu_mulai' => Carbon::now()->subHours(rand(5, 10)),
                            'waktu_selesai' => in_array($status, ['menunggu_validasi_akhir', 'selesai']) ? Carbon::now()->subHours(rand(1, 4)) : null,
                        ]);

                        LaporanStatusHistory::create([
                            'laporan_sampah_id' => $laporan->id,
                            'status_sebelum' => 'diverifikasi',
                            'status_sesudah' => 'sedang_ditangani',
                            'keterangan' => 'Petugas mulai menangani di lokasi.',
                            'changed_by' => $assignedPetugas->user_id,
                            'changed_at' => Carbon::now()->subHours(rand(4, 8)),
                        ]);
                    }

                    // Jika menunggu_validasi_akhir atau selesai
                    if (in_array($status, ['menunggu_validasi_akhir', 'selesai'])) {
                        LaporanStatusHistory::create([
                            'laporan_sampah_id' => $laporan->id,
                            'status_sebelum' => 'sedang_ditangani',
                            'status_sesudah' => 'menunggu_validasi_akhir',
                            'keterangan' => 'Petugas telah menyelesaikan pekerjaan.',
                            'changed_by' => $assignedPetugas->user_id,
                            'changed_at' => Carbon::now()->subHours(rand(2, 4)),
                        ]);
                    }

                    // Jika selesai
                    if ($status === 'selesai') {
                        LaporanStatusHistory::create([
                            'laporan_sampah_id' => $laporan->id,
                            'status_sebelum' => 'menunggu_validasi_akhir',
                            'status_sesudah' => 'selesai',
                            'keterangan' => 'Admin memvalidasi dan menyelesaikan laporan.',
                            'changed_by' => 1,
                            'changed_at' => Carbon::now()->subHours(rand(1, 2)),
                        ]);
                    }
                }
            }
        }
    }
}
