<?php

namespace App\Http\Controllers;

use App\Http\Requests\KebersihanSiswaUpdateRequest;
use App\Models\KebersihanSiswa;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;

class KebersihanSiswaController extends Controller
{
    
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

    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        
    }

   
    public function show(KebersihanSiswa $kebersihanSiswa)
    {
       
    }

 
    public function edit(KebersihanSiswa $kebersihanSiswa)
    {
       
    }

    
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

    
    public function destroy(KebersihanSiswa $kebersihanSiswa)
    {
        
    }
}
