<?php

namespace App\Exports;

use App\Models\Pemohon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PemohonExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public function collection()
    {
        return Pemohon::select('pemohon', 'alamat', 'status')->get();
    }

    public function headings(): array
    {
        return [
            ['DAFTAR PEMOHON ZAKAT FITRAH'],
            ['ZAKAT FITRAH, MAAL, INFAQ, DAN SHODAQOH TAHUN 2025'],
            ['MASJID AL HIKMAH PASADENA SEMARANG'],
            [''], // Baris kosong untuk pemisah
            ['NAMA LEMBAGA / PEMOHON', 'ALAMAT', 'KETERANGAN']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]], // Judul utama
            2 => ['font' => ['bold' => true, 'size' => 12]], // Subjudul
            3 => ['font' => ['bold' => true, 'size' => 12]], // Nama masjid
            5 => ['font' => ['bold' => true]], // Header kolom
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Mengatur merge cells agar format sesuai dengan file asli
                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('A2:C2');
                $sheet->mergeCells('A3:C3');

                // Memusatkan teks
                $sheet->getDelegate()->getStyle('A1:C1')->getAlignment()->setHorizontal('center');
                $sheet->getDelegate()->getStyle('A2:C2')->getAlignment()->setHorizontal('center');
                $sheet->getDelegate()->getStyle('A3:C3')->getAlignment()->setHorizontal('center');
                
                // Mengatur border untuk header
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];
                $sheet->getStyle('A5:C5')->applyFromArray($styleArray);
            }
        ];
    }
}
