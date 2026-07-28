<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        $petugasRole = DB::table('roles')->where('name', 'petugas')->first();
        $masyarakatRole = DB::table('roles')->where('name', 'masyarakat')->first();
        
        $kecamatan = DB::table('kecamatans')->first();
        $desa = DB::table('desas')->first();

        // Admin
        DB::table('users')->insert([
            'role_id' => $adminRole->id,
            'name' => 'Admin Diskominfo',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // Petugas
        $petugasId = DB::table('users')->insertGetId([
            'role_id' => $petugasRole->id,
            'name' => 'Budi Santoso',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081298765432',
            'created_at' => now(), 'updated_at' => now()
        ]);

        DB::table('petugas')->insert([
            'user_id' => $petugasId,
            'nip' => '198001012005011001',
            'wilayah_tugas_kecamatan_id' => $kecamatan->id,
            'status_petugas' => 'aktif',
            'created_at' => now(), 'updated_at' => now()
        ]);


    }
    
}
