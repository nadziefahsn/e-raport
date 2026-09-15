<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KriteriaPenilaian;
use App\Models\Sekolah;
use App\Models\AnggotaKelas;
use App\Models\CapaianPerkembangan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PdfController extends Controller
{

    public function index(Request $request)
    {
        $anggotaKelasId = $request->input('anggota_id');

        if (!$anggotaKelasId) {
            $anggotaKelas = AnggotaKelas::first();

            if (!$anggotaKelas) {
                return redirect()->back()->with('error', 'Data anggota kelas tidak ditemukan.');
            }

            $anggotaKelasId = $anggotaKelas->id;
        }

        return $this->show($anggotaKelasId);
    }

    public function show($id)
    {
        $sekolah = Sekolah::first();
        $kriterias = KriteriaPenilaian::all();
        
        $anggotaKelas = AnggotaKelas::with([
            'siswa', 
            'kelas.tahunAjaran',
            'kebersihanSiswa',
            'kesehatanMata',
            'kesehatanTelinga',
            'kesehatanGigi',
            'kesehatanMulut',
            'kondisiTubuh'
        ])->findOrFail($id);

        $namaKelas = $anggotaKelas->kelas->rombel ?? '';
        $rombelUpper = strtoupper($namaKelas);

        if (str_contains($rombelUpper, 'B')) {
            $jenjangTujuan = 'TK B';
        } elseif (str_contains($rombelUpper, 'A')) {
            $jenjangTujuan = 'TK A';
        } else {
            $jenjangTujuan = 'PG';
        }

        $kelasId = $anggotaKelas->kelas_id;
        $tahunAjaranId = $anggotaKelas->kelas->tahun_ajaran_id ?? null;

        $capaianPerkembangan = CapaianPerkembangan::with(['indikators' => function ($query) use ($jenjangTujuan) {
            $query->when($jenjangTujuan, function ($q) use ($jenjangTujuan) {
                $q->where('jenjang', $jenjangTujuan);
            })->with('indikatorCapaian');
        }])->get();

        $daftarCapaian = [];
        $abjad = range('A', 'Z');

        foreach ($capaianPerkembangan as $index => $kategori) {
            $prefix = isset($abjad[$index]) ? $abjad[$index] . '. ' : '';
            $namaJudul = $kategori->capaian_perkembangan ?? 'KATEGORI';
            $keyJudul = $prefix . strtoupper($namaJudul);

            $daftarCapaian[$keyJudul] = $kategori->indikators;
        }

        $pdf = Pdf::loadView('pdf.rapot', compact(
            'sekolah',
            'karakters',
            'kehadirans',
            'kriterias',
            'anggotaKelas',
            'siswa',
            'jenjangTujuan',
            'daftarCapaian'
        ))->setPaper('A4', 'portrait')
        ->setOption($pdfOptions);

        $namaKelasClean = $namaKelas ?: 'Kelas';
        $namaSiswa = $siswa->nama_siswa ?? $siswa->nama_siswa ?? 'Siswa';
        
        $fileName = 'Penilaian Karakter & Biodata (' . $jenjangTujuan . ') - ' . trim($namaKelasClean) . '_' . trim($namaSiswa) . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }
}