<?php

namespace App\Models;
use App\Models\Guru;
use App\Models\TahunAjaran;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'rombel',
        'wali_kelas_id',
        'pendamping_id',
        'tahun_ajaran_id',
    ];

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function pendamping()
    {
        return $this->belongsTo(Guru::class, 'pendamping_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
    
}
