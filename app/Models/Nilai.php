<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'anggota_kelas_id',
        'karakter_id',
        'nilai',
    ];
    //
}
