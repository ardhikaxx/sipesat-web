<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

if (!function_exists('logActivity')) {
    function logActivity(string $aktivitas, string $modul, ?string $deskripsi = null, ?int $userId = null): ?ActivityLog
    {
        try {
            return ActivityLog::create([
                'user_id' => $userId ?? auth()->id(),
                'aktivitas' => $aktivitas,
                'modul' => $modul,
                'deskripsi' => $deskripsi,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }
}
