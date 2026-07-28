<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'label' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'petugas', 'label' => 'Petugas Lapangan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'masyarakat', 'label' => 'Masyarakat', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
    
}
