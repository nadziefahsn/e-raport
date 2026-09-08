<?php

namespace App\Http\Controllers;

use App\Http\Requests\KesehatanTelingaUpdateRequest;
use App\Models\KesehatanTelinga;
use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\Kelas;

class KesehatanTelingaController extends Controller
{

    public function index(Request $request)
{
    $user = auth()->user();
    $kesehatanTelingas = collect();
    $kelas = null;

    if ($user->hasRole('guru')) {
        // Otomatis ambil ID dari relasi guru
        $guruId = $user->guru?->id;

        // Ambil kelas yang diampu (wali kelas atau pendamping)
        $kelas = Kelas::where('wali_kelas_id', $guruId)
            ->orWhere('pendamping_id', $guruId)
            ->get();

        $kelasIds = $kelas->pluck('id');

        // Ambil data anggota kelas beserta relasi kehadirannya
        $kesehatanTelingas = AnggotaKelas::whereIn('kelas_id', $kelasIds)
            ->with(['siswa', 'kelas', 'kesehatanTelinga'])
            ->get();
    } else {
        // Jika Admin, tampilkan semua kelas dan anggota
        $kelas = Kelas::orderBy('rombel', 'asc')->get();
        $kesehatanTelingas = AnggotaKelas::with(['siswa', 'kelas', 'kesehatanTelinga'])->get();
    }

    return view('telingas.index', compact('kesehatanTelingas', 'kelas'));
}


    public function create()
    {
       
    }


    public function store(Request $request)
    {
       
    }


    public function show(KesehatanTelinga $kesehatanTelinga)
    {
      
    }


    public function edit(KesehatanTelinga $kesehatanTelinga)
    {
        
    }


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


    public function destroy(string $id)
    {
        
    }
}
