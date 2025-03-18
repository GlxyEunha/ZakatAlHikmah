<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zakat extends Model
{
    use HasFactory;

    protected $table = 'zakat';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama', 'jml_jiwa', 'alamat', 'fitrah_uang', 'fitrah_beras', 'maal', 'infaq', 'fidyah_uang', 'fidyah_beras', 'fidyah_lainnya', 'panitia'];

}
