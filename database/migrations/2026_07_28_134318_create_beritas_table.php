<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->string('slug', 220)->unique();
            $table->string('thumbnail')->nullable();
            $table->longText('konten');
            $table->enum('kategori', ['edukasi', 'pengumuman', 'kegiatan']);
            $table->foreignId('penulis_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published']);
            $table->timestamp('tanggal_publish')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
