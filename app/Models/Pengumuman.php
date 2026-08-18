<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = [
        'user_id',
        'judul',
        'isi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
