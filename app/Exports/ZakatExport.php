<?php

namespace App\Exports;

use App\Models\Zakat;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ZakatExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new TotalPemasukanSheet(),
            new RekapZakatSheet(),
        ];
    }
}