<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Zakat;
use App\Models\Pemohon;
use App\Models\Pengeluaran;

class DashboardExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public function collection()
    {
        $total_uang = Zakat::sum('fitrah_uang') + Zakat::sum('maal') + Zakat::sum('infaq') + Zakat::sum('fidyah_uang');
        $total_beras = Zakat::sum('fitrah_beras') + Zakat::sum('fidyah_beras');
        $total_pemohon = Pemohon::count();
        $total_pengeluaran_uang = Pengeluaran::sum('biaya_uang') + Pengeluaran::sum('biaya_lainnya');
        $total_pengeluaran_beras = Pengeluaran::sum('biaya_beras');
        $total_uang_bersih = $total_uang - $total_pengeluaran_uang;
        $total_beras_bersih = $total_beras - $total_pengeluaran_beras;

        return collect([
            ['Total Pemasukan Uang', 'Rp ' . number_format($total_uang, 0, ',', '.')],
            ['Total Pemasukan Beras', number_format($total_beras, 0, ',', '.') . ' KG'],
            ['Total Pemohon', number_format($total_pemohon, 0, ',', '.') . ' Jiwa'],
            ['Total Pengeluaran Uang', 'Rp ' . number_format($total_pengeluaran_uang, 0, ',', '.')],
            ['Total Pengeluaran Beras', number_format($total_pengeluaran_beras, 0, ',', '.') . ' KG'],
            ['Total Uang Bersih', 'Rp ' . number_format($total_uang_bersih, 0, ',', '.')],
            ['Total Beras Bersih', number_format($total_beras_bersih, 0, ',', '.') . ' KG'],
        ]);
    }

    public function headings(): array
    {
        return [
            ['LAPORAN KEUANGAN ZAKAT'],
            ['RINGKASAN KESELURUHAN'],
            [''],
            ['Keterangan', 'Jumlah']
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
                $sheet->mergeCells('A1:B1');
                $sheet->mergeCells('A2:B2');
                $sheet->getStyle('A1:B1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:B2')->getAlignment()->setHorizontal('center');
            }
        ];
    }
}
