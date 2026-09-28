<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karakter extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'kode',
        'karakter',
        'tahun_ajaran_id',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
