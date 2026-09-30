<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;

class Siswa extends Model
{
    protected $table = 'siswas';
    public $incrementing = false;
    protected $primaryKey = 'nis';
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'nisn',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'anak_ke',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'alamat',
        'telepon',
        'kelas_id',
    ];

    public function getRouteKeyName()
    {
        return 'nis';
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function getAnakKeFormattedAttribute()
    {
        if (empty($this->anak_ke)) {
            return '-';
        }

        $angka = [
        1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat', 5 => 'Lima',
        6 => 'Enam', 7 => 'Tujuh', 8 => 'Delapan', 9 => 'Sembilan', 10 => 'Sepuluh',
    ];

    $terbilang = $angka[$this->anak_ke] ?? null;

    return $terbilang 
        ? "{$this->anak_ke} ({$terbilang})" 
        : $this->anak_ke;
    }
}
