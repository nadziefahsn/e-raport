<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\KondisiTubuh;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\KondisiTubuhStoreRequest;

class KondisiTubuhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Data kelas masih kosong. Silakan isi data kelas terlebih dahulu.');
        }

        // 2. Ambil Tahun Ajaran Aktif/Terbaru
        $tahunAjaranAktif = TahunAjaran::latest()->first();

        // 3. Ambil Anggota Kelas beserta relasi Siswa, Kelas, dan Kondisi Tubuh
        $anggotaKelas = AnggotaKelas::with([
            'siswa',
            'kelas',
            'kondisiTubuh' => function ($query) use ($tahunAjaranAktif) {
                if ($tahunAjaranAktif) {
                    $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
                }
            }
        ])
        ->where('kelas_id', $kelas->id)
        ->get();

        // 4. Kirim data ke View
        return view('kondisi_tubuhs.index', compact('anggotaKelas', 'kelas', 'tahunAjaranAktif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
