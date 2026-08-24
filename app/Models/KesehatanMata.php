<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KesehatanMata extends Model
{
    protected $table = 'matas';

    protected $fillable = [
        'anggota_kelas_id',
        'ketajaman_kanan',
        'ketajaman_kiri',
        'buta_warna',
        'radang_kanan',
        'radangkiri',
        'juling_kanan',
        'juling_kiri',
    ];

    public function anggota_kelas_id()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }

}
