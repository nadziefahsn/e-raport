<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Siswa;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SiswaImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            if ($index < 8) {
                continue;
            }

            $nis = !empty($row[1]) ? trim((string)$row[1]) : null;

            if (empty($nis) || !is_numeric($nis)) {
                continue;
            }

            if (strlen($nis) < 5) {
                continue;
            }

            $colC = trim((string)($row[2] ?? ''));
            $colD = trim((string)($row[3] ?? ''));
            $colE = trim((string)($row[4] ?? ''));

            $nisn = '-';
            $nama_siswa = '-';
            $offset = 0;

            if (!empty($colC) && (preg_match('/^[AB]\d+$/i', $colC) || strtolower($colC) === 'pg')) {
                $nisn = (is_numeric($colD) && strlen($colD) >= 8) ? $colD : '-';
                $nama_siswa = (!empty($colD) && !is_numeric($colD)) ? $colD : (!empty($colE) ? $colE : '-');
                if (!empty($colD) && !is_numeric($colD)) {
                    $offset = -1;
                }
            } else {
                $nisn = (is_numeric($colC) && strlen($colC) >= 8) ? $colC : '-';
                $nama_siswa = !empty($colE) ? $colE : (!empty($colD) && !is_numeric($colD) ? $colD : '-');
                $offset = 0;
            }

            $nama_lower = strtolower($nama_siswa);
            if (
                empty($nama_siswa) || 
                $nama_siswa === '-' || 
                strlen($nama_siswa) < 3 || 
                str_contains($nama_lower, '/') || 
                str_contains($nama_lower, 'tahun') || 
                str_contains($nama_lower, 'ajaran') || 
                str_contains($nama_lower, 'kelompok') || 
                str_contains($nama_lower, 'wali') || 
                str_contains($nama_lower, 'guru') ||
                preg_match('/\d{4}/', $nama_siswa)
            ) {
                continue;
            }

            $jk_idx      = 5 + $offset;
            $tempat_idx  = 6 + $offset;
            $tanggal_idx = 7 + $offset;
            $agama_idx   = 8 + $offset;
            $anak_idx    = 9 + $offset;
            $ayah_idx    = 10 + $offset;
            $p_ayah_idx  = 11 + $offset;
            $ibu_idx     = 14 + $offset;
            $p_ibu_idx   = 15 + $offset;
            $alamat_idx  = 16 + $offset;
            $telepon_idx = 22 + $offset;

            $jk_raw = strtoupper(trim((string)($row[$jk_idx] ?? '')));
            if ($jk_raw === 'P' || str_contains($jk_raw, 'PEREMP')) {
                $jenis_kelamin = 'Perempuan';
            } else {
                $jenis_kelamin = 'Laki-laki';
            }

            $tanggal_lahir = $this->parseTanggal($row[$tanggal_idx] ?? null);

            Siswa::updateOrCreate(
                ['nis' => $nis],
                [
                    'nisn'           => $nisn,
                    'nama_siswa'     => $nama_siswa,
                    'jenis_kelamin'  => $jenis_kelamin,
                    'tempat_lahir'   => !empty($row[$tempat_idx]) ? trim((string)$row[$tempat_idx]) : '-',
                    'tanggal_lahir'  => $tanggal_lahir,
                    'agama'          => !empty($row[$agama_idx]) ? trim((string)$row[$agama_idx]) : 'Islam',
                    'anak_ke'        => is_numeric($row[$anak_idx] ?? null) ? $row[$anak_idx] : 1,
                    'nama_ayah'      => !empty($row[$ayah_idx]) ? trim((string)$row[$ayah_idx]) : '-',
                    'pekerjaan_ayah' => !empty($row[$p_ayah_idx]) ? trim((string)$row[$p_ayah_idx]) : '-',
                    'nama_ibu'       => !empty($row[$ibu_idx]) ? trim((string)$row[$ibu_idx]) : '-',
                    'pekerjaan_ibu'  => !empty($row[$p_ibu_idx]) ? trim((string)$row[$p_ibu_idx]) : '-',
                    'alamat'         => !empty($row[$alamat_idx]) ? trim((string)$row[$alamat_idx]) : '-',
                    'telepon'        => !empty($row[$telepon_idx]) ? trim((string)$row[$telepon_idx]) : '-',
                ]
            );
        }
    }

    private function parseTanggal($val): string
    {
        $default = '2000-01-01';

        if (empty($val) || $val === '-') {
            return $default;
        }

        if (is_numeric($val)) {
            if ($val > 100000) return $default;

            try {
                return Date::excelToDateTimeObject($val)->format('Y-m-d');
            } catch (\Throwable $e) {
                return $default;
            }
        }

        $val = trim((string)$val);

        $bulanIndo = [
            'januari' => '01', 'jan' => '01',
            'februari' => '02', 'feb' => '02',
            'maret' => '03', 'mar' => '03',
            'april' => '04', 'apr' => '04',
            'mei' => '05', 'may' => '05',
            'juni' => '06', 'jun' => '06',
            'juli' => '07', 'jul' => '07',
            'agustus' => '08', 'ags' => '08', 'aug' => '08',
            'september' => '09', 'sep' => '09',
            'oktober' => '10', 'okt' => '10', 'oct' => '10',
            'november' => '11', 'nov' => '11', 'nopember' => '11', 'nop' => '11',
            'desember' => '12', 'des' => '12', 'dec' => '12',
        ];

        $parts = preg_split('/[\s\-\/]+/', $val);

        if (count($parts) >= 3) {
            $tgl = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
            $blnKey = strtolower($parts[1]);
            $thn = $parts[2];

            if (strlen($thn) === 2) {
                $thn = '20' . $thn;
            }

            if (isset($bulanIndo[$blnKey])) {
                return "{$thn}-{$bulanIndo[$blnKey]}-{$tgl}";
            }
        }

        try {
            return Carbon::parse($val)->format('Y-m-d');
        } catch (\Throwable $e) {
            return $default;
        }
    }
}