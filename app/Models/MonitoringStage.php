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
            1 => ['label' => 'Input Data', 'badge' => 'Input Data', 'type' => 'belum', 'color' => 'slate'],
            2 => ['label' => 'Verifikasi', 'badge' => 'Verifikasi Wali Data', 'type' => 'berjalan', 'color' => 'orange'],
            3 => ['label' => 'Validasi BPS', 'badge' => 'Validasi BPS Admin', 'type' => 'selesai', 'color' => 'emerald'],
            default => ['label' => 'Input Data', 'badge' => 'Input Data', 'type' => 'belum', 'color' => 'slate'],
        };
    }
}

