<?php

namespace App\Http\Controllers;

use App\Http\Requests\KesehatanMulutUpdateRequest;
use App\Models\KesehatanMulut;
use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\Kelas;

class KesehatanMulutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guruId = $request->input('guru_id');
        $kelas = null;
        $kesehatanMuluts = collect();

        if ($guruId) {
            $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

            if ($kelas) {
                $kesehatanMuluts = AnggotaKelas::where('kelas_id', $kelas->id)
                    ->with(['siswa', 'kelas', 'kesehatanMulut'])
                    ->get();
            }
        }

        return view('muluts.index', compact('kesehatanMuluts', 'kelas', 'guruId'));
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
    public function show(KesehatanMulut $kesehatanMulut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KesehatanMulut $kesehatanMulut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KesehatanMulutUpdateRequest $request, KesehatanMulut $kesehatanMulut)
    {
        $validated = $request->validated();
        $guruId = $request->input('guru_id');

        foreach ($validated['anggota_kelas_id'] as $index => $anggotaId) {
            KesehatanMulut::updateOrCreate(
                ['anggota_kelas_id' => $anggotaId],
                [
                    'kesehatan_mulut' => $validated['kesehatan_mulut'][$index],
                    'keterangan' => $validated['keterangan'][$index] ?? null,
                ]
            );
        }

        return redirect()
            ->route('mulut.index', ['guru_id' => $guruId])
            ->with('success', 'Data kesehatan mulut berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KesehatanMulut $kesehatanMulut)
    {
        //
    }
}