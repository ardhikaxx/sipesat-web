<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('laporan_sampahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_laporan', 20)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_sampah_id')->constrained('kategori_sampahs')->onDelete('cascade');
            $table->foreignId('kecamatan_id')->constrained('kecamatans')->onDelete('cascade');
            $table->foreignId('desa_id')->constrained('desas')->onDelete('cascade');
            $table->string('judul_laporan', 150);
            $table->text('deskripsi');
            $table->text('alamat_lengkap');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->json('foto_laporan');
            $table->enum('prioritas_pelapor', ['rendah', 'sedang', 'tinggi']);
            $table->enum('prioritas_admin', ['rendah', 'sedang', 'tinggi', 'darurat'])->nullable();
            $table->enum('status', ['menunggu_verifikasi', 'ditolak', 'diverifikasi', 'sedang_ditangani', 'menunggu_validasi_akhir', 'selesai'])->default('menunggu_verifikasi');
            $table->text('alasan_penolakan')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('laporan_sampahs');
    }
};
