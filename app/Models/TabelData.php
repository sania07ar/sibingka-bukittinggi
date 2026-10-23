<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelData extends Model
{
    use HasFactory;

    protected $table = 'tabel_opd_data';

    protected $fillable = [
        'table_code',
        'opd_code',
        'year',
        'row_key',
        'row_label',
        'value',
        'satuan',
        'order_index',
        'keterangan',
    ];
}
