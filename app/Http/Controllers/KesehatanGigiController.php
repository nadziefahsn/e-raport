<?php

namespace App\Http\Controllers;

use App\Http\Requests\KesehatanGigiUpdateRequest;
use App\Models\KesehatanGigi;
use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\Kehadiran;
use App\Models\Kelas;

class KesehatanGigiController extends Controller
{
    
    public function index(Request $request)
    {
        $guruId = $request->input('guru_id');
        $kelas = null;
        $kesehatanGigis = collect();

        if ($guruId) {
            $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

            if ($kelas) {
                $kesehatanGigis = AnggotaKelas::where('kelas_id', $kelas->id)
                    ->with(['siswa', 'kelas', 'kesehatanGigi'])
                    ->get();
            }
        }

        return view('gigis.index', compact('kesehatanGigis', 'kelas', 'guruId'));
    }

    
    public function create()
    {
        
    }

   
    public function store(Request $request)
    {
        
    }

   
    public function show(KesehatanGigi $kesehatanGigi)
    {
        
    }

    public function edit(KesehatanGigi $kesehatanGigi)
    {
        
    }

   
    public function update(KesehatanGigiUpdateRequest $request, KesehatanGigi $kesehatanGigi)
    {
        $validated = $request->validated();
        $guruId = $request->input('guru_id');

        foreach ($validated['anggota_kelas_id'] as $index => $anggotaId) {
            KesehatanGigi::updateOrCreate(
                ['anggota_kelas_id' => $anggotaId],
                [
                    'kesehatan_gigi' => $validated['kesehatan_gigi'][$index],
                    'keterangan' => $validated['keterangan'][$index] ?? null,
                ]
            );
        }

        return redirect()
            ->route('gigi.index', ['guru_id' => $guruId])
            ->with('success', 'Data kesehatan gigi berhasil disimpan');
    }
    
    public function destroy(KesehatanGigi $kesehatanGigi)
    {
        
    }
}
