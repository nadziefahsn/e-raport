<?php

namespace App\Http\Controllers;

use App\Http\Requests\KesehatanTelingaUpdateRequest;
use App\Models\KesehatanTelinga;
use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\Kelas;

class KesehatanTelingaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guruId = $request->input('guru_id');
        $kelas = null;
        $kesehatanTelingas = collect();

        if ($guruId) {
            $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

            if ($kelas) {
                $kesehatanTelingas = AnggotaKelas::where('kelas_id', $kelas->id)
                    ->with(['siswa', 'kelas', 'kesehatanTelinga'])
                    ->get();
            }
        }

        return view('telingas.index', compact('kesehatanTelingas', 'kelas', 'guruId'));
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
    public function show(KesehatanTelinga $kesehatanTelinga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KesehatanTelinga $kesehatanTelinga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KesehatanTelingaUpdateRequest $request, KesehatanTelinga $kesehatanTelinga)
    {
        $validated = $request->validated();
        $guruId = $request->input('guru_id');

        foreach ($validated['anggota_kelas_id'] as $index => $anggotaId) {
            KesehatanTelinga::updateOrCreate(
                ['anggota_kelas_id' => $anggotaId],
                [
                    'pendengaran_kanan' => $validated['pendengaran_kanan'][$index] ?? null,
                    'pendengaran_kiri'  => $validated['pendengaran_kiri'][$index] ?? null,
                    'radang_kanan'      => $validated['radang_kanan'][$index] ?? null,
                    'radang_kiri'       => $validated['radang_kiri'][$index] ?? null,
                ]
            );
        }

        return redirect()
            ->route('kesehatan-telinga.index', ['guru_id' => $guruId])
            ->with('success', 'Data kesehatan telinga berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
