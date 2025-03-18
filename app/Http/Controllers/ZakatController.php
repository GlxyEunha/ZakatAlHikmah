<?php

namespace App\Http\Controllers;

use App\Exports\DashboardExport;
use App\Models\User;
use App\Models\Zakat;
use App\Models\Pemohon;
use App\Models\Pengeluaran;
use App\Exports\ZakatExport;
use Illuminate\Http\Request;
use App\Exports\PemohonExport;
use App\Exports\PengeluaranExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ZakatController extends Controller
{
    public function dashboard()
    {
        $total_uang = Zakat::sum('fitrah_uang') + Zakat::sum('maal') + Zakat::sum('infaq') + Zakat::sum('fidyah_uang');
        $total_beras = Zakat::sum('fitrah_beras') + Zakat::sum('fidyah_beras');
        $total_pemohon = Pemohon::count();
        $total_pengeluaran_uang = Pengeluaran::sum('biaya_uang') + Pengeluaran::sum('biaya_lainnya');
        $total_pengeluaran_beras = Pengeluaran::sum('biaya_beras');
        $total_uang_bersih = $total_uang - $total_pengeluaran_uang;
        $total_beras_bersih = $total_beras - $total_pengeluaran_beras;

        return view('dashboard', compact(
            'total_uang', 
            'total_beras', 
            'total_pemohon', 
            'total_pengeluaran_uang', 
            'total_pengeluaran_beras', 
            'total_uang_bersih', 
            'total_beras_bersih'
        ));
    }

    public function index_zakat(Request $request)
    {
        $query = trim($request->input('query')); // Menghapus spasi di awal dan akhir

        if (!empty($query)) {
            // Jika ada query pencarian, filter data berdasarkan nama
            $zakat = Zakat::where('nama', 'LIKE', "%{$query}%")->get();
        } else {
            // Jika query kosong, tampilkan semua data
            $zakat = Zakat::all();
        }

        return view('zakat', compact('zakat', 'query'));
    }


    public function store_zakat(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jml_jiwa' => 'required',
            'alamat' => 'required',
            'fitrah_uang' => 'required',
            'fitrah_beras' => 'required',
            'maal' => 'required',
            'infaq' => 'required',
            'fidyah_uang' => 'required',
            'fidyah_beras' => 'required',
            'fidyah_lainnya' => 'required',
            'panitia' => 'required',
        ]);

        // Bersihkan angka sebelum disimpan ke database
        $fitrah_uang = $this->bersihkanAngka($request->input('fitrah_uang'));
        $fitrah_beras = $this->bersihkanAngka($request->input('fitrah_beras'));
        $maal = $this->bersihkanAngka($request->input('maal'));
        $infaq = $this->bersihkanAngka($request->input('infaq'));
        $fidyah_uang = $this->bersihkanAngka($request->input('fidyah_uang'));
        $fidyah_beras = $this->bersihkanAngka($request->input('fidyah_beras'));
        $fidyah_lainnya = $this->bersihkanAngka($request->input('fidyah_lainnya'));

        // Simpan ke database
        $zakat = Zakat::create([
            'nama' => $request->input('nama'),
            'jml_jiwa' => $this->bersihkanAngka($request->input('jml_jiwa')), // Pastikan jumlah jiwa hanya angka
            'alamat' => $request->input('alamat'),
            'fitrah_uang' => $fitrah_uang,
            'fitrah_beras' => $fitrah_beras,
            'maal' => $maal,
            'infaq' => $infaq,
            'fidyah_uang' => $fidyah_uang,
            'fidyah_beras' => $fidyah_beras,
            'fidyah_lainnya' => $fidyah_lainnya,
            'panitia' => $request->input('panitia'),
        ]);

        return redirect()->route('rekap_zakat')->with('success', 'Zakat berhasil ditambahkan!');
    }

    public function edit_zakat($id)
    {
        $zakat = Zakat::findOrFail($id);
        return view('edit_zakat', compact('zakat'));
    }

    public function update_zakat(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jml_jiwa' => 'required',
            'alamat' => 'required',
            'fitrah_uang' => 'required',
            'fitrah_beras' => 'required',
            'maal' => 'required',
            'infaq' => 'required',
            'fidyah_uang' => 'required',
            'fidyah_beras' => 'required',
            'fidyah_lainnya' => 'required',
            'panitia' => 'required',
        ]);

        $zakat = Zakat::findOrFail($id);
        
        $zakat->update([
            'nama' => $request->input('nama'),
            'jml_jiwa' => $this->bersihkanAngka($request->input('jml_jiwa')),
            'alamat' => $request->input('alamat'),
            'fitrah_uang' => $this->bersihkanAngka($request->input('fitrah_uang')),
            'fitrah_beras' => $this->bersihkanAngka($request->input('fitrah_beras')),
            'maal' => $this->bersihkanAngka($request->input('maal')),
            'infaq' => $this->bersihkanAngka($request->input('infaq')),
            'fidyah_uang' => $this->bersihkanAngka($request->input('fidyah_uang')),
            'fidyah_beras' => $this->bersihkanAngka($request->input('fidyah_beras')),
            'fidyah_lainnya' => $this->bersihkanAngka($request->input('fidyah_lainnya')),
            'panitia' => $request->input('panitia'),
        ]);

        return redirect()->route('rekap_zakat')->with('success', 'Data zakat berhasil diperbarui!');
    }

    public function delete_zakat($id)
    {
        $zakat = Zakat::findOrFail($id);
        $zakat->delete();

        return redirect()->route('rekap_zakat')->with('success', 'Data zakat berhasil dihapus!');
    }

    public function delete_all_zakat()
    {
        Zakat::query()->delete();

        return redirect()->route('rekap_zakat')->with('success', 'Semua data zakat berhasil dihapus!');
    }

    public function index_pemohon(Request $request)
    {
        $query = trim($request->input('query')); // Menghapus spasi di awal dan akhir

        if (!empty($query)) {
            // Jika ada query pencarian, filter data berdasarkan nama
            $pemohon = Pemohon::where('pemohon', 'LIKE', "%{$query}%")->get();
        } else {
            // Jika query kosong, tampilkan semua data
            $pemohon = Pemohon::all();
        }
        return view('pemohon', compact('pemohon', 'query'));
    }

    public function store_pemohon(Request $request)
    {
        $request->validate([
            'pemohon' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $status = $request->has('gridCheck') ? 'Diterima' : 'Belum Diterima';

        Pemohon::create([
            'pemohon' => $request->pemohon,
            'alamat' => $request->alamat,
            'status' => $status,
        ]);

        return redirect()->route('rekap_pemohon')->with('success', 'Pemohon berhasil ditambahkan!');
    }

    // Menampilkan form edit pemohon
    public function edit_pemohon($id)
    {
        $pemohon = Pemohon::findOrFail($id);
        return view('edit_pemohon', compact('pemohon'));
    }

    // Memproses update data pemohon (tanpa mengubah status)
    public function update_pemohon(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'pemohon' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        // Tentukan status berdasarkan checkbox
        $status = isset($request->gridCheck) ? 'Diterima' : 'Belum Diterima';

        // Cari data pemohon berdasarkan ID
        $pemohon = Pemohon::findOrFail($id);

        // Update data
        $pemohon->update([
            'pemohon' => $validated['pemohon'],
            'alamat' => $validated['alamat'],
            'status' => $status,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('rekap_pemohon')->with('success', 'Data pemohon berhasil diperbarui!');
    }

    // Menghapus data pemohon
    public function delete_pemohon($id)
    {
        $pemohon = Pemohon::findOrFail($id);
        $pemohon->delete();

        return redirect()->route('rekap_pemohon')->with('success', 'Data pemohon berhasil dihapus!');
    }

    public function delete_all_pemohon()
    {
        Pemohon::query()->delete();

        return redirect()->route('rekap_pemohon')->with('success', 'Semua data pemohon berhasil dihapus!');
    }

    public function index_pengeluaran(Request $request)
    {
        $query = trim($request->input('query')); // Menghapus spasi di awal dan akhir

        if (!empty($query)) {
            // Jika ada query pencarian, filter data berdasarkan nama
            $pengeluaran = Pengeluaran::where('nama', 'LIKE', "%{$query}%")->get();
        } else {
            // Jika query kosong, tampilkan semua data
            $pengeluaran = Pengeluaran::all();
        }
        return view('pengeluaran', compact('pengeluaran', 'query'));
    }

    function bersihkanAngka($nilai) {
        return preg_replace('/[^0-9]/', '', $nilai);
    }    

    public function store_pengeluaran(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'nama' => 'required',
            'uraian' => 'required',
            'biaya_uang' => 'required',
            'biaya_beras' => 'required',
            'biaya_lainnya' => 'required',
            'keterangan' => 'required',
        ]);

        // Bersihkan input sebelum disimpan ke database
        $biaya_uang = $this->bersihkanAngka($request->input('biaya_uang'));
        $biaya_beras = $this->bersihkanAngka($request->input('biaya_beras'));
        $biaya_lainnya = $this->bersihkanAngka($request->input('biaya_lainnya'));

        // Simpan ke database
        $pengeluaran = Pengeluaran::create([
            'tanggal' => $request->input('tanggal'),
            'nama' => $request->input('nama'),
            'uraian' => $request->input('uraian'),
            'biaya_uang' => $biaya_uang,
            'biaya_beras' => $biaya_beras,
            'biaya_lainnya' => $biaya_lainnya,
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('rekap_pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function edit_pengeluaran($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('edit_pengeluaran', compact('pengeluaran'));
    }

    public function update_pengeluaran(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required',
            'nama' => 'required',
            'uraian' => 'required',
            'biaya_uang' => 'required',
            'biaya_beras' => 'required',
            'biaya_lainnya' => 'required',
            'keterangan' => 'required',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);

        $pengeluaran->update([
            'tanggal' => $request->input('tanggal'),
            'nama' => $request->input('nama'),
            'uraian' => $request->input('uraian'),
            'biaya_uang' => $this->bersihkanAngka($request->input('biaya_uang')),
            'biaya_beras' => $this->bersihkanAngka($request->input('biaya_beras')),
            'biaya_lainnya' => $this->bersihkanAngka($request->input('biaya_lainnya')),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('rekap_pengeluaran')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function delete_pengeluaran($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('rekap_pengeluaran')->with('success', 'Pengeluaran berhasil dihapus!');
    }

    public function delete_all_pengeluaran()
    {
        Pengeluaran::query()->delete();

        return redirect()->route('rekap_pengeluaran')->with('success', 'Semua data pengeluaran berhasil dihapus!');
    }

    public function export_pemohon()
    {
        return Excel::download(new PemohonExport, 'daftar_pemohon.xlsx');
    }

    public function export_pengeluaran()
    {
        return Excel::download(new PengeluaranExport, 'catatan_pengeluaran.xlsx');
    }

    public function export_zakat()
    {
        return Excel::download(new ZakatExport, 'Zakat.xlsx');
    }

    public function export_dashboard()
    {
        return Excel::download(new DashboardExport, 'Dashboard.xlsx');
    }
}
