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

    public function create()
    {
        
    }


    public function store(Request $request)
    {
        
    }


    public function show(KondisiTubuh $kondisiTubuh)
    {
        
    }


    public function edit(KondisiTubuh $kondisiTubuh)
    {

    }

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

    public function destroy(KondisiTubuh $kondisiTubuh)
    {

    }
}