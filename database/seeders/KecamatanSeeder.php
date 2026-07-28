<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KecamatanSeeder extends Seeder
{

    public function run(): void
    {
        $kecamatans = [
            'Poncol', 'Parang', 'Lembeyan', 'Takeran', 'Kawedanan', 'Magetan', 
            'Plaosan', 'Panekan', 'Sukomoro', 'Bendo', 'Barat', 'Karangrejo', 
            'Karas', 'Kartoharjo', 'Ngariboyo', 'Nguntoronadi', 'Maospati', 'Sidorejo'
        ];
        foreach ($kecamatans as $i => $kec) {
            DB::table('kecamatans')->insert([
                'kode_kecamatan' => '35.20.' . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'nama_kecamatan' => $kec,
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }
    
}
