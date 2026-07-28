<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('dokumentasi_penanganans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_sampah_id')->constrained('laporan_sampahs')->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained('petugas')->onDelete('cascade');
            $table->json('foto_sebelum');
            $table->json('foto_sesudah')->nullable();
            $table->text('catatan_pekerjaan')->nullable();
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_penanganans');
    }
};
