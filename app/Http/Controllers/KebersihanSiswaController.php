<?php

namespace App\Http\Controllers;

use App\Http\Requests\KebersihanSiswaUpdateRequest;
use App\Models\KebersihanSiswa;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;

class KebersihanSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guruId = $request->query('guru_id');
        
        $kelas = null;
        $kebersihanSiswa = collect();

        if ($guruId) {
        $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

        if ($kelas) {
            $kebersihanSiswa = AnggotaKelas::where('kelas_id', $kelas->id)
                ->with(['siswa', 'kelas', 'kebersihanSiswa'])
                ->get();
        }
    }

        return view('kebersihans.index', compact('kebersihanSiswa', 'kelas'));
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
    public function show(KebersihanSiswa $kebersihanSiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KebersihanSiswa $kebersihanSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KebersihanSiswaUpdateRequest $request)
    {
        $validated = $request->validated();

        $guruId = $request->input('guru_id');

        foreach ($validated['anggota_kelas_id'] as $index => $anggotaId) {
            KebersihanSiswa::updateOrCreate(
                [
                    'anggota_kelas_id' => $anggotaId,
                ],
                [
                    'hasil_pakaian'       => $validated['hasil_pakaian'][$index],
                    'hasil_kuku'          => $validated['hasil_kuku'][$index],
                    'hasil_rambut'        => $validated['hasil_rambut'][$index],
                    'hasil_kulit'         => $validated['hasil_kulit'][$index],
                    'keterangan'          => $validated['keterangan'][$index] ?? null,
                ]
            );
        }

        return redirect()
            ->route('kebersihan-siswa.index', ['guru_id' => $guruId])
            ->with('success', 'Data kebersihan siswa berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KebersihanSiswa $kebersihanSiswa)
    {
        //
    }
}
