<?php

namespace App\Imports;

use App\Models\Materi;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MateriImport implements ToModel, WithHeadingRow
{
    protected $tahunAjaranAktifId;

    public function __construct()
    {
        $this->tahunAjaranAktifId = TahunAjaran::latest()->first()?->id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['nama_materi'])) {
            return null;
        }

        return new Materi([
            'capaian_hafalan_id' => $row['capaian_hafalan_id'],
            'kode'               => $row['kode'],
            'nama_materi'        => $row['nama_materi'],
            'jenjang'            => $row['jenjang'],
            'tahun_ajaran_id'    => $row['tahun_ajaran_id'] ?? $this->tahunAjaranAktifId,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}