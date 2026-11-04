<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringStage extends Model
{
    protected $table = 'monitoring_stages';

    protected $fillable = [
        'agency_type',
        'agency_code',
        'year',
        'stage',
        'status_text',
        'notes',
    ];

    public static function getStageInfo(int $stage): array
    {
        return match ($stage) {
            1 => ['label' => 'Persiapan', 'badge' => 'Belum Mulai', 'type' => 'belum', 'color' => 'rose'],
            2 => ['label' => 'Input Data', 'badge' => 'Pengisian', 'type' => 'berjalan', 'color' => 'orange'],
            3 => ['label' => 'Verifikasi', 'badge' => 'Verifikasi', 'type' => 'berjalan', 'color' => 'orange'],
            4 => ['label' => 'Validasi BPS', 'badge' => 'Validasi BPS', 'type' => 'berjalan', 'color' => 'orange'],
            5 => ['label' => 'Publikasi', 'badge' => 'Publikasi Selesai', 'type' => 'selesai', 'color' => 'emerald'],
            default => ['label' => 'Persiapan', 'badge' => 'Belum Mulai', 'type' => 'belum', 'color' => 'rose'],
        };
    }
}

