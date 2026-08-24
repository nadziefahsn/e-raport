<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KebersihanSiswa extends Model
{
    protected $table = 'kebersihans';
    protected $guarded = [];

    protected $fillable = [
        'anggota_kelas_id',
        'hasil_pakaian',
        'hasil_kuku',
        'hasil_rambut',
        'hasil_kulit',
        'keterangan',
    ];

    public function anggota_kelas_id()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }
}
