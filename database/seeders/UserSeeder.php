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

        // Admin
        DB::table('users')->insert([
            'role_id' => $adminRole->id,
            'name' => 'Admin Diskominfo',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // Petugas 1
        $petugasId1 = DB::table('users')->insertGetId([
            'role_id' => $petugasRole->id,
            'name' => 'Budi Santoso',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081298765432',
            'created_at' => now(), 'updated_at' => now()
        ]);
        DB::table('petugas')->insert([
            'user_id' => $petugasId1,
            'nip' => '198001012005011001',
            'wilayah_tugas_kecamatan_id' => $kecamatan->id,
            'status_petugas' => 'aktif',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // Petugas 2
        $petugasId2 = DB::table('users')->insertGetId([
            'role_id' => $petugasRole->id,
            'name' => 'Eko Prasetyo',
            'email' => 'petugas2@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081298765433',
            'created_at' => now(), 'updated_at' => now()
        ]);
        DB::table('petugas')->insert([
            'user_id' => $petugasId2,
            'nip' => '198203152006041002',
            'wilayah_tugas_kecamatan_id' => $kecamatan->id,
            'status_petugas' => 'aktif',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // Petugas 3
        $petugasId3 = DB::table('users')->insertGetId([
            'role_id' => $petugasRole->id,
            'name' => 'Agus Kurniawan',
            'email' => 'petugas3@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081298765434',
            'created_at' => now(), 'updated_at' => now()
        ]);
        DB::table('petugas')->insert([
            'user_id' => $petugasId3,
            'nip' => '198507202008011003',
            'wilayah_tugas_kecamatan_id' => $kecamatan->id,
            'status_petugas' => 'aktif',
            'created_at' => now(), 'updated_at' => now()
        ]);
    }
}
