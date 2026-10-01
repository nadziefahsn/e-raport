<?php

namespace App\Imports;

use App\Models\Indikator;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndikatorImport implements ToModel, WithHeadingRow
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
        if (empty($row['nama_indikator'])) {
            return null;
        }

        return new Indikator([
            'capaian_perkembangan_id' => $row['capaian_perkembangan_id'],
            'kode'               => $row['kode'],
            'nama_indikator'        => $row['nama_indikator'],
            'jenjang'            => $row['jenjang'],
            'tahun_ajaran_id'    => $row['tahun_ajaran_id'] ?? $this->tahunAjaranAktifId,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}