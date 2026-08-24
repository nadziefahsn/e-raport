<?php

namespace App\Http\Controllers;

use App\Http\Requests\KondisiTubuhStoreRequest;
use App\Models\KondisiTubuh;
use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KondisiTubuhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guruId = $request->input('guru_id');
        $kelas = null;
        $kondisiTubuhs = collect();
        $tahunAjaranAktif = TahunAjaran::latest()->first();

        if ($guruId) {
            $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

            if ($kelas) {
                $kondisiTubuhs = AnggotaKelas::where('kelas_id', $kelas->id)
                    ->with(['siswa', 'kelas', 'kondisiTubuh' => function($query) use ($tahunAjaranAktif) {
                        if ($tahunAjaranAktif) {
                            $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
                        }
                    }])
                    ->get();
            }
        }

        return view('kondisi_tubuhs.index', compact('kondisiTubuhs', 'kelas', 'guruId', 'tahunAjaranAktif'));
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
    public function show(KondisiTubuh $kondisiTubuh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KondisiTubuh $kondisiTubuh)
    {
        //
    }

    /**
     * Update/Store the specified resource in storage.
     */
    public function update(Request $request)
    {
        $guruId = $request->input('guru_id');
        $tahunAjaranAktif = TahunAjaran::latest()->first();

        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Tahun ajaran aktif belum ditentukan.');
        }

        $anggotaIds = $request->input('anggota_kelas_id', []);
        $beratBadan = $request->input('berat_badan', []);
        $tinggiBadan = $request->input('tinggi_badan', []);

        foreach ($anggotaIds as $index => $anggotaId) {
            KondisiTubuh::updateOrCreate(
                [
                    'anggota_kelas_id' => $anggotaId,
                    'tahun_ajaran_id'  => $tahunAjaranAktif->id,
                ],
                [
                    'berat_badan'  => $beratBadan[$index] ?? null,
                    'tinggi_badan' => $tinggiBadan[$index] ?? null,
                ]
            );
        }

        return redirect()
            ->route('kondisi-tubuh.index', ['guru_id' => $guruId])
            ->with('success', 'Data kondisi tubuh berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KondisiTubuh $kondisiTubuh)
    {
        //
    }
}