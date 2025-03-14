<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemohon extends Model
{
    use HasFactory;

    protected $table = 'pemohon_zakat';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'pemohon', 'alamat', 'status'];

    public $timestamps = false;
}
