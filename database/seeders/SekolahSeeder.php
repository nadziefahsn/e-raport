<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sekolah::create([
            'nama_sekolah' => 'TK Islam Plus Prima Insani',
            'npsn' => '69956855',
            'alamat' => 'Jl. Ciledug No. 281',
            'kode' => '44112',
            'telepon' => '081234567890',
            'desa' => 'Kota Kulon',
            'kecamatan' => 'Garut Kota',
            'kabupaten' => 'Garut',
            'provinsi' => 'Jawa Barat',
            'logo' => null,
        ]);
    }
}
