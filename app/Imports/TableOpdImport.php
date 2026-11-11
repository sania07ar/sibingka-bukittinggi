<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class TableOpdImport implements ToArray
{
    protected array $rows = [];

    public function array(array $array): void
    {
        $this->rows = $array;
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
