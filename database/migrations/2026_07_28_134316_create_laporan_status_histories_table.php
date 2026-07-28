<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('laporan_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_sampah_id')->constrained('laporan_sampahs')->onDelete('cascade');
            $table->string('status_sebelum', 30)->nullable();
            $table->string('status_sesudah', 30);
            $table->text('keterangan')->nullable();
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('laporan_status_histories');
    }
};
