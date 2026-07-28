<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_sampah_id')->unique()->constrained('laporan_sampahs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
