<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;


    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'email',
        'nama_guru',
        'jabatan',
        'nip',
    ];
=======

    protected $table = 'gurus'; // Sesuaikan dengan nama tabel di database
    
    // Mengizinkan semua field diisi agar tidak error saat menyimpan
    protected $guarded = [];
>>>>>>> fitur-user

    /**
     * Relasi ke model User (Guru terhubung ke 1 User)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}