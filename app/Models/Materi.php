<?php

namespace App\Models;
use App\Models\Hafalan;
use App\Models\TahunAjaran;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    
    protected $fillable = [
        'capaian_hafalan_id',
        'kode',
        'nama_materi',
        'jenjang',
        'tahun_ajaran_id',
    ];

    public function capaianHafalan()
    {
        return $this->belongsTo(Hafalan::class, 'capaian_hafalan_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

}
