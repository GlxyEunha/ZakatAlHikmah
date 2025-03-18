<?php

namespace App\Exports;

use App\Models\Zakat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TotalPemasukanSheet implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public function collection()
    {
        $groupedZakat = Zakat::selectRaw("
            DATE(created_at) as tanggal,
            SUM(jml_jiwa) as jumlah_jiwa,
            SUM(fitrah_uang) as fitrah_uang,
            SUM(fitrah_beras) as fitrah_beras,
            SUM(maal) as maal,
            SUM(infaq) as infaq,
            SUM(fidyah_uang) as fidyah_uang,
            SUM(fidyah_beras) as fidyah_beras,
            SUM(fidyah_lainnya) as fidyah_lainnya
        ")->groupBy('tanggal')->get();

        // Hitung total keseluruhan
        $totalFitrahUang = $groupedZakat->sum('fitrah_uang');
        $totalMaal = $groupedZakat->sum('maal');
        $totalInfaq = $groupedZakat->sum('infaq');
        $totalFidyahUang = $groupedZakat->sum('fidyah_uang');
        $totalGabunganUang = $totalFitrahUang + $totalMaal + $totalInfaq + $totalFidyahUang;

        $totalFitrahBeras = $groupedZakat->sum('fitrah_beras');
        $totalFidyahBeras = $groupedZakat->sum('fidyah_beras');
        $totalGabunganBeras = $totalFitrahBeras + $totalFidyahBeras;

        // Tambahkan total ke dalam koleksi
        $groupedZakat->push([
            'tanggal' => 'TOTAL',
            'jumlah_jiwa' => number_format($groupedZakat->sum('jumlah_jiwa'), 0, ',', '.'),
            'fitrah_uang' => 'Rp ' . number_format($totalFitrahUang, 0, ',', '.'),
            'fitrah_beras' => number_format($totalFitrahBeras, 0, ',', '.') . ' KG',
            'maal' => 'Rp ' . number_format($totalMaal, 0, ',', '.'),
            'infaq' => 'Rp ' . number_format($totalInfaq, 0, ',', '.'),
            'fidyah_uang' => 'Rp ' . number_format($totalFidyahUang, 0, ',', '.'),
            'fidyah_beras' => number_format($totalFidyahBeras, 0, ',', '.') . ' KG',
            'fidyah_lainnya' => number_format($groupedZakat->sum('fidyah_lainnya'), 0, ',', '.')
        ]);

        // Tambahkan baris baru untuk total gabungan
        $groupedZakat->push([
            'tanggal' => 'TOTAL GABUNGAN UANG',
            'jumlah_jiwa' => '',
            'fitrah_uang' => '',
            'fitrah_beras' => 'Rp ' . number_format($totalGabunganUang, 0, ',', '.'),
            'maal' => 'TOTAL GABUNGAN BERAS',
            'infaq' => '',
            'fidyah_uang' => '',
            'fidyah_beras' => number_format($totalGabunganBeras, 0, ',', '.') . ' KG',
            'fidyah_lainnya' => '',
        ]);

        return $groupedZakat;
    }

    public function headings(): array
    {
        return [
            ['TOTAL PEMASUKAN ZAKAT'],
            ['ZAKAT FITRAH, MAAL, INFAQ, DAN SHODAQOH'],
            [''],
            ['TANGGAL', 'JUMLAH JIWA', 'ZAKAT FITRAH UANG (Rp - IDR)', 'ZAKAT FITRAH BERAS (KG)', 'ZAKAT MAAL', 'INFAQ/SHODAQOH', 'FIDYAH UANG (Rp - IDR)', 'FIDYAH BERAS (Kg)', 'FIDYAH LAINNYA']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            4 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');
                $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal('center');
            }
        ];
    }
}
