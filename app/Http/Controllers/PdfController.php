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
        $kriterias = KriteriaPenilaian::all();

        $anggotaKelas = AnggotaKelas::with([
            'siswa',
            'kelas.tahunAjaran',
            'nilaiKarakter',
            'kehadiran',
            'kebersihanSiswa',
            'kesehatanMata',
            'kesehatanTelinga',
            'kesehatanGigi',
            'kesehatanMulut',
            'kondisiTubuh'
        ])->findOrFail($decryptedId);

        $siswa = $anggotaKelas->siswa;

        $pdf = Pdf::loadView('pdf.rapot', compact(
            'sekolah',
            'karakters',
            'kehadirans',
            'kriterias',
            'anggotaKelas',
            'siswa'
        ))->setPaper('A4', 'portrait')
        ->setOption($pdfOptions);

        $namaKelas = $anggotaKelas->kelas->rombel ?? 'Kelas';
        $namaSiswa = $siswa->nama_lengkap ?? $siswa->nama_siswa ?? 'Siswa';
        
        $fileName = 'Penilaian Karakter & Biodata - ' . trim($namaKelas) . '_' . trim($namaSiswa) . '.pdf';

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