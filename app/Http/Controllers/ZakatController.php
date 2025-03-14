<?php

namespace App\Http\Controllers;

use App\Models\Pemohon;
use App\Models\Pengeluaran;
use App\Models\User;
use App\Models\Zakat;
use Illuminate\Http\Request;

class ZakatController extends Controller
{
    public function index_zakat()
    {
        $zakat = Zakat::all();
        return view('zakat', compact('zakat'));
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

        // Create user
        $zakat = Zakat::create([
            'nama' => $request->nama,
            'jml_jiwa' => $request->jml_jiwa,
            'alamat' => $request->alamat,
            'fitrah_uang' => $request->fitrah_uang,
            'fitrah_beras' => $request->fitrah_beras,
            'maal' => $request->maal,
            'infaq' => $request->infaq,
            'fidyah_uang' => $request->fidyah_uang,
            'fidyah_beras' => $request->fidyah_beras,
            'fidyah_lainnya' => $request->fidyah_lainnya,
            'panitia' => $request->panitia,
        ]);

        return redirect()->route('rekap_zakat')->with('success', 'Zakat berhasil ditambahkan!');
    }

    public function index_pemohon()
    {
        $pemohon = Pemohon::all();
        return view('pemohon', compact('pemohon'));
    }

    public function store_pemohon(Request $request)
    {
        $request->validate([
            'pemohon' => 'required',
            'alamat' => 'required',
            'status' => 'required',
        ]);

        // Create user
        $pemohon = Pemohon::create([
            'pemohon' => $request->pemohon,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()->route('rekap_pemohon')->with('success', 'Pemohon berhasil ditambahkan!');
    }

    public function index_pengeluaran()
    {
        $pengeluaran = Pengeluaran::all();
        return view('pengeluaran', compact('pengeluaran'));
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

        // Create user
        $pengeluaran = Pengeluaran::create([
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'uraian' => $request->uraian,
            'biaya_uang' => $request->biaya_uang,
            'biaya_beras' => $request->biaya_beras,
            'biay_lainnya' => $request->biay_lainnya,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('rekap_pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }
}
