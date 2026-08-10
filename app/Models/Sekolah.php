<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{

    protected $fillable=[
        'nama_sekolah',
        'npsn',
        'alamat',
        'kode',
        'telepon',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'logo',
    ];
}
