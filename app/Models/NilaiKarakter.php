<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiKarakter extends Model
{
    protected $fillable = [
        'anggota_kelas_id',
        'karakter_id',
        'nilai',
    ];
    

    public function karakter()
    {
        return $this->belongsTo(Karakter::class, 'karakter_id');
    }

    public function anggotaKelas()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }
}
