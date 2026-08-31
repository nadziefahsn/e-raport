<?php

namespace App\Http\Controllers;

use App\Http\Requests\NilaiKarakterUpdateRequest; // Sesuaikan dengan nama Request kamu
use App\Models\NilaiKarakter;
use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\Karakter;

class NilaiKarakterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guruId = $request->query('guru_id');
        $kelas = null;
        $anggotaKelas = collect();
        $karakters = Karakter::all(); 
        if ($guruId) {
            $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

            if ($kelas) {
                $anggotaKelas = AnggotaKelas::where('kelas_id', $kelas->id)
                    ->with(['siswa', 'kelas', 'nilaiKarakter'])
                    ->get();
            }
        }

        return view('nilai_karakters.index', compact('anggotaKelas', 'kelas', 'guruId', 'karakters'));
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
    public function show(NilaiKarakter $nilaiKarakter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiKarakter $nilaiKarakter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NilaiKarakterUpdateRequest $request, $id = null)
    {
        $validated = $request->validated();
        $guruId = $request->input('guru_id');

        if (isset($validated['nilai'])) {
            foreach ($validated['nilai'] as $anggotaKelasId => $karakterArray) {
                foreach ($karakterArray as $karakterId => $nilaiValue) {
                    if (empty($nilaiValue)) {
                        continue;
                    }

                    NilaiKarakter::updateOrCreate(
                        [
                            'anggota_kelas_id' => $anggotaKelasId,
                            'karakter_id'      => $karakterId,
                        ],
                        [
                            'nilai'            => $nilaiValue,
                        ]
                    );
                }
            }
        }

        return redirect()
            ->route('nilai_karakters.index', ['guru_id' => $guruId])
            ->with('success', 'Data nilai karakter berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiKarakter $nilaiKarakter)
    {
        //
    }
}