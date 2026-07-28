<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'slug', 'thumbnail', 'konten', 'kategori', 'penulis_id', 'status', 'tanggal_publish', 'views'];
    protected $casts = ['tanggal_publish' => 'datetime'];
    public function penulis() { return $this->belongsTo(User::class, 'penulis_id'); }
    
}
