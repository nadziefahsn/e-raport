<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus'; // Sesuaikan dengan nama tabel di database
    
    // Mengizinkan semua field diisi agar tidak error saat menyimpan
    protected $guarded = [];

    /**
     * Relasi ke model User (Guru terhubung ke 1 User)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}