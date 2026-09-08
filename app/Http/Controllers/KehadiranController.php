<?php

namespace App\Http\Controllers;

use App\Http\Requests\KehadiranUpdateRequest;
use App\Http\Controllers\KelasController;
use App\Models\AnggotaKelas;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();
    $kehadirans = collect();
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
        $kehadirans = AnggotaKelas::whereIn('kelas_id', $kelasIds)
            ->with(['siswa', 'kelas', 'kehadiran'])
            ->get();
    } else {
        // Jika Admin, tampilkan semua kelas dan anggota
        $kelas = Kelas::orderBy('rombel', 'asc')->get();
        $kehadirans = AnggotaKelas::with(['siswa', 'kelas', 'kehadiran'])->get();
    }

    return view('kehadirans.index', compact('kehadirans', 'kelas'));
}

  
    public function create()
    {
        
    }

   
    public function store(Request $request)
    {
      
    }

   
    public function show(Kehadiran $kehadiran)
    {
        
    }

   
    public function edit(Kehadiran $kehadiran)
    {
        
    }

   
    public function update(KehadiranUpdateRequest $request)
    {
        $validated = $request->validated();

        $guruId = $request->input('guru_id');

        $tahunAjaranAktif = TahunAjaran::first();

        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Data Tahun Ajaran belum ada di database!');
        }

        foreach ($validated['anggota_kelas_id'] as $index => $anggotaId) {
        Kehadiran::updateOrCreate(
            [
                'anggota_kelas_id' => $anggotaId,
                'tahun_ajaran_id'  => $tahunAjaranAktif->id, 
            ],
            [
                'sakit'            => $validated['sakit'][$index] ?? 0,
                'izin'             => $validated['izin'][$index] ?? 0,
                'tanpa_keterangan' => $validated['tanpa_keterangan'][$index] ?? 0,
            ]
        );
        }

        return redirect()
            ->route('kehadiran.index', ['guru_id' => $guruId])
            ->with('success', 'Data kehadiran berhasil disimpan!');
    }

    
    public function destroy(Kehadiran $kehadiran)
    {
        
    }
}
