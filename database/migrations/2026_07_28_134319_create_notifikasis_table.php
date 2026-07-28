<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('laporan_sampah_id')->nullable()->constrained('laporan_sampahs')->onDelete('cascade');
            $table->string('judul', 150);
            $table->text('pesan');
            $table->enum('tipe', ['laporan_baru', 'verifikasi', 'penolakan', 'penugasan', 'status_update', 'rating_masuk']);
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
