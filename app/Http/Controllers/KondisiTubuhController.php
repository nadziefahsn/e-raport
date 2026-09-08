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
        $user = auth()->user();
    $kondisiTubuhs = collect();
    $kelas = null;

    if ($user->hasRole('guru')) {
        $guruId = $user->guru?->id;

        $kelas = Kelas::where('wali_kelas_id', $guruId)
            ->orWhere('pendamping_id', $guruId)
            ->get();

        $kelasIds = $kelas->pluck('id');

        $kondisiTubuhs = AnggotaKelas::whereIn('kelas_id', $kelasIds)
            ->with(['siswa', 'kelas', 'kondisiTubuh'])
            ->get();
    } else {
        $kelas = Kelas::orderBy('rombel', 'asc')->get();
        $kondisiTubuhs = AnggotaKelas::with(['siswa', 'kelas', 'kondisiTubuh'])->get();
    }

    return view('kondisi_tubuhs.index', compact('kondisiTubuhs', 'kelas'));
    }

    public function create()
    {
        
    }


    public function store(KondisiTubuhStoreRequest $request)
    {
        
    }


    public function show(KondisiTubuh $kondisiTubuh)
    {
        
    }


    public function edit(KondisiTubuh $kondisiTubuh)
    {

    }

    public function update(KondisiTubuhStoreRequest $request)
    {
        $data = $request->validated();

        $guruId = $data['guru_id'] ?? null;
        $tahunAjaranAktif = TahunAjaran::latest()->first();

        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Tahun ajaran aktif belum ditentukan.');
        }

        $anggotaIds  = $data['anggota_kelas_id'];
        $beratBadan  = $data['berat_badan'];
        $tinggiBadan = $data['tinggi_badan'];

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