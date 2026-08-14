<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DesaSeeder extends Seeder {
    public function run(): void {
        // Desa for PONCOL
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520010')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GONGGANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PONCOL', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'CILENG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SOMBO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PLANGKRONGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'ALASTUWO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'JANGGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GENILANGIT', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for PARANG
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520020')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SAYUTAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGLOPANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MATEGAL', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TROSONO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGAGLIK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PARANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAMANARUM', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PRAGAK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KRAJAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'JOKETRO', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for LEMBEYAN
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520030')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KEDIREN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'LEMBEYAN KULON', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'LEMBEYAN WETAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KEDUNGPANJI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGURI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAPEN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KROWE', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for TAKERAN
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520040')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KIRINGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAWANGREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SAWOJAJAR', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAKERAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KUWONHARJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KEPUHREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KERIK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'WADUK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'JOMBLANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KERANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MADIGONDO', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for NGUNTORONADI
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520041')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUKOWIDI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GORANG GARENG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PETUNGREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGUNTORONADI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'DRIYOREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SIMBATAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PURWOREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KENONGOMULYO', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for KAWEDANAN
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520050')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GIRIPURNO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BALEREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GARON', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TLADAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'POJOK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KAWEDANAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SAMPUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MANGUNREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SELOREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'JAMBANGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BOGEM', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'REJOSARI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MOJOREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GENENGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KARANGREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGADIREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUGIHREJO', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for MAGETAN
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520060')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'RINGINAGUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'CANDIREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SELOSARI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MAGETAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BULUKERTO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MANGKUJAYAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAMBAKREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAMBRAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KEBONAGUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KEPOLOREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAWANGANOM', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUKOWINANGUN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BARON', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PURWOSARI', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for NGARIBOYO
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520061')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SELOTINATAH', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BANYUDONO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BANJARPANJANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BANJAREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MOJOPURNO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BALEGONDO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGARIBOYO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BALEASRI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SELOPANGGUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BANGSRI', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for PLAOSAN
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520070')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGANCAR', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PUNTUKDORO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BOGOARUM', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'RANDUGEDE', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUMBERAGUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NITIKAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SIDOMUKTI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BULUHARJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PLAOSAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'DADI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SARANGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PACALAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SENDANGAGUNG', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for SIDOREJO
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520071')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GETASANYAR', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SIDOREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'DURENAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SAMBIROBYONG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'CAMPURSARI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KALANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'WIDOROKANDANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SIDOKERTO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUMBERSAWIT', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SIDOMULYO', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for PANEKAN
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520080')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'CEPOKO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MILANGASRI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'WATES', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PANEKAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MANJUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TANJUNGSARI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUMBERDODOL', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAPAK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUKOWIDI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BEDAGUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGILIRAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'JABUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'REJOMULYO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TURI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SIDOWAYAH', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BANJAREJO', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for SUKOMORO
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520090')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KALANGKETI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAMANAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAMBAKMAS', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BANDAR', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BIBIS', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUKOMORO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'POJOKSARI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TINAP', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KEMBANGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KEDUNGGUWO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KENTANGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BOGEM', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for BENDO
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520100')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BELOTAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PINGKUK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TANJUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TEGALARUM', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BULAK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SOCO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'CARIKAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BENDO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KLECO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KLEDOKAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'LEMAHBANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KINANDANG', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for MAOSPATI
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520110')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUGIHWARAS', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TANJUNGSEPREH', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MALANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MAOSPATI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KLAGEN GAMBIRAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PANDEYAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SURATMAJAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'RONOWIJAYAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUMBEREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KRATON', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MRANGGEN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SEMPOL', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for KARANGREJO
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520120')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MANTREN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GONDANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SAMBIREMBE', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PATIHAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KARANGREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MANISREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GEBYOG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PRAMPELAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GRABAHAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KAUMAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MARON', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BALUK', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for KARAS
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520121')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BOTOK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GINUK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TAJI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TEMBORO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TEMENGGUNGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GEPLAK', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KARAS', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KUWON', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SOBONTORO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUMURSONGO', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for BARAT
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520130')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BANJAREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PURWODADI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KARANGSONO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BOGOREJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'TEBON', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MANJUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PANGGUNG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KLAGEN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BANGUNASRI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BLARAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MANGGE', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'JONGGRANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'REJOMULYO', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        // Desa for KARTOHARJO
        $kec = DB::table('kecamatans')->where('kode_kecamatan', '3520131')->first();
        if($kec) {
            DB::table('desas')->insert([
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KLURAHAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'PENCOL', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'SUKOWIDI', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KARTOHARJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'NGELANG', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'JAJAR', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'GUNUNGAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'KARANGMOJO', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'MRAHU', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BAYEM TAMAN', 'created_at' => now(), 'updated_at' => now()],
                ['kecamatan_id' => $kec->id, 'nama_desa' => 'BAYEM WETAN', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
