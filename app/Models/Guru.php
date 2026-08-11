<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{

    protected $fillable = [
        'user_id',
        'nama_guru',
        'jabatan',
        'nip',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

