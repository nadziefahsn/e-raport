<?php

namespace App\Http\Controllers;

use App\Http\Requests\KesehatanMataUpdateRequest;
use App\Models\AnggotaKelas;
use App\Models\KesehatanMata;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KesehatanMataController extends Controller
{
    
    public function index(Request $request)
    {
        $guruId = $request->query('guru_id');

        $kelas = null;
        $kesehatanMata = collect();

        if ($guruId) {
            $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

            if($kelas) {
                $kesehatanMata = AnggotaKelas::where('kelas_id', $kelas->id)
                    ->with(['siswa', 'kelas', 'kesehatanMata'])
                    ->get();
            }
        }

        return view('matas.index', compact('kesehatanMata', 'kelas'));
    }

    
    public function create()
    {
        
    }


    public function store(Request $request)
    {
        
    }

   
    public function show(KesehatanMata $kesehatanMata)
    {
        
    }

    
    public function edit(KesehatanMata $kesehatanMata)
    {
       
    }

  
    public function update(KesehatanMataUpdateRequest $request)
    {
        $validated = $request->validated();

        $guruId = $request->input('guru_id');

        foreach ($validated['anggota_kelas_id'] as $index => $anggota_id) {
            KesehatanMata::updateOrCreate(
                [
                    'anggota_kelas_id' => $anggota_id,
                ], 
                [
                    'ketajaman_kanan' => $validated['ketajaman_kanan'][$index] ?? null,
                    'ketajaman_kiri'  => $validated['ketajaman_kiri'][$index] ?? null,
                    'buta_warna'      => $validated['buta_warna'][$index] ?? null,
                    'radang_kanan'    => $validated['radang_kanan'][$index] ?? null,
                    'radang_kiri'     => $validated['radang_kiri'][$index] ?? null, 
                    'juling_kanan'    => $validated['juling_kanan'][$index] ?? null,
                    'juling_kiri'     => $validated['juling_kiri'][$index] ?? null,
                ]
            );
        }
        return redirect()
            ->route('mata.index', ['guru_id' => $guruId])
            ->with('success', 'Data kesehatan mata berhasil disimpan!');
    }


    public function destroy(KesehatanMata $kesehatanMata)
    {
       
    }
}
