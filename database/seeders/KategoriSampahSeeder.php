<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KategoriSampahSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('kategori_sampahs')->insert([
            ['nama_kategori' => 'Sampah Rumah Tangga', 'deskripsi' => 'Sampah dari aktivitas sehari-hari di rumah.', 'icon' => 'fa-home', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Sampah Liar/Pembuangan Ilegal', 'deskripsi' => 'Tumpukan sampah liar di lahan kosong atau pinggir jalan.', 'icon' => 'fa-dumpster', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Sampah Sungai/Saluran Air', 'deskripsi' => 'Sampah yang menyumbat aliran sungai atau gorong-gorong.', 'icon' => 'fa-water', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Sampah Pasar', 'deskripsi' => 'Sampah organik dan non-organik dari aktivitas pasar.', 'icon' => 'fa-shop', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Limbah B3 Ringan', 'deskripsi' => 'Seperti baterai bekas, lampu, dan elektronik kecil.', 'icon' => 'fa-battery-quarter', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
    
}
