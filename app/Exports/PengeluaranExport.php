<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PengeluaranExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public function collection()
    {
        return Pengeluaran::select('tanggal', 'nama', 'uraian', 'biaya_uang', 'biaya_beras', 'biaya_lainnya', 'keterangan')->get();
    }

    public function headings(): array
    {
        return [
            ['DAFTAR PENGELUARAN KEGIATAN PENERIMAAN ZAKAT FITRAH'],
            ['ZAKAT FITRAH, MAAL, INFAQ, DAN SHODAQOH TAHUN 2025'],
            ['MASJID AL HIKMAH PASADENA SEMARANG'],
            [''], // Baris kosong
            ['TANGGAL PENGELUARAN', 'NAMA PELAPOR', 'URAIAN PENGELUARAN', 'BIAYA UANG', 'BIAYA BERAS', 'BIAYA LAINNYA', 'KETERANGAN']
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
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');

                // Memusatkan teks
                $sheet->getDelegate()->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
                $sheet->getDelegate()->getStyle('A2:G2')->getAlignment()->setHorizontal('center');
                $sheet->getDelegate()->getStyle('A3:G3')->getAlignment()->setHorizontal('center');
                
                // Mengatur border untuk header
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];
                $sheet->getStyle('A5:G5')->applyFromArray($styleArray);
            }
        ];
    }
}
