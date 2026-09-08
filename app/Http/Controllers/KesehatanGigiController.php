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
    $user = auth()->user();
    $kesehatanGigis = collect();
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
        $kesehatanGigis = AnggotaKelas::whereIn('kelas_id', $kelasIds)
            ->with(['siswa', 'kelas', 'kesehatanGigi'])
            ->get();
    } else {
        // Jika Admin, tampilkan semua kelas dan anggota
        $kelas = Kelas::orderBy('rombel', 'asc')->get();
        $kesehatanGigis= AnggotaKelas::with(['siswa', 'kelas', 'kesehatanGigis'])->get();
    }

    return view('gigis.index', compact('kesehatanGigis', 'kelas'));
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
