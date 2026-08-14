<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class KecamatanSeeder extends Seeder {
    public function run(): void {
        $kecId_3520010 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520010',
            'nama_kecamatan' => 'PONCOL',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520020 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520020',
            'nama_kecamatan' => 'PARANG',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520030 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520030',
            'nama_kecamatan' => 'LEMBEYAN',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520040 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520040',
            'nama_kecamatan' => 'TAKERAN',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520041 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520041',
            'nama_kecamatan' => 'NGUNTORONADI',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520050 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520050',
            'nama_kecamatan' => 'KAWEDANAN',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520060 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520060',
            'nama_kecamatan' => 'MAGETAN',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520061 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520061',
            'nama_kecamatan' => 'NGARIBOYO',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520070 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520070',
            'nama_kecamatan' => 'PLAOSAN',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520071 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520071',
            'nama_kecamatan' => 'SIDOREJO',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520080 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520080',
            'nama_kecamatan' => 'PANEKAN',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520090 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520090',
            'nama_kecamatan' => 'SUKOMORO',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520100 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520100',
            'nama_kecamatan' => 'BENDO',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520110 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520110',
            'nama_kecamatan' => 'MAOSPATI',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520120 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520120',
            'nama_kecamatan' => 'KARANGREJO',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520121 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520121',
            'nama_kecamatan' => 'KARAS',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520130 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520130',
            'nama_kecamatan' => 'BARAT',
            'created_at' => now(), 'updated_at' => now()
        ]);
        $kecId_3520131 = DB::table('kecamatans')->insertGetId([
            'kode_kecamatan' => '3520131',
            'nama_kecamatan' => 'KARTOHARJO',
            'created_at' => now(), 'updated_at' => now()
        ]);
    }
}
