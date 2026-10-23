<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelMetadata extends Model
{
    use HasFactory;

    protected $table = 'tabel_opd_metadata';

    protected $fillable = [
        'table_code',
        'opd_code',
        'year',
        'title_id',
        'title_en',
        'source',
        'note',
        'table_html',
        'source_type',
        'is_saved',
    ];

    protected $casts = [
        'is_saved' => 'boolean',
    ];
}
