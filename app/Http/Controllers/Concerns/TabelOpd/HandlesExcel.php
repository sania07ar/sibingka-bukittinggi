<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

/**
 * Trait gabungan untuk ekspor & impor Excel.
 * Menggabungkan ExportsExcel dan ImportsExcel agar backward-compatible.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait HandlesExcel
{
    use ExportsExcel, ImportsExcel;
}
