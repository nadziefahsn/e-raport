<?php

namespace App\Http\Controllers;

use App\Http\Requests\KehadiranUpdateRequest;
use App\Http\Controllers\KelasController;
use App\Models\AnggotaKelas;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $wali_kelas = Guru::where('user_id', Auth::user()->id)->first();
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        $id_kelas_diampu = Kelas::whereTahunAjaranId( $tahunAjaranAktif->id)->whereWaliKelasId($wali_kelas->id)->get('id');
        $data_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get();

        foreach ($data_anggota_kelas as $anggota) {
            $kehadirans = Kehadiran::where('anggota_kelas_id', $anggota->id)->first();
            if (is_null($kehadirans)) {
                $anggota->sakit = 0;
                $anggota->izin = 0;
                $anggota->tanpa_keterangan = 0;
                    } else {
                        $anggota->sakit = $kehadirans->sakit;
                        $anggota->izin = $kehadirans->izin;
                        $anggota->tanpa_keterangan = $kehadirans->tanpa_keterangan;
                    }
                }                        

        return view('kehadirans.index', compact('data_anggota_kelas'));
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
