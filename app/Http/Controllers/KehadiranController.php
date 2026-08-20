<?php

namespace App\Http\Controllers;

use App\Http\Requests\KehadiranUpdateRequest;
use App\Http\Controllers\KelasController;
use App\Models\AnggotaKelas;
use App\Models\Kehadiran;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
{
    $guruId = $request->query('guru_id');

    $kelas = null;
    $kehadirans = collect();

    if ($guruId) {
        $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

        if ($kelas) {
            $kehadirans = AnggotaKelas::where('kelas_id', $kelas->id)
                ->with(['siswa', 'kelas', 'kehadiran'])
                ->get();
        }
    }

    return view('kehadirans.index', compact('kehadirans', 'kelas'));
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
    public function store(KehadiranStoreRequest $request)
    {
       //
    }

    /**
     * Display the specified resource.
     */
    public function show(Kehadiran $kehadiran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kehadiran $kehadiran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KehadiranUpdateRequest $request)
    {
        $validated = $request->validated();

        $guruId = $request->input('guru_id');

        $tahunAjaranAktif = TahunAjaran::first();

        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Data Tahun Ajaran belum ada di database!');
        }

        foreach ($validated['anggota_kelas_id'] as $index => $anggotaId) {
        Kehadiran::updateOrCreate(
            [
                'anggota_kelas_id' => $anggotaId,
                'tahun_ajaran_id'  => $tahunAjaranAktif->id, 
            ],
            [
                'sakit'            => $validated['sakit'][$index] ?? 0,
                'izin'             => $validated['izin'][$index] ?? 0,
                'tanpa_keterangan' => $validated['tanpa_keterangan'][$index] ?? 0,
            ]
        );
        }

        return redirect()
            ->route('kehadiran.index', ['guru_id' => $guruId])
            ->with('success', 'Data kehadiran berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kehadiran $kehadiran)
    {
        //
    }
}
