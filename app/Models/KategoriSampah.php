<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriSampah extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori', 'deskripsi', 'icon', 'is_active'];
    
}
