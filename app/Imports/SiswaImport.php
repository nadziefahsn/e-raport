<?php

namespace App\Imports;

use App\Models\AnggotaKelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $tanggal_lahir = isset($row['tanggal_lahir'])
            ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('Y-m-d')
            : null;

        $siswa = Siswa:: create([
            'nis'                   => $row['nis'],
            'nisn'                  => $row['nisn'],
            'nama_siswa'            => $row['nama_siswa'],
            'jenis_kelamin'         => $row['jenis_kelamin'],
            'tempat_lahir'          => $row['tempat_lahir'],
            'tanggal_lahir'         => $tanggal_lahir,        
            'agama'                 => $row['agama'],
            'nama_ayah'             => $row['nama_ayah'],
            'nama_ibu'              => $row['nama_ibu'],
            'pekerjaan_ayah'        => $row['pekerjaan_ayah'],
            'pekerjaan_ibu'         => $row['pekerjaan_ibu'],
            'alamat'                => $row['alamat'],
            'telepon'               => $row['telepon'],
            'anak_ke'               => $row['anak_ke'],
        ]);

        AnggotaKelas::create([
            'nis_id'                => $siswa->nis,
        ]);

        return $siswa;
    }
}
