<?php

namespace App\Http\Controllers;

use App\Http\Requests\KesehatanMulutUpdateRequest;
use App\Models\KesehatanMulut;
use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TahunAjaran;

class KesehatanMulutController extends Controller
{
   
    public function index(Request $request)
    {
        $user = auth()->user();
        $kelas = null;
        $kesehatanMuluts = collect();
        $tahunAjaranAktif = TahunAjaran::latest()->first();

        if ($user->hasRole('guru')) {
            $guruId = $user->guru?->id;

            $kelas = Kelas::whereTahunAjaranId($tahunAjaranAktif->id)
                ->where(function ($query) use ($guruId) {
                    $query->where('wali_kelas_id', $guruId)
                          ->orWhere('pendamping_id', $guruId);    
                })
                ->get();
        } else {
            $kelas = Kelas::whereTahunAjaranId($tahunAjaranAktif->id)
                ->orderBy('rombel', 'asc')
                ->get(); 
        }
        
        $kelasIds = $kelas->pluck('id');

            $kesehatanMuluts = AnggotaKelas::whereIn('kelas_id', $kelasIds)
                ->with(['siswa', 'kelas', 'kesehatanMulut' ])
                ->get();

        return view('muluts.index', compact('kesehatanMuluts', 'kelas'));
    }


    public function create()
    {
        
    }


    public function store(Request $request)
    {
        
    }


    public function show(KesehatanMulut $kesehatanMulut)
    {
        
    }


    public function edit(KesehatanMulut $kesehatanMulut)
    {
       
    }

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

    public function destroy(KesehatanMulut $kesehatanMulut)
    {
       
    }
}