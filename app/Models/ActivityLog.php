<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = ['created_at' => 'datetime'];

    protected $fillable = ['user_id', 'aktivitas', 'modul', 'deskripsi', 'ip_address', 'user_agent', 'created_at'];
    public function user() { return $this->belongsTo(User::class); }
    
}
