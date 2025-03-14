<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'catatan_pengeluaran';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tanggal', 'nama', 'uraian', 'biaya_uang', 'biaya_beras', 'biaya_lainnya', 'keterangan'];

    public $timestamps = false;
}
