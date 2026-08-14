<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'nama_lengkap',
        'usia',
        'blok_rumah',
        'nomor_rumah',
        'nomor_undian',
        'sudah_diundi',
        'diundi_pada',
        'batch_undian',
    ];
}
