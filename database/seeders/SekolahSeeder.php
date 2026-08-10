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
            'nama_sekolah' => 'TK Prima Insani',
            'npsn' => '123456789',
            'alamat' => 'Jl. Ciledug',
            'kode' => 'TKBI001',
            'telepon' => '081234567890',
            'desa' => 'Kota Kulon',
            'kecamatan' => 'Garut Kota',
            'kabupaten' => 'Garut',
            'provinsi' => 'Jawa Barat',
            'logo' => null,
            ]);
    }
}
