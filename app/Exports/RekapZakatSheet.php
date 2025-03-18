<?php

namespace App\Exports;

use App\Models\Zakat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapZakatSheet implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public function collection()
    {
        return Zakat::select('nama', 'jml_jiwa', 'alamat', 'fitrah_uang', 'fitrah_beras', 'maal', 'infaq', 'panitia', 'fidyah_uang', 'fidyah_beras', 'fidyah_lainnya')->get();
    }

    public function headings(): array
    {
        return [
            ['REKAP ZAKAT'],
            [''],
            ['NAMA', 'JUMLAH JIWA', 'ALAMAT', 'ZAKAT FITRAH UANG (Rp - IDR)', 'ZAKAT FITRAH BERAS (KG)', 'ZAKAT MAAL', 'INFAQ/SHODAQOH', 'NAMA PENERIMA (PANITIA)', 'FIDYAH UANG (Rp - IDR)', 'FIDYAH BERAS (Kg)', 'FIDYAH LAINNYA']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            3 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:K1');
                $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal('center');
            }
        ];
    }
}
