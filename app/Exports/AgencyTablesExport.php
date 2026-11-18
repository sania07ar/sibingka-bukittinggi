<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AgencyTablesExport implements Export, WithMultipleSheets
{
    use Exportable;

    /**
     * @param array $sheets
     */
    public function __construct(
        protected array $sheets
    ) {}

    /**
     * @return array
     */
    public function sheets(): array
    {
        return $this->sheets;
    }
}
