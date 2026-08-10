<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    protected $table = 'kriteria_penilaians';

    protected $fillable=[
        'kriteria',
        'deskripsi',
    ];
}
