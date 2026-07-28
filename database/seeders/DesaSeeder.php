<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DesaSeeder extends Seeder
{

    public function run(): void
    {
        $kecamatans = DB::table('kecamatans')->get();
        foreach ($kecamatans as $kec) {
            for ($i = 1; $i <= 3; $i++) {
                DB::table('desas')->insert([
                    'kecamatan_id' => $kec->id,
                    'nama_desa' => 'Desa ' . $kec->nama_kecamatan . ' ' . $i,
                    'created_at' => now(), 'updated_at' => now()
                ]);
            }
        }
    }
    
}
