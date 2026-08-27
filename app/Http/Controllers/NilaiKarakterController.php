<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\NilaiKarakter;

class NilaiKarakterController extends Controller
{
    // Fungsi untuk menampilkan tabel siswa
    public function index()
    {
        $id_kelas = auth()->user()->id_kelas; 
        $id_guru  = auth()->user()->id_guru;

        $siswaList = DB::table('anggota_kelas')
            ->join('siswas', 'anggota_kelas.id_siswa', '=', 'siswas.id_siswa')
            ->join('kelas', 'anggota_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('nilai_karakters', function($join) use ($id_guru) {
                $join->on('siswa.id_siswa', '=', 'nilai_karakter.id_siswa')
                     ->where('nilai_karakter.id_guru', '=', $id_guru);
            })
            ->where('anggota_kelas.id_kelas', $id_kelas)
            ->select(
                'siswa.id_siswa',
                'siswa.nomor_induk',
                'siswa.nama_siswa',
                'kelas.nama_kelas',
                // Disesuaikan mengambil 4 karakter
                'nilai_karakter.karakter_1',
                'nilai_karakter.karakter_2',
                'nilai_karakter.karakter_3',
                'nilai_karakter.karakter_4'
            )
            ->get();

        return view('nilai_karakter.index', compact('siswaList'));
    }

    // Fungsi untuk menyimpan nilai saat tombol Simpan diklik
    public function store(Request $request)
    {
        $id_guru = auth()->user()->id_guru;

        foreach ($request->nilai as $data) {
            // Menyimpan/update 4 kolom karakter sekaligus
            NilaiKarakter::updateOrCreate(
                [
                    'id_siswa' => $data['id_siswa'],
                    'id_guru'  => $id_guru,
                ],
                [
                    'karakter_1' => $data['karakter_1'] ?? null,
                    'karakter_2' => $data['karakter_2'] ?? null,
                    'karakter_3' => $data['karakter_3'] ?? null,
                    'karakter_4' => $data['karakter_4'] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }
}