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
            'nama_sekolah' => 'TK Islam Prima Insani',
            'npsn' => '69956855',
            'kode_pos' => '44112',
            'nomor_telpon' => '(0262) 231348',
            'alamat' => 'Jl. Ciledug No. 281',
            'website' => 'https://www.primainsani.sch.id',
            'email' => 'gis.primainsani.sch.id',
            'kepala_sekolah' => 'Santi Rismayanti, M.Pd.',
            'nip_kepala_sekolah' => '19023L1040211212119024'
        ]);
    }
}
