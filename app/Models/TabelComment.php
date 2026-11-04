<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabelComment extends Model
{
    protected $table = 'tabel_opd_comments';

    protected $fillable = [
        'table_code',
        'opd_code',
        'year',
        'cell_key',
        'cell_label',
        'cell_value',
        'user_name',
        'user_role',
        'comment',
    ];

    protected $casts = [
        'year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

