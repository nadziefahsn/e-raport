<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KriteriaPenilaian;
use App\Models\Sekolah;
use App\Models\AnggotaKelas;

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

        $pdf = Pdf::loadView('pdf.rapot', compact(
            'sekolah', 
            'kriterias', 
            'anggotaKelas'
        ))->setOption([
            'isRemoteEnabled' => true, 
            'isHtml5ParserEnabled' => true
        ])->setPaper('A4', 'portrait');

        $namaKelas = $anggotaKelas->kelas->rombel ?? 'Kelas';
        $namaSiswa = $anggotaKelas->siswa->nama_siswa ?? 'Siswa';
        
        $fileName = trim($namaKelas) . '_' . trim($namaSiswa) . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }
}