<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            KecamatanSeeder::class,
            DesaSeeder::class,
            KategoriSampahSeeder::class,
            UserSeeder::class,
            LaporanSampahSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}
