<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\Karakter;
use App\Models\Kehadiran;
use App\Models\KriteriaPenilaian;
use App\Models\Sekolah;
use App\Models\AnggotaKelas;
use App\Models\TahunAjaran;
use App\Models\CapaianPerkembangan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PdfController extends Controller
{
    public function index(Request $request)
    {
        $anggotaKelasId = $request->input('anggota_id');
        $tahunAjarans = TahunAjaran::latest()->first();

        if (!$anggotaKelasId) {
            $anggotaKelas = AnggotaKelas::first();

            if (!$anggotaKelas) {
                return redirect()->back()->with('error', 'Data anggota kelas tidak ditemukan.');
            }

            $anggotaKelasId = $anggotaKelas->id;
        }

        return $this->show($request, $anggotaKelasId);
    }

    public function show(Request $request, string $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $decryptedId = $id;
        }

        $pdfOptions = [
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'chroot' => public_path(),
        ];

        $sekolah = Sekolah::first();
        $karakters = Karakter::all();
        $kehadirans = Kehadiran::all();
        $tahun_ajarans = TahunAjaran::all(); 
        $kriterias = KriteriaPenilaian::all();
        
        $anggotaKelas = AnggotaKelas::with([
            'siswa',
            'kelas.tahunAjaran',
            'nilaiKarakter',
            'hasilCapaian',
            'kehadiran',
            'kebersihanSiswa',
            'kesehatanMata',
            'kesehatanTelinga',
            'kesehatanGigi',
            'kesehatanMulut',
            'kondisiTubuh'
        ])->findOrFail($decryptedId);

        $siswa = $anggotaKelas->siswa;

        $namaKelas = $anggotaKelas->kelas->rombel ?? '';
        $rombelUpper = strtoupper($namaKelas);

        if (str_contains($rombelUpper, 'B')) {
            $jenjangTujuan = 'TK B';
            $usia = '5-6';
        } elseif (str_contains($rombelUpper, 'A')) {
            $jenjangTujuan = 'TK A';
            $usia = '4-5';
        } else {
            $jenjangTujuan = 'PG';
            $usia = '3-4';
        }

        $kelasId = $anggotaKelas->kelas_id;
        
        $tahunAjaranId = $anggotaKelas->kelas->tahun_ajaran_id ?? null;

        $capaianPerkembangan = CapaianPerkembangan::with(['indikators' => function ($query) use ($jenjangTujuan, $tahunAjaranId) {
            $query->when($jenjangTujuan, function ($q) use ($jenjangTujuan) {
                $q->where('jenjang', $jenjangTujuan);
            })
            ->when($tahunAjaranId, function ($q) use ($tahunAjaranId) {
                $q->where('tahun_ajaran_id', $tahunAjaranId);
            })
            ->with('indikatorCapaian');
        }])->get();

        $daftarCapaian = [];
        $abjad = range('A', 'Z');

        foreach ($capaianPerkembangan as $index => $kategori) {
            $prefix = isset($abjad[$index]) ? $abjad[$index] . '. ' : '';
            $namaJudul = $kategori->capaian_perkembangan ?? 'KATEGORI';
            $keyJudul = $prefix . strtoupper($namaJudul);

            $daftarCapaian[$keyJudul] = $kategori->indikators;
        }

        $tahunAjaranAktif = TahunAjaran::latest()->first();

        $pdf = Pdf::loadView('pdf.rapot', compact(
            'sekolah',
            'karakters',
            'kehadirans',
            'kriterias',
            'anggotaKelas',
            'siswa',
            'jenjangTujuan',
            'usia', 
            'daftarCapaian',
            'tahunAjaranAktif'
        ))->setPaper('A4', 'portrait')
        ->setOption($pdfOptions);

        $namaKelasClean = $namaKelas ?: 'Kelas';
        $namaSiswa = $siswa->nama_siswa ?? 'Siswa';
        
        $fileName = 'Penilaian Karakter & Biodata (' . $jenjangTujuan . ') - ' . trim($namaKelasClean) . '_' . trim($namaSiswa) . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}